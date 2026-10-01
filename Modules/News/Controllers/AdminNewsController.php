<?php

namespace Modules\News\Controllers;

use App\Controllers\BaseController;
use Modules\News\Models\NewsModel;
use Modules\News\Models\NewsCategoryModel;

class AdminNewsController extends BaseController
{
    protected NewsModel $model;

    public function __construct()
    {
        $this->model = new NewsModel();
    }

    public function index()
    {
        $news = $this->model->withCategory()
            ->where('news.deleted_at', null)
            ->orderBy('news.created_at', 'DESC')
            ->findAll();

        return view('Modules\News\Views\admin\index', [
            'title' => 'Manajemen Berita',
            'news' => $news,
            'breadcrumbs' => [['title' => 'Berita']],
        ]);
    }

    public function create()
    {
        $categoryModel = new NewsCategoryModel();
        return view('Modules\News\Views\admin\form', [
            'title' => 'Tambah Berita',
            'breadcrumbs' => [['title' => 'Berita', 'url' => base_url('admin/berita')], ['title' => 'Tambah']],
            'categories' => $categoryModel->getActive(),
            'article' => null,
        ]);
    }

    public function store()
    {
        $title = $this->request->getPost('title');
        $slug = $this->model->generateSlug($title);

        $thumbnail = null;
        $thumbFile = $this->request->getFile('thumbnail');
        if ($thumbFile && $thumbFile->isValid() && !$thumbFile->hasMoved()) {
            $newName = $thumbFile->getRandomName();
            $thumbFile->move(ROOTPATH . 'public/assets/uploads/news/', $newName);
            $thumbnail = $newName;
        }

        $status = $this->request->getPost('status');
        $this->model->insert([
            'category_id' => $this->request->getPost('category_id') ?: null,
            'author_id' => session()->get('admin_id'),
            'title' => $title,
            'slug' => $slug,
            'thumbnail' => $thumbnail,
            'excerpt' => $this->request->getPost('excerpt'),
            'content' => $this->request->getPost('content'),
            'tags' => $this->request->getPost('tags'),
            'status' => $status,
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
            'meta_keywords' => $this->request->getPost('meta_keywords'),
            'published_at' => $status === 'published' ? date('Y-m-d H:i:s') : null,
        ]);

        return redirect()->to('/admin/berita')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $article = $this->model->find($id);
        if (!$article) return redirect()->to('/admin/berita')->with('error', 'Berita tidak ditemukan.');

        $categoryModel = new NewsCategoryModel();
        return view('Modules\News\Views\admin\form', [
            'title' => 'Edit Berita',
            'breadcrumbs' => [['title' => 'Berita', 'url' => base_url('admin/berita')], ['title' => 'Edit']],
            'categories' => $categoryModel->getActive(),
            'article' => $article,
        ]);
    }

    public function update(int $id)
    {
        $article = $this->model->find($id);
        if (!$article) return redirect()->to('/admin/berita')->with('error', 'Berita tidak ditemukan.');

        $title = $this->request->getPost('title');
        $data = [
            'category_id' => $this->request->getPost('category_id') ?: null,
            'title' => $title,
            'slug' => $title !== $article['title'] ? $this->model->generateSlug($title, $id) : $article['slug'],
            'excerpt' => $this->request->getPost('excerpt'),
            'content' => $this->request->getPost('content'),
            'tags' => $this->request->getPost('tags'),
            'status' => $this->request->getPost('status'),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
            'meta_keywords' => $this->request->getPost('meta_keywords'),
        ];

        if ($data['status'] === 'published' && !$article['published_at']) {
            $data['published_at'] = date('Y-m-d H:i:s');
        }

        $thumbFile = $this->request->getFile('thumbnail');
        if ($thumbFile && $thumbFile->isValid() && !$thumbFile->hasMoved()) {
            if ($article['thumbnail']) @unlink(ROOTPATH . 'public/assets/uploads/news/' . $article['thumbnail']);
            $newName = $thumbFile->getRandomName();
            $thumbFile->move(ROOTPATH . 'public/assets/uploads/news/', $newName);
            $data['thumbnail'] = $newName;
        }

        $this->model->update($id, $data);
        return redirect()->to('/admin/berita')->with('success', 'Berita berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $this->model->delete($id);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Berita berhasil dihapus.']);
    }
}
