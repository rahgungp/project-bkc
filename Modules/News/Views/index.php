<?= $this->extend('Modules\Website\Views\layout\main') ?>
<?= $this->section('content') ?>

<style>
:root {
    --gold: #C8A34D;
    --gold-light: rgba(200,163,77,0.12);
    --royal: #1E4FA3;
    --royal-light: rgba(30,79,163,0.08);
    --dark: #121212;
    --surface: #f5f7fa;
}

/* ---- Hero ---- */
.news-hero {
    background: linear-gradient(135deg, #0a0a1a 0%, #0d1b3e 50%, #121212 100%);
    padding: 110px 0 70px; position: relative; overflow: hidden;
}
.news-hero::before {
    content: ''; position: absolute; inset: 0;
    background: radial-gradient(ellipse 60% 60% at 80% 50%, rgba(200,163,77,0.07) 0%, transparent 60%),
                radial-gradient(ellipse 50% 50% at 15% 70%, rgba(30,79,163,0.09) 0%, transparent 60%);
}
.news-hero-badge {
    display: inline-flex; align-items: center; gap: 8px; padding: 6px 18px;
    background: rgba(200,163,77,0.15); border: 1px solid rgba(200,163,77,0.3);
    border-radius: 100px; font-size: 12px; font-weight: 600; letter-spacing: 1.2px;
    text-transform: uppercase; color: #C8A34D; margin-bottom: 18px;
}
.news-hero-title { font-size: clamp(32px,4.5vw,58px); font-weight: 900; color: #fff; margin-bottom: 14px; }
.news-hero-title span { color: #C8A34D; }
.news-hero-sub { color: rgba(255,255,255,.7); font-size: 16px; max-width: 560px; }

/* ---- Search & Filters ---- */
.news-filter-section {
    background: #fff; border-bottom: 1px solid #e9ecef;
    padding: 20px 0; position: sticky; top: 70px; z-index: 100;
    box-shadow: 0 2px 12px rgba(0,0,0,.06);
}
.search-box {
    display: flex; border: 2px solid #dee2e6; border-radius: 50px; overflow: hidden;
    transition: border-color .2s;
}
.search-box:focus-within { border-color: #C8A34D; }
.search-box input {
    border: none; outline: none; padding: 10px 18px; flex: 1; font-size: 14px;
}
.search-box button {
    background: #C8A34D; border: none; color: #121212; font-weight: 700;
    padding: 10px 22px; font-size: 14px; cursor: pointer; transition: background .2s;
}
.search-box button:hover { background: #b8932d; }
.cat-filter-tabs { display: flex; gap: 8px; flex-wrap: wrap; }
.cat-tab {
    padding: 7px 18px; border-radius: 30px; font-size: 13px; font-weight: 600;
    background: #f0f2f5; color: #555; border: none; cursor: pointer; transition: all .2s;
    text-decoration: none;
}
.cat-tab.active, .cat-tab:hover {
    background: #C8A34D; color: #121212;
}

/* ---- Featured Article ---- */
.featured-article {
    background: #fff; border-radius: 20px; overflow: hidden;
    box-shadow: 0 4px 24px rgba(0,0,0,.09); margin-bottom: 48px;
    display: flex; flex-wrap: wrap;
}
.featured-img-wrap {
    flex: 0 0 48%; max-width: 48%;
    min-height: 300px; overflow: hidden;
}
.featured-img-wrap img {
    width: 100%; height: 100%; object-fit: cover; transition: transform .4s;
}
.featured-article:hover .featured-img-wrap img { transform: scale(1.04); }
.featured-content {
    flex: 0 0 52%; max-width: 52%; padding: 36px 40px;
    display: flex; flex-direction: column; justify-content: center;
}
.featured-label {
    font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase;
    color: #C8A34D; margin-bottom: 10px;
}
.featured-label i { margin-right: 5px; }
.featured-title { font-size: clamp(20px,2.5vw,28px); font-weight: 800; color: #121212; margin-bottom: 12px; line-height: 1.3; }
.featured-title a { color: inherit; text-decoration: none; }
.featured-title a:hover { color: #1E4FA3; }
.featured-meta { font-size: 12px; color: #6B7280; margin-bottom: 14px; display: flex; gap: 16px; flex-wrap: wrap; }
.featured-meta span { display: flex; align-items: center; gap: 5px; }
.featured-excerpt { font-size: 14px; color: #555; line-height: 1.7; margin-bottom: 24px; }
.featured-badge {
    display: inline-block; background: rgba(200,163,77,.15); color: #7a5a1a;
    font-size: 11px; font-weight: 700; padding: 3px 12px; border-radius: 20px; margin-bottom: 12px;
}
@media(max-width:768px) {
    .featured-img-wrap, .featured-content { flex: 0 0 100%; max-width: 100%; }
    .featured-content { padding: 24px; }
}

/* ---- News Grid ---- */
.news-main-section { background: var(--surface); padding: 60px 0 80px; }
.news-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 28px; }
@media(max-width:992px) { .news-grid { grid-template-columns: repeat(2,1fr); } }
@media(max-width:576px) { .news-grid { grid-template-columns: 1fr; } }

.news-card {
    background: #fff; border-radius: 16px; overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,.07); transition: all .3s;
    display: flex; flex-direction: column;
}
.news-card:hover { transform: translateY(-6px); box-shadow: 0 12px 32px rgba(0,0,0,.12); }
.news-card-img {
    height: 200px; overflow: hidden; position: relative;
}
.news-card-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
.news-card:hover .news-card-img img { transform: scale(1.06); }
.news-card-img .no-img {
    width: 100%; height: 100%; background: linear-gradient(135deg, #1E4FA3, #0d3280);
    display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,.3); font-size: 48px;
}
.news-cat-badge {
    position: absolute; top: 14px; left: 14px;
    background: #C8A34D; color: #121212; font-size: 10px; font-weight: 700;
    padding: 3px 12px; border-radius: 20px; letter-spacing: .5px; text-transform: uppercase;
}
.news-card-body { padding: 20px; flex: 1; display: flex; flex-direction: column; }
.news-date { font-size: 11px; color: #adb5bd; margin-bottom: 8px; display: flex; align-items: center; gap: 5px; }
.news-title {
    font-size: 15px; font-weight: 700; color: #212529; margin-bottom: 10px; line-height: 1.4;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}
.news-title a { color: inherit; text-decoration: none; }
.news-title a:hover { color: #1E4FA3; }
.news-excerpt {
    font-size: 13px; color: #6B7280; line-height: 1.65;
    display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
    flex: 1;
}
.news-card-footer {
    padding: 0 20px 18px; display: flex; justify-content: space-between; align-items: center;
}
.btn-read-more {
    font-size: 13px; font-weight: 700; color: #1E4FA3; text-decoration: none;
    display: flex; align-items: center; gap: 5px; transition: gap .2s;
}
.btn-read-more:hover { gap: 10px; color: #C8A34D; }
.news-views { font-size: 11px; color: #adb5bd; display: flex; align-items: center; gap: 4px; }

/* ---- Pagination ---- */
.news-pagination { display: flex; justify-content: center; margin-top: 48px; gap: 6px; }
.news-pagination .page-link {
    width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center;
    border: 2px solid #dee2e6; color: #333; font-weight: 600; font-size: 14px;
    text-decoration: none; transition: all .2s;
}
.news-pagination .page-link:hover, .news-pagination .page-link.active {
    background: #C8A34D; border-color: #C8A34D; color: #121212;
}

/* ---- Empty State ---- */
.news-empty { text-align: center; padding: 80px 20px; }
.news-empty i { font-size: 52px; color: #C8A34D; opacity: .4; margin-bottom: 20px; }
.news-empty h5 { font-weight: 700; color: #333; }
.news-empty p { color: #6B7280; }

/* ---- Section Head ---- */
.section-head { margin-bottom: 36px; }
.section-head h2 { font-size: 28px; font-weight: 900; color: #212529; margin-bottom: 4px; }
.section-head p { font-size: 14px; color: #6B7280; }
.section-head .line {
    width: 50px; height: 4px; background: #C8A34D; border-radius: 4px; margin-top: 10px;
}
</style>

<!-- HERO -->
<section class="news-hero">
    <div class="container position-relative">
        <div class="row">
            <div class="col-lg-7" data-aos="fade-up">
                <div class="news-hero-badge">
                    <i class="fas fa-newspaper"></i>
                    Berita &amp; Artikel
                </div>
                <h1 class="news-hero-title">
                    Informasi <span>Terkini</span>
                </h1>
                <p class="news-hero-sub">
                    Informasi terkini seputar pelatihan dan pengembangan SDM dari CV. Bagus Kencana Cakrada.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- FILTER BAR -->
<div class="news-filter-section">
    <div class="container">
        <form action="" method="GET" class="d-flex gap-3 align-items-center flex-wrap">
            <div class="search-box flex-grow-1" style="max-width:360px;">
                <input type="text" name="q" value="<?= esc($filters['q'] ?? '') ?>" placeholder="Cari artikel...">
                <button type="submit"><i class="fas fa-search"></i></button>
            </div>
            <div class="cat-filter-tabs">
                <a href="<?= base_url('berita') ?>" class="cat-tab <?= empty($filters['category']) ? 'active' : '' ?>">
                    Semua
                </a>
                <?php if(!empty($categories)): foreach($categories as $cat): ?>
                <a href="<?= base_url('berita?category=' . esc($cat['slug'] ?? $cat['id'])) ?>"
                   class="cat-tab <?= (($filters['category'] ?? '') == ($cat['slug'] ?? $cat['id'])) ? 'active' : '' ?>">
                    <?= esc($cat['name']) ?>
                </a>
                <?php endforeach; endif; ?>
            </div>
        </form>
    </div>
</div>

<!-- MAIN CONTENT -->
<section class="news-main-section">
    <div class="container">

        <!-- Featured Article -->
        <?php if(!empty($featuredNews)): $fn = $featuredNews; ?>
        <div class="featured-article" data-aos="fade-up">
            <div class="featured-img-wrap">
                <?php if(!empty($fn['thumbnail'])): ?>
                    <img src="<?= base_url('assets/uploads/news/' . esc($fn['thumbnail'])) ?>" alt="<?= esc($fn['title']) ?>">
                <?php else: ?>
                    <img src="<?= base_url('assets/images/news-placeholder.jpg') ?>" alt=""
                         onerror="this.outerHTML='<div style=\'height:100%;background:linear-gradient(135deg,#1E4FA3,#0d3280);display:flex;align-items:center;justify-content:center;\'><i class=\'fas fa-newspaper\' style=\'font-size:60px;color:rgba(255,255,255,.2)\'></i></div>'">
                <?php endif; ?>
            </div>
            <div class="featured-content">
                <div class="featured-label">
                    <i class="fas fa-star"></i>Artikel Unggulan
                </div>
                <?php if(!empty($fn['category_name'])): ?>
                <span class="featured-badge"><?= esc($fn['category_name']) ?></span>
                <?php endif; ?>
                <h2 class="featured-title">
                    <a href="<?= base_url('berita/' . esc($fn['slug'])) ?>"><?= esc($fn['title']) ?></a>
                </h2>
                <div class="featured-meta">
                    <span><i class="fas fa-calendar"></i><?= !empty($fn['published_at']) ? date('d F Y', strtotime($fn['published_at'])) : date('d F Y', strtotime($fn['created_at'])) ?></span>
                    <?php if(!empty($fn['author_name'])): ?>
                    <span><i class="fas fa-user"></i><?= esc($fn['author_name']) ?></span>
                    <?php endif; ?>
                    <?php if(!empty($fn['views'])): ?>
                    <span><i class="fas fa-eye"></i><?= number_format((int)$fn['views']) ?> dilihat</span>
                    <?php endif; ?>
                </div>
                <p class="featured-excerpt">
                    <?= esc(mb_substr(strip_tags($fn['excerpt'] ?? $fn['content'] ?? ''), 0, 220)) ?>...
                </p>
                <a href="<?= base_url('berita/' . esc($fn['slug'])) ?>"
                   class="d-inline-flex align-items-center gap-2"
                   style="background:#C8A34D; color:#121212; font-weight:700; padding:12px 24px; border-radius:10px; text-decoration:none; font-size:14px; transition:all .2s;">
                    <span>Baca Selengkapnya</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        <?php endif; ?>

        <!-- Section Head -->
        <div class="section-head" data-aos="fade-up">
            <h2>Semua Artikel</h2>
            <p>Informasi terbaru seputar pelatihan, SDM, dan regulasi</p>
            <div class="line"></div>
        </div>

        <?php if(!empty($news) && count($news) > 0): ?>

        <!-- News Grid -->
        <div class="news-grid">
            <?php foreach($news as $i => $article): ?>
            <div class="news-card" data-aos="fade-up" data-aos-delay="<?= ($i % 3) * 80 ?>">
                <div class="news-card-img">
                    <?php if(!empty($article['thumbnail'])): ?>
                        <img src="<?= base_url('assets/uploads/news/' . esc($article['thumbnail'])) ?>"
                             alt="<?= esc($article['title']) ?>"
                             loading="lazy"
                             onerror="this.parentElement.innerHTML='<div class=\'no-img\'><i class=\'fas fa-newspaper\'></i></div>'">
                    <?php else: ?>
                        <div class="no-img"><i class="fas fa-newspaper"></i></div>
                    <?php endif; ?>

                    <?php if(!empty($article['category_name'])): ?>
                    <span class="news-cat-badge"><?= esc($article['category_name']) ?></span>
                    <?php endif; ?>
                </div>
                <div class="news-card-body">
                    <div class="news-date">
                        <i class="fas fa-calendar"></i>
                        <?= !empty($article['published_at']) ? date('d M Y', strtotime($article['published_at'])) : date('d M Y', strtotime($article['created_at'])) ?>
                    </div>
                    <h3 class="news-title">
                        <a href="<?= base_url('berita/' . esc($article['slug'])) ?>"><?= esc($article['title']) ?></a>
                    </h3>
                    <p class="news-excerpt">
                        <?= esc(mb_substr(strip_tags($article['excerpt'] ?? $article['content'] ?? ''), 0, 150)) ?>...
                    </p>
                </div>
                <div class="news-card-footer">
                    <a href="<?= base_url('berita/' . esc($article['slug'])) ?>" class="btn-read-more">
                        Baca <i class="fas fa-arrow-right"></i>
                    </a>
                    <?php if(!empty($article['views'])): ?>
                    <span class="news-views"><i class="fas fa-eye"></i><?= number_format((int)$article['views']) ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if(!empty($pager)): ?>
        <div class="news-pagination" data-aos="fade-up">
            <?= $pager->links('default', 'news_pager') ?>
        </div>
        <?php endif; ?>

        <?php else: ?>

        <!-- Empty State -->
        <div class="news-empty" data-aos="fade-up">
            <i class="fas fa-newspaper d-block"></i>
            <h5>Belum Ada Artikel</h5>
            <p>
                <?php if(!empty($filters['q'])): ?>
                    Tidak ditemukan artikel untuk pencarian "<strong><?= esc($filters['q']) ?></strong>".
                    <a href="<?= base_url('berita') ?>" style="color:#C8A34D;">Lihat semua artikel</a>
                <?php else: ?>
                    Artikel akan segera hadir. Pantau terus update dari kami!
                <?php endif; ?>
            </p>
        </div>

        <?php endif; ?>

    </div>
</section>

<!-- CTA Section -->
<section style="background: linear-gradient(135deg, #1E4FA3, #0d3280); padding: 60px 0; text-align: center;">
    <div class="container" data-aos="fade-up">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <h3 style="font-size:28px; font-weight:900; color:#fff; margin-bottom:12px;">
                    Tertarik dengan Pelatihan Kami?
                </h3>
                <p style="color:rgba(255,255,255,.75); font-size:16px; margin-bottom:28px;">
                    Konsultasikan kebutuhan pelatihan instansi Anda bersama tim BKC secara gratis.
                </p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="<?= base_url('pelatihan') ?>"
                       style="background:#C8A34D; color:#121212; font-weight:800; padding:14px 30px; border-radius:12px; text-decoration:none; font-size:15px; display:inline-flex; align-items:center; gap:8px;">
                        <i class="fas fa-graduation-cap"></i>Lihat Pelatihan
                    </a>
                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $profile['whatsapp'] ?? '6281805492754') ?>?text=<?= urlencode('Halo Admin BKC, saya ingin informasi pelatihan.') ?>"
                       target="_blank" rel="noopener"
                       style="background:rgba(255,255,255,.12); color:#fff; font-weight:700; padding:14px 30px; border-radius:12px; text-decoration:none; font-size:15px; display:inline-flex; align-items:center; gap:8px; border:1.5px solid rgba(255,255,255,.3);">
                        <i class="fab fa-whatsapp"></i>Konsultasi Gratis
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
