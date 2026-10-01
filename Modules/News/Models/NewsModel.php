<?php

namespace Modules\News\Models;

use App\Models\BaseModel;

class NewsModel extends BaseModel
{
    protected $table = 'news';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'category_id', 'author_id', 'title', 'slug', 'thumbnail', 'excerpt',
        'content', 'tags', 'status', 'is_featured', 'views',
        'meta_title', 'meta_description', 'meta_keywords', 'og_image', 'published_at'
    ];

    public function withCategory(): static
    {
        return $this->select('news.*, news_categories.name as category_name, news_categories.slug as category_slug, users.name as author_name')
                    ->join('news_categories', 'news_categories.id = news.category_id', 'left')
                    ->join('users', 'users.id = news.author_id', 'left');
    }

    public function getPublished(int $limit = 10, int $offset = 0, array $filters = []): array
    {
        $builder = $this->withCategory()->where('news.status', 'published')->where('news.deleted_at', null);

        if (!empty($filters['category'])) {
            $builder->where('news_categories.slug', $filters['category']);
        }
        if (!empty($filters['search'])) {
            $builder->groupStart()->like('news.title', $filters['search'])->orLike('news.excerpt', $filters['search'])->groupEnd();
        }

        return $builder->orderBy('news.published_at', 'DESC')->findAll($limit, $offset);
    }

    public function getPopular(int $limit = 5): array
    {
        return $this->withCategory()->where('news.status', 'published')->where('news.deleted_at', null)->orderBy('news.views', 'DESC')->findAll($limit);
    }

    public function getLatest(int $limit = 5): array
    {
        return $this->withCategory()->where('news.status', 'published')->where('news.deleted_at', null)->orderBy('news.published_at', 'DESC')->findAll($limit);
    }

    public function getBySlug(string $slug): ?array
    {
        return $this->withCategory()->where('news.slug', $slug)->where('news.deleted_at', null)->first();
    }

    public function getFeatured(int $limit = 3): array
    {
        return $this->withCategory()->where('news.status', 'published')->where('news.is_featured', 1)->where('news.deleted_at', null)->orderBy('news.published_at', 'DESC')->findAll($limit);
    }

    public function incrementViews(int $id): void
    {
        $this->set('views', 'views+1', false)->where('id', $id)->update();
    }
}
