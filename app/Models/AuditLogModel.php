<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditLogModel extends Model
{
    protected $table = 'audit_logs';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = ['user_id', 'action', 'module', 'record_id', 'old_values', 'new_values', 'ip_address', 'user_agent', 'created_at'];

    public function withUser(): static
    {
        return $this->select('audit_logs.*, users.name as user_name, users.email as user_email')
                    ->join('users', 'users.id = audit_logs.user_id', 'left');
    }
}
