<?php

namespace Modules\Testimonial\Controllers;

use App\Controllers\BaseController;
use Modules\Testimonial\Models\TestimonialModel;

class AdminTestimonialController extends BaseController
{
    protected TestimonialModel $model;

    public function __construct()
    {
        $this->model = new TestimonialModel();
    }

    public function index()
    {
        $testimonials = $this->model->where('deleted_at', null)->orderBy('sort_order', 'ASC')->orderBy('created_at', 'DESC')->findAll();
        return view('Modules\Testimonial\Views\admin\index', [
            'title' => 'Manajemen Testimoni',
            'testimonials' => $testimonials,
            'breadcrumbs' => [['title' => 'Testimoni']],
        ]);
    }

    public function store()
    {
        $photo = null;
        $photoFile = $this->request->getFile('photo');
        if ($photoFile && $photoFile->isValid() && !$photoFile->hasMoved()) {
            $newName = $photoFile->getRandomName();
            $photoFile->move(ROOTPATH . 'public/assets/uploads/testimonials/', $newName);
            $photo = $newName;
        }

        $this->model->insert([
            'name' => $this->request->getPost('name'),
            'position' => $this->request->getPost('position'),
            'institution' => $this->request->getPost('institution'),
            'photo' => $photo,
            'rating' => (int)($this->request->getPost('rating') ?: 5),
            'comment' => $this->request->getPost('comment'),
            'is_approved' => $this->request->getPost('is_approved') ? 1 : 0,
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'sort_order' => (int)($this->request->getPost('sort_order') ?: 0),
        ]);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Testimoni berhasil ditambahkan.']);
    }

    public function approve(int $id)
    {
        $testi = $this->model->find($id);
        if (!$testi) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Testimoni tidak ditemukan.']);
        }
        $this->model->update($id, ['is_approved' => $testi['is_approved'] ? 0 : 1]);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Status persetujuan berhasil diubah.']);
    }

    public function toggleFeatured(int $id)
    {
        $testi = $this->model->find($id);
        if (!$testi) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Testimoni tidak ditemukan.']);
        }
        $this->model->update($id, ['is_featured' => $testi['is_featured'] ? 0 : 1]);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Status featured berhasil diubah.']);
    }

    public function update(int $id)
    {
        $this->model->update($id, [
            'name' => $this->request->getPost('name'),
            'position' => $this->request->getPost('position'),
            'institution' => $this->request->getPost('institution'),
            'rating' => (int)$this->request->getPost('rating'),
            'comment' => $this->request->getPost('comment'),
            'is_approved' => $this->request->getPost('is_approved') ? 1 : 0,
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'sort_order' => (int)($this->request->getPost('sort_order') ?: 0),
        ]);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Testimoni berhasil diperbarui.']);
    }

    public function delete(int $id)
    {
        $this->model->delete($id);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Testimoni berhasil dihapus.']);
    }
}
