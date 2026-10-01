<?php

namespace Modules\Training\Models;

use App\Models\BaseModel;

class TrainingModel extends BaseModel
{
    protected $table = 'trainings';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'uuid', 'category_id', 'location_id', 'title', 'slug', 'cover',
        'brochure', 'short_description', 'description', 'benefits', 'materials',
        'target_segment', 'duration_days', 'duration_hours', 'price', 'price_info',
        'max_participants', 'current_participants', 'start_date', 'end_date',
        'registration_deadline', 'status', 'is_featured', 'is_online', 'online_link',
        'certificate_template', 'meta_title', 'meta_description', 'meta_keywords',
        'og_image', 'views', 'sort_order', 'created_by', 'updated_by'
    ];

    public function withCategory(): static
    {
        return $this->select('trainings.*, training_categories.name as category_name, training_categories.slug as category_slug, training_categories.icon as category_icon, training_categories.color as category_color')
                    ->join('training_categories', 'training_categories.id = trainings.category_id', 'left');
    }

    public function withLocation(): static
    {
        return $this->select('trainings.*, locations.name as location_name, locations.city as location_city, locations.type as location_type, locations.stars as location_stars')
                    ->join('locations', 'locations.id = trainings.location_id', 'left');
    }

    public function withAll(): static
    {
        return $this->select('trainings.*, training_categories.name as category_name, training_categories.slug as category_slug, training_categories.icon as category_icon, training_categories.color as category_color, locations.name as location_name, locations.city as location_city, locations.type as location_type, locations.stars as location_stars')
                    ->join('training_categories', 'training_categories.id = trainings.category_id', 'left')
                    ->join('locations', 'locations.id = trainings.location_id', 'left');
    }

    public function getPublished(int $limit = 9, int $offset = 0, array $filters = []): array
    {
        $builder = $this->withAll()->where('trainings.status', 'published')->where('trainings.deleted_at', null);

        if (!empty($filters['category'])) {
            $builder->where('training_categories.slug', $filters['category']);
        }
        if (!empty($filters['search'])) {
            $builder->groupStart()
                    ->like('trainings.title', $filters['search'])
                    ->orLike('trainings.short_description', $filters['search'])
                    ->groupEnd();
        }
        if (!empty($filters['segment'])) {
            $builder->like('trainings.target_segment', $filters['segment']);
        }

        return $builder->orderBy('trainings.start_date', 'ASC')->findAll($limit, $offset);
    }

    public function getUpcoming(int $limit = 6): array
    {
        return $this->withAll()
                    ->where('trainings.status', 'published')
                    ->where('trainings.start_date >=', date('Y-m-d'))
                    ->where('trainings.deleted_at', null)
                    ->orderBy('trainings.start_date', 'ASC')
                    ->findAll($limit);
    }

    public function getFeatured(int $limit = 3): array
    {
        return $this->withAll()
                    ->where('trainings.status', 'published')
                    ->where('trainings.is_featured', 1)
                    ->where('trainings.deleted_at', null)
                    ->orderBy('trainings.sort_order', 'ASC')
                    ->findAll($limit);
    }

    public function getBySlug(string $slug): ?array
    {
        return $this->withAll()
                    ->where('trainings.slug', $slug)
                    ->where('trainings.deleted_at', null)
                    ->first();
    }

    public function incrementViews(int $id): void
    {
        $this->set('views', 'views+1', false)->where('id', $id)->update();
    }

    public function getForCalendar(): array
    {
        return $this->select('trainings.id, trainings.title, trainings.slug, trainings.start_date, trainings.end_date, trainings.status, training_categories.name as category_name, training_categories.color as category_color')
                    ->join('training_categories', 'training_categories.id = trainings.category_id', 'left')
                    ->where('trainings.status !=', 'draft')
                    ->where('trainings.deleted_at', null)
                    ->findAll();
    }
}
