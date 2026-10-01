<?php

namespace Modules\FAQ\Models;

use App\Models\BaseModel;

class FaqModel extends BaseModel
{
    protected $table = 'faqs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['question', 'answer', 'category', 'sort_order', 'is_active'];

    public function getActive(): array
    {
        return $this->where('is_active', 1)->where('deleted_at', null)->orderBy('sort_order', 'ASC')->findAll();
    }
}
