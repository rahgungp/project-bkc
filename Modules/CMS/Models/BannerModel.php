<?php

namespace Modules\CMS\Models;

use App\Models\BaseModel;

class BannerModel extends BaseModel
{
    protected $table = 'banners';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title', 'subtitle', 'image', 'link', 'position', 'sort_order', 'is_active',
    ];

    /**
     * Returns active banners ordered by sort_order.
     */
    public function getActive(string $position = 'home'): array
    {
        return $this->where('is_active', 1)
                    ->where('position', $position)
                    ->where('deleted_at', null)
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }
}
