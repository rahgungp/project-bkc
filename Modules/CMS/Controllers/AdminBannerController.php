<?php

namespace Modules\CMS\Controllers;

use App\Controllers\BaseController;
use Modules\CMS\Models\BannerModel;

class AdminBannerController extends BaseController
{
    protected BannerModel $model;
    protected string $uploadPath = ROOTPATH . 'public/uploads/banners/';
    protected string $uploadUrl  = 'uploads/banners/';

    public function __construct()
    {
        $this->model = new BannerModel();
    }

    /**
     * List all banners in a sortable DataTables view.
     */
    public function index()
    {
        $banners = $this->model->where('deleted_at', null)->orderBy('sort_order', 'ASC')->findAll();

        return view('Modules\CMS\Views\admin\banners', [
            'title'       => 'Manajemen Banner',
            'banners'     => $banners,
            'breadcrumbs' => [['title' => 'Banner']],
        ]);
    }

    /**
     * AJAX: Create a new banner.
     */
    public function store()
    {
        $rules = [
            'title'      => 'required|max_length[255]',
            'sort_order' => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors'  => $this->validator->getErrors(),
            ]);
        }

        $image = $this->_uploadImage('image');

        $id = $this->model->insert([
            'title'       => $this->request->getPost('title'),
            'subtitle'    => $this->request->getPost('subtitle'),
            'link'        => $this->request->getPost('button_url'),
            'image'       => $image,
            'is_active'   => $this->request->getPost('is_active') ? 1 : 0,
            'sort_order'  => (int) ($this->request->getPost('sort_order') ?: 0),
            'position'    => $this->request->getPost('position') ?: 'home',
        ]);

        return $this->response->setJSON([
            'success'  => true,
            'message'  => 'Banner berhasil ditambahkan.',
            'id'       => $id,
            'image_url' => $image ? base_url($this->uploadUrl . $image) : null,
        ]);
    }

    /**
     * AJAX: Update an existing banner; replace image if a new one is uploaded.
     */
    public function update(int $id)
    {
        $banner = $this->model->find($id);
        if (!$banner) {
            return $this->response->setJSON(['success' => false, 'message' => 'Banner tidak ditemukan.']);
        }

        $rules = [
            'title'      => 'required|max_length[255]',
            'sort_order' => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors'  => $this->validator->getErrors(),
            ]);
        }

        $image    = $banner['image'];
        $newImage = $this->_uploadImage('image');
        if ($newImage) {
            if ($image && file_exists($this->uploadPath . $image)) {
                @unlink($this->uploadPath . $image);
            }
            $image = $newImage;
        }

        $this->model->update($id, [
            'title'       => $this->request->getPost('title'),
            'subtitle'    => $this->request->getPost('subtitle'),
            'link'        => $this->request->getPost('button_url'),
            'image'       => $image,
            'is_active'   => $this->request->getPost('is_active') ? 1 : 0,
            'sort_order'  => (int) ($this->request->getPost('sort_order') ?: 0),
        ]);

        return $this->response->setJSON([
            'success'   => true,
            'message'   => 'Banner berhasil diperbarui.',
            'image_url' => $image ? base_url($this->uploadUrl . $image) : null,
        ]);
    }

    /**
     * AJAX: Soft-delete a banner.
     */
    public function delete(int $id)
    {
        $banner = $this->model->find($id);
        if (!$banner) {
            return $this->response->setJSON(['success' => false, 'message' => 'Banner tidak ditemukan.']);
        }

        $this->model->delete($id);

        return $this->response->setJSON(['success' => true, 'message' => 'Banner berhasil dihapus.']);
    }

    /**
     * AJAX: Toggle is_active only (no title validation needed).
     */
    public function toggleActive(int $id)
    {
        $banner = $this->model->find($id);
        if (!$banner) {
            return $this->response->setJSON(['success' => false, 'message' => 'Banner tidak ditemukan.']);
        }
        $this->model->update($id, ['is_active' => $this->request->getPost('is_active') ? 1 : 0]);
        return $this->response->setJSON(['success' => true]);
    }

    /**
     * AJAX: Batch reorder — accepts JSON array of {id, sort_order} pairs.
     */
    public function reorder()
    {
        $body  = $this->request->getBody();
        $items = json_decode($body, true);

        if (!is_array($items)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data tidak valid.']);
        }

        foreach ($items as $item) {
            if (isset($item['id'], $item['sort_order'])) {
                $this->model->update((int) $item['id'], ['sort_order' => (int) $item['sort_order']]);
            }
        }

        return $this->response->setJSON(['success' => true, 'message' => 'Urutan banner berhasil disimpan.']);
    }

    // ─── Helpers ───────────────────────────────────────────────────────────────

    protected function _uploadImage(string $field): ?string
    {
        $file = $this->request->getFile($field);
        if (!$file || !$file->isValid() || $file->hasMoved()) {
            return null;
        }

        $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file->getMimeType(), $allowed)) {
            return null;
        }

        if ($file->getSize() > 10 * 1024 * 1024) {
            return null;
        }

        $newName = uniqid('banner_', true) . '.' . $file->getExtension();
        $file->move($this->uploadPath, $newName);

        return $newName;
    }
}
