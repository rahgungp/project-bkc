<?= $this->extend('Modules\Website\Views\layout\main') ?>
<?= $this->section('content') ?>

<?php if ($profile['show_section_hero'] ?? 1): ?>
<!-- ====== HERO SECTION ====== -->
<section class="hero-section" id="hero">
    <div class="hero-video-bg">
        <video autoplay muted loop playsinline poster="<?= base_url('assets/images/hero/hero-poster.jpg') ?>">
            <source src="<?= base_url('assets/videos/hero-bg.mp4') ?>" type="video/mp4">
        </video>
        <div class="hero-overlay"></div>
    </div>

    <div class="container">
        <div class="hero-content">
            <div class="row">
                <div class="col-lg-8 col-xl-7">

                    <div class="hero-badge" data-aos="fade-down">
                        <i class="fas fa-award"></i>
                        Mitra Resmi Pengembangan SDM Profesional
                    </div>

                    <h1 class="hero-title">
                        <span class="highlight">Building</span><br>
                        Knowledge<br>&amp; Capacity
                    </h1>

                    <p class="hero-subtitle">
                        <strong>EMBA</strong> — Ekonomi, Bisnis, Manajemen, dan Akuntansi.
                    </p>

                    <div class="hero-buttons">
                        <a href="<?= base_url('pelatihan') ?>" class="btn-hero-primary">
                            <i class="fas fa-graduation-cap"></i>
                            Lihat Pelatihan
                        </a>
                        <a href="<?= base_url('kontak') ?>" class="btn-hero-secondary">
                            <i class="fas fa-phone-alt"></i>
                            Hubungi Kami
                        </a>
                    </div>

                    <div class="hero-stats">
                        <div class="hero-stat">
                            <span class="hero-stat-value"><i class="fas fa-award"></i></span>
                            <span class="hero-stat-label">Sertifikasi Resmi</span>
                        </div>
                        <div class="hero-stat">
                            <span class="hero-stat-value"><i class="fas fa-chalkboard-teacher"></i></span>
                            <span class="hero-stat-label">Narasumber Ahli</span>
                        </div>
                        <div class="hero-stat">
                            <span class="hero-stat-value"><i class="fas fa-book-open"></i></span>
                            <span class="hero-stat-label">Materi Terstandar</span>
                        </div>
                        <div class="hero-stat">
                            <span class="hero-stat-value"><i class="fas fa-handshake"></i></span>
                            <span class="hero-stat-label">Mitra Terpercaya</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="hero-scroll">
        <i class="fas fa-chevron-down"></i>
        <span>Scroll</span>
    </div>
</section>
<?php endif; ?>

<?php if ($profile['show_section_about'] ?? 1): ?>
<!-- ====== ABOUT SECTION ====== -->
<section class="about-section section-padding" id="tentang">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="about-content">
                    <div class="about-badge">
                        <i class="fas fa-star" style="color:var(--gold);"></i>
                        Tentang Kami
                    </div>
                    <h2 class="about-title">CV. Bagus Kencana Cakrada</h2>
                    <p class="about-text">
                        <?= esc($profile['company_vision'] ?? 'Menjadi mitra terpercaya bagi instansi pemerintah dan swasta dalam pengembangan SDM non-formal yang unggul, kompeten, dan adaptif di bidang EMBA.') ?>
                    </p>

                    <div class="about-features">
                        <div class="about-feature" data-aos="fade-up" data-aos-delay="100">
                            <div class="about-feature-icon"><i class="fas fa-eye"></i></div>
                            <div>
                                <div class="about-feature-title">Visi</div>
                                <div class="about-feature-text"><?= esc(substr($profile['company_vision'] ?? '', 0, 120)) ?>...</div>
                            </div>
                        </div>
                        <div class="about-feature" data-aos="fade-up" data-aos-delay="200">
                            <div class="about-feature-icon"><i class="fas fa-rocket"></i></div>
                            <div>
                                <div class="about-feature-title">Misi</div>
                                <div class="about-feature-text">Menyelenggarakan Bimtek berkualitas tinggi dengan narasumber profesional dan fasilitas terbaik.</div>
                            </div>
                        </div>
                        <div class="about-feature" data-aos="fade-up" data-aos-delay="300">
                            <div class="about-feature-icon"><i class="fas fa-bullseye"></i></div>
                            <div>
                                <div class="about-feature-title">Tujuan</div>
                                <div class="about-feature-text"><?= esc($profile['company_goal'] ?? 'Meningkatkan kapasitas SDM melalui pelatihan praktis dan sesuai regulasi.') ?></div>
                            </div>
                        </div>
                    </div>

                    <a href="<?= base_url('tentang') ?>" class="btn-outline-gold-lg mt-4 d-inline-flex">
                        <i class="fas fa-arrow-right"></i> Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left">
                <div class="about-visual">
                    <img src="<?= base_url('assets/images/hero/about-bg.jpg') ?>"
                         alt="CV. Bagus Kencana Cakrada"
                         class="about-img-main"
                         onerror="this.src='https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=600&h=500&fit=crop'">

                    <div class="about-card-floating card-top-right" data-aos="zoom-in" data-aos-delay="300">
                        <div class="card-floating-icon"><i class="fas fa-certificate"></i></div>
                        <div class="card-floating-value" style="font-size:13px;line-height:1.3;">Sertifikat<br>Resmi</div>
                        <div class="card-floating-label">Berstandar Nasional</div>
                    </div>

                    <div class="about-card-floating card-bottom-left" data-aos="zoom-in" data-aos-delay="400">
                        <div class="card-floating-icon"><i class="fas fa-user-tie"></i></div>
                        <div class="card-floating-value" style="font-size:13px;line-height:1.3;">Tim<br>Profesional</div>
                        <div class="card-floating-label">Narasumber Berpengalaman</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if ($profile['show_section_excellence'] ?? 1): ?>
<!-- ====== EXCELLENCE / KEUNGGULAN ====== -->
<section class="excellence-section section-padding" id="keunggulan">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-label">Keunggulan Kami</span>
            <h2 class="section-title">Mengapa Memilih BKC?</h2>
            <p class="section-subtitle">Kami berkomitmen memberikan pelatihan berkualitas tinggi dengan standar internasional untuk pengembangan SDM Indonesia.</p>
        </div>

        <div class="excellence-grid">
            <?php
            $excellences = [
                ['icon' => 'fa-graduation-cap', 'title' => 'Fokus EMBA', 'text' => 'Spesialis di bidang Ekonomi, Bisnis, Manajemen, dan Akuntansi untuk hasil optimal.'],
                ['icon' => 'fa-medal', 'title' => 'Pelatihan Premium', 'text' => 'Fasilitas bintang lima dengan metode pembelajaran modern dan interaktif.'],
                ['icon' => 'fa-lightbulb', 'title' => 'Studi Kasus Nyata', 'text' => 'Pembelajaran berbasis kasus nyata dari praktisi dan akademisi berpengalaman.'],
                ['icon' => 'fa-chalkboard-teacher', 'title' => 'Narasumber Ahli', 'text' => 'Narasumber adalah praktisi dan akademisi terkemuka di bidangnya.'],
                ['icon' => 'fa-shield-alt', 'title' => 'Legal & Terpercaya', 'text' => 'Badan hukum resmi terdaftar dengan pengalaman lebih dari satu dekade.'],
                ['icon' => 'fa-star', 'title' => 'Profesional', 'text' => 'Tim profesional berdedikasi memastikan kepuasan peserta terpenuhi.'],
                ['icon' => 'fa-hotel', 'title' => 'Hotel Berbintang', 'text' => 'Venue pelatihan di hotel dan resort berbintang untuk kenyamanan maksimal.'],
                ['icon' => 'fa-network-wired', 'title' => 'Networking', 'text' => 'Kesempatan membangun jaringan profesional antar peserta dari berbagai instansi.'],
            ];
            foreach ($excellences as $i => $exc): ?>
            <div class="excellence-card" data-aos="fade-up" data-aos-delay="<?= $i * 60 ?>">
                <div class="excellence-icon"><i class="fas <?= $exc['icon'] ?>"></i></div>
                <h3 class="excellence-title"><?= $exc['title'] ?></h3>
                <p class="excellence-text"><?= $exc['text'] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if ($profile['show_section_kategori'] ?? 1): ?>
<!-- ====== KATEGORI PELATIHAN ====== -->
<section class="section-padding" style="background:var(--white);" id="kategori">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-label">Bidang Pelatihan</span>
            <h2 class="section-title">Kategori Program EMBA</h2>
            <p class="section-subtitle">Temukan program pelatihan yang sesuai dengan kebutuhan pengembangan SDM instansi Anda.</p>
        </div>

        <div class="row g-3 justify-content-center">
            <?php foreach ($categories as $i => $cat): ?>
            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="<?= $i * 100 ?>">
                <a href="<?= base_url('pelatihan?category=' . $cat['slug']) ?>"
                   class="d-block p-4 text-center rounded-4 border h-100"
                   style="border-color:rgba(0,0,0,0.08)!important; transition:all 0.3s; text-decoration:none;"
                   onmouseover="this.style.borderColor='<?= esc($cat['color'] ?? '#C8A34D') ?>'; this.style.boxShadow='0 8px 32px rgba(0,0,0,0.1)'; this.style.transform='translateY(-4px)'"
                   onmouseout="this.style.borderColor='rgba(0,0,0,0.08)'; this.style.boxShadow=''; this.style.transform=''">
                    <div style="width:72px; height:72px; border-radius:20px; background:<?= esc($cat['color'] ?? '#C8A34D') ?>20; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; font-size:28px; color:<?= esc($cat['color'] ?? '#C8A34D') ?>;">
                        <i class="fas <?= esc($cat['icon'] ?? 'fa-book') ?>"></i>
                    </div>
                    <h3 style="font-size:18px; font-weight:800; color:var(--dark); margin-bottom:8px;"><?= esc($cat['name']) ?></h3>
                    <p style="font-size:13px; color:var(--gray); margin:0;"><?= esc($cat['description'] ?? '') ?></p>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if ($profile['show_section_trainings'] ?? 1): ?>
<!-- ====== FEATURED TRAININGS ====== -->
<section class="training-section section-padding" id="pelatihan">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-label">Program Pelatihan</span>
            <h2 class="section-title">Pelatihan Unggulan</h2>
            <p class="section-subtitle">Program pelatihan premium kami dirancang untuk mengoptimalkan kompetensi SDM instansi Anda.</p>
        </div>

        <?php if (!empty($featuredTrainings)): ?>
        <div class="row g-4">
            <?php foreach ($featuredTrainings as $i => $training): ?>
            <div class="col-lg-4 col-md-6 training-card-wrap"
                 data-category="<?= esc($training['category_slug']) ?>"
                 data-aos="fade-up"
                 data-aos-delay="<?= $i * 100 ?>">
                <div class="training-card">
                    <div class="training-card-img">
                        <img src="<?= $training['cover'] ? base_url('assets/uploads/training/' . $training['cover']) : 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=400&h=200&fit=crop' ?>"
                             alt="<?= esc($training['title']) ?>"
                             loading="lazy">
                        <div class="training-card-category"
                             style="background:<?= esc($training['category_color'] ?? '#C8A34D') ?>20; color:<?= esc($training['category_color'] ?? '#C8A34D') ?>;">
                            <?= esc($training['category_name']) ?>
                        </div>
                        <?php if ($training['is_featured']): ?>
                        <div class="training-card-badge">Featured</div>
                        <?php endif; ?>
                    </div>

                    <div class="training-card-body">
                        <h3 class="training-card-title"><?= esc($training['title']) ?></h3>

                        <div class="training-card-meta">
                            <span class="training-meta-item">
                                <i class="fas fa-clock"></i> <?= $training['duration_days'] ?> Hari
                            </span>
                            <span class="training-meta-item">
                                <i class="fas fa-map-marker-alt"></i> <?= esc($training['location_name'] ?? 'Bali') ?>
                            </span>
                            <?php if ($training['start_date']): ?>
                            <span class="training-meta-item">
                                <i class="fas fa-calendar"></i> <?= date('d M Y', strtotime($training['start_date'])) ?>
                            </span>
                            <?php endif; ?>
                        </div>

                        <p class="training-card-desc"><?= esc($training['short_description']) ?></p>

                        <?php
                        $quotaPercent = $training['max_participants'] > 0
                            ? round(($training['current_participants'] / $training['max_participants']) * 100)
                            : 0;
                        ?>
                        <div class="training-card-quota">
                            <div class="quota-bar">
                                <div class="quota-fill" style="width:<?= min($quotaPercent, 100) ?>%"></div>
                            </div>
                            <div class="quota-text">
                                <span>Kuota Terisi</span>
                                <span><?= $training['current_participants'] ?>/<?= $training['max_participants'] ?> Peserta</span>
                            </div>
                        </div>

                        <div class="training-card-footer">
                            <a href="<?= base_url('pelatihan/' . $training['slug']) ?>" class="btn-training-detail">
                                <i class="fas fa-eye me-1"></i> Detail
                            </a>
                            <a href="<?= base_url('pelatihan/daftar/' . $training['slug']) ?>" class="btn-training-register">
                                <i class="fas fa-pen me-1"></i> Daftar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="<?= base_url('pelatihan') ?>" class="btn-outline-gold-lg">
                <i class="fas fa-th-list me-2"></i> Lihat Semua Pelatihan
            </a>
        </div>

        <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-graduation-cap"></i>
            <h4>Pelatihan Segera Hadir</h4>
            <p>Kami sedang mempersiapkan program pelatihan terbaik untuk Anda.</p>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

<!-- ====== UPCOMING TRAINING COUNTDOWN ====== -->
<?php if (!empty($upcomingTrainings)):
    $upcoming = $upcomingTrainings[0];
?>
<section class="upcoming-section section-padding">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-7" data-aos="fade-right">
                <div class="upcoming-card">
                    <div class="upcoming-title">
                        <i class="fas fa-fire me-2"></i>Pelatihan Terdekat
                    </div>
                    <h3 class="upcoming-name"><?= esc($upcoming['title']) ?></h3>
                    <div class="upcoming-meta">
                        <span><i class="fas fa-calendar me-1"></i><?= date('d F Y', strtotime($upcoming['start_date'])) ?></span>
                        <span><i class="fas fa-map-marker-alt me-1"></i><?= esc($upcoming['location_name'] ?? 'Bali') ?></span>
                        <span><i class="fas fa-clock me-1"></i><?= $upcoming['duration_days'] ?> Hari</span>
                        <span><i class="fas fa-users me-1"></i><?= $upcoming['max_participants'] - $upcoming['current_participants'] ?> Kursi Tersisa</span>
                    </div>
                    <div class="mt-4 d-flex gap-3">
                        <a href="<?= base_url('pelatihan/' . $upcoming['slug']) ?>" class="btn-hero-secondary" style="padding:12px 24px; font-size:14px;">
                            <i class="fas fa-eye me-1"></i> Lihat Detail
                        </a>
                        <a href="<?= base_url('pelatihan/daftar/' . $upcoming['slug']) ?>" class="btn-hero-primary" style="padding:12px 24px; font-size:14px;">
                            <i class="fas fa-pen me-1"></i> Daftar Sekarang
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-5" data-aos="fade-left">
                <div class="countdown-wrap">
                    <div class="countdown-title">Mulai dalam...</div>
                    <div class="countdown" id="countdownTimer" data-date="<?= $upcoming['start_date'] ?>">
                        <div class="countdown-item">
                            <span class="countdown-value" id="cdDays">00</span>
                            <span class="countdown-label">Hari</span>
                        </div>
                        <span class="countdown-sep">:</span>
                        <div class="countdown-item">
                            <span class="countdown-value" id="cdHours">00</span>
                            <span class="countdown-label">Jam</span>
                        </div>
                        <span class="countdown-sep">:</span>
                        <div class="countdown-item">
                            <span class="countdown-value" id="cdMinutes">00</span>
                            <span class="countdown-label">Menit</span>
                        </div>
                        <span class="countdown-sep">:</span>
                        <div class="countdown-item">
                            <span class="countdown-value" id="cdSeconds">00</span>
                            <span class="countdown-label">Detik</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if ($profile['show_section_stats'] ?? 1): ?>
<!-- ====== KEUNGGULAN ====== -->
<section class="stats-section section-padding-sm">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="0">
                <div class="text-center">
                    <div style="font-size:32px;color:var(--gold);margin-bottom:10px;"><i class="fas fa-award"></i></div>
                    <div class="stat-counter-label" style="font-weight:700;font-size:14px;color:var(--white);">Sertifikasi Resmi</div>
                    <div style="font-size:12px;color:rgba(255,255,255,0.55);margin-top:4px;">Berstandar Nasional</div>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="100">
                <div class="text-center">
                    <div style="font-size:32px;color:var(--gold);margin-bottom:10px;"><i class="fas fa-chalkboard-teacher"></i></div>
                    <div class="stat-counter-label" style="font-weight:700;font-size:14px;color:var(--white);">Narasumber Ahli</div>
                    <div style="font-size:12px;color:rgba(255,255,255,0.55);margin-top:4px;">Praktisi Berpengalaman</div>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="200">
                <div class="text-center">
                    <div style="font-size:32px;color:var(--gold);margin-bottom:10px;"><i class="fas fa-book-open"></i></div>
                    <div class="stat-counter-label" style="font-weight:700;font-size:14px;color:var(--white);">Materi Terstandar</div>
                    <div style="font-size:12px;color:rgba(255,255,255,0.55);margin-top:4px;">Kurikulum Mutakhir</div>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="300">
                <div class="text-center">
                    <div style="font-size:32px;color:var(--gold);margin-bottom:10px;"><i class="fas fa-headset"></i></div>
                    <div class="stat-counter-label" style="font-weight:700;font-size:14px;color:var(--white);">Konsultasi Gratis</div>
                    <div style="font-size:12px;color:rgba(255,255,255,0.55);margin-top:4px;">Siap Membantu Anda</div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>


<!-- ====== FOUNDER PROFILE ====== -->
<?php if ($founder && ($profile['show_section_founder'] ?? 1)): ?>
<section class="founder-section section-padding" id="pendiri">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-4" data-aos="fade-right">
                <div class="founder-image-wrap">
                    <img src="<?= $founder['photo'] ? base_url('assets/uploads/' . $founder['photo']) : 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=420&h=560&fit=crop&crop=faces' ?>"
                         alt="<?= esc($founder['name']) ?>"
                         class="founder-image">
                    <div class="founder-image-frame"></div>
                </div>

                <div class="founder-credentials mt-4">
                    <div class="credential-badge">
                        <div class="credential-icon"><i class="fas fa-university"></i></div>
                        <div>
                            <div class="credential-text">S3 Akuntansi</div>
                            <div class="credential-sub">Universitas Brawijaya</div>
                        </div>
                    </div>
                    <div class="credential-badge">
                        <div class="credential-icon"><i class="fas fa-search"></i></div>
                        <div>
                            <div class="credential-text">Scopus Author</div>
                            <div class="credential-sub">Terindeks Internasional</div>
                        </div>
                    </div>
                    <div class="credential-badge">
                        <div class="credential-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                        <div>
                            <div class="credential-text">200+ Pelatihan</div>
                            <div class="credential-sub">Sebagai Narasumber</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8" data-aos="fade-left">
                <div class="founder-content">
                    <div class="about-badge mb-3">
                        <i class="fas fa-user-tie" style="color:var(--gold);"></i>
                        Profil Pendiri
                    </div>
                    <h2 class="founder-name"><?= esc($founder['name']) ?></h2>
                    <div class="founder-title"><?= esc($founder['title']) ?></div>
                    <?php if (!empty($founder['bio'])): ?><p class="founder-bio"><?= esc($founder['bio']) ?></p><?php endif; ?>

                    <?php if (!empty($founder['education'])): ?>
                    <h4 style="font-size:14px; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:var(--gray); margin-bottom:16px;">Riwayat Pendidikan</h4>
                    <div class="education-list">
                        <?php foreach ($founder['education'] as $edu): ?>
                        <div class="education-item">
                            <i class="fas fa-graduation-cap" style="color:var(--gold); font-size:20px; flex-shrink:0;"></i>
                            <div>
                                <div class="edu-degree"><?= esc($edu['degree'] ?? '') ?></div>
                                <div class="edu-uni"><?= esc($edu['institution'] ?? $edu['university'] ?? '') ?></div>
                            </div>
                            <span style="margin-left:auto; font-size:12px; color:var(--gray); flex-shrink:0;"><?= esc($edu['year_end'] ?? $edu['year_start'] ?? $edu['year'] ?? '') ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($founder['experience'])): ?>
                    <h4 style="font-size:14px; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:var(--gray); margin:24px 0 16px;">Pengalaman</h4>
                    <div class="row g-2">
                        <?php foreach ($founder['experience'] as $exp): ?>
                        <div class="col-auto">
                            <span style="display:inline-flex; align-items:center; gap:6px; padding:6px 14px; background:rgba(200,163,77,0.1); border-radius:20px; font-size:13px; color:var(--dark); font-weight:500;">
                                <i class="fas fa-check-circle" style="color:var(--gold); font-size:11px;"></i>
                                <?php if (is_array($exp)): ?>
                                <?= esc(implode(' – ', array_filter([$exp['position'] ?? '', $exp['company'] ?? '']))) ?>
                                <?php else: ?>
                                <?= esc($exp) ?>
                                <?php endif; ?>
                            </span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <div class="mt-4">
                        <a href="<?= base_url('profil-pendiri') ?>" class="btn-outline-gold-lg">
                            <i class="fas fa-user me-2"></i>Profil Lengkap
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ====== TESTIMONIALS ====== -->
<?php if (!empty($testimonials)): ?>
<section class="testimonial-section section-padding" id="testimoni">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-label">Testimoni</span>
            <h2 class="section-title">Apa Kata Peserta Kami?</h2>
            <p class="section-subtitle">Ribuan peserta dari berbagai instansi telah merasakan manfaat pelatihan BKC.</p>
        </div>

        <div class="row g-4">
            <?php foreach ($testimonials as $i => $testi): ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?= $i * 80 ?>">
                <div class="testimonial-card">
                    <div class="testimonial-stars">
                        <?php for ($s = 1; $s <= 5; $s++): ?>
                        <i class="fas fa-star" style="color:<?= $s <= $testi['rating'] ? 'var(--gold)' : '#ddd' ?>;"></i>
                        <?php endfor; ?>
                    </div>
                    <div class="testimonial-quote"><?= esc($testi['comment']) ?></div>
                    <div class="testimonial-author">
                        <?php if ($testi['photo']): ?>
                        <img src="<?= base_url('assets/uploads/testimonials/' . $testi['photo']) ?>" alt="<?= esc($testi['name']) ?>" class="testimonial-avatar">
                        <?php else: ?>
                        <div class="testimonial-avatar-placeholder"><?= strtoupper(substr($testi['name'], 0, 1)) ?></div>
                        <?php endif; ?>
                        <div>
                            <div class="testimonial-name"><?= esc($testi['name']) ?></div>
                            <div class="testimonial-position"><?= esc($testi['position'] ?? '') ?><?= ($testi['position'] && $testi['institution']) ? ', ' : '' ?><?= esc($testi['institution'] ?? '') ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="<?= base_url('testimoni') ?>" class="btn-outline-gold-lg">
                <i class="fas fa-star me-2"></i>Lihat Semua Testimoni
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ====== FAQ ====== -->
<?php if (!empty($faqs)): ?>
<section class="faq-section section-padding" id="faq">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-label">FAQ</span>
            <h2 class="section-title">Pertanyaan Umum</h2>
            <p class="section-subtitle">Temukan jawaban atas pertanyaan yang sering diajukan tentang program pelatihan kami.</p>
        </div>

        <div class="faq-accordion">
            <?php foreach ($faqs as $i => $faq): ?>
            <div class="faq-item" data-aos="fade-up" data-aos-delay="<?= $i * 60 ?>">
                <button class="faq-question" aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>">
                    <span><?= esc($faq['question']) ?></span>
                    <div class="faq-icon"><i class="fas fa-plus"></i></div>
                </button>
                <div class="faq-answer <?= $i === 0 ? 'open' : '' ?>">
                    <p><?= nl2br(esc($faq['answer'])) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <p style="color:var(--gray); margin-bottom:16px;">Masih ada pertanyaan lain?</p>
            <a href="https://wa.me/6281803867430?text=<?= urlencode('Halo BKC, saya ingin bertanya tentang program pelatihan.') ?>"
               class="btn-primary-gold d-inline-flex w-auto" style="gap:8px;" target="_blank">
                <i class="fab fa-whatsapp" style="font-size:18px;"></i>
                Tanya via WhatsApp
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ====== LATEST NEWS ====== -->
<?php if (!empty($latestNews)): ?>
<section class="news-section section-padding" id="berita">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-label">Berita & Artikel</span>
            <h2 class="section-title">Informasi Terkini</h2>
            <p class="section-subtitle">Ikuti perkembangan terbaru seputar pelatihan, seminar, dan insight dunia EMBA.</p>
        </div>

        <div class="row g-4">
            <?php foreach ($latestNews as $i => $news): ?>
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                <a href="<?= base_url('berita/' . $news['slug']) ?>" style="text-decoration:none;">
                    <div class="news-card">
                        <div class="news-card-img">
                            <img src="<?= $news['thumbnail'] ? base_url('assets/uploads/news/' . $news['thumbnail']) : 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=400&h=200&fit=crop' ?>"
                                 alt="<?= esc($news['title']) ?>"
                                 loading="lazy">
                        </div>
                        <div class="news-card-body">
                            <div class="news-card-category"><?= esc($news['category_name'] ?? 'Berita') ?></div>
                            <h3 class="news-card-title"><?= esc($news['title']) ?></h3>
                            <p class="news-card-excerpt"><?= esc($news['excerpt']) ?></p>
                            <div class="news-card-meta">
                                <span class="news-card-date"><i class="fas fa-calendar"></i><?= date('d M Y', strtotime($news['published_at'] ?? $news['created_at'])) ?></span>
                                <span class="news-card-read">Baca <i class="fas fa-arrow-right"></i></span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="<?= base_url('berita') ?>" class="btn-outline-gold-lg">
                <i class="fas fa-newspaper me-2"></i>Lihat Semua Berita
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if ($profile['show_section_cta'] ?? 1): ?>
<!-- ====== CTA SECTION ====== -->
<section class="section-padding" style="background:linear-gradient(135deg, var(--dark), #1a0a2e);">
    <div class="container text-center" data-aos="zoom-in">
        <div style="max-width:600px; margin:0 auto;">
            <span style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:3px; color:var(--gold); display:block; margin-bottom:16px;">
                Siap Meningkatkan Kapasitas SDM?
            </span>
            <h2 style="font-size:clamp(28px, 4vw, 48px); font-weight:900; color:var(--white); margin-bottom:20px; line-height:1.15;">
                Mulai Perjalanan Pengembangan SDM Anda Hari Ini
            </h2>
            <p style="font-size:16px; color:rgba(255,255,255,0.6); margin-bottom:40px; line-height:1.7;">
                Konsultasikan kebutuhan pelatihan instansi Anda dengan tim ahli BKC secara gratis.
            </p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="<?= base_url('pelatihan') ?>" class="btn-hero-primary">
                    <i class="fas fa-graduation-cap"></i> Pilih Pelatihan
                </a>
                <a href="<?= base_url('request-inhouse') ?>" class="btn-hero-secondary">
                    <i class="fas fa-building"></i> In-House Training
                </a>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?= $this->endSection() ?>
