<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'uuid' => '550e8400-e29b-41d4-a716-446655440000',
                'name' => 'Super Admin BKC',
                'email' => 'admin@bkc.co.id',
                'password' => password_hash('Admin@BKC2024!', PASSWORD_ARGON2ID),
                'role_id' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('users')->insertBatch($data);
    }
}
