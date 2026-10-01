<?php

namespace Modules\Admin\Controllers;

use App\Controllers\BaseController;
use App\Models\AuditLogModel;
use App\Models\UserModel;

class ActivityLogController extends BaseController
{
    protected AuditLogModel $logModel;
    protected UserModel     $userModel;

    public function __construct()
    {
        $this->logModel  = new AuditLogModel();
        $this->userModel = new UserModel();
        helper(['url', 'form']);
    }

    // ─── Index ────────────────────────────────────────────────────────────────

    public function index()
    {
        $builder = $this->logModel
            ->select('audit_logs.*, users.name as user_name, roles.name as role_name, roles.slug as role_slug')
            ->join('users', 'users.id = audit_logs.user_id', 'left')
            ->join('roles', 'roles.id = users.role_id', 'left');

        // Filters
        $filterUser   = $this->request->getGet('user_id');
        $filterAction = $this->request->getGet('action');
        $filterModule = $this->request->getGet('module');
        $filterFrom   = $this->request->getGet('date_from');
        $filterTo     = $this->request->getGet('date_to');

        if (!empty($filterUser)) {
            $builder->where('audit_logs.user_id', (int) $filterUser);
        }
        if (!empty($filterAction)) {
            $builder->where('audit_logs.action', $filterAction);
        }
        if (!empty($filterModule)) {
            $builder->like('audit_logs.module', $filterModule);
        }
        if (!empty($filterFrom)) {
            $builder->where('DATE(audit_logs.created_at) >=', $filterFrom);
        }
        if (!empty($filterTo)) {
            $builder->where('DATE(audit_logs.created_at) <=', $filterTo);
        }

        $builder->orderBy('audit_logs.created_at', 'DESC');

        $logs  = $builder->paginate(50, 'default');
        $pager = $this->logModel->pager;

        // All users for filter dropdown
        $users = $this->userModel
            ->select('id, name')
            ->where('deleted_at', null)
            ->orderBy('name', 'ASC')
            ->findAll();

        return view('Modules\Admin\Views\activity_log\index', [
            'title'      => 'Activity Log',
            'breadcrumbs' => [
                ['title' => 'Sistem'],
                ['title' => 'Activity Log'],
            ],
            'logs'         => $logs,
            'pager'        => $pager,
            'users'        => $users,
            'filters'      => [
                'user_id'   => $filterUser,
                'action'    => $filterAction,
                'module'    => $filterModule,
                'date_from' => $filterFrom,
                'date_to'   => $filterTo,
            ],
        ]);
    }

    // ─── Clear Old Logs ───────────────────────────────────────────────────────

    public function clear()
    {
        if (session()->get('admin_role') !== 'superadmin') {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Akses ditolak. Hanya superadmin yang dapat menghapus log.',
            ]);
        }

        $db          = \Config\Database::connect();
        $cutoffDate  = date('Y-m-d H:i:s', strtotime('-90 days'));

        $deletedCount = $db->table('audit_logs')
                           ->where('created_at <', $cutoffDate)
                           ->countAllResults();

        $db->table('audit_logs')
           ->where('created_at <', $cutoffDate)
           ->delete();

        return $this->response->setJSON([
            'success'       => true,
            'message'       => "Berhasil menghapus {$deletedCount} log yang lebih dari 90 hari.",
            'deleted_count' => $deletedCount,
        ]);
    }

    // ─── Export to Excel ──────────────────────────────────────────────────────

    public function export()
    {
        // Require PhpSpreadsheet (composer require phpoffice/phpspreadsheet)
        if (!class_exists('\PhpOffice\PhpSpreadsheet\Spreadsheet')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'PhpSpreadsheet tidak tersedia. Jalankan: composer require phpoffice/phpspreadsheet',
            ]);
        }

        $builder = $this->logModel
            ->select('audit_logs.*, users.name as user_name')
            ->join('users', 'users.id = audit_logs.user_id', 'left');

        // Apply same filters
        $filterUser   = $this->request->getGet('user_id');
        $filterAction = $this->request->getGet('action');
        $filterModule = $this->request->getGet('module');
        $filterFrom   = $this->request->getGet('date_from');
        $filterTo     = $this->request->getGet('date_to');

        if (!empty($filterUser))   $builder->where('audit_logs.user_id', (int) $filterUser);
        if (!empty($filterAction)) $builder->where('audit_logs.action', $filterAction);
        if (!empty($filterModule)) $builder->like('audit_logs.module', $filterModule);
        if (!empty($filterFrom))   $builder->where('DATE(audit_logs.created_at) >=', $filterFrom);
        if (!empty($filterTo))     $builder->where('DATE(audit_logs.created_at) <=', $filterTo);

        $logs = $builder->orderBy('audit_logs.created_at', 'DESC')->findAll();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Activity Log');

        // Header row
        $headers = ['No', 'Waktu', 'User', 'Action', 'Module', 'Record ID', 'IP Address'];
        foreach ($headers as $col => $header) {
            $sheet->setCellValueByColumnAndRow($col + 1, 1, $header);
            $sheet->getStyleByColumnAndRow($col + 1, 1)->getFont()->setBold(true);
        }

        // Data rows
        $row = 2;
        foreach ($logs as $i => $log) {
            $sheet->setCellValueByColumnAndRow(1, $row, $i + 1);
            $sheet->setCellValueByColumnAndRow(2, $row, $log['created_at']);
            $sheet->setCellValueByColumnAndRow(3, $row, $log['user_name'] ?? 'System');
            $sheet->setCellValueByColumnAndRow(4, $row, $log['action']);
            $sheet->setCellValueByColumnAndRow(5, $row, $log['module']);
            $sheet->setCellValueByColumnAndRow(6, $row, $log['record_id']);
            $sheet->setCellValueByColumnAndRow(7, $row, $log['ip_address']);
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer   = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'activity_log_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
