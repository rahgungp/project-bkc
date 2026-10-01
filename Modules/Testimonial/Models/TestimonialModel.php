<?php

namespace Modules\Testimonial\Models;

use App\Models\BaseModel;

class TestimonialModel extends BaseModel
{
    protected $table = 'testimonials';
    protected $primaryKey = 'id';
    protected $allowedFields = ['training_id', 'name', 'position', 'institution', 'photo', 'rating', 'comment', 'is_approved', 'is_featured', 'sort_order'];

    public function getApproved(int $limit = 12): array
    {
        return $this->where('is_approved', 1)->where('deleted_at', null)->orderBy('sort_order', 'ASC')->findAll($limit);
    }

    public function getFeatured(int $limit = 6): array
    {
        return $this->where('is_approved', 1)->where('is_featured', 1)->where('deleted_at', null)->orderBy('sort_order', 'ASC')->findAll($limit);
    }
}
