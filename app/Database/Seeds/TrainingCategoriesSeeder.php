<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TrainingCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['name' => 'Ekonomi', 'slug' => 'ekonomi', 'icon' => 'fa-chart-line', 'color' => '#C8A34D', 'description' => 'Pelatihan bidang Ekonomi Makro dan Mikro', 'sort_order' => 1],
            ['name' => 'Bisnis', 'slug' => 'bisnis', 'icon' => 'fa-briefcase', 'color' => '#1E4FA3', 'description' => 'Pelatihan bidang Bisnis dan Kewirausahaan', 'sort_order' => 2],
            ['name' => 'Manajemen', 'slug' => 'manajemen', 'icon' => 'fa-sitemap', 'color' => '#2E7D32', 'description' => 'Pelatihan bidang Manajemen Organisasi', 'sort_order' => 3],
            ['name' => 'Akuntansi', 'slug' => 'akuntansi', 'icon' => 'fa-calculator', 'color' => '#B71C1C', 'description' => 'Pelatihan bidang Akuntansi dan Keuangan', 'sort_order' => 4],
        ];
        foreach ($data as &$row) {
            $row['created_at'] = date('Y-m-d H:i:s');
            $row['updated_at'] = date('Y-m-d H:i:s');
        }
        $this->db->table('training_categories')->insertBatch($data);
    }
}
