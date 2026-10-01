<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LocationsSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['name' => 'The Trans Resort Bali', 'type' => 'resort', 'city' => 'Seminyak', 'province' => 'Bali', 'stars' => 5],
            ['name' => 'Bali Nusa Dua Convention Center', 'type' => 'convention_hall', 'city' => 'Nusa Dua', 'province' => 'Bali', 'stars' => 0],
            ['name' => 'Hotel Inna Bali Heritage', 'type' => 'hotel', 'city' => 'Denpasar', 'province' => 'Bali', 'stars' => 4],
            ['name' => 'Padma Resort Legian', 'type' => 'resort', 'city' => 'Legian', 'province' => 'Bali', 'stars' => 5],
            ['name' => 'BKC Training Center', 'type' => 'training_center', 'city' => 'Denpasar', 'province' => 'Bali', 'stars' => 0],
        ];
        foreach ($data as &$row) {
            $row['created_at'] = date('Y-m-d H:i:s');
            $row['updated_at'] = date('Y-m-d H:i:s');
        }
        $this->db->table('locations')->insertBatch($data);
    }
}
