<?= $this->extend('Modules\Website\Views\layout\main') ?>
<?= $this->section('content') ?>

<style>
/* ===== IN-HOUSE TRAINING PAGE ===== */
:root {
    --gold: #C8A34D;
    --gold-light: rgba(200,163,77,0.1);
    --gold-gradient: linear-gradient(135deg, #C8A34D, #E8C56A);
    --royal: #1E4FA3;
    --royal-light: rgba(30,79,163,0.08);
    --dark: #121212;
    --gray: #6B7280;
    --white: #FFFFFF;
    --surface: #F8F9FA;
}

/* ----- HERO ----- */
.inhouse-hero {
    background: linear-gradient(135deg, #0a0a1a 0%, #0d1b3e 55%, #0f0f1a 100%);
    padding: 110px 0 72px;
    position: relative;
    overflow: hidden;
}
.inhouse-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 50% 60% at 80% 40%, rgba(200,163,77,0.08) 0%, transparent 60%),
        radial-gradient(ellipse 40% 50% at 15% 70%, rgba(30,79,163,0.1) 0%, transparent 60%);
}
.inhouse-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 18px;
    background: rgba(200,163,77,0.12);
    border: 1px solid rgba(200,163,77,0.25);
    border-radius: 100px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: #C8A34D;
    margin-bottom: 20px;
}
.inhouse-hero-title {
    font-size: clamp(30px, 4.5vw, 58px);
    font-weight: 900;
    color: #fff;
    line-height: 1.15;
    margin-bottom: 18px;
}
.inhouse-hero-title span { color: #C8A34D; }
.inhouse-hero-subtitle {
    font-size: 17px;
    color: rgba(255,255,255,0.65);
    line-height: 1.75;
    margin-bottom: 36px;
    max-width: 520px;
}

/* Hero benefits grid */
.inhouse-benefit-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 9px 18px;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 100px;
    font-size: 13px;
    color: rgba(255,255,255,0.8);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    transition: all 0.25s;
    margin-bottom: 10px;
}
.inhouse-benefit-pill i { color: #C8A34D; font-size: 14px; }
.inhouse-benefit-pill:hover {
    background: rgba(200,163,77,0.12);
    border-color: rgba(200,163,77,0.3);
    color: #fff;
}

/* Hero right — stats glass card */
.hero-glass-card {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 28px;
    padding: 32px;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}
.hero-glass-stat {
    text-align: center;
    padding: 20px;
    border-radius: 18px;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.06);
}
.hero-glass-stat-val { font-size: 36px; font-weight: 900; color: #C8A34D; line-height: 1; }
.hero-glass-stat-lbl { font-size: 12px; color: rgba(255,255,255,0.5); margin-top: 6px; font-weight: 500; }

/* WA quick contact bar */
.wa-quick-bar {
    background: rgba(37,211,102,0.08);
    border: 1px solid rgba(37,211,102,0.2);
    border-radius: 16px;
    padding: 16px 22px;
    display: flex;
    align-items: center;
    gap: 14px;
    text-decoration: none;
    transition: all 0.3s;
}
.wa-quick-bar:hover {
    background: rgba(37,211,102,0.14);
    border-color: rgba(37,211,102,0.35);
    transform: translateY(-2px);
}
.wa-quick-bar-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    background: #25D366;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: #fff;
    flex-shrink: 0;
}
.wa-quick-bar-text { font-weight: 700; font-size: 14px; color: #121212; }
.wa-quick-bar-sub { font-size: 12px; color: #6B7280; margin-top: 2px; }
.wa-quick-bar-chevron { margin-left: auto; color: #25D366; font-size: 16px; }

/* ----- BENEFITS SECTION ----- */
.benefits-section {
    padding: 72px 0;
    background: #fff;
}
.benefit-card {
    display: flex;
    gap: 20px;
    padding: 28px;
    border-radius: 20px;
    border: 1px solid rgba(0,0,0,0.06);
    background: #fff;
    height: 100%;
    transition: all 0.3s cubic-bezier(0.34,1.56,0.64,1);
}
.benefit-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 48px rgba(0,0,0,0.1);
    border-color: rgba(200,163,77,0.25);
}
.benefit-icon {
    width: 56px;
    height: 56px;
    border-radius: 16px;
    background: linear-gradient(135deg, #C8A34D, #E8C56A);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: #fff;
    flex-shrink: 0;
    box-shadow: 0 8px 24px rgba(200,163,77,0.3);
}
.benefit-title {
    font-size: 16px;
    font-weight: 800;
    color: #121212;
    margin-bottom: 8px;
}
.benefit-text {
    font-size: 14px;
    color: #6B7280;
    line-height: 1.7;
    margin: 0;
}

/* ----- PROCESS STEPS ----- */
.process-section {
    padding: 64px 0;
    background: #f8f9fa;
}
.process-step {
    text-align: center;
    padding: 32px 24px;
    position: relative;
}
.process-step-num {
    width: 56px;
    height: 56px;
    border-radius: 16px;
    background: linear-gradient(135deg, #0a0a1a, #0d1b3e);
    color: #C8A34D;
    font-size: 20px;
    font-weight: 900;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}
.process-step-title { font-size: 16px; font-weight: 800; color: #121212; margin-bottom: 10px; }
.process-step-text { font-size: 14px; color: #6B7280; line-height: 1.7; }
.process-arrow {
    position: absolute;
    right: -16px;
    top: 44px;
    color: #C8A34D;
    font-size: 20px;
    opacity: 0.4;
}

/* ----- FORM SECTION ----- */
.form-section {
    padding: 80px 0;
    background: #fff;
}

/* Form wrapper */
.inhouse-form-wrap {
    background: #fff;
    border-radius: 32px;
    box-shadow: 0 8px 64px rgba(0,0,0,0.1);
    border: 1px solid rgba(0,0,0,0.06);
    overflow: hidden;
}

/* Form header */
.inhouse-form-header {
    background: linear-gradient(135deg, #0a0a1a, #0d1b3e);
    padding: 36px 40px;
    position: relative;
    overflow: hidden;
}
.inhouse-form-header::before {
    content: '';
    position: absolute;
    right: -40px;
    top: -40px;
    width: 200px;
    height: 200px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(200,163,77,0.15) 0%, transparent 70%);
}
.inhouse-form-header-title {
    font-size: 26px;
    font-weight: 900;
    color: #fff;
    margin-bottom: 8px;
}
.inhouse-form-header-sub {
    font-size: 15px;
    color: rgba(255,255,255,0.55);
}

/* Form body */
.inhouse-form-body { padding: 40px; }
@media (max-width: 576px) {
    .inhouse-form-header { padding: 28px 24px; }
    .inhouse-form-body { padding: 28px 24px; }
}

/* Form fields */
.form-group-custom { margin-bottom: 22px; }
.form-label-custom {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: #374151;
    margin-bottom: 8px;
}
.form-label-custom .req { color: #ef4444; margin-left: 3px; }
.form-control-custom {
    width: 100%;
    padding: 13px 18px;
    border-radius: 14px;
    border: 1.5px solid rgba(0,0,0,0.1);
    font-size: 14px;
    color: #121212;
    background: #fafafa;
    outline: none;
    transition: all 0.25s;
    font-family: 'Inter', sans-serif;
}
.form-control-custom:focus {
    border-color: #C8A34D;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(200,163,77,0.1);
}
.form-control-custom::placeholder { color: #9CA3AF; }
.form-control-custom.is-invalid { border-color: #ef4444; }
.form-control-custom.is-invalid:focus { box-shadow: 0 0 0 4px rgba(239,68,68,0.1); }
textarea.form-control-custom { resize: vertical; min-height: 120px; }

/* Select custom */
select.form-control-custom {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 16px center;
    padding-right: 40px;
    appearance: none;
    cursor: pointer;
}

/* Submit button */
.btn-inhouse-submit {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 17px 32px;
    border-radius: 16px;
    background: linear-gradient(135deg, #C8A34D, #E8C56A);
    color: #fff;
    font-size: 16px;
    font-weight: 800;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 8px 32px rgba(200,163,77,0.4);
    letter-spacing: 0.3px;
    position: relative;
    overflow: hidden;
}
.btn-inhouse-submit::before {
    content: '';
    position: absolute;
    top: 0; left: -100%; width: 100%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}
.btn-inhouse-submit:hover::before { left: 100%; }
.btn-inhouse-submit:hover {
    transform: translateY(-3px);
    box-shadow: 0 14px 48px rgba(200,163,77,0.55);
}
.btn-inhouse-submit:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

/* Info sidebar */
.form-info-sidebar { position: sticky; top: 88px; }
.info-card {
    background: linear-gradient(135deg, #0a0a1a, #0d1b3e);
    border-radius: 24px;
    padding: 28px;
    color: #fff;
    margin-bottom: 16px;
    border: 1px solid rgba(200,163,77,0.15);
    position: relative;
    overflow: hidden;
}
.info-card::before {
    content: '';
    position: absolute;
    top: -50px; right: -50px;
    width: 150px; height: 150px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(200,163,77,0.1) 0%, transparent 70%);
}
.info-card-title {
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: rgba(255,255,255,0.4);
    margin-bottom: 6px;
}
.info-card-value {
    font-size: 26px;
    font-weight: 900;
    color: #C8A34D;
    margin-bottom: 4px;
}
.info-card-sub { font-size: 13px; color: rgba(255,255,255,0.5); }

.checklist-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 14px 0;
    border-bottom: 1px solid rgba(255,255,255,0.06);
}
.checklist-item:last-child { border-bottom: none; padding-bottom: 0; }
.checklist-item i { color: #C8A34D; font-size: 16px; flex-shrink: 0; margin-top: 2px; }
.checklist-item-text { font-size: 14px; color: rgba(255,255,255,0.75); line-height: 1.6; }

.white-info-card {
    background: #fff;
    border-radius: 20px;
    padding: 22px;
    border: 1px solid rgba(0,0,0,0.06);
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    margin-bottom: 16px;
}
.white-info-card-title {
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: #9CA3AF;
    margin-bottom: 16px;
}

/* Spinner for submit */
.spinner-sm {
    width: 18px; height: 18px;
    border: 2.5px solid rgba(255,255,255,0.35);
    border-top-color: #fff;
    border-radius: 50%;
    animation: spin 0.7s linear infinite;
    display: none;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* Section header */
.section-label-gold {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2.5px;
    color: #C8A34D;
    display: block;
    margin-bottom: 12px;
}
.section-title-dark {
    font-size: clamp(26px, 3.5vw, 42px);
    font-weight: 900;
    color: #121212;
    margin-bottom: 16px;
    line-height: 1.2;
}
.section-subtitle-gray {
    font-size: 16px;
    color: #6B7280;
    line-height: 1.7;
    max-width: 560px;
    margin: 0 auto;
}

@media (max-width: 991px) {
    .form-info-sidebar { position: static; margin-bottom: 32px; }
    .process-arrow { display: none; }
}
</style>

<!-- ====== HERO ====== -->
<section class="inhouse-hero">
    <div class="container position-relative">
        <div class="row align-items-center g-5">
            <!-- Left -->
            <div class="col-lg-7" data-aos="fade-right">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb" style="--bs-breadcrumb-divider-color:rgba(255,255,255,0.3);">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url() ?>" style="color:rgba(255,255,255,0.5); text-decoration:none; font-size:13px;">
                                <i class="fas fa-home me-1"></i>Beranda
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= site_url('pelatihan') ?>" style="color:rgba(255,255,255,0.5); text-decoration:none; font-size:13px;">Pelatihan</a>
                        </li>
                        <li class="breadcrumb-item active" style="color:rgba(255,255,255,0.75); font-size:13px;">In-House Training</li>
                    </ol>
                </nav>

                <div class="inhouse-hero-badge" data-aos="fade-down">
                    <i class="fas fa-building"></i>
                    Layanan Eksklusif BKC
                </div>

                <h1 class="inhouse-hero-title" data-aos="fade-up" data-aos-delay="100">
                    <span>In-House</span><br>Training Khusus<br>Instansi Anda
                </h1>

                <p class="inhouse-hero-subtitle" data-aos="fade-up" data-aos-delay="150">
                    Program pelatihan yang dirancang khusus sesuai kebutuhan instansi atau perusahaan Anda — kurikulum custom, jadwal fleksibel, di lokasi pilihan Anda.
                </p>

                <!-- Benefit pills -->
                <div class="d-flex flex-wrap gap-2" data-aos="fade-up" data-aos-delay="200">
                    <div class="inhouse-benefit-pill"><i class="fas fa-sliders-h"></i> Kurikulum Custom</div>
                    <div class="inhouse-benefit-pill"><i class="fas fa-calendar-check"></i> Jadwal Fleksibel</div>
                    <div class="inhouse-benefit-pill"><i class="fas fa-map-marker-alt"></i> Lokasi Pilihan</div>
                    <div class="inhouse-benefit-pill"><i class="fas fa-tags"></i> Harga Lebih Efisien</div>
                    <div class="inhouse-benefit-pill"><i class="fas fa-certificate"></i> Sertifikat Resmi</div>
                    <div class="inhouse-benefit-pill"><i class="fas fa-headset"></i> Pendampingan Penuh</div>
                </div>
            </div>

            <!-- Right -->
            <div class="col-lg-5 d-none d-lg-block" data-aos="fade-left" data-aos-delay="250">
                <div class="hero-glass-card">
                    <div style="font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:2px; color:rgba(255,255,255,0.35); margin-bottom:20px; text-align:center;">
                        Keunggulan Layanan
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="hero-glass-stat">
                                <div style="font-size:26px; color:#C8A34D; margin-bottom:6px;"><i class="fas fa-sliders-h"></i></div>
                                <div class="hero-glass-stat-lbl">Kurikulum Custom</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="hero-glass-stat">
                                <div style="font-size:26px; color:#C8A34D; margin-bottom:6px;"><i class="fas fa-calendar-alt"></i></div>
                                <div class="hero-glass-stat-lbl">Jadwal Fleksibel</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="hero-glass-stat">
                                <div style="font-size:26px; color:#C8A34D; margin-bottom:6px;"><i class="fas fa-map-marker-alt"></i></div>
                                <div class="hero-glass-stat-lbl">Lokasi Pilihan</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="hero-glass-stat">
                                <div style="font-size:26px; color:#C8A34D; margin-bottom:6px;"><i class="fas fa-award"></i></div>
                                <div class="hero-glass-stat-lbl">Sertifikat Resmi</div>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top:20px; padding:16px; background:rgba(200,163,77,0.08); border-radius:14px; border:1px solid rgba(200,163,77,0.15);">
                        <div style="font-size:12px; color:rgba(255,255,255,0.4); margin-bottom:6px;">Respon dalam</div>
                        <div style="font-size:20px; font-weight:900; color:#C8A34D;">1 × 24 Jam</div>
                        <div style="font-size:12px; color:rgba(255,255,255,0.4); margin-top:4px;">Tim kami siap menghubungi Anda</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====== BENEFITS SECTION ====== -->
<section class="benefits-section">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label-gold">Mengapa In-House Training BKC?</span>
            <h2 class="section-title-dark">6 Keunggulan Program<br>In-House Training Kami</h2>
            <p class="section-subtitle-gray">
                Kami memahami bahwa setiap instansi memiliki kebutuhan unik. Itulah mengapa kami menyediakan solusi pelatihan yang sepenuhnya disesuaikan.
            </p>
        </div>

        <div class="row g-4">
            <?php
            $inhouseBenefits = [
                [
                    'icon' => 'fa-sliders-h',
                    'title' => 'Kurikulum Sepenuhnya Disesuaikan',
                    'text' => 'Materi pelatihan dirancang khusus sesuai dengan kebutuhan, tantangan, dan tujuan spesifik instansi Anda — bukan program generik.',
                ],
                [
                    'icon' => 'fa-calendar-check',
                    'title' => 'Jadwal Sepenuhnya Fleksibel',
                    'text' => 'Anda menentukan tanggal, durasi, dan frekuensi sesi pelatihan. Kami menyesuaikan jadwal dengan operasional instansi Anda.',
                ],
                [
                    'icon' => 'fa-map-marker-alt',
                    'title' => 'Lokasi Sesuai Kebutuhan',
                    'text' => 'Pelatihan dapat diselenggarakan di kantor Anda, hotel pilihan, atau venue yang kami rekomendasikan — di seluruh Indonesia.',
                ],
                [
                    'icon' => 'fa-coins',
                    'title' => 'Lebih Efisien Secara Biaya',
                    'text' => 'Untuk peserta dalam jumlah besar, biaya per orang jauh lebih ekonomis dibandingkan program publik. Investasi lebih optimal.',
                ],
                [
                    'icon' => 'fa-chalkboard-teacher',
                    'title' => 'Narasumber Ahli Terpilih',
                    'text' => 'Kami menyeleksi narasumber terbaik yang memiliki keahlian spesifik sesuai topik dan industri instansi Anda.',
                ],
                [
                    'icon' => 'fa-shield-alt',
                    'title' => 'Garansi Kualitas & Sertifikat',
                    'text' => 'Setiap peserta mendapatkan sertifikat resmi. Kami menjamin kualitas pelatihan dan memberikan laporan evaluasi komprehensif.',
                ],
            ];
            foreach ($inhouseBenefits as $i => $ben):
            ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?= min($i * 80, 400) ?>">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas <?= $ben['icon'] ?>"></i>
                    </div>
                    <div>
                        <div class="benefit-title"><?= $ben['title'] ?></div>
                        <p class="benefit-text"><?= $ben['text'] ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ====== PROCESS STEPS ====== -->
<section class="process-section">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label-gold">Proses Mudah & Cepat</span>
            <h2 class="section-title-dark text-center">Cara Kerja In-House Training</h2>
        </div>
        <div class="row g-0">
            <?php
            $steps = [
                ['num' => '01', 'icon' => 'fa-file-alt', 'title' => 'Kirim Permintaan', 'text' => 'Isi formulir permintaan In-House Training dengan kebutuhan dan informasi instansi Anda.'],
                ['num' => '02', 'icon' => 'fa-headset', 'title' => 'Konsultasi Tim BKC', 'text' => 'Tim kami menghubungi dalam 1×24 jam untuk diskusi mendalam tentang kebutuhan Anda.'],
                ['num' => '03', 'icon' => 'fa-file-signature', 'title' => 'Proposal & MOU', 'text' => 'Kami menyiapkan proposal terperinci dan penandatanganan MOU kerja sama.'],
                ['num' => '04', 'icon' => 'fa-graduation-cap', 'title' => 'Pelaksanaan', 'text' => 'Pelatihan dilaksanakan sesuai jadwal dengan narasumber ahli dan materi terbaik.'],
            ];
            foreach ($steps as $si => $step):
            ?>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="<?= $si * 100 ?>">
                <div class="process-step">
                    <?php if ($si < 3): ?><div class="process-arrow d-none d-lg-block"><i class="fas fa-chevron-right"></i></div><?php endif; ?>
                    <div class="process-step-num"><?= $step['num'] ?></div>
                    <div class="process-step-title"><?= $step['title'] ?></div>
                    <p class="process-step-text"><?= $step['text'] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ====== FORM SECTION ====== -->
<section class="form-section" id="request-form">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label-gold">Formulir Permintaan</span>
            <h2 class="section-title-dark">Request In-House Training</h2>
            <p class="section-subtitle-gray">Isi formulir di bawah ini dan tim kami akan menghubungi Anda dalam 1×24 jam kerja untuk diskusi lebih lanjut.</p>
        </div>

        <div class="row g-5 align-items-start">

            <!-- Sidebar info (left on desktop) -->
            <div class="col-lg-4 order-lg-1 order-2">
                <div class="form-info-sidebar" data-aos="fade-right" data-aos-delay="100">

                    <!-- Dark card: Why us -->
                    <div class="info-card">
                        <div class="info-card-title">Komitmen Kami</div>
                        <div style="margin-bottom:20px;">
                            <div class="checklist-item">
                                <i class="fas fa-check-circle"></i>
                                <div class="checklist-item-text">Respons dalam 1×24 jam kerja</div>
                            </div>
                            <div class="checklist-item">
                                <i class="fas fa-check-circle"></i>
                                <div class="checklist-item-text">Konsultasi awal gratis tanpa komitmen</div>
                            </div>
                            <div class="checklist-item">
                                <i class="fas fa-check-circle"></i>
                                <div class="checklist-item-text">Proposal disesuaikan kebutuhan</div>
                            </div>
                            <div class="checklist-item">
                                <i class="fas fa-check-circle"></i>
                                <div class="checklist-item-text">Narasumber berpengalaman & tersertifikasi</div>
                            </div>
                            <div class="checklist-item">
                                <i class="fas fa-check-circle"></i>
                                <div class="checklist-item-text">Sertifikat resmi untuk setiap peserta</div>
                            </div>
                            <div class="checklist-item">
                                <i class="fas fa-check-circle"></i>
                                <div class="checklist-item-text">Laporan evaluasi & dokumentasi kegiatan</div>
                            </div>
                        </div>
                    </div>

                    <!-- WA contact -->
                    <a href="https://wa.me/<?= esc($profile['whatsapp'] ?? '6281803867430') ?>?text=<?= urlencode('Halo BKC, saya ingin berdiskusi mengenai program In-House Training untuk instansi kami.') ?>"
                       class="wa-quick-bar" target="_blank" rel="noopener">
                        <div class="wa-quick-bar-icon"><i class="fab fa-whatsapp"></i></div>
                        <div>
                            <div class="wa-quick-bar-text">Chat Langsung via WhatsApp</div>
                            <div class="wa-quick-bar-sub">+62 818-0386-7430 &bull; Resp. Cepat</div>
                        </div>
                        <i class="fas fa-chevron-right wa-quick-bar-chevron"></i>
                    </a>

                    <!-- Quick info -->
                    <div class="white-info-card mt-3">
                        <div class="white-info-card-title">Kontak Tim In-House</div>
                        <div style="display:flex; flex-direction:column; gap:12px;">
                            <div style="display:flex; align-items:center; gap:12px; font-size:13px; color:#374151;">
                                <i class="fab fa-whatsapp" style="color:#25D366; width:18px; font-size:16px;"></i>
                                <a href="tel:+6281803867430" style="text-decoration:none; color:#374151; font-weight:600;">+62 818-0386-7430</a>
                            </div>
                            <div style="display:flex; align-items:center; gap:12px; font-size:13px; color:#374151;">
                                <i class="fas fa-envelope" style="color:#C8A34D; width:18px;"></i>
                                <a href="mailto:<?= esc($profile['email'] ?? 'inhouse@bkc.co.id') ?>" style="text-decoration:none; color:#374151; font-weight:600;"><?= esc($profile['email'] ?? 'inhouse@bkc.co.id') ?></a>
                            </div>
                            <div style="display:flex; align-items:center; gap:12px; font-size:13px; color:#374151;">
                                <i class="fas fa-clock" style="color:#C8A34D; width:18px;"></i>
                                <span>Senin &ndash; Jumat, 08:00 &ndash; 17:00 WITA</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Form (right on desktop) -->
            <div class="col-lg-8 order-lg-2 order-1">
                <div class="inhouse-form-wrap" data-aos="fade-left" data-aos-delay="100">

                    <!-- Form header -->
                    <div class="inhouse-form-header">
                        <div style="position:relative; z-index:1;">
                            <div style="font-size:11px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:rgba(255,255,255,0.4); margin-bottom:8px;">
                                <i class="fas fa-building me-2" style="color:#C8A34D;"></i>Formulir Permintaan
                            </div>
                            <div class="inhouse-form-header-title">Data Instansi & Kebutuhan Pelatihan</div>
                            <div class="inhouse-form-header-sub">Semua field yang bertanda <span style="color:#ef4444;">*</span> wajib diisi</div>
                        </div>
                    </div>

                    <!-- Form body -->
                    <div class="inhouse-form-body">
                        <form id="inhouseForm" novalidate>
                            <?= csrf_field() ?>

                            <!-- Row 1: Perusahaan & Contact Person -->
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">
                                            <i class="fas fa-building me-1" style="color:#C8A34D;"></i>
                                            Nama Perusahaan / Institusi<span class="req">*</span>
                                        </label>
                                        <input type="text"
                                               name="institution"
                                               id="institution"
                                               class="form-control-custom"
                                               placeholder="Contoh: Dinas Pendidikan Kab. Badung"
                                               required>
                                        <div class="invalid-message" id="err-institution" style="display:none; color:#ef4444; font-size:12px; margin-top:5px;"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">
                                            <i class="fas fa-user me-1" style="color:#C8A34D;"></i>
                                            Nama Contact Person<span class="req">*</span>
                                        </label>
                                        <input type="text"
                                               name="name"
                                               id="cpName"
                                               class="form-control-custom"
                                               placeholder="Nama lengkap Anda"
                                               required>
                                        <div class="invalid-message" id="err-name" style="display:none; color:#ef4444; font-size:12px; margin-top:5px;"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Row 2: Jabatan & Email -->
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">
                                            <i class="fas fa-id-badge me-1" style="color:#C8A34D;"></i>
                                            Jabatan / Posisi
                                        </label>
                                        <input type="text"
                                               name="position"
                                               class="form-control-custom"
                                               placeholder="Contoh: Kepala Bagian SDM">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">
                                            <i class="fas fa-envelope me-1" style="color:#C8A34D;"></i>
                                            Alamat Email<span class="req">*</span>
                                        </label>
                                        <input type="email"
                                               name="email"
                                               id="cpEmail"
                                               class="form-control-custom"
                                               placeholder="email@instansi.go.id"
                                               required>
                                        <div class="invalid-message" id="err-email" style="display:none; color:#ef4444; font-size:12px; margin-top:5px;"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Row 3: WhatsApp & Kota -->
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">
                                            <i class="fab fa-whatsapp me-1" style="color:#25D366;"></i>
                                            No. WhatsApp<span class="req">*</span>
                                        </label>
                                        <input type="tel"
                                               name="phone"
                                               id="cpPhone"
                                               class="form-control-custom"
                                               placeholder="08xx-xxxx-xxxx"
                                               required>
                                        <div class="invalid-message" id="err-phone" style="display:none; color:#ef4444; font-size:12px; margin-top:5px;"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">
                                            <i class="fas fa-map-marker-alt me-1" style="color:#C8A34D;"></i>
                                            Kota / Lokasi Pelatihan
                                        </label>
                                        <input type="text"
                                               name="location_pref"
                                               class="form-control-custom"
                                               placeholder="Contoh: Denpasar, Bali">
                                    </div>
                                </div>
                            </div>

                            <!-- Topik -->
                            <div class="form-group-custom">
                                <label class="form-label-custom">
                                    <i class="fas fa-book-open me-1" style="color:#C8A34D;"></i>
                                    Topik / Bidang Pelatihan yang Dibutuhkan<span class="req">*</span>
                                </label>
                                <input type="text"
                                       name="topic"
                                       id="cpTopic"
                                       class="form-control-custom"
                                       placeholder="Contoh: Manajemen Keuangan Daerah, Pengadaan Barang dan Jasa, dll."
                                       required>
                                <div class="invalid-message" id="err-topic" style="display:none; color:#ef4444; font-size:12px; margin-top:5px;"></div>
                            </div>

                            <!-- Row 4: Peserta & Tanggal -->
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">
                                            <i class="fas fa-users me-1" style="color:#C8A34D;"></i>
                                            Estimasi Jumlah Peserta<span class="req">*</span>
                                        </label>
                                        <input type="number"
                                               name="participants_count"
                                               id="cpParticipants"
                                               class="form-control-custom"
                                               placeholder="Contoh: 30"
                                               min="5"
                                               required>
                                        <div class="invalid-message" id="err-participants" style="display:none; color:#ef4444; font-size:12px; margin-top:5px;"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">
                                            <i class="fas fa-calendar-alt me-1" style="color:#C8A34D;"></i>
                                            Estimasi Tanggal Pelaksanaan
                                        </label>
                                        <input type="date"
                                               name="preferred_date"
                                               class="form-control-custom"
                                               min="<?= date('Y-m-d', strtotime('+7 days')) ?>">
                                    </div>
                                </div>
                            </div>

                            <!-- Budget -->
                            <div class="form-group-custom">
                                <label class="form-label-custom">
                                    <i class="fas fa-wallet me-1" style="color:#C8A34D;"></i>
                                    Estimasi Anggaran (Opsional)
                                </label>
                                <select name="budget" class="form-control-custom">
                                    <option value="">-- Pilih Kisaran Anggaran --</option>
                                    <option value="<10jt">Di bawah Rp 10 Juta</option>
                                    <option value="10-25jt">Rp 10 Juta – Rp 25 Juta</option>
                                    <option value="25-50jt">Rp 25 Juta – Rp 50 Juta</option>
                                    <option value="50-100jt">Rp 50 Juta – Rp 100 Juta</option>
                                    <option value=">100jt">Di atas Rp 100 Juta</option>
                                    <option value="negosiasi">Terbuka untuk Negosiasi</option>
                                </select>
                            </div>

                            <!-- Pesan Tambahan -->
                            <div class="form-group-custom">
                                <label class="form-label-custom">
                                    <i class="fas fa-comment-dots me-1" style="color:#C8A34D;"></i>
                                    Pesan Tambahan / Kebutuhan Khusus
                                </label>
                                <textarea name="message"
                                          class="form-control-custom"
                                          placeholder="Sampaikan kebutuhan spesifik, kendala, atau pertanyaan yang ingin Anda diskusikan dengan tim kami..."
                                          rows="5"></textarea>
                            </div>

                            <!-- Privacy notice -->
                            <div style="background:rgba(200,163,77,0.06); border:1px solid rgba(200,163,77,0.15); border-radius:12px; padding:14px 18px; margin-bottom:24px; display:flex; gap:12px; align-items:flex-start;">
                                <i class="fas fa-lock" style="color:#C8A34D; margin-top:2px; flex-shrink:0;"></i>
                                <p style="font-size:13px; color:#6B7280; margin:0; line-height:1.6;">
                                    Data Anda dilindungi dan hanya digunakan untuk keperluan tindak lanjut permintaan In-House Training. Kami tidak membagikan data Anda ke pihak ketiga.
                                </p>
                            </div>

                            <!-- Submit button -->
                            <button type="submit" class="btn-inhouse-submit" id="submitBtn">
                                <span class="spinner-sm" id="submitSpinner"></span>
                                <i class="fas fa-paper-plane" id="submitIcon"></i>
                                <span id="submitText">Kirim Permintaan In-House Training</span>
                            </button>

                        </form>
                    </div><!-- /form-body -->

                </div><!-- /form-wrap -->
            </div>

        </div>
    </div>
</section>

<!-- ====== CLIENT LOGOS / PARTNER CTA ====== -->
<section style="padding:64px 0; background:linear-gradient(135deg, #0a0a1a, #0d1b3e);">
    <div class="container text-center" data-aos="zoom-in">
        <div style="max-width:600px; margin:0 auto;">
            <div class="inhouse-hero-badge d-inline-flex mb-4">
                <i class="fas fa-handshake"></i> Bergabung Bersama Kami
            </div>
            <h2 style="font-size:clamp(24px,3.5vw,40px); font-weight:900; color:#fff; margin-bottom:16px;">
                Ratusan Instansi Telah Mempercayai BKC
            </h2>
            <p style="color:rgba(255,255,255,0.55); font-size:16px; margin-bottom:36px; line-height:1.7;">
                Bergabunglah bersama instansi pemerintah, BUMN, dan perusahaan swasta yang telah merasakan manfaat In-House Training bersama BKC.
            </p>
            <a href="#request-form"
               style="display:inline-flex; align-items:center; gap:10px; padding:15px 36px; border-radius:100px; background:linear-gradient(135deg,#C8A34D,#E8C56A); color:#fff; font-weight:800; font-size:16px; text-decoration:none; box-shadow:0 8px 32px rgba(200,163,77,0.4);">
                <i class="fas fa-arrow-up"></i> Ajukan Sekarang — Gratis
            </a>
        </div>
    </div>
</section>

<script>
(function() {
    const form = document.getElementById('inhouseForm');
    if (!form) return;

    const submitBtn = document.getElementById('submitBtn');
    const submitIcon = document.getElementById('submitIcon');
    const submitText = document.getElementById('submitText');
    const submitSpinner = document.getElementById('submitSpinner');

    // Field refs
    const fields = {
        institution: { el: document.getElementById('institution'), err: document.getElementById('err-institution') },
        name:        { el: document.getElementById('cpName'),       err: document.getElementById('err-name') },
        email:       { el: document.getElementById('cpEmail'),      err: document.getElementById('err-email') },
        phone:       { el: document.getElementById('cpPhone'),      err: document.getElementById('err-phone') },
        topic:       { el: document.getElementById('cpTopic'),      err: document.getElementById('err-topic') },
        participants_count: { el: document.getElementById('cpParticipants'), err: document.getElementById('err-participants') },
    };

    function clearErrors() {
        Object.values(fields).forEach(f => {
            if (f.el) f.el.classList.remove('is-invalid');
            if (f.err) { f.err.style.display = 'none'; f.err.textContent = ''; }
        });
    }

    function showError(key, msg) {
        const f = fields[key];
        if (f && f.el) f.el.classList.add('is-invalid');
        if (f && f.err) { f.err.textContent = msg; f.err.style.display = 'block'; }
    }

    function validateForm() {
        clearErrors();
        let valid = true;

        if (!fields.institution.el.value.trim()) {
            showError('institution', 'Nama perusahaan / institusi wajib diisi.');
            valid = false;
        }
        if (!fields.name.el.value.trim() || fields.name.el.value.trim().length < 3) {
            showError('name', 'Nama contact person minimal 3 karakter.');
            valid = false;
        }
        const emailVal = fields.email.el.value.trim();
        if (!emailVal || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailVal)) {
            showError('email', 'Masukkan alamat email yang valid.');
            valid = false;
        }
        if (!fields.phone.el.value.trim()) {
            showError('phone', 'No. WhatsApp wajib diisi.');
            valid = false;
        }
        if (!fields.topic.el.value.trim() || fields.topic.el.value.trim().length < 5) {
            showError('topic', 'Topik pelatihan minimal 5 karakter.');
            valid = false;
        }
        const pCount = parseInt(fields.participants_count.el.value);
        if (!pCount || pCount < 1) {
            showError('participants_count', 'Estimasi peserta harus lebih dari 0.');
            valid = false;
        }

        return valid;
    }

    function setLoading(loading) {
        submitBtn.disabled = loading;
        submitIcon.style.display = loading ? 'none' : '';
        submitSpinner.style.display = loading ? 'block' : 'none';
        submitText.textContent = loading ? 'Mengirim...' : 'Kirim Permintaan In-House Training';
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        if (!validateForm()) {
            // Scroll to first error
            const firstErr = form.querySelector('.is-invalid');
            if (firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }

        setLoading(true);

        const formData = new FormData(form);

        fetch('<?= site_url('pelatihan/inhouse/kirim') ?>', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: formData,
        })
        .then(res => res.json())
        .then(data => {
            setLoading(false);

            if (data.status === 'success') {
                form.reset();
                clearErrors();

                Swal.fire({
                    icon: 'success',
                    title: 'Permintaan Terkirim!',
                    html: `
                        <div style="text-align:center; padding:8px 0;">
                            <p style="color:#374151; font-size:15px; line-height:1.7; margin-bottom:16px;">
                                ${data.message || 'Terima kasih! Tim BKC akan menghubungi Anda dalam 1×24 jam kerja.'}
                            </p>
                            <div style="background:rgba(200,163,77,0.08); border-radius:12px; padding:14px; font-size:13px; color:#6B7280;">
                                <i class="fab fa-whatsapp" style="color:#25D366;"></i>
                                Atau hubungi langsung: <strong>+62 818-0386-7430</strong>
                            </div>
                        </div>
                    `,
                    confirmButtonText: 'Baik, Terima Kasih!',
                    confirmButtonColor: '#C8A34D',
                    showClass: { popup: 'animate__animated animate__fadeInDown' },
                    customClass: {
                        confirmButton: 'px-5',
                    },
                    width: '480px',
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Mengirim',
                    text: data.message || 'Terjadi kesalahan. Silakan coba lagi atau hubungi kami via WhatsApp.',
                    confirmButtonColor: '#C8A34D',
                });
            }
        })
        .catch(() => {
            setLoading(false);
            Swal.fire({
                icon: 'error',
                title: 'Koneksi Bermasalah',
                text: 'Tidak dapat mengirim permintaan. Periksa koneksi internet Anda atau hubungi kami via WhatsApp.',
                confirmButtonColor: '#C8A34D',
                footer: `<a href="https://wa.me/<?= esc($profile['whatsapp'] ?? '6281803867430') ?>" target="_blank" style="color:#25D366; font-weight:700;"><i class="fab fa-whatsapp me-1"></i>Chat WhatsApp</a>`,
            });
        });
    });

    // Real-time clear error on input
    Object.entries(fields).forEach(([key, f]) => {
        if (f.el) {
            f.el.addEventListener('input', function() {
                this.classList.remove('is-invalid');
                if (f.err) { f.err.style.display = 'none'; f.err.textContent = ''; }
            });
        }
    });
})();
</script>

<?= $this->endSection() ?>
