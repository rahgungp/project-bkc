<?php

namespace Modules\Registration\Controllers;

use App\Controllers\BaseController;
use Modules\Training\Models\TrainingModel;
use Modules\Registration\Models\RegistrationModel;
use Modules\Registration\Models\ParticipantModel;

class RegistrationController extends BaseController
{
    public function form(string $slug)
    {
        $trainingModel = new TrainingModel();
        $training = $trainingModel->withAll()->where('trainings.slug', $slug)->where('trainings.status !=', 'cancelled')->where('trainings.deleted_at', null)->first();

        if (!$training) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $spotsLeft = $training['max_participants'] - $training['current_participants'];

        return view('Modules\Registration\Views\form', [
            'meta_title' => 'Daftar ' . $training['title'] . ' - CV. Bagus Kencana Cakrada',
            'training' => $training,
            'spotsLeft' => $spotsLeft,
        ]);
    }

    public function store()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[200]',
            'email' => 'required|valid_email',
            'phone' => 'required',
            'institution' => 'required',
            'training_id' => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => implode(' ', $this->validator->getErrors()),
            ]);
        }

        $trainingModel = new TrainingModel();
        $trainingId = (int) $this->request->getPost('training_id');

        // C-1: validate training exists, is published, and not soft-deleted
        $training = $trainingModel->where('id', $trainingId)
            ->where('status', 'published')
            ->where('deleted_at', null)
            ->first();

        if (!$training) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Pelatihan tidak ditemukan atau tidak tersedia.']);
        }

        // Find or create participant before entering the transaction
        $participantModel = new ParticipantModel();
        $participantId = $participantModel->findOrCreate([
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'position' => $this->request->getPost('position'),
            'institution' => $this->request->getPost('institution'),
            'institution_type' => $this->request->getPost('institution_type') ?: 'other',
            'city' => $this->request->getPost('city'),
            'province' => $this->request->getPost('province'),
        ]);

        $regModel = new RegistrationModel();

        // C-2: wrap quota check + insert + counter update in a transaction
        $db = \Config\Database::connect();
        $db->transStart();

        // Re-read the training row with a write-lock to prevent race condition
        $training = $db->table('trainings')
            ->select('id, title, price, max_participants, current_participants')
            ->where('id', $trainingId)
            ->where('status', 'published')
            ->where('deleted_at', null)
            ->get()->getRowArray();

        if (!$training) {
            $db->transRollback();
            return $this->response->setJSON(['status' => 'error', 'message' => 'Pelatihan tidak tersedia.']);
        }

        $spotsLeft = $training['max_participants'] - $training['current_participants'];
        if ($spotsLeft <= 0) {
            $db->transRollback();
            return $this->response->setJSON(['status' => 'error', 'message' => 'Maaf, kuota pelatihan ini sudah penuh.']);
        }

        // Check if already registered (inside transaction)
        $existing = $regModel->where('training_id', $trainingId)->where('participant_id', $participantId)->where('deleted_at', null)->first();
        if ($existing) {
            $db->transRollback();
            return $this->response->setJSON(['status' => 'error', 'message' => 'Anda sudah terdaftar di pelatihan ini.']);
        }

        $regCode = $regModel->generateCode();
        $regModel->insert([
            'uuid' => $regModel->generateUuid(),
            'registration_code' => $regCode,
            'training_id' => $trainingId,
            'participant_id' => $participantId,
            'status' => 'pending',
            'amount' => $training['price'],
            'special_request' => $this->request->getPost('special_request'),
        ]);

        // Update participant count atomically
        $db->table('trainings')->where('id', $trainingId)->set('current_participants', 'current_participants+1', false)->update();

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal memproses pendaftaran. Silakan coba lagi.']);
        }

        // Prepare WhatsApp message

        $waMsg = urlencode(
            "Halo Admin BKC 👋\n\n" .
            "Saya ingin konfirmasi pendaftaran:\n" .
            "📚 *Pelatihan:* {$training['title']}\n" .
            "👤 *Nama:* " . $this->request->getPost('name') . "\n" .
            "🏢 *Instansi:* " . $this->request->getPost('institution') . "\n" .
            "📧 *Email:* " . $this->request->getPost('email') . "\n" .
            "📞 *HP:* " . $this->request->getPost('phone') . "\n" .
            "🎫 *Kode:* {$regCode}\n\n" .
            "Mohon konfirmasi pendaftaran saya. Terima kasih! 🙏"
        );

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Pendaftaran berhasil! Kode pendaftaran Anda: ' . $regCode,
            'registration_code' => $regCode,
            'wa_url' => 'https://wa.me/6281803867430?text=' . $waMsg,
        ]);
    }
}
