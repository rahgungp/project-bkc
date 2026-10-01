<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FaqsSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['question' => 'Apa itu Bimbingan Teknis (Bimtek)?', 'answer' => 'Bimbingan Teknis (Bimtek) adalah program pelatihan intensif yang dirancang untuk meningkatkan kompetensi teknis peserta di bidang tertentu. Program ini biasanya berlangsung 2-5 hari dan dilaksanakan di hotel berbintang.', 'category' => 'umum', 'sort_order' => 1, 'is_active' => 1],
            ['question' => 'Siapa yang dapat mengikuti pelatihan BKC?', 'answer' => 'Pelatihan BKC terbuka untuk ASN (Aparatur Sipil Negara), BUMN, BUMD, perusahaan swasta, universitas, yayasan, koperasi, dan UMKM. Kami menerima peserta dari seluruh Indonesia.', 'category' => 'umum', 'sort_order' => 2, 'is_active' => 1],
            ['question' => 'Apakah peserta mendapatkan sertifikat?', 'answer' => 'Ya, setiap peserta yang menyelesaikan program pelatihan akan mendapatkan sertifikat resmi dari CV. Bagus Kencana Cakrada. Sertifikat dapat diunduh secara digital melalui platform kami.', 'category' => 'sertifikat', 'sort_order' => 3, 'is_active' => 1],
            ['question' => 'Bagaimana cara mendaftar pelatihan?', 'answer' => 'Anda dapat mendaftar melalui: (1) Website kami dengan mengklik tombol "Daftar Sekarang" pada pelatihan yang dipilih, (2) WhatsApp ke +62 818-0386-7430, (3) Email ke info@bkc.co.id', 'category' => 'pendaftaran', 'sort_order' => 4, 'is_active' => 1],
            ['question' => 'Apakah tersedia program in-house training?', 'answer' => 'Ya, kami menyediakan program In-House Training yang dapat disesuaikan dengan kebutuhan institusi Anda. Silakan hubungi kami untuk konsultasi dan penawaran khusus.', 'category' => 'pelatihan', 'sort_order' => 5, 'is_active' => 1],
            ['question' => 'Di mana pelatihan dilaksanakan?', 'answer' => 'Pelatihan dilaksanakan di hotel-hotel berbintang, resort, dan convention hall terpilih di Bali dan kota-kota besar Indonesia. Setiap pelatihan mencantumkan lokasi yang spesifik.', 'category' => 'lokasi', 'sort_order' => 6, 'is_active' => 1],
            ['question' => 'Apakah biaya pelatihan sudah termasuk akomodasi?', 'answer' => 'Paket biaya pelatihan kami mencakup: biaya pelatihan, materi, sertifikat, konsumsi selama pelatihan, dan coffee break. Untuk akomodasi hotel, biasanya ditanggung oleh peserta atau instansi masing-masing.', 'category' => 'biaya', 'sort_order' => 7, 'is_active' => 1],
        ];
        foreach ($data as &$row) {
            $row['created_at'] = date('Y-m-d H:i:s');
            $row['updated_at'] = date('Y-m-d H:i:s');
        }
        $this->db->table('faqs')->insertBatch($data);
    }
}
