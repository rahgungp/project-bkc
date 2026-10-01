<?php

namespace Modules\News\Models;

use App\Models\BaseModel;

class NewsCategoryModel extends BaseModel
{
    protected $table = 'news_categories';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['name', 'slug', 'description', 'sort_order', 'is_active'];

    public function getActive(): array
    {
        return $this->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll();
    }
}
