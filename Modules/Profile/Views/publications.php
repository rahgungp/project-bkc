<?= $this->extend('Modules\Website\Views\layout\main') ?>
<?= $this->section('content') ?>

<style>
/* ===== PUBLICATIONS PAGE ===== */
.pub-hero {
    background: linear-gradient(135deg,#1E4FA3 0%,#152f6b 60%,#0d1f45 100%);
    padding: 100px 0 70px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.pub-hero::before {
    content:'';
    position:absolute; inset:0;
    background-image: radial-gradient(circle at 30% 70%, rgba(200,163,77,0.1) 0%, transparent 50%);
}
.pub-hero-badge {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(200,163,77,0.15); border: 1px solid rgba(200,163,77,0.4);
    color: #C8A34D; padding: 6px 20px; border-radius: 50px;
    font-size: 12px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase;
    margin-bottom: 22px;
}
.pub-hero h1 { font-size: clamp(2rem, 5vw, 3.4rem); font-weight: 800; color: #fff; margin-bottom: 14px; }
.pub-hero-sub { font-size: 16px; color: rgba(255,255,255,0.7); max-width: 500px; margin: 0 auto; }

/* Filter tabs */
.pub-filter-bar {
    background: #fff;
    border-bottom: 1px solid rgba(0,0,0,0.07);
    padding: 18px 0;
    position: sticky;
    top: 0;
    z-index: 50;
    box-shadow: 0 2px 12px rgba(0,0,0,0.05);
}
.filter-tabs { display: flex; gap: 10px; flex-wrap: wrap; }
.filter-tab {
    padding: 8px 20px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    border: 1.5px solid transparent;
    background: #f5f7fa;
    color: #555;
    transition: all 0.25s;
}
.filter-tab:hover { background: rgba(200,163,77,0.1); border-color: rgba(200,163,77,0.4); color: #C8A34D; }
.filter-tab.active { background: #1E4FA3; color: #fff; border-color: #1E4FA3; }
.filter-tab .tab-count {
    display: inline-block; background: rgba(255,255,255,0.2);
    border-radius: 20px; padding: 1px 7px; font-size: 11px; margin-left: 4px;
}
.filter-tab:not(.active) .tab-count { background: rgba(0,0,0,0.08); }

/* Grid */
.pub-grid-section { padding: 60px 0; background: #f5f7fa; min-height: 400px; }

.pub-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid rgba(0,0,0,0.06);
    height: 100%;
    transition: all 0.3s;
    display: flex; flex-direction: column;
}
.pub-card:hover { box-shadow: 0 8px 32px rgba(0,0,0,0.1); transform: translateY(-4px); }

.pub-card-cover {
    height: 160px;
    background: linear-gradient(135deg,#1E4FA3,#2d6abf);
    display: flex; align-items: center; justify-content: center;
    font-size: 50px; color: rgba(255,255,255,0.2);
    position: relative;
    overflow: hidden;
}
.pub-card-cover img {
    width: 100%; height: 100%; object-fit: cover;
    position: absolute; inset: 0;
}
.pub-card-cover-icon { position: relative; z-index: 1; }

/* Cover colors by type */
.cover-jurnal { background: linear-gradient(135deg,#1E4FA3,#2d6abf); }
.cover-buku { background: linear-gradient(135deg,#b38b30,#C8A34D); }
.cover-artikel { background: linear-gradient(135deg,#198754,#2dba76); }
.cover-prosiding { background: linear-gradient(135deg,#6f42c1,#9b66e8); }

.pub-card-body { padding: 20px 22px; flex: 1; display: flex; flex-direction: column; }
.pub-type-badge {
    display: inline-block;
    font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;
    padding: 3px 10px; border-radius: 4px; margin-bottom: 10px;
}
.badge-jurnal { background: rgba(30,79,163,0.1); color: #1E4FA3; }
.badge-buku { background: rgba(200,163,77,0.15); color: #b38b30; }
.badge-artikel { background: rgba(25,135,84,0.1); color: #198754; }
.badge-prosiding { background: rgba(111,66,193,0.1); color: #6f42c1; }

.pub-title {
    font-size: 14.5px; font-weight: 700; color: #1a1a2e;
    line-height: 1.45; margin-bottom: 8px;
    flex: 1;
}
.pub-meta { font-size: 12px; color: #888; display: flex; align-items: center; gap: 6px; margin-bottom: 14px; }
.pub-meta-dot { width: 4px; height: 4px; border-radius: 50%; background: #ccc; }
.pub-abstract { font-size: 12.5px; color: #666; line-height: 1.6; margin-bottom: 14px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
.pub-scopus-badge { font-size: 10px; font-weight: 700; background: rgba(255,107,107,0.1); color: #e53e3e; padding: 2px 8px; border-radius: 4px; margin-bottom: 12px; display: inline-block; }
.btn-pub-detail {
    display: inline-flex; align-items: center; gap: 6px;
    background: linear-gradient(135deg,#C8A34D,#e8c46d);
    color: #121212; font-weight: 700; border: none; border-radius: 50px;
    padding: 9px 20px; font-size: 13px; text-decoration: none;
    transition: all 0.25s; width: 100%; justify-content: center; margin-top: auto;
}
.btn-pub-detail:hover { box-shadow: 0 4px 14px rgba(200,163,77,0.4); color: #121212; }

/* Empty state */
.pub-empty {
    text-align: center; padding: 80px 20px; color: #aaa;
}
.pub-empty i { font-size: 50px; display: block; margin-bottom: 16px; color: #ddd; }

/* Stats bar */
.pub-stats-bar {
    background: #fff;
    border-bottom: 1px solid rgba(0,0,0,0.06);
    padding: 14px 0;
}
.pub-stat-item { text-align: center; padding: 0 20px; }
.pub-stat-num { font-size: 1.5rem; font-weight: 800; color: #1E4FA3; }
.pub-stat-label { font-size: 11px; color: #888; text-transform: uppercase; letter-spacing: 0.5px; }

@media (max-width: 768px) {
    .filter-tabs { gap: 6px; }
    .filter-tab { padding: 6px 14px; font-size: 12px; }
    .pub-grid-section { padding: 40px 0; }
}
</style>

<!-- ===== HERO ===== -->
<section class="pub-hero">
    <div class="container position-relative">
        <div data-aos="fade-up">
            <div class="pub-hero-badge"><i class="fas fa-book"></i> Karya Tulis Ilmiah</div>
            <h1>Publikasi</h1>
            <p class="pub-hero-sub">Jurnal ilmiah, buku, artikel, dan prosiding<?= !empty($founder) ? ' karya <strong style="color:#C8A34D;">' . esc($founder['name']) . '</strong>' : '' ?>.</p>
            <nav aria-label="breadcrumb" class="mt-4">
                <ol class="breadcrumb justify-content-center" style="background:none; font-size:13px;">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>" style="color:rgba(255,255,255,0.6);">Beranda</a></li>
                    <li class="breadcrumb-item active" style="color:rgba(255,255,255,0.9);">Publikasi</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<?php
// Count by type
$allPubs    = $publications;
$typeCounts = array_count_values(array_map('strtolower', array_column($publications, 'type')));
$types = [
    'all'      => ['label' => 'Semua', 'count' => count($allPubs)],
    'jurnal'   => ['label' => 'Jurnal', 'count' => $typeCounts['jurnal'] ?? 0],
    'buku'     => ['label' => 'Buku', 'count' => $typeCounts['buku'] ?? 0],
    'artikel'  => ['label' => 'Artikel', 'count' => $typeCounts['artikel'] ?? 0],
    'prosiding' => ['label' => 'Prosiding', 'count' => $typeCounts['prosiding'] ?? 0],
];
$scopusCount = count(array_filter($allPubs, fn($p) => !empty($p['is_scopus'])));
?>

<!-- Stats Bar -->
<div class="pub-stats-bar">
    <div class="container">
        <div class="row g-3 justify-content-center">
            <div class="col-6 col-sm-3 col-md-2 pub-stat-item">
                <div class="pub-stat-num"><?= count($allPubs) ?></div>
                <div class="pub-stat-label">Total Karya</div>
            </div>
            <div class="col-6 col-sm-3 col-md-2 pub-stat-item">
                <div class="pub-stat-num" style="color:#e53e3e;"><?= $scopusCount ?></div>
                <div class="pub-stat-label">Terindeks Scopus</div>
            </div>
            <div class="col-6 col-sm-3 col-md-2 pub-stat-item">
                <div class="pub-stat-num" style="color:#198754;"><?= $typeCounts['jurnal'] ?? 0 ?></div>
                <div class="pub-stat-label">Jurnal</div>
            </div>
            <div class="col-6 col-sm-3 col-md-2 pub-stat-item">
                <div class="pub-stat-num" style="color:#C8A34D;"><?= $typeCounts['buku'] ?? 0 ?></div>
                <div class="pub-stat-label">Buku</div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Tabs -->
<div class="pub-filter-bar">
    <div class="container">
        <div class="filter-tabs">
            <?php foreach ($types as $typeKey => $typeData): ?>
            <?php if ($typeData['count'] > 0 || $typeKey === 'all'): ?>
            <button class="filter-tab <?= $typeKey === 'all' ? 'active' : '' ?>"
                    data-filter="<?= $typeKey ?>">
                <?= $typeData['label'] ?>
                <span class="tab-count"><?= $typeData['count'] ?></span>
            </button>
            <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Grid -->
<section class="pub-grid-section">
    <div class="container">
        <?php if (empty($allPubs)): ?>
        <div class="pub-empty">
            <i class="fas fa-book-open"></i>
            <h5 style="color:#888; font-weight:700;">Belum ada publikasi</h5>
            <p style="font-size:14px;">Publikasi akan ditampilkan di sini.</p>
        </div>
        <?php else: ?>
        <div class="row g-4" id="pubGrid">
            <?php foreach ($allPubs as $pub): ?>
            <?php
                $type     = strtolower($pub['type'] ?? 'artikel');
                $typeLabel = ucfirst($type);
                $typeIcons = [
                    'jurnal'   => 'fa-flask',
                    'buku'     => 'fa-book',
                    'artikel'  => 'fa-newspaper',
                    'prosiding' => 'fa-file-alt',
                ];
                $icon = $typeIcons[$type] ?? 'fa-file-alt';
                $coverClass = 'cover-' . $type;
            ?>
            <div class="col-md-6 col-lg-4 pub-item" data-type="<?= $type ?>">
                <div class="pub-card" data-aos="fade-up">
                    <!-- Cover -->
                    <div class="pub-card-cover <?= $coverClass ?>">
                        <i class="fas <?= $icon ?> pub-card-cover-icon"></i>
                    </div>
                    <!-- Body -->
                    <div class="pub-card-body">
                        <div>
                            <span class="pub-type-badge badge-<?= $type ?>"><?= $typeLabel ?></span>
                            <?php if (!empty($pub['is_scopus'])): ?>
                            <span class="pub-scopus-badge ms-1"><i class="fas fa-certificate me-1"></i>Scopus Indexed</span>
                            <?php endif; ?>
                        </div>
                        <div class="pub-title"><?= esc($pub['title']) ?></div>
                        <div class="pub-meta">
                            <?php if (!empty($pub['journal']) || !empty($pub['publisher'])): ?>
                            <span><?= esc($pub['journal'] ?? $pub['publisher']) ?></span>
                            <?php endif; ?>
                            <?php if (!empty($pub['year'])): ?>
                            <span class="pub-meta-dot"></span>
                            <span><?= esc($pub['year']) ?></span>
                            <?php endif; ?>
                            <?php if (!empty($pub['issn'])): ?>
                            <span class="pub-meta-dot"></span>
                            <span>ISSN: <?= esc($pub['issn']) ?></span>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($pub['abstract'])): ?>
                        <div class="pub-abstract"><?= esc($pub['abstract']) ?></div>
                        <?php endif; ?>

                        <?php if (!empty($pub['url'])): ?>
                        <a href="<?= esc($pub['url']) ?>" target="_blank" rel="noopener" class="btn-pub-detail">
                            <i class="fas fa-external-link-alt"></i> Lihat Selengkapnya
                        </a>
                        <?php elseif (!empty($pub['doi'])): ?>
                        <a href="https://doi.org/<?= esc($pub['doi']) ?>" target="_blank" rel="noopener" class="btn-pub-detail">
                            <i class="fas fa-link"></i> DOI: <?= esc($pub['doi']) ?>
                        </a>
                        <?php else: ?>
                        <span class="btn-pub-detail" style="background:#e2e8f0; color:#888; cursor:default;">
                            <i class="fas fa-lock"></i> Tidak Tersedia Online
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- No results -->
        <div id="noResults" class="pub-empty" style="display:none;">
            <i class="fas fa-search"></i>
            <h5 style="color:#888; font-weight:700;">Tidak ada publikasi ditemukan</h5>
            <p>Pilih kategori lain atau tampilkan semua.</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- CTA -->
<section style="padding:70px 0; background:#fff;">
    <div class="container text-center" data-aos="fade-up">
        <div class="section-label" style="display:block; text-align:center; margin-bottom:8px;">Ingin Berkolaborasi?</div>
        <h2 style="font-size:1.8rem; font-weight:800; color:#1a1a2e; margin-bottom:14px;">Kontak Penulis</h2>
        <p style="color:#666; font-size:15px; max-width:440px; margin:0 auto 28px;">Hubungi kami untuk informasi lebih lanjut tentang penelitian dan publikasi.</p>
        <a href="<?= base_url('kontak') ?>" class="btn" style="background:linear-gradient(135deg,#1E4FA3,#2d6abf); color:#fff; font-weight:700; border-radius:50px; padding:13px 32px; font-size:14px; border:none; margin-right:12px;">
            <i class="fas fa-envelope me-2"></i>Hubungi Kami
        </a>
        <a href="<?= base_url('pendiri') ?>" class="btn" style="background:linear-gradient(135deg,#C8A34D,#e8c46d); color:#121212; font-weight:700; border-radius:50px; padding:13px 32px; font-size:14px; border:none;">
            <i class="fas fa-user-tie me-2"></i>Profil Pendiri
        </a>
    </div>
</section>

<script>
(function () {
    const tabs  = document.querySelectorAll('.filter-tab');
    const items = document.querySelectorAll('.pub-item');
    const noRes = document.getElementById('noResults');

    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            const filter = this.getAttribute('data-filter');
            let visible  = 0;

            items.forEach(item => {
                const type = item.getAttribute('data-type');
                const show = filter === 'all' || type === filter;
                item.style.display = show ? '' : 'none';
                if (show) visible++;
            });

            if (noRes) noRes.style.display = visible === 0 ? 'block' : 'none';
        });
    });
})();
</script>

<?= $this->endSection() ?>
