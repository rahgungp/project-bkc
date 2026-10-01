<?php

namespace App\Models;

class UserModel extends BaseModel
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'uuid', 'name', 'email', 'password', 'role_id', 'avatar',
        'phone', 'is_active', 'two_fa_secret', 'two_fa_enabled',
        'last_login', 'login_attempts', 'locked_until',
        'reset_token', 'reset_token_expiry'
    ];
    public function withRole(): static
    {
        return $this->select('users.*, roles.name as role_name, roles.slug as role_slug, roles.permissions')
                    ->join('roles', 'roles.id = users.role_id', 'left');
    }

    public function findByEmail(string $email): ?array
    {
        return $this->withRole()->where('users.email', $email)->where('users.deleted_at', null)->first();
    }

    public function isLocked(int $id): bool
    {
        $user = $this->find($id);
        if (!$user) {
            return false;
        }
        return !empty($user['locked_until']) && strtotime($user['locked_until']) > time();
    }

    public function incrementFailedLogin(int $id): void
    {
        $user = $this->find($id);
        if ($user === null) {
            return;
        }
        $attempts = ($user['login_attempts'] ?? 0) + 1;
        $lockedUntil = null;

        if ($attempts >= 5) {
            $lockedUntil = date('Y-m-d H:i:s', strtotime('+30 minutes'));
        }

        $this->update($id, [
            'login_attempts' => $attempts,
            'locked_until' => $lockedUntil,
        ]);
    }

    public function resetLoginAttempts(int $id): void
    {
        $this->update($id, [
            'login_attempts' => 0,
            'locked_until' => null,
            'last_login' => date('Y-m-d H:i:s'),
        ]);
    }
}
