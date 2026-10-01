<?= $this->extend('Modules\Website\Views\layout\main') ?>
<?= $this->section('content') ?>

<style>
/* ===== ABOUT PAGE STYLES ===== */
/* ---- Hero ---- */
.about-hero {
    background: linear-gradient(135deg, #1E4FA3 0%, #152f6b 55%, #0d1f45 100%);
    padding: 110px 0 80px;
    position: relative;
    overflow: hidden;
    text-align: center;
}
.about-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle at 20% 50%, rgba(200,163,77,0.1) 0%, transparent 50%),
                      radial-gradient(circle at 80% 20%, rgba(200,163,77,0.08) 0%, transparent 50%);
}
.about-hero-badge {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(200,163,77,0.15);
    border: 1px solid rgba(200,163,77,0.4);
    color: #C8A34D;
    padding: 6px 20px;
    border-radius: 50px;
    font-size: 12px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase;
    margin-bottom: 22px;
}
.about-hero h1 { font-size: clamp(2.2rem, 5vw, 3.8rem); font-weight: 800; color: #fff; margin-bottom: 16px; }
.about-hero-sub { font-size: 16px; color: rgba(255,255,255,0.7); max-width: 520px; margin: 0 auto; }
.hero-breadcrumb { margin-top: 24px; display: flex; justify-content: center; gap: 8px; font-size: 13px; color: rgba(255,255,255,0.5); }
.hero-breadcrumb a { color: rgba(255,255,255,0.7); text-decoration: none; }
.hero-breadcrumb a:hover { color: #C8A34D; }

/* ---- Section utility ---- */
.section-padding { padding: 90px 0; }
.section-label { font-size: 12px; text-transform: uppercase; letter-spacing: 2.5px; color: #C8A34D; font-weight: 700; margin-bottom: 10px; }
.section-title { font-size: clamp(1.6rem, 3.5vw, 2.4rem); font-weight: 800; color: #1a1a2e; margin-bottom: 0; line-height: 1.2; }
.section-divider { width: 60px; height: 3px; background: linear-gradient(to right, #C8A34D, transparent); margin: 16px 0 22px; border-radius: 2px; }

/* ---- About section ---- */
.about-img-wrap { position: relative; }
.about-img-wrap img { border-radius: 20px; width: 100%; object-fit: cover; aspect-ratio: 4/3; }
.about-img-badge {
    position: absolute; bottom: -16px; right: -16px;
    background: linear-gradient(135deg,#C8A34D,#e8c46d);
    color: #121212;
    border-radius: 16px;
    padding: 16px 20px;
    font-weight: 800; font-size: 13px;
    box-shadow: 0 8px 24px rgba(200,163,77,0.35);
    text-align: center;
    min-width: 100px;
}
.about-img-badge .big { font-size: 28px; font-weight: 900; line-height: 1; display: block; }

/* ---- Vision Mission ---- */
.vm-section { background: #f5f7fa; }
.vm-card {
    background: #fff;
    border-radius: 20px;
    padding: 36px 30px;
    height: 100%;
    border: 1px solid rgba(0,0,0,0.05);
    transition: all 0.3s;
}
.vm-card:hover { box-shadow: 0 8px 30px rgba(0,0,0,0.08); transform: translateY(-4px); }
.vm-icon {
    width: 64px; height: 64px;
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    font-size: 26px;
    margin-bottom: 20px;
}
.vm-icon-gold { background: linear-gradient(135deg,#C8A34D,#e8c46d); color: #fff; }
.vm-icon-blue { background: linear-gradient(135deg,#1E4FA3,#3b82f6); color: #fff; }
.vm-title { font-size: 1.3rem; font-weight: 800; color: #1a1a2e; margin-bottom: 12px; }
.vm-text { font-size: 14px; color: #666; line-height: 1.8; }
.vm-list { list-style: none; padding: 0; margin: 0; }
.vm-list li { padding: 6px 0; font-size: 14px; color: #555; display: flex; align-items: flex-start; gap: 10px; }
.vm-list li::before { content: ''; width: 8px; height: 8px; background: #C8A34D; border-radius: 50%; flex-shrink: 0; margin-top: 6px; }

/* ---- Stats counter ---- */
.stats-section { background: linear-gradient(135deg,#1E4FA3 0%,#152f6b 100%); }
.stat-counter-card { text-align: center; padding: 20px 16px; }
.stat-counter-value { font-size: clamp(2.4rem,5vw,3.5rem); font-weight: 900; color: #C8A34D; line-height: 1; display: block; }
.stat-counter-suffix { font-size: 1.5rem; font-weight: 800; color: #C8A34D; }
.stat-counter-label { font-size: 14px; color: rgba(255,255,255,0.75); margin-top: 8px; font-weight: 600; letter-spacing: 0.5px; }
.stat-divider { width: 1px; background: rgba(255,255,255,0.15); height: 80px; align-self: center; }

/* ---- Why Us / Keunggulan ---- */
.keunggulan-section { background: #fff; }
.keunggulan-card {
    background: #f9fafc;
    border: 1px solid rgba(0,0,0,0.05);
    border-radius: 18px;
    padding: 30px 26px;
    height: 100%;
    transition: all 0.3s;
    position: relative;
    overflow: hidden;
}
.keunggulan-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(to right,#C8A34D,#e8c46d);
    opacity: 0;
    transition: opacity 0.3s;
}
.keunggulan-card:hover { box-shadow: 0 8px 30px rgba(200,163,77,0.12); transform: translateY(-4px); }
.keunggulan-card:hover::before { opacity: 1; }
.keunggulan-icon { font-size: 32px; color: #C8A34D; margin-bottom: 16px; }
.keunggulan-title { font-size: 1rem; font-weight: 800; color: #1a1a2e; margin-bottom: 10px; }
.keunggulan-text { font-size: 13.5px; color: #666; line-height: 1.7; }

/* ---- Founder section ---- */
.founder-section { background: #f5f7fa; }
.founder-card {
    background: #fff;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 8px 40px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,0,0,0.05);
}
.founder-photo-col { background: linear-gradient(135deg,#1E4FA3,#152f6b); }
.founder-photo-wrap { padding: 40px 30px; text-align: center; }
.founder-photo-wrap img {
    width: 200px; height: 200px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #C8A34D;
    box-shadow: 0 8px 30px rgba(0,0,0,0.3);
}
.founder-photo-placeholder {
    width: 200px; height: 200px;
    border-radius: 50%;
    background: rgba(200,163,77,0.15);
    border: 4px solid #C8A34D;
    display: flex; align-items: center; justify-content: center;
    font-size: 60px; color: #C8A34D;
    margin: 0 auto;
}
.founder-name { font-size: 1.5rem; font-weight: 800; color: #fff; margin-top: 20px; line-height: 1.2; }
.founder-title-text { font-size: 13px; color: #C8A34D; font-weight: 600; margin-top: 6px; }
.founder-links { display: flex; justify-content: center; gap: 12px; margin-top: 18px; }
.founder-link {
    width: 38px; height: 38px;
    border-radius: 50%;
    background: rgba(255,255,255,0.1);
    display: flex; align-items: center; justify-content: center;
    color: #fff;
    text-decoration: none;
    transition: all 0.3s;
    font-size: 15px;
}
.founder-link:hover { background: #C8A34D; color: #121212; }
.founder-info-col { padding: 40px 36px; }
.edu-badge {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(200,163,77,0.1);
    border: 1px solid rgba(200,163,77,0.3);
    color: #b38b30;
    padding: 4px 12px;
    border-radius: 50px;
    font-size: 11.5px;
    font-weight: 600;
    margin-bottom: 4px;
}
.founder-bio { font-size: 14px; color: #555; line-height: 1.8; }

/* ---- Responsive ---- */
@media (max-width: 768px) {
    .section-padding { padding: 60px 0; }
    .about-img-badge { right: 0; }
    .founder-info-col { padding: 24px 20px; }
    .stat-divider { display: none; }
}
</style>

<!-- ===== HERO ===== -->
<section class="about-hero">
    <div class="container position-relative">
        <div data-aos="fade-up">
            <div class="about-hero-badge"><i class="fas fa-info-circle"></i> Tentang Kami</div>
            <h1><?= esc($profile['company_tagline'] ?? 'Building Knowledge & Capacity') ?></h1>
            <p class="about-hero-sub">Mitra terpercaya dalam pengembangan Sumber Daya Manusia profesional di Indonesia.</p>
            <div class="hero-breadcrumb">
                <a href="<?= base_url() ?>">Beranda</a>
                <span>/</span>
                <span style="color:rgba(255,255,255,0.9);">Tentang Kami</span>
            </div>
        </div>
    </div>
</section>

<!-- ===== ABOUT SECTION ===== -->
<section class="section-padding" style="background:#fff;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5" data-aos="fade-right">
                <div class="about-img-wrap">
                    <?php if (!empty($profile['company_logo'])): ?>
                    <img src="<?= base_url('assets/images/logo/' . $profile['company_logo']) ?>" alt="BKC" loading="lazy">
                    <?php else: ?>
                    <img src="<?= base_url('assets/images/logo/logo_BKC_1.png') ?>" alt="BKC" loading="lazy" onerror="this.parentElement.innerHTML='<div style=\'background:linear-gradient(135deg,#1E4FA3,#152f6b);border-radius:20px;aspect-ratio:4/3;display:flex;align-items:center;justify-content:center;\'><i class=\'fas fa-graduation-cap\' style=\'font-size:80px;color:rgba(200,163,77,0.5);\'></i></div>'">
                    <?php endif; ?>
                    <div class="about-img-badge">
                        <span class="big"><?= $profile['stats_years'] ?? date('Y') - 2018 ?>+</span>
                        Tahun Pengalaman
                    </div>
                </div>
            </div>
            <div class="col-lg-7" data-aos="fade-left">
                <div class="section-label">Profil Perusahaan</div>
                <h2 class="section-title">CV. Bagus Kencana Cakrada</h2>
                <div class="section-divider"></div>
                <div style="font-size:15px; color:#444; line-height:1.9; margin-bottom:20px;">
                    <?= nl2br(esc($profile['about_long'] ?? $profile['about'] ?? 'CV. Bagus Kencana Cakrada adalah lembaga pelatihan dan pengembangan SDM profesional yang berkomitmen untuk meningkatkan kompetensi sumber daya manusia melalui program Bimbingan Teknis (Bimtek), Workshop, Seminar, dan Pelatihan bidang EMBA (Ekonomi, Bisnis, Manajemen, dan Akuntansi).')) ?>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-6">
                        <div style="display:flex; align-items:center; gap:10px; font-size:14px; color:#444;">
                            <i class="fas fa-check-circle" style="color:#C8A34D; font-size:18px; flex-shrink:0;"></i>
                            Tenaga Pengajar Berpengalaman
                        </div>
                    </div>
                    <div class="col-6">
                        <div style="display:flex; align-items:center; gap:10px; font-size:14px; color:#444;">
                            <i class="fas fa-check-circle" style="color:#C8A34D; font-size:18px; flex-shrink:0;"></i>
                            Kurikulum Terstandarisasi
                        </div>
                    </div>
                    <div class="col-6">
                        <div style="display:flex; align-items:center; gap:10px; font-size:14px; color:#444;">
                            <i class="fas fa-check-circle" style="color:#C8A34D; font-size:18px; flex-shrink:0;"></i>
                            Sertifikat Keikutsertaan
                        </div>
                    </div>
                    <div class="col-6">
                        <div style="display:flex; align-items:center; gap:10px; font-size:14px; color:#444;">
                            <i class="fas fa-check-circle" style="color:#C8A34D; font-size:18px; flex-shrink:0;"></i>
                            Program In-House Training
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="<?= base_url('kontak') ?>" class="btn" style="background:linear-gradient(135deg,#C8A34D,#e8c46d); color:#121212; font-weight:700; border-radius:50px; padding:13px 30px; font-size:14px; border:none;">
                        <i class="fas fa-phone-alt me-2"></i>Hubungi Kami
                    </a>
                    <a href="<?= base_url('pelatihan') ?>" class="btn btn-outline-primary ms-3" style="border-radius:50px; padding:13px 30px; font-size:14px; color:#1E4FA3; border-color:#1E4FA3;">
                        <i class="fas fa-graduation-cap me-2"></i>Lihat Pelatihan
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== VISION & MISSION ===== -->
<section class="section-padding vm-section">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="section-label" style="display:block; text-align:center;">Arah & Tujuan</div>
            <h2 class="section-title">Visi & Misi</h2>
            <div class="section-divider" style="margin: 16px auto 0;"></div>
        </div>
        <div class="row g-4">
            <!-- Vision -->
            <div class="col-md-6" data-aos="fade-right">
                <div class="vm-card">
                    <div class="vm-icon vm-icon-gold"><i class="fas fa-eye"></i></div>
                    <div class="vm-title">Visi</div>
                    <p class="vm-text"><?= esc($profile['vision'] ?? 'Menjadi lembaga pelatihan dan pengembangan SDM terkemuka dan terpercaya di Indonesia, yang berkontribusi nyata dalam peningkatan kompetensi profesional sumber daya manusia untuk mendukung kemajuan bangsa.') ?></p>
                </div>
            </div>
            <!-- Mission -->
            <div class="col-md-6" data-aos="fade-left">
                <div class="vm-card">
                    <div class="vm-icon vm-icon-blue"><i class="fas fa-bullseye"></i></div>
                    <div class="vm-title">Misi</div>
                    <?php
                    $misi = $profile['mission'] ?? null;
                    if ($misi && is_array($misi)): ?>
                    <ul class="vm-list">
                        <?php foreach ($misi as $m): ?>
                        <li><?= esc($m) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php else: ?>
                    <ul class="vm-list">
                        <li>Menyelenggarakan program pelatihan berkualitas tinggi yang relevan dengan kebutuhan industri.</li>
                        <li>Menghadirkan tenaga pengajar berpengalaman dan kompeten di bidangnya.</li>
                        <li>Membangun jaringan kemitraan strategis dengan instansi pemerintah dan swasta.</li>
                        <li>Mengembangkan kurikulum yang adaptif mengikuti perkembangan ilmu pengetahuan terkini.</li>
                    </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== STATS COUNTER ===== -->
<section class="section-padding stats-section">
    <div class="container">
        <div class="row align-items-center justify-content-center g-0" data-aos="fade-up">
            <!-- Trainings -->
            <div class="col-6 col-md-3">
                <div class="stat-counter-card">
                    <span class="stat-counter-value" data-target="<?= $profile['stats_trainings'] ?? 150 ?>">0</span>
                    <span class="stat-counter-suffix d-none">+</span>
                    <div class="stat-counter-label">Program Pelatihan</div>
                </div>
            </div>
            <div class="d-none d-md-block col-md-auto stat-divider"></div>
            <!-- Clients -->
            <div class="col-6 col-md-3">
                <div class="stat-counter-card">
                    <span class="stat-counter-value" data-target="<?= $profile['total_clients'] ?? $profile['stats_institutions'] ?? 120 ?>">0</span>
                    <span class="stat-counter-suffix d-none">+</span>
                    <div class="stat-counter-label">Instansi / Klien</div>
                </div>
            </div>
            <div class="d-none d-md-block col-md-auto stat-divider"></div>
            <!-- Certificates -->
            <div class="col-6 col-md-3">
                <div class="stat-counter-card">
                    <span class="stat-counter-value" data-target="<?= $profile['total_certificates'] ?? $profile['stats_participants'] ?? 2000 ?>">0</span>
                    <span class="stat-counter-suffix d-none">+</span>
                    <div class="stat-counter-label">Sertifikat Diterbitkan</div>
                </div>
            </div>
            <div class="d-none d-md-block col-md-auto stat-divider"></div>
            <!-- Years -->
            <div class="col-6 col-md-3">
                <div class="stat-counter-card">
                    <span class="stat-counter-value" data-target="<?= $profile['total_years'] ?? $profile['stats_years'] ?? (date('Y') - 2018) ?>">0</span>
                    <span class="stat-counter-suffix d-none">+</span>
                    <div class="stat-counter-label">Tahun Pengalaman</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== KEUNGGULAN / WHY US ===== -->
<section class="section-padding keunggulan-section">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="section-label" style="display:block; text-align:center;">Mengapa Memilih Kami</div>
            <h2 class="section-title">Keunggulan BKC</h2>
            <div class="section-divider" style="margin: 16px auto 0;"></div>
            <p style="color:#666; font-size:15px; max-width:520px; margin:16px auto 0;">Kami hadir dengan komitmen penuh memberikan layanan pelatihan terbaik untuk pengembangan SDM Anda.</p>
        </div>
        <div class="row g-4">
            <?php
            $keunggulan = [
                ['icon' => 'fa-chalkboard-teacher', 'title' => 'Pengajar Berpengalaman', 'text' => 'Instruktur berpengalaman dengan latar belakang akademis S2/S3 dan rekam jejak praktisi industri terbukti.'],
                ['icon' => 'fa-award', 'title' => 'Bersertifikat & Terakreditasi', 'text' => 'Setiap peserta menerima sertifikat resmi keikutsertaan yang dapat digunakan sebagai bukti pengembangan kompetensi.'],
                ['icon' => 'fa-book-open', 'title' => 'Kurikulum Terkini', 'text' => 'Materi pelatihan selalu diperbarui mengikuti perkembangan regulasi, teknologi, dan best practice terbaru.'],
                ['icon' => 'fa-users', 'title' => 'Kelas Interaktif', 'text' => 'Metode pembelajaran dua arah, studi kasus nyata, diskusi kelompok, dan simulasi praktik langsung.'],
                ['icon' => 'fa-home', 'title' => 'In-House Training', 'text' => 'Kami siap hadir ke lokasi Anda dengan program pelatihan yang disesuaikan kebutuhan instansi.'],
                ['icon' => 'fa-headset', 'title' => 'Dukungan Purna Pelatihan', 'text' => 'Konsultasi lanjutan dan dukungan teknis tersedia setelah program pelatihan selesai dilaksanakan.'],
            ];
            ?>
            <?php foreach ($keunggulan as $i => $item): ?>
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= ($i % 3) * 80 ?>">
                <div class="keunggulan-card">
                    <div class="keunggulan-icon"><i class="fas <?= $item['icon'] ?>"></i></div>
                    <div class="keunggulan-title"><?= $item['title'] ?></div>
                    <p class="keunggulan-text"><?= $item['text'] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===== FOUNDER SECTION ===== -->
<?php if ($founder): ?>
<section class="section-padding founder-section">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="section-label" style="display:block; text-align:center;">Pemimpin Kami</div>
            <h2 class="section-title">Profil Pendiri</h2>
            <div class="section-divider" style="margin: 16px auto 0;"></div>
        </div>

        <div class="founder-card" data-aos="fade-up">
            <div class="row g-0">
                <!-- Photo Column -->
                <div class="col-md-4 founder-photo-col">
                    <div class="founder-photo-wrap">
                        <?php if (!empty($founder['photo'])): ?>
                        <img src="<?= base_url('assets/uploads/' . $founder['photo']) ?>" alt="<?= esc($founder['name']) ?>" loading="lazy">
                        <?php else: ?>
                        <div class="founder-photo-placeholder"><i class="fas fa-user-tie"></i></div>
                        <?php endif; ?>
                        <div class="founder-name"><?= esc($founder['name'] ?? '') ?></div>
                        <div class="founder-title-text"><?= esc($founder['title'] ?? 'Direktur & Pendiri') ?></div>
                        <div class="founder-links">
                            <?php if (!empty($founder['email'])): ?>
                            <a href="mailto:<?= esc($founder['email']) ?>" class="founder-link" title="Email"><i class="fas fa-envelope"></i></a>
                            <?php endif; ?>
                            <?php if (!empty($founder['linkedin'])): ?>
                            <a href="<?= esc($founder['linkedin']) ?>" target="_blank" rel="noopener" class="founder-link" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                            <?php endif; ?>
                            <?php if (!empty($founder['google_scholar'])): ?>
                            <a href="<?= esc($founder['google_scholar']) ?>" target="_blank" rel="noopener" class="founder-link" title="Google Scholar"><i class="fas fa-graduation-cap"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- Info Column -->
                <div class="col-md-8">
                    <div class="founder-info-col">
                        <div class="section-label" style="margin-bottom:6px;">Biografi</div>
                        <p class="founder-bio"><?= nl2br(esc($founder['bio'] ?? '')) ?></p>

                        <?php if (!empty($founder['education'])): ?>
                        <div class="mt-4">
                            <div style="font-size:13px; font-weight:800; text-transform:uppercase; letter-spacing:1px; color:#1a1a2e; margin-bottom:10px;">
                                <i class="fas fa-university me-2" style="color:#C8A34D;"></i>Riwayat Pendidikan
                            </div>
                            <div class="d-flex flex-wrap gap-2">
                                <?php foreach ($founder['education'] as $edu): ?>
                                <div class="edu-badge">
                                    <i class="fas fa-graduation-cap"></i>
                                    <span><?= esc($edu['degree'] ?? '') ?> – <?= esc($edu['university'] ?? '') ?> (<?= esc($edu['year'] ?? '') ?>)</span>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="mt-4">
                            <a href="<?= base_url('pendiri') ?>" class="btn" style="background:linear-gradient(135deg,#C8A34D,#e8c46d); color:#121212; font-weight:700; border-radius:50px; padding:11px 26px; font-size:14px; border:none;">
                                <i class="fas fa-user-tie me-2"></i>Profil Lengkap
                            </a>
                            <?php if (!empty($founder['linkedin'])): ?>
                            <a href="<?= esc($founder['linkedin']) ?>" target="_blank" rel="noopener" class="btn btn-outline-primary ms-3" style="border-radius:50px; padding:11px 24px; font-size:14px; color:#1E4FA3; border-color:#1E4FA3;">
                                <i class="fab fa-linkedin-in me-2"></i>LinkedIn
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ===== TEAM / ORG STRUCTURE PLACEHOLDER ===== -->
<section class="section-padding" style="background:#fff;">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <div class="section-label" style="display:block; text-align:center;">Tim Kami</div>
            <h2 class="section-title">Struktur Organisasi</h2>
            <div class="section-divider" style="margin: 16px auto 0;"></div>
            <p style="color:#999; font-size:14px; margin-top:30px; font-style:italic;">
                <i class="fas fa-sitemap me-2" style="color:#C8A34D; font-size:40px; display:block; margin-bottom:14px;"></i>
                Bagan struktur organisasi akan ditampilkan di sini.
            </p>
        </div>
    </div>
</section>

<!-- ===== CTA ===== -->
<section style="padding:70px 0; background:linear-gradient(135deg,#1E4FA3,#152f6b);">
    <div class="container text-center" data-aos="fade-up">
        <h2 style="font-size:2rem; font-weight:800; color:#fff; margin-bottom:14px;">Siap Bergabung Bersama Kami?</h2>
        <p style="color:rgba(255,255,255,0.75); font-size:15px; max-width:480px; margin:0 auto 30px;">Tingkatkan kompetensi Anda bersama BKC — mitra terpercaya pengembangan SDM profesional Indonesia.</p>
        <a href="<?= base_url('pelatihan') ?>" class="btn" style="background:linear-gradient(135deg,#C8A34D,#e8c46d); color:#121212; font-weight:700; border-radius:50px; padding:14px 36px; font-size:15px; border:none;">
            <i class="fas fa-graduation-cap me-2"></i>Lihat Program Pelatihan
        </a>
    </div>
</section>

<script>
// ===== Animated counter using Intersection Observer =====
(function () {
    function animateCounter(el) {
        const target = parseInt(el.getAttribute('data-target')) || 0;
        const duration = 1800;
        const start    = performance.now();
        const suffix   = el.nextElementSibling;

        function step(now) {
            const elapsed  = now - start;
            const progress = Math.min(elapsed / duration, 1);
            // Ease-out
            const eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.floor(eased * target).toLocaleString('id-ID');
            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                el.textContent = target.toLocaleString('id-ID');
                if (suffix && suffix.classList.contains('stat-counter-suffix')) {
                    suffix.classList.remove('d-none');
                }
            }
        }
        requestAnimationFrame(step);
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.3 });

    document.querySelectorAll('.stat-counter-value').forEach(el => observer.observe(el));
})();
</script>

<?= $this->endSection() ?>
