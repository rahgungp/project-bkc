<?php

namespace Modules\Registration\Controllers;

use App\Controllers\BaseController;
use Modules\Registration\Models\RegistrationModel;
use Modules\Registration\Models\ParticipantModel;

class AdminRegistrationController extends BaseController
{
    protected RegistrationModel $model;

    public function __construct()
    {
        $this->model = new RegistrationModel();
    }

    public function index()
    {
        $registrations = $this->model->withDetails()
            ->where('registrations.deleted_at', null)
            ->orderBy('registrations.created_at', 'DESC')
            ->findAll();

        $stats = $this->model->getStats();

        return view('Modules\Registration\Views\admin\index', [
            'title' => 'Manajemen Pendaftaran',
            'registrations' => $registrations,
            'stats' => $stats,
            'breadcrumbs' => [['title' => 'Pendaftaran']],
        ]);
    }

    public function detail(int $id)
    {
        $reg = $this->model->withDetails()->where('registrations.id', $id)->first();
        if (!$reg) return redirect()->to('/admin/pendaftaran');

        return view('Modules\Registration\Views\admin\detail', [
            'title' => 'Detail Pendaftaran',
            'reg' => $reg,
            'breadcrumbs' => [['title' => 'Pendaftaran', 'url' => base_url('admin/pendaftaran')], ['title' => $reg['registration_code']]],
        ]);
    }

    public function updateStatus(int $id)
    {
        $status = $this->request->getPost('status');
        $validStatuses = ['pending', 'confirmed', 'rejected', 'paid', 'completed', 'cancelled'];

        if (!in_array($status, $validStatuses)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Status tidak valid.']);
        }

        $updateData = ['status' => $status];
        if ($status === 'confirmed') {
            $updateData['confirmed_by'] = session()->get('admin_id');
            $updateData['confirmed_at'] = date('Y-m-d H:i:s');
        }

        $this->model->update($id, $updateData);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Status pendaftaran berhasil diperbarui.']);
    }

    public function deleteRegistration(int $id)
    {
        $reg = $this->model->find($id);
        if (!$reg) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Pendaftaran tidak ditemukan.']);
        }
        $this->model->delete($id);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Pendaftaran berhasil dihapus.']);
    }

    public function updateParticipant(int $id)
    {
        $reg = $this->model->find($id);
        if (!$reg) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Pendaftaran tidak ditemukan.']);
        }

        $participantModel = new ParticipantModel();
        $participantModel->update($reg['participant_id'], [
            'name'        => $this->request->getPost('name'),
            'email'       => $this->request->getPost('email'),
            'phone'       => $this->request->getPost('phone'),
            'institution' => $this->request->getPost('institution'),
            'position'    => $this->request->getPost('position'),
            'address'     => $this->request->getPost('address'),
        ]);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Data peserta berhasil diperbarui.']);
    }

    public function participantHistory()
    {
        $email = $this->request->getGet('email');
        if (!$email) {
            return $this->response->setJSON(['data' => []]);
        }

        $participantModel = new ParticipantModel();
        $participant = $participantModel->where('email', $email)->first();
        if (!$participant) {
            return $this->response->setJSON(['data' => []]);
        }

        $history = $this->model->withDetails()
            ->where('registrations.participant_id', $participant['id'])
            ->where('registrations.deleted_at', null)
            ->orderBy('registrations.created_at', 'DESC')
            ->findAll();

        return $this->response->setJSON(['data' => $history]);
    }

    public function exportExcel()
    {
        $registrations = $this->model->withDetails()->where('registrations.deleted_at', null)->orderBy('registrations.created_at', 'DESC')->findAll();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Pendaftaran');

        $headers = ['No', 'Kode', 'Peserta', 'Email', 'HP', 'Instansi', 'Pelatihan', 'Status', 'Tanggal Daftar'];
        foreach ($headers as $col => $header) {
            $sheet->setCellValue(chr(65 + $col) . '1', $header);
        }

        foreach ($registrations as $i => $reg) {
            $row = $i + 2;
            $sheet->setCellValue("A{$row}", $i + 1);
            $sheet->setCellValue("B{$row}", $reg['registration_code']);
            $sheet->setCellValue("C{$row}", $reg['participant_name']);
            $sheet->setCellValue("D{$row}", $reg['participant_email']);
            $sheet->setCellValue("E{$row}", $reg['participant_phone']);
            $sheet->setCellValue("F{$row}", $reg['participant_institution']);
            $sheet->setCellValue("G{$row}", $reg['training_title']);
            $sheet->setCellValue("H{$row}", $reg['status']);
            $sheet->setCellValue("I{$row}", date('d/m/Y H:i', strtotime($reg['created_at'])));
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="pendaftaran_' . date('Ymd') . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }

    public function exportPdf()
    {
        $registrations = $this->model->withDetails()->where('registrations.deleted_at', null)->orderBy('registrations.created_at', 'DESC')->findAll();

        $html = '<h1 style="font-family:sans-serif;">Daftar Pendaftaran Pelatihan</h1>';
        $html .= '<p style="font-family:sans-serif;">Dicetak: ' . date('d/m/Y H:i') . '</p>';
        $html .= '<table border="1" cellpadding="6" cellspacing="0" width="100%" style="font-family:sans-serif; font-size:11px; border-collapse:collapse;">';
        $html .= '<thead style="background:#C8A34D;"><tr><th>No</th><th>Kode</th><th>Peserta</th><th>Instansi</th><th>Pelatihan</th><th>Status</th><th>Tanggal</th></tr></thead><tbody>';

        foreach ($registrations as $i => $reg) {
            $html .= '<tr>';
            $html .= '<td>' . ($i + 1) . '</td>';
            $html .= '<td>' . esc($reg['registration_code']) . '</td>';
            $html .= '<td>' . esc($reg['participant_name']) . '</td>';
            $html .= '<td>' . esc($reg['participant_institution']) . '</td>';
            $html .= '<td>' . esc($reg['training_title']) . '</td>';
            $html .= '<td>' . ucfirst($reg['status']) . '</td>';
            $html .= '<td>' . date('d/m/Y', strtotime($reg['created_at'])) . '</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody></table>';

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('pendaftaran_' . date('Ymd') . '.pdf', ['Attachment' => true]);
    }
}
