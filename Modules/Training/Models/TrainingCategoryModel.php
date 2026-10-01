<?php

namespace Modules\Training\Models;

use App\Models\BaseModel;

class TrainingCategoryModel extends BaseModel
{
    protected $table = 'training_categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'slug', 'icon', 'color', 'description', 'sort_order', 'is_active'];

    public function getActive(): array
    {
        return $this->where('is_active', 1)->where('deleted_at', null)->orderBy('sort_order', 'ASC')->findAll();
    }
}
