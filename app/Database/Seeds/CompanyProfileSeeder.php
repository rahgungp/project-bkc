<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CompanyProfileSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['key' => 'company_name', 'value' => 'CV. Bagus Kencana Cakrada', 'type' => 'text', 'group' => 'general', 'label' => 'Nama Perusahaan'],
            ['key' => 'company_tagline', 'value' => 'Building Knowledge & Capacity', 'type' => 'text', 'group' => 'general', 'label' => 'Tagline'],
            ['key' => 'company_vision', 'value' => 'Menjadi mitra terpercaya bagi instansi pemerintah dan swasta dalam pengembangan SDM non-formal yang unggul, kompeten, dan adaptif di bidang EMBA (Ekonomi, Bisnis, Manajemen, dan Akuntansi).', 'type' => 'textarea', 'group' => 'about', 'label' => 'Visi'],
            ['key' => 'company_mission', 'value' => json_encode(['Menyelenggarakan Bimtek berkualitas tinggi', 'Menghadirkan narasumber profesional', 'Menyediakan fasilitas hotel terbaik']), 'type' => 'json', 'group' => 'about', 'label' => 'Misi'],
            ['key' => 'company_goal', 'value' => 'Meningkatkan kapasitas SDM melalui pelatihan praktis dan sesuai regulasi.', 'type' => 'textarea', 'group' => 'about', 'label' => 'Tujuan'],
            ['key' => 'company_address', 'value' => 'Jl. Raya Sesetan No. 123, Denpasar Selatan, Bali 80223', 'type' => 'textarea', 'group' => 'contact', 'label' => 'Alamat'],
            ['key' => 'company_email', 'value' => 'info@bkc.co.id', 'type' => 'text', 'group' => 'contact', 'label' => 'Email'],
            ['key' => 'company_phone', 'value' => '+62 818-0386-7430', 'type' => 'text', 'group' => 'contact', 'label' => 'Telepon/WA'],
            ['key' => 'company_whatsapp', 'value' => '6281803867430', 'type' => 'text', 'group' => 'contact', 'label' => 'WhatsApp Number'],
            ['key' => 'company_maps_embed', 'value' => 'https://maps.google.com/maps?q=Denpasar&output=embed', 'type' => 'text', 'group' => 'contact', 'label' => 'Google Maps Embed URL'],
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/bkc.training', 'type' => 'text', 'group' => 'social', 'label' => 'Instagram'],
            ['key' => 'social_facebook', 'value' => 'https://facebook.com/bkc.training', 'type' => 'text', 'group' => 'social', 'label' => 'Facebook'],
            ['key' => 'social_youtube', 'value' => 'https://youtube.com/@bkc-training', 'type' => 'text', 'group' => 'social', 'label' => 'YouTube'],
            ['key' => 'social_linkedin', 'value' => 'https://linkedin.com/company/bkc-training', 'type' => 'text', 'group' => 'social', 'label' => 'LinkedIn'],
            ['key' => 'meta_title', 'value' => 'CV. Bagus Kencana Cakrada - Building Knowledge & Capacity', 'type' => 'text', 'group' => 'seo', 'label' => 'Meta Title'],
            ['key' => 'meta_description', 'value' => 'EMBA.', 'type' => 'textarea', 'group' => 'seo', 'label' => 'Meta Description'],
            ['key' => 'google_analytics', 'value' => '', 'type' => 'text', 'group' => 'seo', 'label' => 'Google Analytics ID'],
            ['key' => 'stats_trainings', 'value' => '100', 'type' => 'text', 'group' => 'stats', 'label' => 'Total Pelatihan'],
            ['key' => 'stats_participants', 'value' => '1000', 'type' => 'text', 'group' => 'stats', 'label' => 'Total Peserta'],
            ['key' => 'stats_institutions', 'value' => '100', 'type' => 'text', 'group' => 'stats', 'label' => 'Total Instansi'],
            ['key' => 'stats_satisfaction', 'value' => '95', 'type' => 'text', 'group' => 'stats', 'label' => 'Kepuasan (%)'],
        ];

        foreach ($data as &$row) {
            $row['created_at'] = date('Y-m-d H:i:s');
            $row['updated_at'] = date('Y-m-d H:i:s');
        }

        $this->db->table('company_profile')->insertBatch($data);
    }
}
