<?php

namespace Modules\Admin\Controllers;

use App\Controllers\BaseController;
use Modules\Registration\Models\ParticipantModel;
use Modules\Registration\Models\RegistrationModel;

class ParticipantController extends BaseController
{
    protected ParticipantModel $model;
    protected RegistrationModel $registrationModel;

    public function __construct()
    {
        $this->model             = new ParticipantModel();
        $this->registrationModel = new RegistrationModel();
    }

    /**
     * List all participants with registration count, paginated.
     */
    public function index()
    {
        $db = \Config\Database::connect();

        $participants = $db->table('participants p')
            ->select('p.*,
                      COUNT(r.id) AS registration_count,
                      MAX(r.created_at) AS last_registration_date')
            ->join('registrations r', 'r.participant_id = p.id AND r.deleted_at IS NULL', 'left')
            ->where('p.deleted_at', null)
            ->groupBy('p.id')
            ->orderBy('p.name', 'ASC')
            ->get()
            ->getResultArray();

        return view('Modules\Admin\Views\participants\index', [
            'title'        => 'Data Peserta',
            'participants' => $participants,
            'breadcrumbs'  => [['title' => 'Peserta']],
        ]);
    }

    /**
     * Show participant detail + registration history.
     */
    public function detail(int $id)
    {
        $participant = $this->model->where('id', $id)->where('deleted_at', null)->first();
        if (!$participant) {
            return redirect()->to(base_url('admin/peserta'))->with('error', 'Peserta tidak ditemukan.');
        }

        $registrations = $this->registrationModel
            ->withDetails()
            ->where('registrations.participant_id', $id)
            ->where('registrations.deleted_at', null)
            ->orderBy('registrations.created_at', 'DESC')
            ->findAll();

        $stats = [
            'total'     => count($registrations),
            'completed' => count(array_filter($registrations, fn ($r) => $r['status'] === 'completed')),
            'total_spent' => array_sum(array_column($registrations, 'amount')),
        ];

        return view('Modules\Admin\Views\participants\detail', [
            'title'         => 'Detail Peserta',
            'participant'   => $participant,
            'registrations' => $registrations,
            'stats'         => $stats,
            'breadcrumbs'   => [
                ['title' => 'Peserta', 'url' => base_url('admin/peserta')],
                ['title' => esc($participant['name'])],
            ],
        ]);
    }

    /**
     * Show edit form.
     */
    public function edit(int $id)
    {
        $participant = $this->model->where('id', $id)->where('deleted_at', null)->first();
        if (!$participant) {
            return redirect()->to(base_url('admin/peserta'))->with('error', 'Peserta tidak ditemukan.');
        }

        return view('Modules\Admin\Views\participants\edit', [
            'title'       => 'Edit Peserta',
            'participant' => $participant,
            'breadcrumbs' => [
                ['title' => 'Peserta', 'url' => base_url('admin/peserta')],
                ['title' => esc($participant['name']), 'url' => base_url('admin/peserta/detail/' . $id)],
                ['title' => 'Edit'],
            ],
        ]);
    }

    /**
     * Process participant update.
     */
    public function update(int $id)
    {
        $participant = $this->model->where('id', $id)->where('deleted_at', null)->first();
        if (!$participant) {
            return redirect()->to(base_url('admin/peserta'))->with('error', 'Peserta tidak ditemukan.');
        }

        $rules = [
            'name'         => 'required|min_length[2]|max_length[200]',
            'email'        => "required|valid_email|max_length[200]",
            'phone'        => 'permit_empty|max_length[20]',
            'institution'  => 'permit_empty|max_length[200]',
            'position'     => 'permit_empty|max_length[200]',
            'address'      => 'permit_empty|max_length[500]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');

        // Check email uniqueness (exclude current)
        $emailCheck = $this->model
            ->where('email', $email)
            ->where('id !=', $id)
            ->where('deleted_at', null)
            ->countAllResults();

        if ($emailCheck > 0) {
            return redirect()->back()->withInput()->with('error', 'Email sudah digunakan oleh peserta lain.');
        }

        $oldValues = $participant;
        $newValues = [
            'name'        => $this->request->getPost('name'),
            'email'       => $email,
            'phone'       => $this->request->getPost('phone'),
            'institution' => $this->request->getPost('institution'),
            'position'    => $this->request->getPost('position'),
            'address'     => $this->request->getPost('address'),
        ];

        $this->model->update($id, $newValues);

        // Audit log
        $db = \Config\Database::connect();
        $db->table('audit_logs')->insert([
            'user_id'    => session()->get('admin_id'),
            'action'     => 'UPDATE',
            'module'     => 'participants',
            'record_id'  => $id,
            'old_values' => json_encode($oldValues),
            'new_values' => json_encode($newValues),
            'ip_address' => $this->request->getIPAddress(),
            'user_agent' => $this->request->getUserAgent()->getAgentString() ?? '',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('admin/peserta/detail/' . $id))->with('success', 'Data peserta berhasil diperbarui.');
    }

    /**
     * Soft delete a participant. Prevents deletion if active registrations exist.
     */
    public function delete(int $id)
    {
        $participant = $this->model->where('id', $id)->where('deleted_at', null)->first();
        if (!$participant) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Peserta tidak ditemukan.']);
        }

        // Check for active (non-cancelled) registrations
        $activeCount = $this->registrationModel
            ->where('participant_id', $id)
            ->whereNotIn('status', ['cancelled', 'rejected'])
            ->where('deleted_at', null)
            ->countAllResults();

        if ($activeCount > 0) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Peserta tidak dapat dihapus karena masih memiliki ' . $activeCount . ' pendaftaran aktif.',
            ]);
        }

        $this->model->delete($id);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Peserta berhasil dihapus.']);
    }

    /**
     * Export participants to Excel using PhpSpreadsheet.
     */
    public function export()
    {
        $db = \Config\Database::connect();
        $participants = $db->table('participants p')
            ->select('p.*, COUNT(r.id) AS registration_count')
            ->join('registrations r', 'r.participant_id = p.id AND r.deleted_at IS NULL', 'left')
            ->where('p.deleted_at', null)
            ->groupBy('p.id')
            ->orderBy('p.name', 'ASC')
            ->get()
            ->getResultArray();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Peserta');

        $headers = ['No', 'Nama', 'Email', 'No. HP', 'Jabatan', 'Instansi', 'Alamat', 'Total Pendaftaran', 'Tgl Daftar'];
        foreach ($headers as $col => $header) {
            $sheet->setCellValue(chr(65 + $col) . '1', $header);
        }

        // Style header
        $headerStyle = $sheet->getStyle('A1:I1');
        $headerStyle->getFont()->setBold(true);
        $headerStyle->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFC8A34D');

        foreach ($participants as $i => $p) {
            $row = $i + 2;
            $sheet->setCellValue("A{$row}", $i + 1);
            $sheet->setCellValue("B{$row}", $p['name']);
            $sheet->setCellValue("C{$row}", $p['email']);
            $sheet->setCellValue("D{$row}", $p['phone']);
            $sheet->setCellValue("E{$row}", $p['position']);
            $sheet->setCellValue("F{$row}", $p['institution']);
            $sheet->setCellValue("G{$row}", $p['address']);
            $sheet->setCellValue("H{$row}", $p['registration_count']);
            $sheet->setCellValue("I{$row}", $p['created_at'] ? date('d/m/Y', strtotime($p['created_at'])) : '-');
        }

        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="peserta_' . date('Ymd') . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }
}
