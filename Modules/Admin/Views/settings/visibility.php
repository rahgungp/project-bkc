<?= $this->extend('Modules\Admin\Views\layout\main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1 class="page-title">Visibilitas Seksi</h1>
        <p class="page-subtitle">Tampilkan atau sembunyikan seksi halaman utama website</p>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<form action="<?= base_url('admin/visibilitas/update') ?>" method="POST">
    <?= csrf_field() ?>
    <div class="admin-card" data-aos="fade-up">
        <div class="admin-card-header">
            <h6 class="admin-card-title"><i class="fas fa-toggle-on me-2"></i>Seksi Halaman Beranda</h6>
        </div>
        <div class="admin-card-body">
            <?php
            $sections = [
                'show_section_hero'       => ['label' => 'Hero / Banner Utama',      'icon' => 'fa-image',            'desc' => 'Bagian hero dengan video background dan teks utama'],
                'show_section_about'      => ['label' => 'Tentang Kami',              'icon' => 'fa-info-circle',      'desc' => 'Profil singkat perusahaan di halaman beranda'],
                'show_section_excellence' => ['label' => 'Keunggulan BKC',            'icon' => 'fa-star',             'desc' => 'Grid keunggulan dan nilai lebih BKC'],
                'show_section_kategori'   => ['label' => 'Kategori Pelatihan (EMBA)', 'icon' => 'fa-th-large',         'desc' => 'Tampilkan 4 kategori program EMBA'],
                'show_section_trainings'  => ['label' => 'Pelatihan Unggulan',        'icon' => 'fa-graduation-cap',   'desc' => 'Daftar pelatihan featured/unggulan'],
                'show_section_stats'      => ['label' => 'Keunggulan Layanan',        'icon' => 'fa-award',            'desc' => 'Empat pilar keunggulan layanan BKC'],
                'show_section_layanan'    => ['label' => 'Bidang Usaha / Layanan',    'icon' => 'fa-briefcase',        'desc' => 'Grid layanan Bimtek, Workshop, Seminar, In-House'],
                'show_section_founder'    => ['label' => 'Profil Pendiri',            'icon' => 'fa-user-tie',         'desc' => 'Tampilkan profil singkat pendiri perusahaan'],
                'show_section_cta'        => ['label' => 'CTA / Ajakan Bertindak',   'icon' => 'fa-bullhorn',         'desc' => 'Banner bawah dengan tombol ajakan hubungi/daftar'],
            ];
            ?>
            <div class="row g-3">
                <?php foreach ($sections as $key => $sec): ?>
                <div class="col-md-6">
                    <div style="display:flex; align-items:center; gap:16px; padding:16px 20px; background:var(--bg-primary); border-radius:12px; border:1px solid var(--border-color);">
                        <div style="width:44px; height:44px; background:rgba(200,163,77,0.12); border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <i class="fas <?= $sec['icon'] ?>" style="color:var(--gold); font-size:18px;"></i>
                        </div>
                        <div style="flex:1; min-width:0;">
                            <div style="font-weight:700; font-size:14px; color:var(--text-primary); margin-bottom:2px;"><?= $sec['label'] ?></div>
                            <div style="font-size:12px; color:var(--text-muted);"><?= $sec['desc'] ?></div>
                        </div>
                        <div class="form-check form-switch" style="margin:0;">
                            <input class="form-check-input" type="checkbox" role="switch"
                                   name="<?= $key ?>" id="<?= $key ?>"
                                   <?= ($settings[$key] ?? '1') !== '0' ? 'checked' : '' ?>
                                   style="width:44px; height:24px; cursor:pointer;">
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="mt-4 d-flex gap-3">
                <button type="submit" class="btn btn-primary" style="background:var(--gold); border-color:var(--gold); color:#121212; font-weight:700; border-radius:10px; padding:10px 28px;">
                    <i class="fas fa-save me-2"></i>Simpan Pengaturan
                </button>
                <button type="button" class="btn btn-outline-secondary" style="border-radius:10px; padding:10px 20px;"
                        onclick="document.querySelectorAll('.form-check-input').forEach(el=>el.checked=true)">
                    <i class="fas fa-eye me-2"></i>Tampilkan Semua
                </button>
            </div>
        </div>
    </div>
</form>

<?= $this->endSection() ?>
