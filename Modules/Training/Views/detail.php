<?= $this->extend('Modules\Website\Views\layout\main') ?>
<?= $this->section('content') ?>

<style>
/* ===== TRAINING DETAIL PAGE ===== */
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

/* Page top bar */
.detail-topbar {
    background: linear-gradient(135deg, #0a0a1a, #0d1b3e);
    padding: 100px 0 48px;
    position: relative;
    overflow: hidden;
}
.detail-topbar::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse 50% 80% at 90% 50%, rgba(200,163,77,0.07) 0%, transparent 60%);
}
.detail-breadcrumb .breadcrumb-item a {
    color: rgba(255,255,255,0.5);
    text-decoration: none;
    font-size: 13px;
    transition: color 0.2s;
}
.detail-breadcrumb .breadcrumb-item a:hover { color: #C8A34D; }
.detail-breadcrumb .breadcrumb-item.active {
    color: rgba(255,255,255,0.75);
    font-size: 13px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 240px;
}
.detail-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255,255,255,0.3);
}
.detail-topbar-title {
    font-size: clamp(22px, 3.5vw, 40px);
    font-weight: 900;
    color: #fff;
    margin: 12px 0 0;
    line-height: 1.25;
}

/* Main layout */
.detail-main { padding: 48px 0 80px; background: #f8f9fa; }

/* Left column */
.detail-content-wrap { background: #fff; border-radius: 24px; overflow: hidden; box-shadow: 0 2px 20px rgba(0,0,0,0.06); }

/* Cover image */
.detail-cover-img {
    width: 100%;
    aspect-ratio: 16/7;
    object-fit: cover;
    display: block;
    border-radius: 0;
}

/* Badges row */
.detail-badges { display: flex; flex-wrap: wrap; gap: 8px; padding: 24px 32px 0; }
.badge-category {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 16px;
    border-radius: 100px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}
.badge-status-open {
    background: rgba(16,185,129,0.1);
    color: #059669;
    border: 1px solid rgba(16,185,129,0.25);
    padding: 6px 16px;
    border-radius: 100px;
    font-size: 12px;
    font-weight: 700;
}
.badge-status-full {
    background: rgba(239,68,68,0.1);
    color: #dc2626;
    border: 1px solid rgba(239,68,68,0.25);
    padding: 6px 16px;
    border-radius: 100px;
    font-size: 12px;
    font-weight: 700;
}
.badge-online {
    background: rgba(30,79,163,0.1);
    color: #1E4FA3;
    border: 1px solid rgba(30,79,163,0.2);
    padding: 6px 16px;
    border-radius: 100px;
    font-size: 12px;
    font-weight: 700;
}
.badge-featured {
    background: linear-gradient(135deg, #C8A34D, #E8C56A);
    color: #fff;
    padding: 6px 16px;
    border-radius: 100px;
    font-size: 12px;
    font-weight: 700;
}

/* Title */
.detail-title-area { padding: 20px 32px 24px; border-bottom: 1px solid #f3f4f6; }
.detail-h1 {
    font-size: clamp(22px, 3vw, 34px);
    font-weight: 900;
    color: #121212;
    line-height: 1.25;
    margin-bottom: 20px;
}

/* Meta row */
.detail-meta-row {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}
.detail-meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: #6B7280;
}
.detail-meta-item i {
    color: #C8A34D;
    font-size: 15px;
    width: 18px;
    text-align: center;
}
.detail-meta-item strong { color: #121212; }

/* Tabs */
.detail-tabs-wrap { padding: 0 32px; border-bottom: 2px solid #f3f4f6; }
.detail-tab-nav {
    display: flex;
    gap: 4px;
    overflow-x: auto;
    scrollbar-width: none;
    -ms-overflow-style: none;
}
.detail-tab-nav::-webkit-scrollbar { display: none; }
.detail-tab-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 14px 20px;
    font-size: 14px;
    font-weight: 600;
    color: #6B7280;
    background: none;
    border: none;
    border-bottom: 2.5px solid transparent;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.2s;
    margin-bottom: -2px;
}
.detail-tab-btn:hover { color: #C8A34D; }
.detail-tab-btn.active {
    color: #C8A34D;
    border-bottom-color: #C8A34D;
}

/* Tab panels */
.detail-tab-panels { padding: 32px; }
.detail-tab-panel { display: none; animation: fadePanel 0.35s ease; }
.detail-tab-panel.active { display: block; }
@keyframes fadePanel {
    from { opacity: 0; transform: translateY(8px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* Description (raw HTML from CKEditor) */
.ck-content h2, .ck-content h3 { font-weight: 800; color: #121212; margin-top: 24px; margin-bottom: 12px; }
.ck-content p { color: #374151; line-height: 1.8; margin-bottom: 16px; }
.ck-content ul, .ck-content ol { padding-left: 24px; color: #374151; line-height: 1.9; }
.ck-content blockquote {
    border-left: 4px solid #C8A34D;
    padding: 16px 24px;
    background: rgba(200,163,77,0.06);
    border-radius: 0 12px 12px 0;
    color: #374151;
    font-style: italic;
    margin: 24px 0;
}
.ck-content img { max-width: 100%; border-radius: 12px; }

/* Materials list */
.materials-list { list-style: none; padding: 0; margin: 0; }
.materials-list li {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 14px 20px;
    background: #f8f9fa;
    border-radius: 14px;
    margin-bottom: 10px;
    border: 1px solid rgba(0,0,0,0.05);
    transition: all 0.2s;
}
.materials-list li:hover { background: rgba(200,163,77,0.05); border-color: rgba(200,163,77,0.2); }
.materials-list li .num {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    background: linear-gradient(135deg, #C8A34D, #E8C56A);
    color: #fff;
    font-size: 12px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.materials-list li span { font-size: 14px; color: #374151; line-height: 1.6; padding-top: 3px; }

/* Schedule table */
.schedule-table { width: 100%; border-collapse: collapse; }
.schedule-table th {
    background: linear-gradient(135deg, #0a0a1a, #0d1b3e);
    color: #C8A34D;
    padding: 14px 20px;
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    text-align: left;
}
.schedule-table th:first-child { border-radius: 16px 0 0 0; }
.schedule-table th:last-child { border-radius: 0 16px 0 0; }
.schedule-table td {
    padding: 14px 20px;
    border-bottom: 1px solid #f3f4f6;
    font-size: 14px;
    color: #374151;
    vertical-align: top;
}
.schedule-table tr:hover td { background: rgba(200,163,77,0.03); }
.map-embed {
    width: 100%;
    height: 280px;
    border-radius: 16px;
    overflow: hidden;
    border: none;
    margin-top: 24px;
}
.map-embed iframe { width: 100%; height: 100%; border: none; }

/* Gallery masonry */
.gallery-grid {
    columns: 3;
    column-gap: 12px;
}
@media (max-width: 768px) { .gallery-grid { columns: 2; } }
.gallery-item {
    break-inside: avoid;
    margin-bottom: 12px;
    border-radius: 14px;
    overflow: hidden;
    cursor: pointer;
    position: relative;
}
.gallery-item img {
    width: 100%;
    display: block;
    transition: transform 0.4s ease;
}
.gallery-item:hover img { transform: scale(1.05); }
.gallery-item::after {
    content: '\f00e';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.4);
    color: #fff;
    font-size: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s;
}
.gallery-item:hover::after { opacity: 1; }

/* Testimonials */
.testi-card {
    background: #f8f9fa;
    border-radius: 20px;
    padding: 24px;
    border: 1px solid rgba(0,0,0,0.05);
    margin-bottom: 16px;
    transition: all 0.25s;
}
.testi-card:hover {
    background: #fff;
    box-shadow: 0 8px 32px rgba(0,0,0,0.08);
    transform: translateY(-3px);
}
.testi-stars { margin-bottom: 12px; }
.testi-stars i { font-size: 14px; }
.testi-quote {
    font-size: 14px;
    color: #374151;
    line-height: 1.75;
    font-style: italic;
    margin-bottom: 16px;
    position: relative;
    padding-left: 20px;
}
.testi-quote::before {
    content: '"';
    position: absolute;
    left: 0;
    top: -4px;
    font-size: 36px;
    color: #C8A34D;
    line-height: 1;
    font-style: normal;
}
.testi-author {
    display: flex;
    align-items: center;
    gap: 12px;
}
.testi-avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    object-fit: cover;
}
.testi-avatar-placeholder {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: linear-gradient(135deg, #C8A34D, #E8C56A);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 16px;
    font-weight: 800;
}
.testi-name { font-size: 14px; font-weight: 700; color: #121212; }
.testi-pos { font-size: 12px; color: #9CA3AF; }

/* FAQ */
.faq-item-det {
    border-radius: 16px;
    border: 1px solid rgba(0,0,0,0.07);
    margin-bottom: 10px;
    overflow: hidden;
    background: #fff;
}
.faq-q-det {
    width: 100%;
    background: none;
    border: none;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 22px;
    font-size: 15px;
    font-weight: 700;
    color: #121212;
    cursor: pointer;
    text-align: left;
    gap: 16px;
    transition: background 0.2s;
}
.faq-q-det:hover { background: rgba(200,163,77,0.04); }
.faq-q-det .faq-icon-det {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    background: rgba(200,163,77,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #C8A34D;
    font-size: 13px;
    flex-shrink: 0;
    transition: transform 0.3s;
}
.faq-q-det[aria-expanded="true"] .faq-icon-det { transform: rotate(45deg); background: #C8A34D; color: #fff; }
.faq-a-det {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.4s ease;
}
.faq-a-det.open { max-height: 500px; }
.faq-a-det-inner {
    padding: 0 22px 18px;
    font-size: 14px;
    color: #374151;
    line-height: 1.8;
    border-top: 1px solid #f3f4f6;
    padding-top: 16px;
}

/* ===== RIGHT SIDEBAR ===== */
.detail-sidebar { position: sticky; top: 88px; }

/* Price card glassmorphism */
.price-card {
    background: linear-gradient(135deg, rgba(10,10,26,0.97), rgba(13,27,62,0.97));
    border-radius: 24px;
    padding: 28px;
    border: 1px solid rgba(200,163,77,0.2);
    box-shadow: 0 20px 64px rgba(0,0,0,0.25);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    position: relative;
    overflow: hidden;
    margin-bottom: 16px;
}
.price-card::before {
    content: '';
    position: absolute;
    top: -60px;
    right: -60px;
    width: 180px;
    height: 180px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(200,163,77,0.12) 0%, transparent 70%);
}
.price-card-label {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: rgba(255,255,255,0.4);
    margin-bottom: 6px;
}
.price-card-price {
    font-size: 34px;
    font-weight: 900;
    color: #C8A34D;
    line-height: 1.1;
    margin-bottom: 4px;
}
.price-card-price-info {
    font-size: 12px;
    color: rgba(255,255,255,0.45);
    margin-bottom: 20px;
}
.price-card-divider {
    height: 1px;
    background: rgba(255,255,255,0.08);
    margin: 16px 0;
}

/* Quota in sidebar */
.sidebar-quota-label {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
    margin-bottom: 8px;
    color: rgba(255,255,255,0.5);
}
.sidebar-quota-label span:last-child { color: #C8A34D; font-weight: 700; }
.sidebar-quota-track {
    height: 8px;
    background: rgba(255,255,255,0.1);
    border-radius: 100px;
    overflow: hidden;
    margin-bottom: 16px;
}
.sidebar-quota-fill {
    height: 100%;
    border-radius: 100px;
    background: linear-gradient(90deg, #C8A34D, #E8C56A);
}
.sidebar-quota-fill.full { background: linear-gradient(90deg, #ef4444, #f87171); }

/* Countdown */
.sidebar-countdown {
    display: flex;
    gap: 8px;
    margin-bottom: 20px;
    justify-content: center;
}
.countdown-box {
    flex: 1;
    text-align: center;
    background: rgba(255,255,255,0.06);
    border-radius: 12px;
    padding: 10px 6px;
    border: 1px solid rgba(255,255,255,0.08);
}
.countdown-box-val {
    font-size: 22px;
    font-weight: 900;
    color: #fff;
    display: block;
    line-height: 1;
}
.countdown-box-lbl {
    font-size: 10px;
    color: rgba(255,255,255,0.4);
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin-top: 4px;
    display: block;
}
.countdown-over {
    font-size: 13px;
    color: #ef4444;
    text-align: center;
    font-weight: 600;
}

/* CTA buttons */
.btn-wa-cta {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 16px 24px;
    border-radius: 16px;
    font-size: 15px;
    font-weight: 800;
    cursor: pointer;
    border: none;
    background: linear-gradient(135deg, #C8A34D, #E8C56A);
    color: #fff;
    text-decoration: none;
    transition: all 0.3s;
    box-shadow: 0 8px 32px rgba(200,163,77,0.4);
    letter-spacing: 0.3px;
}
.btn-wa-cta:hover {
    transform: translateY(-3px);
    box-shadow: 0 14px 40px rgba(200,163,77,0.55);
    color: #fff;
}
.btn-outline-sidebar {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 13px 20px;
    border-radius: 14px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    background: transparent;
    border: 1.5px solid rgba(255,255,255,0.15);
    color: rgba(255,255,255,0.8);
    text-decoration: none;
    transition: all 0.25s;
    margin-top: 10px;
}
.btn-outline-sidebar:hover {
    background: rgba(255,255,255,0.08);
    color: #fff;
    border-color: rgba(255,255,255,0.3);
}
.btn-outline-sidebar i { color: #C8A34D; }

/* Secondary actions card */
.sidebar-actions-card {
    background: #fff;
    border-radius: 20px;
    padding: 22px;
    border: 1px solid rgba(0,0,0,0.07);
    margin-bottom: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
}
.sidebar-card-title {
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: #9CA3AF;
    margin-bottom: 14px;
}
.sidebar-action-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    border-radius: 12px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    background: #f8f9fa;
    border: 1px solid rgba(0,0,0,0.05);
    margin-bottom: 8px;
    transition: all 0.2s;
}
.sidebar-action-btn:last-child { margin-bottom: 0; }
.sidebar-action-btn:hover {
    background: rgba(200,163,77,0.07);
    border-color: rgba(200,163,77,0.25);
    color: #C8A34D;
}
.sidebar-action-btn i { width: 20px; color: #C8A34D; font-size: 16px; }

/* Share buttons */
.share-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 9px 16px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    flex: 1;
}
.share-btn-wa { background: rgba(37,211,102,0.1); color: #25D366; border: 1px solid rgba(37,211,102,0.2); }
.share-btn-wa:hover { background: #25D366; color: #fff; }
.share-btn-fb { background: rgba(24,119,242,0.1); color: #1877F2; border: 1px solid rgba(24,119,242,0.2); }
.share-btn-fb:hover { background: #1877F2; color: #fff; }
.share-btn-tw { background: rgba(29,161,242,0.1); color: #1DA1F2; border: 1px solid rgba(29,161,242,0.2); }
.share-btn-tw:hover { background: #1DA1F2; color: #fff; }
.share-btn-copy { background: rgba(107,114,128,0.1); color: #6B7280; border: 1px solid rgba(107,114,128,0.15); }
.share-btn-copy:hover { background: #C8A34D; color: #fff; border-color: #C8A34D; }

/* Related trainings */
.related-training-card {
    display: flex;
    gap: 12px;
    padding: 12px;
    border-radius: 14px;
    text-decoration: none;
    background: #f8f9fa;
    border: 1px solid rgba(0,0,0,0.05);
    transition: all 0.25s;
    margin-bottom: 10px;
}
.related-training-card:last-child { margin-bottom: 0; }
.related-training-card:hover {
    background: #fff;
    box-shadow: 0 6px 24px rgba(0,0,0,0.08);
    transform: translateX(4px);
}
.related-training-img {
    width: 72px;
    height: 56px;
    border-radius: 10px;
    object-fit: cover;
    flex-shrink: 0;
}
.related-training-title {
    font-size: 13px;
    font-weight: 700;
    color: #121212;
    line-height: 1.45;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 4px;
}
.related-training-date { font-size: 11px; color: #9CA3AF; }
.related-training-price { font-size: 13px; font-weight: 800; color: #C8A34D; }

/* Gallery lightbox modal */
.gallery-modal .modal-dialog { max-width: 90vw; }
.gallery-modal .modal-content {
    background: #000;
    border-radius: 16px;
    overflow: hidden;
    border: none;
}
.gallery-modal img { width: 100%; max-height: 80vh; object-fit: contain; }

@media (max-width: 991px) {
    .detail-sidebar { position: static; margin-top: 24px; }
    .detail-tabs-wrap { padding: 0 20px; }
    .detail-tab-panels { padding: 24px 20px; }
    .detail-badges { padding: 20px 20px 0; }
    .detail-title-area { padding: 16px 20px 20px; }
}
</style>

<!-- ====== TOP BAR ====== -->
<div class="detail-topbar">
    <div class="container position-relative">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb detail-breadcrumb mb-3">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="fas fa-home me-1"></i>Beranda</a></li>
                <li class="breadcrumb-item"><a href="<?= site_url('pelatihan') ?>">Pelatihan</a></li>
                <li class="breadcrumb-item active" title="<?= esc($training['title']) ?>"><?= esc($training['title']) ?></li>
            </ol>
        </nav>
        <h1 class="detail-topbar-title"><?= esc($training['title']) ?></h1>
    </div>
</div>

<!-- ====== MAIN CONTENT ====== -->
<div class="detail-main">
    <div class="container">
        <div class="row g-5">

            <!-- ======== LEFT COLUMN ======== -->
            <div class="col-lg-8">
                <div class="detail-content-wrap" data-aos="fade-up">

                    <!-- Cover image -->
                    <?php
                    $coverUrl = !empty($training['cover'])
                        ? base_url('assets/uploads/training/' . $training['cover'])
                        : 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=900&h=400&fit=crop';
                    ?>
                    <img src="<?= $coverUrl ?>"
                         alt="<?= esc($training['title']) ?>"
                         class="detail-cover-img"
                         onerror="this.src='https://images.unsplash.com/photo-1552664730-d307ca884978?w=900&h=400&fit=crop'">

                    <!-- Badges -->
                    <div class="detail-badges">
                        <?php if (!empty($training['category_name'])): ?>
                        <span class="badge-category"
                              style="background:<?= esc($training['category_color'] ?? '#C8A34D') ?>18; color:<?= esc($training['category_color'] ?? '#C8A34D') ?>; border:1px solid <?= esc($training['category_color'] ?? '#C8A34D') ?>35;">
                            <i class="fas <?= esc($training['category_icon'] ?? 'fa-tag') ?>"></i>
                            <?= esc($training['category_name']) ?>
                        </span>
                        <?php endif; ?>

                        <?php
                        $seatsLeft = max(0, ($training['max_participants'] ?? 0) - ($training['current_participants'] ?? 0));
                        $isFull = !empty($training['max_participants']) && $seatsLeft === 0;
                        $isOpen = !$isFull && (!isset($training['registration_deadline']) || !$training['registration_deadline'] || strtotime($training['registration_deadline']) >= time());
                        ?>
                        <?php if ($isFull): ?>
                        <span class="badge-status-full"><i class="fas fa-times-circle me-1"></i>Kuota Penuh</span>
                        <?php elseif ($isOpen): ?>
                        <span class="badge-status-open"><i class="fas fa-check-circle me-1"></i>Pendaftaran Dibuka</span>
                        <?php endif; ?>

                        <?php if (!empty($training['is_online'])): ?>
                        <span class="badge-online"><i class="fas fa-wifi me-1"></i>Online</span>
                        <?php endif; ?>

                        <?php if (!empty($training['is_featured'])): ?>
                        <span class="badge-featured"><i class="fas fa-star me-1"></i>Unggulan</span>
                        <?php endif; ?>
                    </div>

                    <!-- Title & Meta -->
                    <div class="detail-title-area">
                        <h1 class="detail-h1"><?= esc($training['title']) ?></h1>

                        <div class="detail-meta-row">
                            <?php if (!empty($training['start_date'])): ?>
                            <div class="detail-meta-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span>
                                    <strong><?= date('d M Y', strtotime($training['start_date'])) ?></strong>
                                    <?php if (!empty($training['end_date']) && $training['end_date'] !== $training['start_date']): ?>
                                    &ndash; <?= date('d M Y', strtotime($training['end_date'])) ?>
                                    <?php endif; ?>
                                </span>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($training['location_name'])): ?>
                            <div class="detail-meta-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?= esc($training['location_name']) ?><?= !empty($training['location_city']) ? ', ' . esc($training['location_city']) : '' ?></span>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($speakers)): ?>
                            <div class="detail-meta-item">
                                <i class="fas fa-chalkboard-teacher"></i>
                                <span>
                                    <?= implode(', ', array_map(fn($s) => esc($s['name']), $speakers)) ?>
                                </span>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($training['duration_days'])): ?>
                            <div class="detail-meta-item">
                                <i class="fas fa-clock"></i>
                                <span><?= (int)$training['duration_days'] ?> Hari<?= !empty($training['duration_hours']) ? ' / ' . (int)$training['duration_hours'] . ' Jam' : '' ?></span>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($training['views'])): ?>
                            <div class="detail-meta-item">
                                <i class="fas fa-eye"></i>
                                <span><?= number_format($training['views']) ?> dilihat</span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Tabs Navigation -->
                    <div class="detail-tabs-wrap">
                        <div class="detail-tab-nav" role="tablist">
                            <button class="detail-tab-btn active" data-tab="deskripsi" role="tab">
                                <i class="fas fa-align-left"></i> Deskripsi
                            </button>
                            <?php if (!empty($materials)): ?>
                            <button class="detail-tab-btn" data-tab="materi" role="tab">
                                <i class="fas fa-list-ul"></i> Materi
                            </button>
                            <?php endif; ?>
                            <?php if (!empty($schedules) || !empty($training['location_lat'])): ?>
                            <button class="detail-tab-btn" data-tab="jadwal" role="tab">
                                <i class="fas fa-calendar-check"></i> Jadwal & Lokasi
                            </button>
                            <?php endif; ?>
                            <?php if (!empty($gallery)): ?>
                            <button class="detail-tab-btn" data-tab="galeri" role="tab">
                                <i class="fas fa-images"></i> Galeri
                            </button>
                            <?php endif; ?>
                            <?php if (!empty($testimonials)): ?>
                            <button class="detail-tab-btn" data-tab="testimoni" role="tab">
                                <i class="fas fa-star"></i> Testimoni
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Tab Panels -->
                    <div class="detail-tab-panels">

                        <!-- Deskripsi -->
                        <div class="detail-tab-panel active" id="tab-deskripsi">
                            <?php if (!empty($training['description'])): ?>
                            <div class="ck-content">
                                <?= $training['description'] ?>
                            </div>
                            <?php elseif (!empty($training['short_description'])): ?>
                            <p style="font-size:16px; color:#374151; line-height:1.8;"><?= esc($training['short_description']) ?></p>
                            <?php else: ?>
                            <p style="color:#9CA3AF;">Deskripsi belum tersedia.</p>
                            <?php endif; ?>
                        </div>

                        <!-- Materi -->
                        <?php if (!empty($materials)): ?>
                        <div class="detail-tab-panel" id="tab-materi">
                            <h3 style="font-size:18px; font-weight:800; color:#121212; margin-bottom:20px;">
                                <i class="fas fa-book-open me-2" style="color:#C8A34D;"></i>
                                Materi Pelatihan (<?= count($materials) ?> Topik)
                            </h3>
                            <ul class="materials-list">
                                <?php foreach ($materials as $idx => $item): ?>
                                <li>
                                    <span class="num"><?= str_pad($idx + 1, 2, '0', STR_PAD_LEFT) ?></span>
                                    <span><?= esc(is_array($item) ? ($item['title'] ?? $item['name'] ?? json_encode($item)) : $item) ?></span>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>

                        <!-- Jadwal & Lokasi -->
                        <?php if (!empty($schedules) || !empty($training['location_lat'])): ?>
                        <div class="detail-tab-panel" id="tab-jadwal">
                            <?php if (!empty($schedules)): ?>
                            <h3 style="font-size:18px; font-weight:800; color:#121212; margin-bottom:20px;">
                                <i class="fas fa-calendar-week me-2" style="color:#C8A34D;"></i>
                                Jadwal Kegiatan
                            </h3>
                            <div style="overflow-x:auto; border-radius:16px; border:1px solid rgba(0,0,0,0.07);">
                                <table class="schedule-table">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Waktu</th>
                                            <th>Sesi / Materi</th>
                                            <th>Ruangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($schedules as $sch): ?>
                                        <tr>
                                            <td>
                                                <strong><?= !empty($sch['date']) ? date('d M Y', strtotime($sch['date'])) : '-' ?></strong>
                                                <?php if (!empty($sch['day_label'])): ?>
                                                <div style="font-size:11px; color:#9CA3AF;"><?= esc($sch['day_label']) ?></div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?= !empty($sch['start_time']) ? esc($sch['start_time']) : '' ?>
                                                <?= !empty($sch['end_time']) ? ' - ' . esc($sch['end_time']) : '' ?>
                                                <?= empty($sch['start_time']) ? '-' : '' ?>
                                            </td>
                                            <td><?= !empty($sch['topic']) ? esc($sch['topic']) : (!empty($sch['session']) ? esc($sch['session']) : '-') ?></td>
                                            <td><?= !empty($sch['room']) ? esc($sch['room']) : '-' ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($training['location_lat']) && !empty($training['location_lng'])): ?>
                            <h3 style="font-size:18px; font-weight:800; color:#121212; margin: 28px 0 16px;">
                                <i class="fas fa-map-marked-alt me-2" style="color:#C8A34D;"></i>
                                Lokasi Venue
                            </h3>
                            <div class="map-embed">
                                <iframe
                                    src="https://maps.google.com/maps?q=<?= esc($training['location_lat']) ?>,<?= esc($training['location_lng']) ?>&z=15&output=embed"
                                    allowfullscreen loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"
                                    title="Lokasi Pelatihan"
                                    style="width:100%; height:100%; border:none; border-radius:16px;">
                                </iframe>
                            </div>
                            <?php elseif (!empty($training['location_name'])): ?>
                            <div style="background:#f8f9fa; border-radius:16px; padding:20px; display:flex; align-items:center; gap:14px; margin-top:24px; border:1px solid rgba(0,0,0,0.06);">
                                <i class="fas fa-map-marker-alt fa-2x" style="color:#C8A34D;"></i>
                                <div>
                                    <div style="font-weight:700; color:#121212;"><?= esc($training['location_name']) ?></div>
                                    <?php if (!empty($training['location_city'])): ?>
                                    <div style="font-size:13px; color:#6B7280;"><?= esc($training['location_city']) ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>

                        <!-- Galeri -->
                        <?php if (!empty($gallery)): ?>
                        <div class="detail-tab-panel" id="tab-galeri">
                            <h3 style="font-size:18px; font-weight:800; color:#121212; margin-bottom:20px;">
                                <i class="fas fa-images me-2" style="color:#C8A34D;"></i>
                                Galeri Kegiatan
                            </h3>
                            <div class="gallery-grid">
                                <?php foreach ($gallery as $gidx => $gal): ?>
                                <?php
                                $imgUrl = !empty($gal['image'])
                                    ? base_url('assets/uploads/training/gallery/' . $gal['image'])
                                    : (is_string($gal) ? base_url($gal) : '');
                                ?>
                                <?php if ($imgUrl): ?>
                                <div class="gallery-item"
                                     data-bs-toggle="modal"
                                     data-bs-target="#galleryModal"
                                     data-img="<?= $imgUrl ?>"
                                     data-caption="<?= esc($gal['caption'] ?? '') ?>">
                                    <img src="<?= $imgUrl ?>"
                                         alt="Galeri <?= $gidx + 1 ?>"
                                         loading="lazy"
                                         onerror="this.parentElement.style.display='none'">
                                </div>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Testimoni -->
                        <?php if (!empty($testimonials)): ?>
                        <div class="detail-tab-panel" id="tab-testimoni">
                            <h3 style="font-size:18px; font-weight:800; color:#121212; margin-bottom:20px;">
                                <i class="fas fa-quote-left me-2" style="color:#C8A34D;"></i>
                                Testimoni Peserta (<?= count($testimonials) ?>)
                            </h3>
                            <div class="row g-3">
                                <?php foreach ($testimonials as $testi): ?>
                                <div class="col-md-6">
                                    <div class="testi-card">
                                        <div class="testi-stars">
                                            <?php for ($s = 1; $s <= 5; $s++): ?>
                                            <i class="fas fa-star" style="color:<?= $s <= (int)($testi['rating'] ?? 5) ? '#C8A34D' : '#e5e7eb' ?>; font-size:13px;"></i>
                                            <?php endfor; ?>
                                            <span style="font-size:12px; color:#9CA3AF; margin-left:6px;"><?= (int)($testi['rating'] ?? 5) ?>/5</span>
                                        </div>
                                        <div class="testi-quote"><?= esc($testi['comment'] ?? $testi['content'] ?? '') ?></div>
                                        <div class="testi-author">
                                            <?php if (!empty($testi['photo'])): ?>
                                            <img src="<?= base_url('assets/uploads/testimonials/' . $testi['photo']) ?>"
                                                 alt="<?= esc($testi['name']) ?>"
                                                 class="testi-avatar"
                                                 onerror="this.style.display='none'">
                                            <?php else: ?>
                                            <div class="testi-avatar-placeholder"><?= strtoupper(substr($testi['name'] ?? 'P', 0, 1)) ?></div>
                                            <?php endif; ?>
                                            <div>
                                                <div class="testi-name"><?= esc($testi['name'] ?? 'Peserta') ?></div>
                                                <div class="testi-pos">
                                                    <?= esc($testi['position'] ?? '') ?>
                                                    <?= !empty($testi['position']) && !empty($testi['institution']) ? ', ' : '' ?>
                                                    <?= esc($testi['institution'] ?? '') ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                    </div><!-- /tab panels -->
                </div><!-- /content wrap -->

                <!-- FAQ Section -->
                <?php if (!empty($faqs)): ?>
                <div class="mt-4" data-aos="fade-up">
                    <div style="background:#fff; border-radius:24px; padding:32px; border:1px solid rgba(0,0,0,0.06); box-shadow:0 2px 20px rgba(0,0,0,0.05);">
                        <div style="margin-bottom:24px;">
                            <span style="font-size:11px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:#9CA3AF;">Pertanyaan Umum</span>
                            <h3 style="font-size:22px; font-weight:900; color:#121212; margin-top:8px; margin-bottom:0;">FAQ Pelatihan</h3>
                        </div>
                        <?php foreach ($faqs as $fi => $faq): ?>
                        <div class="faq-item-det">
                            <button class="faq-q-det"
                                    aria-expanded="<?= $fi === 0 ? 'true' : 'false' ?>">
                                <span><?= esc($faq['question']) ?></span>
                                <div class="faq-icon-det"><i class="fas fa-plus"></i></div>
                            </button>
                            <div class="faq-a-det <?= $fi === 0 ? 'open' : '' ?>">
                                <div class="faq-a-det-inner"><?= nl2br(esc($faq['answer'])) ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

            </div><!-- /col-lg-8 -->

            <!-- ======== RIGHT SIDEBAR ======== -->
            <div class="col-lg-4">
                <div class="detail-sidebar" data-aos="fade-left" data-aos-delay="200">

                    <!-- Price Card (Glassmorphism) -->
                    <div class="price-card">
                        <div class="price-card-label">Investasi Program</div>
                        <?php if (!empty($training['price']) && $training['price'] > 0): ?>
                        <div class="price-card-price">Rp <?= number_format($training['price'], 0, ',', '.') ?></div>
                        <div class="price-card-price-info">
                            <?= esc($training['price_info'] ?? 'per peserta, sudah termasuk sertifikat & materi') ?>
                        </div>
                        <?php else: ?>
                        <div class="price-card-price" style="color:#10B981;">Gratis</div>
                        <div class="price-card-price-info">Tidak ada biaya pendaftaran</div>
                        <?php endif; ?>

                        <div class="price-card-divider"></div>

                        <!-- Quota -->
                        <?php if (!empty($training['max_participants'])): ?>
                        <?php
                        $qPct = round(($training['current_participants'] / max(1, $training['max_participants'])) * 100);
                        ?>
                        <div class="sidebar-quota-label">
                            <span><?= $training['current_participants'] ?>/<?= $training['max_participants'] ?> Peserta</span>
                            <span><?= $seatsLeft > 0 ? $seatsLeft . ' kursi tersisa' : 'Penuh' ?></span>
                        </div>
                        <div class="sidebar-quota-track">
                            <div class="sidebar-quota-fill <?= $isFull ? 'full' : '' ?>"
                                 style="width:<?= min($qPct, 100) ?>%"></div>
                        </div>
                        <?php endif; ?>

                        <!-- Deadline countdown -->
                        <?php if (!empty($training['registration_deadline'])): ?>
                        <div style="font-size:11px; color:rgba(255,255,255,0.4); text-transform:uppercase; letter-spacing:1.5px; margin-bottom:10px; text-align:center;">Pendaftaran ditutup</div>
                        <div class="sidebar-countdown" id="detailCountdown"
                             data-date="<?= esc($training['registration_deadline']) ?>">
                            <div class="countdown-box"><span class="countdown-box-val" id="cdD">--</span><span class="countdown-box-lbl">Hari</span></div>
                            <div class="countdown-box"><span class="countdown-box-val" id="cdH">--</span><span class="countdown-box-lbl">Jam</span></div>
                            <div class="countdown-box"><span class="countdown-box-val" id="cdM">--</span><span class="countdown-box-lbl">Menit</span></div>
                            <div class="countdown-box"><span class="countdown-box-val" id="cdS">--</span><span class="countdown-box-lbl">Detik</span></div>
                        </div>
                        <?php endif; ?>

                        <div class="price-card-divider"></div>

                        <!-- WhatsApp CTA -->
                        <button type="button" class="btn-wa-cta"
                                onclick="waRegister(
                                    '<?= (int)$training['id'] ?>',
                                    '<?= esc(addslashes($training['title'])) ?>',
                                    '<?= !empty($training['start_date']) ? date('d F Y', strtotime($training['start_date'])) : 'TBA' ?>',
                                    '<?= esc($profile['whatsapp'] ?? '6281803867430') ?>'
                                )">
                            <i class="fab fa-whatsapp" style="font-size:20px;"></i>
                            Daftar via WhatsApp
                        </button>

                        <!-- Brochure download -->
                        <?php if (!empty($training['brochure'])): ?>
                        <a href="<?= site_url('pelatihan/' . esc($training['slug']) . '/brosur') ?>"
                           class="btn-outline-sidebar" target="_blank">
                            <i class="fas fa-file-pdf"></i> Download Brosur
                        </a>
                        <?php endif; ?>

                        <!-- Certificate preview -->
                        <a href="<?= site_url('pelatihan/' . esc($training['slug']) . '/sertifikat-preview') ?>"
                           class="btn-outline-sidebar" target="_blank">
                            <i class="fas fa-certificate"></i> Preview E-Certificate
                        </a>

                        <!-- In-House link -->
                        <a href="<?= site_url('pelatihan/inhouse') ?>"
                           class="btn-outline-sidebar">
                            <i class="fas fa-building"></i> Request In-House Training
                        </a>
                    </div>

                    <!-- Secondary Actions -->
                    <div class="sidebar-actions-card">
                        <div class="sidebar-card-title">Kalender Pelatihan</div>
                        <a href="<?= site_url('jadwal-pelatihan') ?>" class="sidebar-action-btn">
                            <i class="fas fa-calendar-alt"></i>
                            Lihat Jadwal Lengkap
                            <i class="fas fa-chevron-right ms-auto" style="color:#9CA3AF; font-size:11px;"></i>
                        </a>
                        <a href="<?= site_url('pelatihan') ?>" class="sidebar-action-btn">
                            <i class="fas fa-th-large"></i>
                            Semua Program Pelatihan
                            <i class="fas fa-chevron-right ms-auto" style="color:#9CA3AF; font-size:11px;"></i>
                        </a>
                        <a href="https://wa.me/<?= esc($profile['whatsapp'] ?? '6281803867430') ?>?text=<?= urlencode('Halo BKC, saya ingin bertanya tentang pelatihan ' . ($training['title'] ?? '')) ?>"
                           class="sidebar-action-btn" target="_blank" rel="noopener">
                            <i class="fab fa-whatsapp"></i>
                            Konsultasi Gratis
                            <i class="fas fa-chevron-right ms-auto" style="color:#9CA3AF; font-size:11px;"></i>
                        </a>
                    </div>

                    <!-- Share Buttons -->
                    <div class="sidebar-actions-card">
                        <div class="sidebar-card-title">Bagikan</div>
                        <div class="d-flex gap-2 flex-wrap">
                            <?php
                            $shareUrl = urlencode(current_url());
                            $shareTitle = urlencode($training['title']);
                            ?>
                            <a href="https://wa.me/?text=<?= $shareTitle . ' ' . $shareUrl ?>"
                               class="share-btn share-btn-wa" target="_blank" rel="noopener">
                                <i class="fab fa-whatsapp"></i> WA
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $shareUrl ?>"
                               class="share-btn share-btn-fb" target="_blank" rel="noopener">
                                <i class="fab fa-facebook-f"></i> FB
                            </a>
                            <a href="https://twitter.com/intent/tweet?text=<?= $shareTitle ?>&url=<?= $shareUrl ?>"
                               class="share-btn share-btn-tw" target="_blank" rel="noopener">
                                <i class="fab fa-x-twitter"></i> X
                            </a>
                            <button class="share-btn share-btn-copy" onclick="copyLink()">
                                <i class="fas fa-link"></i> Salin
                            </button>
                        </div>
                    </div>

                    <!-- Related Trainings -->
                    <?php if (!empty($related)): ?>
                    <div class="sidebar-actions-card">
                        <div class="sidebar-card-title">Pelatihan Terkait</div>
                        <?php foreach ($related as $rel): ?>
                        <a href="<?= site_url('pelatihan/' . esc($rel['slug'])) ?>" class="related-training-card">
                            <img src="<?= !empty($rel['cover']) ? base_url('assets/uploads/training/' . $rel['cover']) : 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=150&h=100&fit=crop' ?>"
                                 alt="<?= esc($rel['title']) ?>"
                                 class="related-training-img"
                                 onerror="this.src='https://images.unsplash.com/photo-1552664730-d307ca884978?w=150&h=100&fit=crop'">
                            <div style="flex:1; min-width:0;">
                                <div class="related-training-title"><?= esc($rel['title']) ?></div>
                                <?php if (!empty($rel['start_date'])): ?>
                                <div class="related-training-date">
                                    <i class="fas fa-calendar me-1"></i><?= date('d M Y', strtotime($rel['start_date'])) ?>
                                </div>
                                <?php endif; ?>
                                <?php if (!empty($rel['price']) && $rel['price'] > 0): ?>
                                <div class="related-training-price">Rp <?= number_format($rel['price'], 0, ',', '.') ?></div>
                                <?php endif; ?>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                </div><!-- /sidebar -->
            </div><!-- /col-lg-4 -->

        </div><!-- /row -->
    </div><!-- /container -->
</div><!-- /detail-main -->

<!-- Gallery Modal -->
<div class="modal fade gallery-modal" id="galleryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0" style="position:absolute; top:0; right:0; z-index:10; padding:8px;">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <img id="galleryModalImg" src="" alt="Galeri" style="width:100%; max-height:80vh; object-fit:contain;">
            </div>
            <div class="modal-footer border-0 justify-content-center" id="galleryModalCaption"
                 style="font-size:13px; color:rgba(255,255,255,0.6); padding:12px;"></div>
        </div>
    </div>
</div>

<script>
// waRegister
function waRegister(trainingId, trainingTitle, trainingDate, waNumber) {
    const msg = `Halo Admin BKC 👋\n\nSaya ingin mendaftarkan diri pada pelatihan berikut:\n\n📚 *${trainingTitle}*\n📅 Tanggal: ${trainingDate}\n\nMohon informasi lebih lanjut mengenai prosedur pendaftaran dan biaya pelatihan. Terima kasih.`;
    window.open(`https://wa.me/${waNumber}?text=${encodeURIComponent(msg)}`, '_blank', 'noopener');
}

// Copy link
function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        Swal.fire({ icon: 'success', title: 'Tautan disalin!', text: 'Tautan pelatihan berhasil disalin ke clipboard.', timer: 2000, showConfirmButton: false, position: 'top-end', toast: true });
    }).catch(() => {
        const el = document.createElement('input');
        el.value = window.location.href;
        document.body.appendChild(el);
        el.select();
        document.execCommand('copy');
        document.body.removeChild(el);
        Swal.fire({ icon: 'success', title: 'Tautan disalin!', timer: 2000, showConfirmButton: false, position: 'top-end', toast: true });
    });
}

// Tab switching
document.querySelectorAll('.detail-tab-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const target = this.dataset.tab;

        document.querySelectorAll('.detail-tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.detail-tab-panel').forEach(p => p.classList.remove('active'));

        this.classList.add('active');
        const panel = document.getElementById('tab-' + target);
        if (panel) panel.classList.add('active');
    });
});

// FAQ toggle
document.querySelectorAll('.faq-q-det').forEach(btn => {
    btn.addEventListener('click', function() {
        const isOpen = this.getAttribute('aria-expanded') === 'true';
        const answer = this.nextElementSibling;

        document.querySelectorAll('.faq-q-det').forEach(b => {
            b.setAttribute('aria-expanded', 'false');
            b.nextElementSibling.classList.remove('open');
        });

        if (!isOpen) {
            this.setAttribute('aria-expanded', 'true');
            answer.classList.add('open');
        }
    });
});

// Gallery modal
document.querySelectorAll('.gallery-item').forEach(item => {
    item.addEventListener('click', function() {
        document.getElementById('galleryModalImg').src = this.dataset.img || '';
        document.getElementById('galleryModalCaption').textContent = this.dataset.caption || '';
    });
});

// Countdown timer
(function() {
    const el = document.getElementById('detailCountdown');
    if (!el) return;

    const target = new Date(el.dataset.date).getTime();

    function tick() {
        const now = Date.now();
        const diff = target - now;

        if (diff <= 0) {
            el.innerHTML = '<div class="countdown-over">Pendaftaran telah ditutup</div>';
            return;
        }

        const d = Math.floor(diff / 86400000);
        const h = Math.floor((diff % 86400000) / 3600000);
        const m = Math.floor((diff % 3600000) / 60000);
        const s = Math.floor((diff % 60000) / 1000);

        const pad = v => String(v).padStart(2, '0');
        const cd = document.getElementById('cdD');
        const ch = document.getElementById('cdH');
        const cm = document.getElementById('cdM');
        const cs = document.getElementById('cdS');
        if (cd) cd.textContent = pad(d);
        if (ch) ch.textContent = pad(h);
        if (cm) cm.textContent = pad(m);
        if (cs) cs.textContent = pad(s);
    }

    tick();
    setInterval(tick, 1000);
})();
</script>

<?= $this->endSection() ?>
