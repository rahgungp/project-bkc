<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SpeakersSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'Dr. I Made Bagus, S.E., M.Si., Ak., CA.',
                'title' => 'Doktor Akuntansi',
                'speciality' => 'Akuntansi & Keuangan',
                'bio' => 'Pakar Akuntansi senior dengan pengalaman 20+ tahun',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('speakers')->insertBatch($data);
    }
}
