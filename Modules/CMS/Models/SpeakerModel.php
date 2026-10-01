<?php

namespace Modules\CMS\Models;

use App\Models\BaseModel;

class SpeakerModel extends BaseModel
{
    protected $table = 'speakers';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'title', 'speciality',
        'photo', 'bio', 'email', 'phone',
        'education', 'experience', 'linkedin', 'is_active',
    ];

    /**
     * Returns non-deleted speakers ordered by name.
     */
    public function getActive(): array
    {
        return $this->where('deleted_at', null)
                    ->orderBy('name', 'ASC')
                    ->findAll();
    }
}
