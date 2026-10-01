<?php

namespace Modules\Website\Models;

use App\Models\BaseModel;

class ContactMessageModel extends BaseModel
{
    protected $table = 'contact_messages';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['name', 'email', 'phone', 'institution', 'subject', 'message', 'is_read', 'reply', 'replied_at', 'ip_address'];
}
