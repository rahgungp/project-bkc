<?php

namespace App\Models;

class RoleModel extends BaseModel
{
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['name', 'slug', 'permissions', 'description', 'is_active'];
}
