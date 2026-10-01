<?php

namespace Modules\Profile\Models;

use App\Models\BaseModel;

class FounderProfileModel extends BaseModel
{
    protected $table = 'founder_profile';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['name', 'title', 'photo', 'bio', 'education', 'experience', 'achievements', 'email', 'linkedin', 'scopus_id', 'google_scholar', 'orcid'];

    public function getMain(): ?array
    {
        $founder = $this->first();
        if ($founder) {
            $founder['education']  = is_string($founder['education'])
                ? (json_decode($founder['education'], true) ?? [])
                : ($founder['education'] ?? []);
            $founder['experience'] = is_string($founder['experience'])
                ? (json_decode($founder['experience'], true) ?? [])
                : ($founder['experience'] ?? []);
        }
        return $founder;
    }
}
