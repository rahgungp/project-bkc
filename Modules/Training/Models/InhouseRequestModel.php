<?php

namespace Modules\Training\Models;

use App\Models\BaseModel;

class InhouseRequestModel extends BaseModel
{
    protected $table = 'inhouse_requests';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['name', 'email', 'phone', 'institution', 'position', 'topic', 'preferred_date', 'participants_count', 'location_pref', 'budget', 'message', 'status', 'notes'];
}
