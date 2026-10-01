<?php

namespace Modules\Registration\Controllers;

use App\Controllers\BaseController;
use Modules\Registration\Models\RegistrationModel;
use Modules\Registration\Models\CertificateModel;

class AdminCertificateController extends BaseController
{
    protected RegistrationModel $model;

    public function __construct()
    {
        $this->model = new RegistrationModel();
    }

    /**
     * List registrations that are eligible for a certificate (status = completed or paid).
     */
    public function index()
    {
        $registrations = $this->model
            ->withDetails()
            ->whereIn('registrations.status', ['completed', 'paid'])
            ->where('registrations.deleted_at', null)
            ->orderBy('registrations.created_at', 'DESC')
            ->findAll();

        $stats = [
            'completed' => $this->model->where('status', 'completed')->where('deleted_at', null)->countAllResults(false),
            'paid'      => $this->model->where('status', 'paid')->where('deleted_at', null)->countAllResults(false),
        ];

        return view('Modules\Registration\Views\admin\certificate_list', [
            'title'         => 'Kelola Sertifikat',
            'registrations' => $registrations,
            'stats'         => $stats,
            'breadcrumbs'   => [['title' => 'Sertifikat']],
        ]);
    }

    /**
     * Generate an HTML preview of the certificate in the browser.
     */
    public function preview(int $registrationId)
    {
        $data = CertificateModel::getCertificateData($registrationId);

        if (!$data) {
            return redirect()->to(base_url('admin/sertifikat'))->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        $certHtml = CertificateModel::buildCertificateHtml($data, false);

        return view('Modules\Registration\Views\admin\certificate_preview', [
            'title'          => 'Preview Sertifikat',
            'cert_html'      => $certHtml,
            'data'           => $data,
            'registrationId' => $registrationId,
            'breadcrumbs'    => [
                ['title' => 'Sertifikat', 'url' => base_url('admin/sertifikat')],
                ['title' => 'Preview'],
            ],
        ]);
    }

    /**
     * Generate and stream a PDF certificate as a file download (admin, requires auth).
     */
    public function download(int $registrationId)
    {
        $data = CertificateModel::getCertificateData($registrationId);

        if (!$data) {
            return redirect()->to(base_url('admin/sertifikat'))->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        $pdfContent = CertificateModel::generateCertificatePdf($data, false);
        $code       = $data['registration']['registration_code'];
        $filename   = 'Sertifikat-' . $code . '.pdf';

        // Mark certificate as issued
        $this->model->update($registrationId, [
            'certificate_issued' => 1,
        ]);

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setHeader('Cache-Control', 'max-age=0')
            ->setBody($pdfContent);
    }

    /**
     * Public endpoint: participant can download their certificate via registration code.
     * No authentication required.
     */
    public function downloadPublic(string $code)
    {
        $db  = \Config\Database::connect();
        $reg = $db->table('registrations')
            ->where('registration_code', $code)
            ->whereIn('status', ['completed', 'paid'])
            ->where('deleted_at', null)
            ->get()
            ->getRowArray();

        if (!$reg) {
            return redirect()->to(base_url())->with('error', 'Sertifikat tidak ditemukan atau pendaftaran belum selesai.');
        }

        $data = CertificateModel::getCertificateData((int) $reg['id']);

        if (!$data) {
            return redirect()->to(base_url())->with('error', 'Data sertifikat tidak tersedia.');
        }

        $pdfContent = CertificateModel::generateCertificatePdf($data, false);
        $filename   = 'Sertifikat-' . $code . '.pdf';

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setHeader('Cache-Control', 'max-age=0')
            ->setBody($pdfContent);
    }
}
