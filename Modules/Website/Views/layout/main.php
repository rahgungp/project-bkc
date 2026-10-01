<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- SEO Meta -->
    <title><?= isset($meta_title) ? esc($meta_title) : 'CV. Bagus Kencana Cakrada - Building Knowledge & Capacity' ?></title>
    <meta name="description" content="<?= isset($meta_description) ? esc($meta_description) : 'EMBA.' ?>">
    <meta name="keywords" content="<?= isset($meta_keywords) ? esc($meta_keywords) : 'Bimtek, Pelatihan, Workshop, Seminar, EMBA, ASN, SDM, Bali' ?>">

    <!-- Open Graph -->
    <meta property="og:title" content="<?= isset($meta_title) ? esc($meta_title) : 'CV. Bagus Kencana Cakrada' ?>">
    <meta property="og:description" content="<?= isset($meta_description) ? esc($meta_description) : 'Building Knowledge & Capacity' ?>">
    <meta property="og:image" content="<?= isset($og_image) ? base_url($og_image) : base_url('assets/images/og-image.jpg') ?>">
    <meta property="og:url" content="<?= current_url() ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="CV. Bagus Kencana Cakrada">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= isset($meta_title) ? esc($meta_title) : 'CV. Bagus Kencana Cakrada' ?>">
    <meta name="twitter:description" content="<?= isset($meta_description) ? esc($meta_description) : 'Building Knowledge & Capacity' ?>">

    <!-- Canonical -->
    <link rel="canonical" href="<?= current_url() ?>">

    <!-- Favicon -->
    <link rel="icon" href="<?= base_url('assets/images/logo/favicon.png') ?>" type="image/png">
    <link rel="apple-touch-icon" href="<?= base_url('assets/images/logo/apple-touch-icon.png') ?>">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- AOS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Website CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/website.css') ?>">

    <?= isset($extra_css) ? $extra_css : '' ?>

    <!-- Schema.org -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "CV. Bagus Kencana Cakrada",
        "url": "<?= base_url() ?>",
        "logo": "<?= base_url('assets/images/logo/logo_BKC_1.png') ?>",
        "description": "Mitra terpercaya dalam pengembangan SDM melalui Bimbingan Teknis, Workshop, Seminar, dan Pelatihan bidang EMBA",
        "telephone": "+6281805492754",
        "email": "baguskencanacakrada@gmail.com",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Perum Wana Asri No. 13A",
            "addressLocality": "Abianbase, Mengwi",
            "addressRegion": "Bali",
            "postalCode": "80351",
            "addressCountry": "ID"
        },
        "sameAs": []
    }
    </script>
</head>
<body>

    <!-- Loading Screen -->
    <div id="loadingScreen">
        <div class="loading-spinner"></div>
        <div class="loading-bar"><div class="loading-progress"></div></div>
    </div>

    <!-- Navbar -->
    <nav class="bkc-navbar navbar navbar-expand-lg <?= isset($navbar_dark) && $navbar_dark ? 'navbar-dark-page' : '' ?>">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <img src="<?= base_url('assets/images/logo/logo_BKC_1.png') ?>" alt="BKC Logo" class="navbar-brand-logo" onerror="this.style.display='none'">
                <div class="navbar-brand-text">
                    <span class="brand-name">Bagus Kencana</span>
                    <span class="brand-tagline">Building Knowledge & Capacity</span>
                </div>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav ms-auto align-items-center gap-1">
                    <li class="nav-item">
                        <a href="<?= base_url() ?>" class="nav-link <?= uri_string() === '' ? 'active' : '' ?>">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('tentang') ?>" class="nav-link <?= uri_string() === 'tentang' ? 'active' : '' ?>">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('pelatihan') ?>" class="nav-link <?= str_starts_with(uri_string(), 'pelatihan') ? 'active' : '' ?>">Pelatihan</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('jadwal-pelatihan') ?>" class="nav-link">Jadwal</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('berita') ?>" class="nav-link <?= str_starts_with(uri_string(), 'berita') ? 'active' : '' ?>">Berita</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('galeri') ?>" class="nav-link <?= uri_string() === 'galeri' ? 'active' : '' ?>">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('kontak') ?>" class="nav-link <?= uri_string() === 'kontak' ? 'active' : '' ?>">Kontak</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a href="<?= base_url('request-inhouse') ?>" class="btn-nav-cta nav-link">
                            <i class="fas fa-handshake me-1"></i> In-House
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <?= $this->renderSection('content') ?>

    <!-- Footer -->
    <footer class="bkc-footer">
        <div class="footer-main">
            <div class="container">
                <div class="row g-5">
                    <!-- Brand -->
                    <div class="col-lg-4">
                        <div class="footer-brand-name">CV. Bagus Kencana Cakrada</div>
                        <div class="footer-brand-tagline">Building Knowledge & Capacity</div>
                        <p class="footer-desc">Mitra terpercaya dalam pengembangan SDM melalui Bimtek, Workshop, Seminar, dan Pelatihan bidang EMBA.</p>
                        <div class="footer-social">
                            <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="#" title="Facebook"><i class="fab fa-facebook"></i></a>
                            <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
                            <a href="#" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="col-lg-2 col-6">
                        <div class="footer-title">Navigasi</div>
                        <ul class="footer-links">
                            <li><a href="<?= base_url() ?>">Beranda</a></li>
                            <li><a href="<?= base_url('tentang') ?>">Tentang Kami</a></li>
                            <li><a href="<?= base_url('pelatihan') ?>">Pelatihan</a></li>
                            <li><a href="<?= base_url('galeri') ?>">Galeri</a></li>
                            <li><a href="<?= base_url('berita') ?>">Berita</a></li>
                            <li><a href="<?= base_url('kontak') ?>">Kontak</a></li>
                        </ul>
                    </div>

                    <!-- Training -->
                    <div class="col-lg-2 col-6">
                        <div class="footer-title">Pelatihan</div>
                        <ul class="footer-links">
                            <li><a href="<?= base_url('pelatihan?category=ekonomi') ?>">Ekonomi</a></li>
                            <li><a href="<?= base_url('pelatihan?category=bisnis') ?>">Bisnis</a></li>
                            <li><a href="<?= base_url('pelatihan?category=manajemen') ?>">Manajemen</a></li>
                            <li><a href="<?= base_url('pelatihan?category=akuntansi') ?>">Akuntansi</a></li>
                            <li><a href="<?= base_url('jadwal-pelatihan') ?>">Jadwal</a></li>
                            <li><a href="<?= base_url('request-inhouse') ?>">In-House Training</a></li>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div class="col-lg-4">
                        <div class="footer-title">Hubungi Kami</div>
                        <div class="footer-contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Perum Wana Asri No. 13A, Abianbase, Mengwi, Badung, Bali 80351</span>
                        </div>
                        <div class="footer-contact-item">
                            <i class="fas fa-envelope"></i>
                            <span>baguskencanacakrada@gmail.com</span>
                        </div>
                        <div class="footer-contact-item">
                            <i class="fab fa-whatsapp"></i>
                            <span>0818-0549-2754</span>
                        </div>
                        <div class="footer-contact-item">
                            <i class="fas fa-clock"></i>
                            <span>Senin &ndash; Jumat, 08.00 &ndash; 17.00 WITA</span>
                        </div>
                        <?php if (isset($totalVisitors) && $totalVisitors > 0): ?>
                        <div class="footer-contact-item" style="margin-top:8px;padding-top:8px;border-top:1px solid rgba(255,255,255,0.1);">
                            <i class="fas fa-eye"></i>
                            <span style="font-size:12px;"><?= number_format($totalVisitors) ?> total kunjungan<?= (isset($todayVisitors) && $todayVisitors > 0) ? ' &bull; ' . number_format($todayVisitors) . ' hari ini' : '' ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="footer-bottom">
                <div>
                    <span class="footer-copyright">&copy; <?= date('Y') ?> PWN Works. All rights reserved.</span>
                </div>
                <div class="footer-legal">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                    <a href="<?= base_url('sitemap.xml') ?>">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Float Button -->
    <div class="wa-float">
        <div class="wa-tooltip">
            <div class="wa-tooltip-title">Chat dengan Kami</div>
            <div class="wa-tooltip-text">Konsultasi pelatihan gratis!</div>
            <div class="wa-tooltip-hours"><i class="fas fa-clock me-1"></i>08.00 &ndash; 17.00 WITA</div>
        </div>
        <a href="https://wa.me/6281805492754?text=<?= urlencode('Halo Admin CV Bagus Kencana Cakrada. Saya ingin berkonsultasi mengenai pelatihan.') ?>"
           class="wa-btn" target="_blank" rel="noopener" title="Chat WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>
    </div>

    <!-- Scroll to Top -->
    <button class="scroll-top-btn" onclick="window.scrollTo({top:0,behavior:'smooth'})">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Website JS -->
    <script src="<?= base_url('assets/js/website.js') ?>"></script>

    <?= isset($extra_js) ? $extra_js : '' ?>
</body>
</html>
