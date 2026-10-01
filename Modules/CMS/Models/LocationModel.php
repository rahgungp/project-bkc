<?php

namespace Modules\CMS\Models;

use App\Models\BaseModel;

class LocationModel extends BaseModel
{
    protected $table = 'locations';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'address', 'city', 'province',
        'google_maps', 'phone', 'image', 'stars', 'description', 'facilities',
        'type', 'is_active',
    ];

    /**
     * Returns non-deleted locations ordered by name.
     */
    public function getActive(): array
    {
        return $this->where('deleted_at', null)
                    ->orderBy('name', 'ASC')
                    ->findAll();
    }
}
