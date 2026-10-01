<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'Super Admin',
                'slug' => 'super-admin',
                'permissions' => json_encode(['*']),
                'description' => 'Akses penuh ke semua fitur',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'permissions' => json_encode(['training.*', 'news.*', 'gallery.*', 'testimonial.*', 'faq.*', 'registration.*', 'participant.*']),
                'description' => 'Admin dengan akses module utama',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Editor',
                'slug' => 'editor',
                'permissions' => json_encode(['news.*', 'gallery.*']),
                'description' => 'Editor konten berita dan galeri',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Operator',
                'slug' => 'operator',
                'permissions' => json_encode(['registration.view', 'registration.update', 'participant.view']),
                'description' => 'Operator pendaftaran',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('roles')->insertBatch($data);
    }
}
