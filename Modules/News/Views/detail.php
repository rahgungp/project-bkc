<?= $this->extend('Modules\Website\Views\layout\main') ?>
<?= $this->section('content') ?>

<style>
:root {
    --gold: #C8A34D;
    --gold-light: rgba(200,163,77,0.12);
    --royal: #1E4FA3;
    --dark: #121212;
    --surface: #f5f7fa;
}

/* ---- Hero / Article Header ---- */
.article-hero {
    background: linear-gradient(135deg, #0a0a1a 0%, #0d1b3e 50%, #121212 100%);
    padding: 100px 0 50px; position: relative; overflow: hidden;
}
.article-hero::before {
    content: ''; position: absolute; inset: 0;
    background: radial-gradient(ellipse 55% 55% at 80% 50%, rgba(200,163,77,0.06) 0%, transparent 60%);
}
.breadcrumb-nav { margin-bottom: 18px; }
.breadcrumb-nav a { color: rgba(255,255,255,.6); text-decoration: none; font-size: 13px; transition: color .2s; }
.breadcrumb-nav a:hover { color: #C8A34D; }
.breadcrumb-nav span { color: rgba(255,255,255,.4); margin: 0 8px; }
.breadcrumb-nav .current { color: rgba(255,255,255,.85); font-size: 13px; }

.article-cat-badge {
    display: inline-block; background: rgba(200,163,77,.18); color: #C8A34D;
    font-size: 11px; font-weight: 700; padding: 4px 14px; border-radius: 20px;
    letter-spacing: .8px; text-transform: uppercase; margin-bottom: 16px;
}
.article-title {
    font-size: clamp(26px,4vw,48px); font-weight: 900; color: #fff; line-height: 1.25; margin-bottom: 20px;
}
.article-meta {
    display: flex; gap: 20px; flex-wrap: wrap; align-items: center;
}
.article-meta-item {
    display: flex; align-items: center; gap: 7px; font-size: 13px; color: rgba(255,255,255,.65);
}
.article-meta-item i { color: #C8A34D; }
.article-meta-item strong { color: rgba(255,255,255,.9); }

/* ---- Cover Image ---- */
.article-cover {
    width: 100%; max-height: 520px; object-fit: cover; border-radius: 0;
}

/* ---- Main Layout ---- */
.article-main-section { background: #fff; }
.article-content-col { padding: 52px 0 60px; }
.article-sidebar-col { padding: 52px 0 60px; padding-left: 40px; }
@media(max-width: 992px) { .article-sidebar-col { padding-left: 0; padding-top: 20px; } }

/* ---- Article Body ---- */
.article-body {
    font-size: 16px; line-height: 1.8; color: #333;
}
.article-body h1, .article-body h2, .article-body h3 {
    font-weight: 800; color: #121212; margin-top: 36px; margin-bottom: 14px;
}
.article-body h2 { font-size: 22px; }
.article-body h3 { font-size: 18px; }
.article-body p { margin-bottom: 18px; }
.article-body img { max-width: 100%; border-radius: 10px; margin: 12px 0; }
.article-body blockquote {
    border-left: 4px solid #C8A34D; background: rgba(200,163,77,.07);
    padding: 16px 24px; border-radius: 0 10px 10px 0; margin: 24px 0;
    font-style: italic; color: #555;
}
.article-body ul, .article-body ol { padding-left: 24px; margin-bottom: 18px; }
.article-body li { margin-bottom: 6px; }
.article-body a { color: #1E4FA3; }
.article-body a:hover { color: #C8A34D; }
.article-body table { width: 100%; border-collapse: collapse; margin: 20px 0; }
.article-body th { background: #1E4FA3; color: #fff; padding: 10px 14px; }
.article-body td { padding: 10px 14px; border-bottom: 1px solid #e9ecef; }
.article-body tr:hover td { background: rgba(200,163,77,.05); }

/* ---- Tags ---- */
.tags-section { margin: 32px 0; padding-top: 24px; border-top: 1px solid #e9ecef; }
.tags-label { font-size: 12px; font-weight: 700; color: #6B7280; text-transform: uppercase; letter-spacing: .8px; margin-bottom: 10px; }
.tag-pill {
    display: inline-block; background: #f0f2f5; color: #555; font-size: 12px; font-weight: 600;
    padding: 4px 14px; border-radius: 20px; margin: 3px 4px 3px 0; text-decoration: none; transition: all .2s;
}
.tag-pill:hover { background: #C8A34D; color: #121212; }

/* ---- Share Buttons ---- */
.share-section { margin: 24px 0 36px; padding: 20px; background: #f8f9fa; border-radius: 14px; }
.share-label { font-size: 13px; font-weight: 700; color: #333; margin-bottom: 12px; }
.share-buttons { display: flex; gap: 10px; flex-wrap: wrap; }
.share-btn {
    display: inline-flex; align-items: center; gap: 7px; padding: 9px 18px;
    border-radius: 10px; font-size: 13px; font-weight: 700; text-decoration: none; border: none; cursor: pointer;
    transition: all .2s;
}
.share-wa  { background: #25d366; color: #fff; }
.share-wa:hover  { background: #20b858; color: #fff; transform: translateY(-1px); }
.share-fb  { background: #1877f2; color: #fff; }
.share-fb:hover  { background: #166ae1; color: #fff; transform: translateY(-1px); }
.share-tw  { background: #1da1f2; color: #fff; }
.share-tw:hover  { background: #17a0e8; color: #fff; transform: translateY(-1px); }
.share-copy { background: #f0f2f5; color: #333; }
.share-copy:hover { background: #e0e2e5; color: #121212; transform: translateY(-1px); }

/* ---- Author Box ---- */
.author-box {
    background: linear-gradient(135deg, #f8f9fa, #fff);
    border: 1px solid #e9ecef; border-radius: 16px; padding: 24px;
    display: flex; gap: 20px; align-items: flex-start; margin: 36px 0;
}
.author-avatar {
    width: 72px; height: 72px; border-radius: 50%; object-fit: cover;
    border: 3px solid #C8A34D; flex-shrink: 0;
}
.author-avatar-fallback {
    width: 72px; height: 72px; border-radius: 50%;
    background: rgba(200,163,77,.15); border: 3px solid #C8A34D;
    display: flex; align-items: center; justify-content: center;
    color: #C8A34D; font-size: 28px; flex-shrink: 0;
}
.author-info-label { font-size: 11px; font-weight: 700; color: #C8A34D; text-transform: uppercase; letter-spacing: .8px; margin-bottom: 3px; }
.author-name { font-size: 17px; font-weight: 800; color: #121212; margin-bottom: 4px; }
.author-title { font-size: 13px; color: #6B7280; margin-bottom: 8px; }
.author-bio { font-size: 13px; color: #555; line-height: 1.6; }

/* ---- Related Articles ---- */
.related-section { background: var(--surface); padding: 56px 0 72px; }
.related-section-title { font-size: 24px; font-weight: 900; color: #212529; margin-bottom: 4px; }
.related-line { width: 44px; height: 4px; background: #C8A34D; border-radius: 4px; margin: 10px 0 28px; }
.related-card {
    background: #fff; border-radius: 14px; overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,.07); transition: all .3s;
}
.related-card:hover { transform: translateY(-5px); box-shadow: 0 10px 28px rgba(0,0,0,.12); }
.related-card-img { height: 170px; overflow: hidden; }
.related-card-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
.related-card:hover .related-card-img img { transform: scale(1.05); }
.related-card-img .no-img {
    width: 100%; height: 100%; background: linear-gradient(135deg, #1E4FA3, #0d3280);
    display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,.25); font-size: 40px;
}
.related-card-body { padding: 18px; }
.related-date { font-size: 11px; color: #adb5bd; margin-bottom: 6px; }
.related-title { font-size: 14px; font-weight: 700; color: #212529; line-height: 1.4;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.related-title a { color: inherit; text-decoration: none; }
.related-title a:hover { color: #1E4FA3; }

/* ---- Sidebar ---- */
.sidebar-widget { background: #fff; border-radius: 14px; padding: 22px; box-shadow: 0 2px 10px rgba(0,0,0,.06); margin-bottom: 24px; }
.widget-title { font-size: 14px; font-weight: 800; color: #212529; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 2px solid rgba(200,163,77,.3); }
.sidebar-news-item { display: flex; gap: 12px; padding: 12px 0; border-bottom: 1px solid #f0f0f0; }
.sidebar-news-item:last-child { border-bottom: none; padding-bottom: 0; }
.sidebar-news-thumb { width: 60px; height: 60px; border-radius: 8px; object-fit: cover; flex-shrink: 0; }
.sidebar-news-title { font-size: 13px; font-weight: 700; color: #212529; line-height: 1.4; margin-bottom: 4px;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.sidebar-news-title a { color: inherit; text-decoration: none; }
.sidebar-news-title a:hover { color: #C8A34D; }
.sidebar-news-date { font-size: 11px; color: #adb5bd; }

/* ---- WA CTA ---- */
.wa-cta-box {
    background: linear-gradient(135deg, #1E4FA3, #0d3280);
    border-radius: 16px; padding: 24px; color: #fff; text-align: center; margin-bottom: 24px;
}
.wa-cta-box h6 { font-weight: 800; font-size: 16px; margin-bottom: 8px; }
.wa-cta-box p { font-size: 13px; color: rgba(255,255,255,.75); margin-bottom: 18px; }
.wa-cta-btn {
    background: #25d366; color: #fff; border: none; border-radius: 10px;
    padding: 12px 24px; font-weight: 700; font-size: 14px; cursor: pointer;
    width: 100%; text-decoration: none; display: block; transition: background .2s;
}
.wa-cta-btn:hover { background: #20b858; color: #fff; }
</style>

<?php
$news = $news ?? [];
$relatedNews = $relatedNews ?? [];
$profile = $profile ?? [];

$articleUrl = urlencode(current_url());
$articleTitle = urlencode($news['title'] ?? '');
$waShareText = urlencode('Baca artikel menarik dari BKC: ' . ($news['title'] ?? '') . ' - ' . current_url());
?>

<!-- ARTICLE HERO -->
<section class="article-hero">
    <div class="container position-relative">
        <!-- Breadcrumb -->
        <div class="breadcrumb-nav">
            <a href="<?= base_url() ?>">Beranda</a>
            <span>/</span>
            <a href="<?= base_url('berita') ?>">Berita</a>
            <span>/</span>
            <span class="current"><?= esc(mb_substr($news['title'] ?? '', 0, 50)) ?><?= mb_strlen($news['title'] ?? '') > 50 ? '...' : '' ?></span>
        </div>

        <?php if(!empty($news['category_name'])): ?>
        <span class="article-cat-badge"><?= esc($news['category_name']) ?></span>
        <?php endif; ?>

        <h1 class="article-title" data-aos="fade-up"><?= esc($news['title'] ?? '') ?></h1>

        <div class="article-meta" data-aos="fade-up" data-aos-delay="80">
            <div class="article-meta-item">
                <i class="fas fa-calendar"></i>
                <span><?= !empty($news['published_at']) ? date('d F Y', strtotime($news['published_at'])) : date('d F Y', strtotime($news['created_at'] ?? 'now')) ?></span>
            </div>
            <?php if(!empty($news['author_name'])): ?>
            <div class="article-meta-item">
                <i class="fas fa-user-edit"></i>
                <span>Oleh <strong><?= esc($news['author_name']) ?></strong></span>
            </div>
            <?php endif; ?>
            <?php if(!empty($news['views'])): ?>
            <div class="article-meta-item">
                <i class="fas fa-eye"></i>
                <span><?= number_format((int)$news['views']) ?> kali dilihat</span>
            </div>
            <?php endif; ?>
            <?php if(!empty($news['read_time'])): ?>
            <div class="article-meta-item">
                <i class="fas fa-clock"></i>
                <span><?= (int)$news['read_time'] ?> menit baca</span>
            </div>
            <?php else: ?>
            <div class="article-meta-item">
                <i class="fas fa-clock"></i>
                <span><?= max(1, (int)(str_word_count(strip_tags($news['content'] ?? '')) / 200)) ?> menit baca</span>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- COVER IMAGE -->
<?php if(!empty($news['thumbnail'])): ?>
<div style="background:#121212; text-align:center;">
    <img src="<?= base_url('assets/uploads/news/' . esc($news['thumbnail'])) ?>"
         alt="<?= esc($news['title']) ?>"
         class="article-cover"
         onerror="this.style.display='none'">
</div>
<?php endif; ?>

<!-- MAIN ARTICLE SECTION -->
<section class="article-main-section">
    <div class="container">
        <div class="row">

            <!-- ARTICLE CONTENT -->
            <div class="col-lg-8 article-content-col">

                <!-- Article Body -->
                <div class="article-body" data-aos="fade-up">
                    <?= $news['content'] ?? '<p>Konten artikel tidak tersedia.</p>' ?>
                </div>

                <!-- Tags -->
                <?php if(!empty($news['tags'])): ?>
                <div class="tags-section" data-aos="fade-up">
                    <div class="tags-label"><i class="fas fa-tags me-1"></i>Tag</div>
                    <?php foreach(array_filter(array_map('trim', explode(',', $news['tags']))) as $tag): ?>
                    <a href="<?= base_url('berita?tag=' . urlencode($tag)) ?>" class="tag-pill"><?= esc($tag) ?></a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Share Buttons -->
                <div class="share-section" data-aos="fade-up">
                    <div class="share-label"><i class="fas fa-share-alt me-2"></i>Bagikan Artikel Ini:</div>
                    <div class="share-buttons">
                        <a href="https://wa.me/?text=<?= $waShareText ?>" target="_blank" rel="noopener" class="share-btn share-wa">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $articleUrl ?>" target="_blank" rel="noopener" class="share-btn share-fb">
                            <i class="fab fa-facebook"></i> Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?text=<?= $articleTitle ?>&url=<?= $articleUrl ?>" target="_blank" rel="noopener" class="share-btn share-tw">
                            <i class="fab fa-twitter"></i> Twitter
                        </a>
                        <button class="share-btn share-copy" onclick="copyUrl()" id="copyBtn">
                            <i class="fas fa-link"></i> Salin Link
                        </button>
                    </div>
                </div>

                <!-- Author Box (if founder article) -->
                <?php if(!empty($news['author_name']) || !empty($profile['founder_name'])): ?>
                <div class="author-box" data-aos="fade-up">
                    <?php
                    $authorPhoto = $news['author_photo'] ?? $profile['founder_photo'] ?? '';
                    $authorName  = $news['author_name'] ?? $profile['founder_name'] ?? 'Tim BKC';
                    $authorTitle = $news['author_title'] ?? $profile['founder_title'] ?? 'CV. Bagus Kencana Cakrada';
                    $authorBio   = $news['author_bio'] ?? $profile['founder_bio'] ?? '';
                    ?>
                    <?php if($authorPhoto): ?>
                    <img src="<?= base_url('assets/uploads/' . esc($authorPhoto)) ?>"
                         alt="<?= esc($authorName) ?>" class="author-avatar"
                         onerror="this.outerHTML='<div class=\'author-avatar-fallback\'><i class=\'fas fa-user-tie\'></i></div>'">
                    <?php else: ?>
                    <div class="author-avatar-fallback"><i class="fas fa-user-tie"></i></div>
                    <?php endif; ?>
                    <div>
                        <div class="author-info-label"><i class="fas fa-pen me-1"></i>Penulis</div>
                        <div class="author-name"><?= esc($authorName) ?></div>
                        <div class="author-title"><?= esc($authorTitle) ?></div>
                        <?php if($authorBio): ?>
                        <div class="author-bio"><?= esc(mb_substr($authorBio, 0, 200)) ?>...</div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- WA Question CTA -->
                <div style="background:linear-gradient(135deg,#f8f9fa,#eef1f8); border:1px solid #e9ecef; border-radius:16px; padding:28px; text-align:center;" data-aos="fade-up">
                    <i class="fas fa-question-circle" style="font-size:32px; color:#C8A34D; margin-bottom:12px; display:block;"></i>
                    <h5 style="font-weight:800; color:#121212; margin-bottom:8px;">Punya pertanyaan tentang artikel ini?</h5>
                    <p style="font-size:14px; color:#6B7280; margin-bottom:20px;">Tim kami siap membantu menjawab pertanyaan Anda seputar pelatihan dan pengembangan SDM.</p>
                    <a href="https://wa.me/6281803867430?text=<?= urlencode('Halo Admin BKC, saya ingin bertanya mengenai artikel: ' . ($news['title'] ?? '') . '. ') ?>"
                       target="_blank" rel="noopener"
                       style="background:#25d366; color:#fff; font-weight:700; padding:13px 28px; border-radius:12px; text-decoration:none; font-size:15px; display:inline-flex; align-items:center; gap:10px; transition:background .2s;">
                        <i class="fab fa-whatsapp fa-lg"></i>
                        Hubungi via WhatsApp
                    </a>
                </div>

            </div>

            <!-- SIDEBAR -->
            <div class="col-lg-4 article-sidebar-col">

                <!-- WA CTA Widget -->
                <div class="wa-cta-box">
                    <i class="fas fa-graduation-cap" style="font-size:32px; color:#C8A34D; margin-bottom:12px;"></i>
                    <h6>Ikuti Pelatihan Kami</h6>
                    <p>Konsultasikan kebutuhan pelatihan instansi Anda bersama tim BKC.</p>
                    <a href="https://wa.me/6281803867430?text=<?= urlencode('Halo Admin BKC, saya ingin informasi pelatihan. Terima kasih.') ?>"
                       target="_blank" rel="noopener" class="wa-cta-btn">
                        <i class="fab fa-whatsapp me-2"></i>Chat Sekarang
                    </a>
                </div>


                <!-- Categories Widget -->
                <?php if(!empty($categories ?? [])): ?>
                <div class="sidebar-widget">
                    <div class="widget-title"><i class="fas fa-folder me-2" style="color:#C8A34D;"></i>Kategori</div>
                    <?php foreach(($categories ?? []) as $cat): ?>
                    <a href="<?= base_url('berita?category=' . esc($cat['slug'] ?? $cat['id'])) ?>"
                       style="display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid #f0f0f0; text-decoration:none; color:#333; font-size:13px; font-weight:600; transition:color .2s;">
                        <span><i class="fas fa-chevron-right me-1" style="color:#C8A34D; font-size:10px;"></i><?= esc($cat['name']) ?></span>
                        <?php if(!empty($cat['news_count'])): ?>
                        <span style="background:#f0f2f5; border-radius:20px; padding:2px 10px; font-size:11px; color:#6B7280;"><?= $cat['news_count'] ?></span>
                        <?php endif; ?>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

            </div><!-- /sidebar -->

        </div>
    </div>
</section>

<!-- RELATED ARTICLES GRID (below) -->
<?php if(!empty($relatedNews)): ?>
<section class="related-section">
    <div class="container">
        <div data-aos="fade-up">
            <h3 class="related-section-title">Artikel Terkait</h3>
            <div class="related-line"></div>
        </div>
        <div class="row g-4">
            <?php foreach(array_slice($relatedNews, 0, 3) as $i => $rn): ?>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?= $i * 80 ?>">
                <div class="related-card">
                    <div class="related-card-img">
                        <?php if(!empty($rn['thumbnail'])): ?>
                            <img src="<?= base_url('assets/uploads/news/' . esc($rn['thumbnail'])) ?>"
                                 alt="<?= esc($rn['title']) ?>" loading="lazy"
                                 onerror="this.parentElement.innerHTML='<div class=\'no-img\'><i class=\'fas fa-newspaper\'></i></div>'">
                        <?php else: ?>
                            <div class="no-img"><i class="fas fa-newspaper"></i></div>
                        <?php endif; ?>
                    </div>
                    <div class="related-card-body">
                        <div class="related-date">
                            <i class="fas fa-calendar me-1"></i>
                            <?= !empty($rn['published_at']) ? date('d M Y', strtotime($rn['published_at'])) : date('d M Y', strtotime($rn['created_at'] ?? 'now')) ?>
                        </div>
                        <div class="related-title">
                            <a href="<?= base_url('berita/' . esc($rn['slug'])) ?>"><?= esc($rn['title']) ?></a>
                        </div>
                        <a href="<?= base_url('berita/' . esc($rn['slug'])) ?>"
                           style="display:inline-flex; align-items:center; gap:5px; color:#C8A34D; font-size:13px; font-weight:700; text-decoration:none; margin-top:10px;">
                            Baca <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-5">
            <a href="<?= base_url('berita') ?>"
               style="background:#C8A34D; color:#121212; font-weight:800; padding:14px 32px; border-radius:12px; text-decoration:none; font-size:15px; display:inline-flex; align-items:center; gap:8px;">
                <i class="fas fa-newspaper"></i> Lihat Semua Artikel
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<script>
function copyUrl() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        const btn = document.getElementById('copyBtn');
        btn.innerHTML = '<i class="fas fa-check"></i> Tersalin!';
        btn.style.background = '#198754';
        btn.style.color = '#fff';
        setTimeout(function() {
            btn.innerHTML = '<i class="fas fa-link"></i> Salin Link';
            btn.style.background = '';
            btn.style.color = '';
        }, 2500);
    }).catch(function() {
        // Fallback
        const textArea = document.createElement('textarea');
        textArea.value = window.location.href;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Link disalin!', timer: 2000, showConfirmButton: false });
    });
}
</script>

<?= $this->endSection() ?>
