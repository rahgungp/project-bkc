<?php

namespace Modules\Admin\Controllers;

use App\Controllers\BaseController;
use Modules\Profile\Models\CompanyProfileModel;

class SettingsController extends BaseController
{
    protected CompanyProfileModel $settingsModel;

    public function __construct()
    {
        $this->settingsModel = new CompanyProfileModel();
        helper(['url', 'form', 'filesystem']);
    }

    // ─── Index ────────────────────────────────────────────────────────────────

    public function index()
    {
        // Load settings grouped by their group key
        $settings = $this->settingsModel->getAll();

        return view('Modules\Admin\Views\settings\index', [
            'title'      => 'Pengaturan Sistem',
            'breadcrumbs' => [
                ['title' => 'Sistem'],
                ['title' => 'Pengaturan'],
            ],
            'settings' => $settings,
        ]);
    }

    // ─── Update (generic tab update via AJAX POST) ────────────────────────────

    public function update()
    {
        $postData = $this->request->getPost();

        // Remove CI4 internal fields
        unset($postData['csrf_test_name'], $postData[csrf_token()]);

        $fileKeys = ['logo', 'favicon'];

        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/x-icon', 'image/vnd.microsoft.icon', 'image/svg+xml'];

        foreach ($fileKeys as $key) {
            $file = $this->request->getFile($key);
            if ($file && $file->isValid() && !$file->hasMoved()) {
                if (!in_array($file->getMimeType(), $allowedMimes, true)) {
                    continue;
                }
                $uploadPath = FCPATH . 'uploads/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                $newName = $key . '_' . time() . '.' . $file->getExtension();
                $file->move($uploadPath, $newName);
                $postData[$key] = 'uploads/' . $newName;
            }
        }

        if (!empty($postData)) {
            $this->settingsModel->updateSettings($postData);
        }

        // Determine if AJAX or regular POST
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Pengaturan berhasil disimpan.',
            ]);
        }

        return redirect()->to(base_url('admin/pengaturan'))
                         ->with('success', 'Pengaturan berhasil disimpan.');
    }

    // ─── Update SEO ───────────────────────────────────────────────────────────

    public function updateSeo()
    {
        $seoKeys = ['meta_title', 'meta_description', 'meta_keywords', 'google_analytics_id', 'google_site_verification'];
        $data    = [];

        foreach ($seoKeys as $key) {
            $val = $this->request->getPost($key);
            if ($val !== null) {
                $data[$key] = $val;
            }
        }

        if (!empty($data)) {
            $this->settingsModel->updateSettings($data);
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Pengaturan SEO berhasil disimpan.',
            ]);
        }

        return redirect()->to(base_url('admin/pengaturan'))
                         ->with('success', 'Pengaturan SEO berhasil disimpan.');
    }

    // ─── Section Visibility ───────────────────────────────────────────────────

    public function visibility()
    {
        $settings = $this->settingsModel->getAll();

        return view('Modules\Admin\Views\settings\visibility', [
            'title'       => 'Visibilitas Seksi',
            'breadcrumbs' => [
                ['title' => 'Sistem'],
                ['title' => 'Visibilitas Seksi'],
            ],
            'settings' => $settings,
        ]);
    }

    public function updateVisibility()
    {
        $sections = [
            'show_section_hero', 'show_section_about', 'show_section_excellence',
            'show_section_kategori', 'show_section_trainings', 'show_section_stats',
            'show_section_layanan', 'show_section_founder', 'show_section_cta',
        ];

        $data = [];
        foreach ($sections as $key) {
            $data[$key] = $this->request->getPost($key) ? '1' : '0';
        }

        $this->settingsModel->updateSettings($data);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Visibilitas seksi berhasil disimpan.',
            ]);
        }

        return redirect()->to(base_url('admin/visibilitas'))
                         ->with('success', 'Visibilitas seksi berhasil disimpan.');
    }

    // ─── Clear Cache ──────────────────────────────────────────────────────────

    public function clearCache()
    {
        // Clear CI4 cache
        $cache = \Config\Services::cache();
        $cache->clean();

        // Also clear the writable/cache directory
        $cacheDir = WRITEPATH . 'cache/';
        if (is_dir($cacheDir)) {
            $files = glob($cacheDir . '*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    @unlink($file);
                }
            }
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Cache berhasil dibersihkan.',
        ]);
    }
}
