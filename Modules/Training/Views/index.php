<?= $this->extend('Modules\Website\Views\layout\main') ?>
<?= $this->section('content') ?>

<style>
/* ===== TRAINING INDEX PAGE ===== */
:root {
    --gold: #C8A34D;
    --gold-light: rgba(200, 163, 77, 0.12);
    --gold-gradient: linear-gradient(135deg, #C8A34D, #E8C56A);
    --royal: #1E4FA3;
    --royal-light: rgba(30, 79, 163, 0.08);
    --dark: #121212;
    --gray: #6B7280;
    --white: #FFFFFF;
    --surface: #F8F9FA;
}

/* ----- HERO ----- */
.training-hero {
    background: linear-gradient(135deg, #0a0a1a 0%, #0d1b3e 50%, #121212 100%);
    padding: 120px 0 80px;
    position: relative;
    overflow: hidden;
}
.training-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 60% 60% at 80% 50%, rgba(200,163,77,0.08) 0%, transparent 60%),
        radial-gradient(ellipse 50% 50% at 20% 80%, rgba(30,79,163,0.1) 0%, transparent 60%);
}
.training-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 18px;
    background: rgba(200,163,77,0.15);
    border: 1px solid rgba(200,163,77,0.3);
    border-radius: 100px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: #C8A34D;
    margin-bottom: 20px;
}
.training-hero-title {
    font-size: clamp(36px, 5vw, 64px);
    font-weight: 900;
    color: #fff;
    line-height: 1.1;
    margin-bottom: 16px;
}
.training-hero-title span { color: #C8A34D; }
.training-hero-subtitle {
    font-size: 17px;
    color: rgba(255,255,255,0.65);
    line-height: 1.7;
    margin-bottom: 0;
    max-width: 540px;
}
.breadcrumb-training { margin-bottom: 0; }
.breadcrumb-training .breadcrumb-item a {
    color: rgba(255,255,255,0.5);
    text-decoration: none;
    font-size: 13px;
    transition: color 0.2s;
}
.breadcrumb-training .breadcrumb-item a:hover { color: #C8A34D; }
.breadcrumb-training .breadcrumb-item.active {
    color: rgba(255,255,255,0.8);
    font-size: 13px;
}
.breadcrumb-training .breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255,255,255,0.3);
}

/* Hero decorative grid */
.hero-grid-deco {
    position: absolute;
    right: -40px;
    top: 50%;
    transform: translateY(-50%);
    width: 420px;
    height: 420px;
    opacity: 0.06;
    background-image:
        linear-gradient(rgba(200,163,77,1) 1px, transparent 1px),
        linear-gradient(90deg, rgba(200,163,77,1) 1px, transparent 1px);
    background-size: 42px 42px;
    border-radius: 50%;
}

/* ----- FILTER BAR ----- */
.filter-bar-section {
    background: #fff;
    box-shadow: 0 2px 20px rgba(0,0,0,0.06);
    padding: 28px 0;
    position: sticky;
    top: 70px;
    z-index: 100;
    border-bottom: 1px solid rgba(0,0,0,0.06);
}
.filter-category-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 18px;
    border-radius: 100px;
    font-size: 13px;
    font-weight: 600;
    border: 1.5px solid rgba(0,0,0,0.12);
    background: transparent;
    color: #374151;
    cursor: pointer;
    transition: all 0.25s;
    white-space: nowrap;
    text-decoration: none;
}
.filter-category-btn:hover,
.filter-category-btn.active {
    background: #C8A34D;
    border-color: #C8A34D;
    color: #fff;
    box-shadow: 0 4px 16px rgba(200,163,77,0.35);
    transform: translateY(-1px);
}
.filter-category-btn.active { color: #fff; }
.filter-search-wrap {
    position: relative;
}
.filter-search-input {
    width: 100%;
    padding: 10px 20px 10px 44px;
    border-radius: 100px;
    border: 1.5px solid rgba(0,0,0,0.12);
    font-size: 14px;
    background: #f8f9fa;
    outline: none;
    transition: all 0.25s;
    color: #121212;
}
.filter-search-input:focus {
    border-color: #C8A34D;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(200,163,77,0.12);
}
.filter-search-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #9CA3AF;
    font-size: 15px;
    pointer-events: none;
}
.filter-sort-select {
    padding: 10px 36px 10px 16px;
    border-radius: 100px;
    border: 1.5px solid rgba(0,0,0,0.12);
    font-size: 13px;
    font-weight: 600;
    background: #f8f9fa url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") no-repeat right 14px center;
    appearance: none;
    color: #374151;
    outline: none;
    cursor: pointer;
    transition: all 0.25s;
}
.filter-sort-select:focus {
    border-color: #C8A34D;
    box-shadow: 0 0 0 3px rgba(200,163,77,0.12);
}
.filter-result-count {
    font-size: 13px;
    color: #6B7280;
}
.filter-result-count strong { color: #121212; }

/* ----- TRAINING GRID ----- */
.training-grid-section { padding: 64px 0; background: #f8f9fa; }

/* ----- TRAINING CARD ----- */
.t-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid rgba(0,0,0,0.06);
    transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    height: 100%;
    display: flex;
    flex-direction: column;
}
.t-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 24px 64px rgba(0,0,0,0.12);
    border-color: rgba(200,163,77,0.25);
}
.t-card-img-wrap {
    position: relative;
    overflow: hidden;
    aspect-ratio: 16/9;
    background: #e5e7eb;
}
.t-card-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}
.t-card:hover .t-card-img { transform: scale(1.06); }
.t-card-category-badge {
    position: absolute;
    top: 14px;
    left: 14px;
    padding: 4px 12px;
    border-radius: 100px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
}
.t-card-featured-badge {
    position: absolute;
    top: 14px;
    right: 14px;
    padding: 4px 10px;
    border-radius: 100px;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    background: linear-gradient(135deg, #C8A34D, #E8C56A);
    color: #fff;
}
.t-card-online-badge {
    position: absolute;
    bottom: 14px;
    right: 14px;
    padding: 4px 10px;
    border-radius: 100px;
    font-size: 10px;
    font-weight: 700;
    background: rgba(30,79,163,0.9);
    color: #fff;
    backdrop-filter: blur(4px);
}
.t-card-body {
    padding: 22px 22px 18px;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.t-card-title {
    font-size: 16px;
    font-weight: 800;
    color: #121212;
    margin-bottom: 12px;
    line-height: 1.45;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.t-card-meta {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-bottom: 14px;
}
.t-card-meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #6B7280;
}
.t-card-meta-item i {
    width: 16px;
    color: #C8A34D;
    font-size: 12px;
    flex-shrink: 0;
}
.t-card-price-row {
    display: flex;
    align-items: baseline;
    gap: 4px;
    margin-bottom: 12px;
}
.t-card-price-label {
    font-size: 11px;
    color: #9CA3AF;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.t-card-price {
    font-size: 20px;
    font-weight: 900;
    color: #C8A34D;
}

/* Quota bar */
.quota-bar-wrap { margin-bottom: 16px; }
.quota-bar-track {
    height: 6px;
    background: #e5e7eb;
    border-radius: 100px;
    overflow: hidden;
    margin-bottom: 6px;
}
.quota-bar-fill {
    height: 100%;
    border-radius: 100px;
    background: linear-gradient(90deg, #C8A34D, #E8C56A);
    transition: width 0.6s ease;
}
.quota-bar-fill.full { background: linear-gradient(90deg, #ef4444, #f87171); }
.quota-bar-label {
    display: flex;
    justify-content: space-between;
    font-size: 11px;
    color: #9CA3AF;
    font-weight: 500;
}
.quota-bar-label .seats-left { color: #C8A34D; font-weight: 700; }

/* Card footer */
.t-card-footer {
    display: flex;
    gap: 10px;
    margin-top: auto;
    padding-top: 16px;
    border-top: 1px solid #f3f4f6;
}
.btn-detail {
    flex: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 10px 16px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    border: 1.5px solid rgba(30,79,163,0.25);
    color: #1E4FA3;
    background: rgba(30,79,163,0.05);
    transition: all 0.25s;
}
.btn-detail:hover {
    background: #1E4FA3;
    color: #fff;
    border-color: #1E4FA3;
}
.btn-wa-register {
    flex: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 10px 16px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    border: none;
    background: linear-gradient(135deg, #C8A34D, #E8C56A);
    color: #fff;
    transition: all 0.25s;
    box-shadow: 0 4px 16px rgba(200,163,77,0.3);
}
.btn-wa-register:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(200,163,77,0.45);
}

/* ----- EMPTY STATE ----- */
.empty-state-box {
    text-align: center;
    padding: 80px 20px;
}
.empty-state-box .icon-wrap {
    width: 96px;
    height: 96px;
    border-radius: 50%;
    background: rgba(200,163,77,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 24px;
    font-size: 40px;
    color: #C8A34D;
}
.empty-state-box h4 {
    font-size: 22px;
    font-weight: 800;
    color: #121212;
    margin-bottom: 10px;
}
.empty-state-box p {
    color: #6B7280;
    font-size: 15px;
    margin-bottom: 28px;
}

/* ----- PAGINATION ----- */
.pagination-wrap .pagination .page-link {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px !important;
    border: 1.5px solid rgba(0,0,0,0.1);
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    background: #fff;
    margin: 0 3px;
    transition: all 0.2s;
}
.pagination-wrap .pagination .page-link:hover {
    background: rgba(200,163,77,0.1);
    border-color: #C8A34D;
    color: #C8A34D;
}
.pagination-wrap .pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #C8A34D, #E8C56A);
    border-color: #C8A34D;
    color: #fff;
    box-shadow: 0 4px 16px rgba(200,163,77,0.4);
}

/* Results info bar */
.results-bar {
    background: #fff;
    border-bottom: 1px solid rgba(0,0,0,0.06);
    padding: 14px 0;
}

@media (max-width: 768px) {
    .training-hero { padding: 100px 0 60px; }
    .filter-bar-section { top: 60px; padding: 16px 0; }
    .filter-category-btn { padding: 6px 14px; font-size: 12px; }
    .t-card-price { font-size: 18px; }
}
</style>

<!-- ====== HERO ====== -->
<section class="training-hero">
    <div class="hero-grid-deco"></div>
    <div class="container position-relative">
        <div class="row">
            <div class="col-lg-7" data-aos="fade-right">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb breadcrumb-training">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="fas fa-home me-1"></i>Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pelatihan</li>
                    </ol>
                </nav>

                <div class="training-hero-badge" data-aos="fade-down" data-aos-delay="100">
                    <i class="fas fa-graduation-cap"></i>
                    Program Pelatihan EMBA Premium
                </div>

                <h1 class="training-hero-title" data-aos="fade-up" data-aos-delay="150">
                    Program <span>Pelatihan</span><br>Unggulan BKC
                </h1>
                <p class="training-hero-subtitle" data-aos="fade-up" data-aos-delay="200">
                    Tingkatkan kompetensi SDM instansi Anda melalui program pelatihan Ekonomi, Bisnis, Manajemen, dan Akuntansi (EMBA) dengan narasumber terpilih dan fasilitas premium.
                </p>
            </div>

            <div class="col-lg-5 d-none d-lg-flex align-items-center justify-content-end" data-aos="fade-left" data-aos-delay="250">
                <div style="text-align:center; width:100%;">
                    <div class="row g-3">
                        <div class="col-6">
                            <div style="background:rgba(255,255,255,0.07); border:1px solid rgba(255,255,255,0.1); border-radius:20px; padding:24px 16px; backdrop-filter:blur(10px);">
                                <div style="font-size:28px; color:#C8A34D; margin-bottom:8px;"><i class="fas fa-award"></i></div>
                                <div style="font-size:12px; color:rgba(255,255,255,0.7); font-weight:600;">Sertifikat Resmi</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div style="background:rgba(255,255,255,0.07); border:1px solid rgba(255,255,255,0.1); border-radius:20px; padding:24px 16px; backdrop-filter:blur(10px); margin-top:24px;">
                                <div style="font-size:28px; color:#C8A34D; margin-bottom:8px;"><i class="fas fa-chalkboard-teacher"></i></div>
                                <div style="font-size:12px; color:rgba(255,255,255,0.7); font-weight:600;">Narasumber Ahli</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div style="background:rgba(255,255,255,0.07); border:1px solid rgba(255,255,255,0.1); border-radius:20px; padding:24px 16px; backdrop-filter:blur(10px); margin-top:-12px;">
                                <div style="font-size:28px; color:#C8A34D; margin-bottom:8px;"><i class="fas fa-book-open"></i></div>
                                <div style="font-size:12px; color:rgba(255,255,255,0.7); font-weight:600;">Materi Terstandar</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div style="background:rgba(255,255,255,0.07); border:1px solid rgba(255,255,255,0.1); border-radius:20px; padding:24px 16px; backdrop-filter:blur(10px);">
                                <div style="font-size:28px; color:#C8A34D; margin-bottom:8px;"><i class="fas fa-headset"></i></div>
                                <div style="font-size:12px; color:rgba(255,255,255,0.7); font-weight:600;">Konsultasi Gratis</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====== FILTER BAR ====== -->
<section class="filter-bar-section">
    <div class="container">
        <form method="GET" action="<?= site_url('pelatihan') ?>" id="filterForm">
            <div class="d-flex flex-wrap align-items-center gap-3">

                <!-- Category filters -->
                <div class="d-flex flex-wrap gap-2 me-auto">
                    <a href="<?= site_url('pelatihan') ?>"
                       class="filter-category-btn <?= empty($filters['category']) ? 'active' : '' ?>">
                        <i class="fas fa-th-large"></i> Semua
                    </a>
                    <?php foreach ($categories as $cat): ?>
                    <a href="<?= site_url('pelatihan?' . http_build_query(array_merge($filters, ['category' => $cat['slug']]))) ?>"
                       class="filter-category-btn <?= ($filters['category'] === $cat['slug']) ? 'active' : '' ?>"
                       style="<?= ($filters['category'] === $cat['slug']) ? '' : '' ?>">
                        <i class="fas <?= esc($cat['icon'] ?? 'fa-folder') ?>"></i>
                        <?= esc($cat['name']) ?>
                    </a>
                    <?php endforeach; ?>
                </div>

                <!-- Search -->
                <div class="filter-search-wrap" style="min-width:220px;">
                    <i class="fas fa-search filter-search-icon"></i>
                    <input type="text"
                           name="search"
                           id="searchInput"
                           class="filter-search-input"
                           placeholder="Cari pelatihan..."
                           value="<?= esc($filters['search'] ?? '') ?>"
                           autocomplete="off">
                </div>

                <!-- Sort -->
                <select name="sort" class="filter-sort-select" onchange="document.getElementById('filterForm').submit()">
                    <option value="terbaru" <?= (($filters['sort'] ?? '') === 'terbaru') ? 'selected' : '' ?>>Terbaru</option>
                    <option value="populer" <?= (($filters['sort'] ?? '') === 'populer') ? 'selected' : '' ?>>Populer</option>
                    <option value="harga_asc" <?= (($filters['sort'] ?? '') === 'harga_asc') ? 'selected' : '' ?>>Harga Terendah</option>
                    <option value="harga_desc" <?= (($filters['sort'] ?? '') === 'harga_desc') ? 'selected' : '' ?>>Harga Tertinggi</option>
                </select>

            </div>
        </form>
    </div>
</section>

<!-- ====== RESULTS INFO ====== -->
<div class="results-bar">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
            <div class="filter-result-count">
                <?php if (!empty($filters['search']) || !empty($filters['category'])): ?>
                Menampilkan <strong><?= $total ?? count($trainings) ?></strong> hasil
                <?php if (!empty($filters['search'])): ?>
                untuk <strong>"<?= esc($filters['search']) ?>"</strong>
                <?php endif; ?>
                <?php else: ?>
                Menampilkan <strong><?= $total ?? count($trainings) ?></strong> program pelatihan
                <?php endif; ?>
            </div>
            <?php if (!empty($filters['category']) || !empty($filters['search'])): ?>
            <a href="<?= site_url('pelatihan') ?>" style="font-size:13px; color:#6B7280; text-decoration:none;">
                <i class="fas fa-times-circle me-1"></i> Reset filter
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- ====== TRAINING GRID ====== -->
<section class="training-grid-section">
    <div class="container">

        <?php if (!empty($trainings)): ?>
        <div class="row g-4" id="trainingGrid">
            <?php foreach ($trainings as $i => $training): ?>
            <?php
                $quotaPercent = ($training['max_participants'] ?? 0) > 0
                    ? round(($training['current_participants'] / $training['max_participants']) * 100)
                    : 0;
                $seatsLeft = max(0, ($training['max_participants'] ?? 0) - ($training['current_participants'] ?? 0));
                $isFull = $seatsLeft === 0;
                $coverUrl = !empty($training['cover'])
                    ? base_url('assets/uploads/training/' . $training['cover'])
                    : 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=600&h=340&fit=crop';
            ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?= min($i * 80, 400) ?>">
                <div class="t-card">
                    <!-- Image -->
                    <div class="t-card-img-wrap">
                        <img src="<?= $coverUrl ?>"
                             alt="<?= esc($training['title']) ?>"
                             class="t-card-img"
                             loading="lazy"
                             onerror="this.src='https://images.unsplash.com/photo-1552664730-d307ca884978?w=600&h=340&fit=crop'">

                        <!-- Category badge -->
                        <span class="t-card-category-badge"
                              style="background:<?= esc($training['category_color'] ?? '#C8A34D') ?>22; color:<?= esc($training['category_color'] ?? '#C8A34D') ?>; border:1px solid <?= esc($training['category_color'] ?? '#C8A34D') ?>44;">
                            <?= esc($training['category_name'] ?? 'Pelatihan') ?>
                        </span>

                        <?php if (!empty($training['is_featured'])): ?>
                        <span class="t-card-featured-badge"><i class="fas fa-star me-1"></i>Unggulan</span>
                        <?php endif; ?>

                        <?php if (!empty($training['is_online'])): ?>
                        <span class="t-card-online-badge"><i class="fas fa-wifi me-1"></i>Online</span>
                        <?php endif; ?>
                    </div>

                    <!-- Body -->
                    <div class="t-card-body">
                        <h3 class="t-card-title"><?= esc($training['title']) ?></h3>

                        <div class="t-card-meta">
                            <?php if (!empty($training['start_date'])): ?>
                            <div class="t-card-meta-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span>
                                    <?= date('d M Y', strtotime($training['start_date'])) ?>
                                    <?php if (!empty($training['end_date']) && $training['end_date'] !== $training['start_date']): ?>
                                    &ndash; <?= date('d M Y', strtotime($training['end_date'])) ?>
                                    <?php endif; ?>
                                </span>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($training['location_name'])): ?>
                            <div class="t-card-meta-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?= esc($training['location_name']) ?><?= !empty($training['location_city']) ? ', ' . esc($training['location_city']) : '' ?></span>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($training['duration_days'])): ?>
                            <div class="t-card-meta-item">
                                <i class="fas fa-clock"></i>
                                <span><?= (int)$training['duration_days'] ?> Hari<?= !empty($training['duration_hours']) ? ' (' . (int)$training['duration_hours'] . ' Jam)' : '' ?></span>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Price -->
                        <div class="t-card-price-row">
                            <span class="t-card-price-label">Investasi&nbsp;</span>
                            <span class="t-card-price">
                                <?php if (!empty($training['price']) && $training['price'] > 0): ?>
                                Rp <?= number_format($training['price'], 0, ',', '.') ?>
                                <?php else: ?>
                                <span style="font-size:15px; color:#10B981; font-weight:700;">Gratis</span>
                                <?php endif; ?>
                            </span>
                        </div>

                        <!-- Quota bar -->
                        <?php if (!empty($training['max_participants'])): ?>
                        <div class="quota-bar-wrap">
                            <div class="quota-bar-track">
                                <div class="quota-bar-fill <?= $isFull ? 'full' : '' ?>"
                                     style="width:<?= min($quotaPercent, 100) ?>%"></div>
                            </div>
                            <div class="quota-bar-label">
                                <span><?= $training['current_participants'] ?? 0 ?>/<?= $training['max_participants'] ?> peserta terdaftar</span>
                                <?php if ($isFull): ?>
                                <span style="color:#ef4444; font-weight:700;">Penuh</span>
                                <?php else: ?>
                                <span class="seats-left"><?= $seatsLeft ?> kursi tersisa</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Footer buttons -->
                        <div class="t-card-footer">
                            <a href="<?= site_url('pelatihan/' . esc($training['slug'])) ?>"
                               class="btn-detail">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            <button type="button"
                                    class="btn-wa-register"
                                    onclick="waRegister(
                                        '<?= (int)$training['id'] ?>',
                                        '<?= esc(addslashes($training['title'])) ?>',
                                        '<?= !empty($training['start_date']) ? date('d F Y', strtotime($training['start_date'])) : 'TBA' ?>',
                                        '<?= esc($profile['whatsapp'] ?? '6281803867430') ?>'
                                    )">
                                <i class="fab fa-whatsapp"></i> Daftar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if (isset($totalPages) && $totalPages > 1): ?>
        <div class="pagination-wrap mt-5 d-flex justify-content-center" data-aos="fade-up">
            <nav aria-label="Halaman pelatihan">
                <ul class="pagination">
                    <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= site_url('pelatihan?' . http_build_query(array_merge($filters, ['page' => $page - 1]))) ?>">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php for ($p = max(1, $page - 2); $p <= min($totalPages, $page + 2); $p++): ?>
                    <li class="page-item <?= $p === $page ? 'active' : '' ?>">
                        <a class="page-link" href="<?= site_url('pelatihan?' . http_build_query(array_merge($filters, ['page' => $p]))) ?>"><?= $p ?></a>
                    </li>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= site_url('pelatihan?' . http_build_query(array_merge($filters, ['page' => $page + 1]))) ?>">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
        <?php endif; ?>

        <?php else: ?>
        <!-- Empty state -->
        <div class="empty-state-box" data-aos="zoom-in">
            <div class="icon-wrap">
                <i class="fas fa-search"></i>
            </div>
            <h4>Pelatihan Tidak Ditemukan</h4>
            <p>
                <?php if (!empty($filters['search'])): ?>
                Tidak ada pelatihan yang cocok dengan pencarian "<strong><?= esc($filters['search']) ?></strong>".
                <?php elseif (!empty($filters['category'])): ?>
                Belum ada pelatihan dalam kategori ini. Coba kategori lain.
                <?php else: ?>
                Kami sedang mempersiapkan program pelatihan terbaik. Pantau terus!
                <?php endif; ?>
            </p>
            <a href="<?= site_url('pelatihan') ?>" class="btn-detail d-inline-flex" style="border-radius:100px; padding:12px 28px;">
                <i class="fas fa-arrow-left me-2"></i> Lihat Semua Pelatihan
            </a>
        </div>
        <?php endif; ?>

    </div>
</section>

<!-- ====== CTA INHOUSE ====== -->
<section style="background:linear-gradient(135deg, #0a0a1a, #0d1b3e); padding:64px 0;">
    <div class="container text-center" data-aos="zoom-in">
        <div style="max-width:560px; margin:0 auto;">
            <div class="training-hero-badge d-inline-flex mb-4" style="margin:0 auto 24px;">
                <i class="fas fa-building"></i>
                In-House Training
            </div>
            <h2 style="font-size:clamp(24px, 3.5vw, 40px); font-weight:900; color:#fff; margin-bottom:16px; line-height:1.2;">
                Butuh Pelatihan Khusus untuk Instansi Anda?
            </h2>
            <p style="color:rgba(255,255,255,0.6); font-size:16px; margin-bottom:36px; line-height:1.7;">
                Kami menyediakan layanan In-House Training yang dapat disesuaikan dengan kebutuhan spesifik instansi atau perusahaan Anda.
            </p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="<?= site_url('pelatihan/inhouse') ?>"
                   style="display:inline-flex; align-items:center; gap:8px; padding:14px 32px; border-radius:100px; background:linear-gradient(135deg,#C8A34D,#E8C56A); color:#fff; font-weight:700; font-size:15px; text-decoration:none; box-shadow:0 8px 32px rgba(200,163,77,0.4);">
                    <i class="fas fa-handshake"></i> Request In-House Training
                </a>
                <a href="https://wa.me/<?= esc($profile['whatsapp'] ?? '6281803867430') ?>?text=<?= urlencode('Halo BKC, saya tertarik dengan program In-House Training.') ?>"
                   target="_blank"
                   style="display:inline-flex; align-items:center; gap:8px; padding:14px 32px; border-radius:100px; background:transparent; border:1.5px solid rgba(255,255,255,0.2); color:#fff; font-weight:600; font-size:15px; text-decoration:none;">
                    <i class="fab fa-whatsapp"></i> Chat WhatsApp
                </a>
            </div>
        </div>
    </div>
</section>

<script>
/**
 * waRegister — open WhatsApp with pre-filled registration message
 */
function waRegister(trainingId, trainingTitle, trainingDate, waNumber) {
    const msg = `Halo Admin BKC 👋\n\nSaya ingin mendaftarkan diri pada pelatihan berikut:\n\n📚 *${trainingTitle}*\n📅 Tanggal: ${trainingDate}\n\nMohon informasi lebih lanjut mengenai prosedur pendaftaran dan biaya pelatihan. Terima kasih.`;
    const url = `https://wa.me/${waNumber}?text=${encodeURIComponent(msg)}`;
    window.open(url, '_blank', 'noopener');
}

// Live search with debounce
(function() {
    let debounceTimer;
    const searchInput = document.getElementById('searchInput');
    if (!searchInput) return;

    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const q = this.value.trim();

        debounceTimer = setTimeout(() => {
            if (q.length === 0 || q.length >= 3) {
                document.getElementById('filterForm').submit();
            }
        }, 600);
    });
})();
</script>

<?= $this->endSection() ?>
