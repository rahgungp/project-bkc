<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginHistoryModel extends Model
{
    protected $table = 'login_history';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = ['user_id', 'ip_address', 'user_agent', 'status', 'created_at'];

    public function log(int $userId, string $status): void
    {
        $request = service('request');
        $this->insert([
            'user_id' => $userId,
            'ip_address' => $request->getIPAddress(),
            'user_agent' => $request->getUserAgent()->getAgentString(),
            'status' => $status,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
