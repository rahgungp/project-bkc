<?php

namespace Modules\Training\Controllers;

use App\Controllers\BaseController;
use Modules\Training\Models\TrainingCategoryModel;

class AdminCategoryController extends BaseController
{
    protected TrainingCategoryModel $model;

    public function __construct()
    {
        $this->model = new TrainingCategoryModel();
    }

    public function index()
    {
        $categories = $this->model->where('deleted_at', null)->orderBy('sort_order', 'ASC')->findAll();
        return view('Modules\Training\Views\admin\categories', [
            'title' => 'Kategori Pelatihan',
            'categories' => $categories,
            'breadcrumbs' => [['title' => 'Pelatihan', 'url' => base_url('admin/pelatihan')], ['title' => 'Kategori']],
        ]);
    }

    public function store()
    {
        $name = $this->request->getPost('name');
        $slug = url_title(strtolower($name), '-', true);

        $this->model->insert([
            'name' => $name,
            'slug' => $slug,
            'icon' => $this->request->getPost('icon') ?: 'fa-book',
            'color' => $this->request->getPost('color') ?: '#C8A34D',
            'description' => $this->request->getPost('description'),
            'sort_order' => (int) ($this->request->getPost('sort_order') ?: 0),
            'is_active' => 1,
        ]);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Kategori berhasil ditambahkan.']);
    }

    public function update(int $id)
    {
        $cat = $this->model->find($id);
        if (!$cat) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Kategori tidak ditemukan.']);
        }

        $name     = $this->request->getPost('name');
        $isActive = $this->request->getPost('is_active');

        $this->model->update($id, [
            'name'        => $name,
            'slug'        => $name !== $cat['name'] ? url_title(strtolower($name), '-', true) : $cat['slug'],
            'icon'        => $this->request->getPost('icon'),
            'color'       => $this->request->getPost('color'),
            'description' => $this->request->getPost('description'),
            'sort_order'  => (int) ($this->request->getPost('sort_order') ?: 0),
            'is_active'   => $isActive !== null ? (int) $isActive : $cat['is_active'],
        ]);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Kategori berhasil diperbarui.']);
    }

    public function delete(int $id)
    {
        $this->model->delete($id);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Kategori berhasil dihapus.']);
    }
}
