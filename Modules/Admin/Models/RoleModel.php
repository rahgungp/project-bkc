<?php

namespace Modules\Admin\Models;

use App\Models\BaseModel;

class RoleModel extends BaseModel
{
    protected $table      = 'roles';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'name', 'slug', 'permissions', 'description', 'is_active',
    ];
    protected $useTimestamps = true;

    // ─── Public Methods ───────────────────────────────────────────────────────

    /**
     * Return only active roles.
     */
    public function getActive(): array
    {
        return $this->where('is_active', 1)->findAll();
    }

    /**
     * Return all roles with a count of assigned users.
     */
    public function withUserCount(): static
    {
        return $this->select('roles.*, COUNT(users.id) as user_count')
                    ->join('users', 'users.role_id = roles.id AND users.deleted_at IS NULL', 'left')
                    ->groupBy('roles.id');
    }

    /**
     * Return decoded permissions array for a given role ID.
     *
     * @param int $id
     * @return array
     */
    public function getPermissionsArray(int $id): array
    {
        $role = $this->find($id);
        if (!$role || empty($role['permissions'])) {
            return [];
        }
        $decoded = json_decode($role['permissions'], true);
        return is_array($decoded) ? $decoded : [];
    }
}
