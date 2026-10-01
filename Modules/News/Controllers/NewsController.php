<?php

namespace Modules\News\Controllers;

use App\Controllers\BaseController;
use Modules\News\Models\NewsModel;
use Modules\News\Models\NewsCategoryModel;

class NewsController extends BaseController
{
    public function index()
    {
        $model = new NewsModel();
        $categoryModel = new NewsCategoryModel();

        $page = max(1, (int)($this->request->getGet('page') ?? 1));
        $perPage = 9;
        $offset = ($page - 1) * $perPage;

        $filters = [
            'category' => $this->request->getGet('category') ?? '',
            'search' => $this->request->getGet('search') ?? '',
        ];

        $news = $model->getPublished($perPage, $offset, $filters);
        $total = $model->withCategory()->where('news.status', 'published')->where('news.deleted_at', null)->countAllResults();
        $featured = $model->getFeatured(1);
        $popular = $model->getPopular(5);
        $categories = $categoryModel->getActive();

        return view('Modules\News\Views\index', [
            'meta_title' => 'Berita & Artikel - CV. Bagus Kencana Cakrada',
            'meta_description' => 'Baca berita terbaru seputar pelatihan, seminar, dan insight dunia EMBA dari CV. Bagus Kencana Cakrada.',
            'title' => 'Berita & Artikel',
            'news' => $news,
            'featured' => $featured ? $featured[0] : null,
            'popular' => $popular,
            'categories' => $categories,
            'filters' => $filters,
            'total' => $total,
            'page' => $page,
            'totalPages' => ceil($total / $perPage),
        ]);
    }

    public function detail(string $slug)
    {
        $model = new NewsModel();
        $article = $model->getBySlug($slug);

        if (!$article) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $model->incrementViews($article['id']);

        $related = $model->withCategory()
            ->where('news.category_id', $article['category_id'])
            ->where('news.id !=', $article['id'])
            ->where('news.status', 'published')
            ->where('news.deleted_at', null)
            ->findAll(3);

        $popular = $model->getPopular(5);
        $categoryModel = new NewsCategoryModel();
        $categories = $categoryModel->getActive();

        return view('Modules\News\Views\detail', [
            'meta_title' => ($article['meta_title'] ?: $article['title']) . ' - CV. Bagus Kencana Cakrada',
            'meta_description' => $article['meta_description'] ?: $article['excerpt'],
            'article' => $article,
            'related' => $related,
            'popular' => $popular,
            'categories' => $categories,
        ]);
    }
}
