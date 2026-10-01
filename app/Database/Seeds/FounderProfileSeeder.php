<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FounderProfileSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name' => '',
                'title' => 'Pendiri & Direktur Utama CV. Bagus Kencana Cakrada',
                'photo' => null,
                'bio' => 'Pendiri merupakan akademisi dan pakar Akuntansi senior yang berpengalaman lebih dari 20 tahun di bidang pendidikan dan pelatihan profesional. Beliau adalah seorang Dosen, Narasumber, Peneliti, dan Penulis Buku yang telah berkontribusi signifikan dalam pengembangan ilmu Akuntansi di Indonesia.',
                'education' => json_encode([
                    ['degree' => 'S1 Akuntansi', 'university' => 'Universitas Warmadewa (UNWAR)', 'year' => '1995'],
                    ['degree' => 'S2 Akuntansi', 'university' => 'Universitas Udayana (UNUD)', 'year' => '2000'],
                    ['degree' => 'S3 Akuntansi', 'university' => 'Universitas Brawijaya', 'year' => '2008'],
                ]),
                'experience' => json_encode([
                    'Dosen Akuntansi di Perguruan Tinggi Negeri Bali',
                    'Narasumber Nasional Bidang EMBA',
                    'Peneliti Bidang Akuntansi dan Keuangan',
                    'Penulis Buku Teks Akuntansi',
                    'Scopus Author',
                    'Pembimbing Program Kreativitas Mahasiswa (PKM)',
                ]),
                'achievements' => json_encode([
                    'Scopus Author dengan H-Index terverifikasi',
                    'Penulis lebih dari 50 publikasi ilmiah',
                    'Narasumber di lebih dari 200 Bimtek dan Pelatihan',
                    'Pembicara di berbagai Seminar Nasional dan Internasional',
                ]),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('founder_profile')->insertBatch($data);
    }
}
