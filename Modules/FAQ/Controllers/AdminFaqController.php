<?php

namespace Modules\FAQ\Controllers;

use App\Controllers\BaseController;
use Modules\FAQ\Models\FaqModel;

class AdminFaqController extends BaseController
{
    protected FaqModel $model;

    public function __construct()
    {
        $this->model = new FaqModel();
    }

    public function index()
    {
        $faqs = $this->model->where('deleted_at', null)->orderBy('sort_order', 'ASC')->findAll();
        return view('Modules\FAQ\Views\admin\index', [
            'title' => 'Manajemen FAQ',
            'faqs' => $faqs,
            'breadcrumbs' => [['title' => 'FAQ']],
        ]);
    }

    public function store()
    {
        $this->model->insert([
            'question' => $this->request->getPost('question'),
            'answer' => $this->request->getPost('answer'),
            'category' => $this->request->getPost('category'),
            'sort_order' => (int)($this->request->getPost('sort_order') ?: 0),
            'is_active' => 1,
        ]);
        return $this->response->setJSON(['status' => 'success', 'message' => 'FAQ berhasil ditambahkan.']);
    }

    public function update(int $id)
    {
        $faq = $this->model->find($id);
        if (!$faq) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'FAQ tidak ditemukan.']);
        }

        // Partial update — only toggle is_active when _toggle_active flag is set
        if ($this->request->getPost('_toggle_active') === '1') {
            $newActive = (int) $this->request->getPost('is_active');
            $this->model->update($id, ['is_active' => $newActive]);
            return $this->response->setJSON(['status' => 'success', 'message' => 'Status FAQ berhasil diubah.']);
        }

        $isActive = $this->request->getPost('is_active');
        $this->model->update($id, [
            'question'   => $this->request->getPost('question'),
            'answer'     => $this->request->getPost('answer'),
            'category'   => $this->request->getPost('category'),
            'sort_order' => (int) ($this->request->getPost('sort_order') ?: 0),
            'is_active'  => $isActive !== null ? (int) $isActive : $faq['is_active'],
        ]);
        return $this->response->setJSON(['status' => 'success', 'message' => 'FAQ berhasil diperbarui.']);
    }

    public function reorder()
    {
        $orders = $this->request->getPost('orders');
        if (!is_array($orders)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak valid.']);
        }
        foreach ($orders as $item) {
            if (isset($item['id'], $item['sort_order'])) {
                $this->model->update((int) $item['id'], ['sort_order' => (int) $item['sort_order']]);
            }
        }
        return $this->response->setJSON(['status' => 'success', 'message' => 'Urutan FAQ berhasil disimpan.']);
    }

    public function delete(int $id)
    {
        $this->model->delete($id);
        return $this->response->setJSON(['status' => 'success', 'message' => 'FAQ berhasil dihapus.']);
    }
}
