<?php

namespace Modules\CMS\Controllers;

use App\Controllers\BaseController;
use Modules\CMS\Models\SpeakerModel;

class AdminSpeakerController extends BaseController
{
    protected SpeakerModel $model;
    protected string $uploadPath = ROOTPATH . 'public/uploads/speakers/';
    protected string $uploadUrl  = 'uploads/speakers/';

    public function __construct()
    {
        $this->model = new SpeakerModel();
    }

    /**
     * List all speakers in a DataTables view.
     */
    public function index()
    {
        $speakers = $this->model->where('deleted_at', null)->orderBy('name', 'ASC')->findAll();

        return view('Modules\CMS\Views\admin\speakers', [
            'title'       => 'Manajemen Narasumber',
            'speakers'    => $speakers,
            'breadcrumbs' => [['title' => 'Narasumber']],
        ]);
    }

    /**
     * AJAX: Create a new speaker.
     */
    public function store()
    {
        $rules = [
            'name'  => 'required|min_length[3]|max_length[255]',
            'title' => 'permit_empty|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors'  => $this->validator->getErrors(),
            ]);
        }

        $photo = $this->_uploadPhoto('photo');

        $id = $this->model->insert([
            'name'           => $this->request->getPost('name'),
            'title'          => $this->request->getPost('title'),
            'speciality'     => $this->request->getPost('specialization'),
            'bio'            => $this->request->getPost('bio'),
            'email'          => $this->request->getPost('email'),
            'phone'          => $this->request->getPost('phone'),
            'education'      => $this->request->getPost('education'),
            'experience'     => $this->request->getPost('experience'),
            'linkedin'       => $this->request->getPost('linkedin'),
            'photo'          => $photo,
            'is_active'      => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return $this->response->setJSON([
            'success'   => true,
            'message'   => 'Narasumber berhasil ditambahkan.',
            'id'        => $id,
            'photo_url' => $photo ? base_url($this->uploadUrl . $photo) : null,
        ]);
    }

    /**
     * AJAX: Update an existing speaker.
     */
    public function update(int $id)
    {
        $speaker = $this->model->find($id);
        if (!$speaker) {
            return $this->response->setJSON(['success' => false, 'message' => 'Narasumber tidak ditemukan.']);
        }

        // Partial update (toggle active only) — name not sent
        if ($this->request->getPost('name') === null) {
            $this->model->update($id, [
                'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            ]);
            return $this->response->setJSON(['success' => true, 'message' => 'Status berhasil diubah.']);
        }

        $rules = [
            'name'  => 'required|min_length[3]|max_length[255]',
            'title' => 'permit_empty|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors'  => $this->validator->getErrors(),
            ]);
        }

        $photo    = $speaker['photo'];
        $newPhoto = $this->_uploadPhoto('photo');
        if ($newPhoto) {
            if ($photo && file_exists($this->uploadPath . $photo)) {
                @unlink($this->uploadPath . $photo);
            }
            $photo = $newPhoto;
        }

        $this->model->update($id, [
            'name'       => $this->request->getPost('name'),
            'title'      => $this->request->getPost('title'),
            'speciality' => $this->request->getPost('specialization'),
            'bio'        => $this->request->getPost('bio'),
            'email'      => $this->request->getPost('email'),
            'phone'      => $this->request->getPost('phone'),
            'education'  => $this->request->getPost('education'),
            'experience' => $this->request->getPost('experience'),
            'linkedin'   => $this->request->getPost('linkedin'),
            'photo'      => $photo,
            'is_active'  => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return $this->response->setJSON([
            'success'   => true,
            'message'   => 'Narasumber berhasil diperbarui.',
            'photo_url' => $photo ? base_url($this->uploadUrl . $photo) : null,
        ]);
    }

    /**
     * AJAX: Soft-delete a speaker.
     */
    public function delete(int $id)
    {
        $speaker = $this->model->find($id);
        if (!$speaker) {
            return $this->response->setJSON(['success' => false, 'message' => 'Narasumber tidak ditemukan.']);
        }

        $this->model->delete($id);

        return $this->response->setJSON(['success' => true, 'message' => 'Narasumber berhasil dihapus.']);
    }

    // ─── Helpers ───────────────────────────────────────────────────────────────

    protected function _uploadPhoto(string $field): ?string
    {
        $file = $this->request->getFile($field);
        if (!$file || !$file->isValid() || $file->hasMoved()) {
            return null;
        }

        $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file->getMimeType(), $allowed)) {
            return null;
        }

        if ($file->getSize() > 5 * 1024 * 1024) {
            return null;
        }

        $newName = uniqid('speaker_', true) . '.' . $file->getExtension();
        $file->move($this->uploadPath, $newName);

        return $newName;
    }
}
