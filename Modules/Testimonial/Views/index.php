<?= $this->extend('Modules\Website\Views\layout\main') ?>

<?= $this->section('meta') ?>
<title><?= esc($title) ?> | <?= esc($profile['company_name'] ?? 'BKC') ?></title>
<meta name="description" content="Baca testimoni dan ulasan dari peserta pelatihan <?= esc($profile['company_name'] ?? 'BKC') ?>. Lebih dari <?= esc($profile['total_clients'] ?? '500') ?> peserta telah merasakan manfaatnya.">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<style>
    .testi-hero {
        background: linear-gradient(135deg, #121212 0%, #1a1a2e 100%);
        padding: 120px 0 60px;
        color: white;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .testi-hero::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: radial-gradient(ellipse at 30% 50%, rgba(200,163,77,0.12) 0%, transparent 60%),
                    radial-gradient(ellipse at 70% 50%, rgba(30,79,163,0.12) 0%, transparent 60%);
    }
    .testi-hero h1 { font-size: 2.8rem; font-weight: 800; position: relative; }
    .testi-hero p { opacity: 0.8; position: relative; font-size: 1.05rem; }

    .rating-strip {
        background: linear-gradient(135deg, #C8A34D, #a8842d);
        padding: 28px 0;
        color: white;
    }
    .rating-stat { text-align: center; }
    .rating-stat .number { font-size: 2.4rem; font-weight: 800; line-height: 1; }
    .rating-stat .label { font-size: 0.85rem; opacity: 0.85; margin-top: 4px; }
    .rating-stat .stars { color: #fff; font-size: 1.1rem; letter-spacing: 2px; }

    .testi-grid { padding: 80px 0; background: #f8fafc; }
    .testi-card {
        background: white;
        border-radius: 16px;
        padding: 28px;
        margin-bottom: 24px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        transition: all 0.3s;
        height: 100%;
        position: relative;
    }
    .testi-card:hover {
        box-shadow: 0 8px 32px rgba(30,79,163,0.12);
        transform: translateY(-4px);
    }
    .testi-card.featured {
        border: 2px solid #C8A34D;
    }
    .testi-card.featured::before {
        content: '⭐ Unggulan';
        position: absolute;
        top: -12px;
        left: 20px;
        background: #C8A34D;
        color: white;
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
    }
    .testi-quote {
        color: #C8A34D;
        font-size: 2.5rem;
        line-height: 0.8;
        font-family: Georgia, serif;
        margin-bottom: 8px;
    }
    .testi-text {
        color: #4a5568;
        line-height: 1.8;
        font-size: 0.95rem;
        margin-bottom: 20px;
        font-style: italic;
    }
    .testi-stars { color: #C8A34D; font-size: 0.9rem; margin-bottom: 12px; }
    .testi-footer { display: flex; align-items: center; gap: 12px; border-top: 1px solid #f1f5f9; padding-top: 16px; }
    .testi-avatar {
        width: 50px; height: 50px; border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e2e8f0;
        flex-shrink: 0;
    }
    .testi-avatar-placeholder {
        width: 50px; height: 50px; border-radius: 50%;
        background: linear-gradient(135deg, #1E4FA3, #C8A34D);
        display: flex; align-items: center; justify-content: center;
        color: white; font-weight: 700; font-size: 1.1rem;
        flex-shrink: 0;
    }
    .testi-name { font-weight: 700; color: #1a202c; font-size: 0.95rem; }
    .testi-meta { color: #64748b; font-size: 0.82rem; }
    .testi-training { color: #1E4FA3; font-size: 0.8rem; font-weight: 600; margin-top: 2px; }

    .rating-filter { display: flex; gap: 8px; flex-wrap: wrap; }
    .filter-btn {
        padding: 6px 16px;
        border-radius: 50px;
        border: 2px solid #e2e8f0;
        background: white;
        color: #64748b;
        cursor: pointer;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.2s;
    }
    .filter-btn.active, .filter-btn:hover {
        border-color: #C8A34D;
        background: #C8A34D;
        color: white;
    }

    .cta-section {
        background: linear-gradient(135deg, #1E4FA3 0%, #0d2d6b 100%);
        padding: 80px 0;
        color: white;
        text-align: center;
    }
    .cta-section h2 { font-size: 2rem; font-weight: 800; margin-bottom: 12px; }
    .cta-section p { opacity: 0.85; margin-bottom: 32px; font-size: 1.05rem; }
</style>

<!-- Hero -->
<section class="testi-hero">
    <div class="container">
        <div data-aos="fade-up">
            <span style="background:rgba(200,163,77,0.2);color:#C8A34D;padding:6px 18px;border-radius:50px;font-size:0.85rem;font-weight:600;letter-spacing:1px;">TESTIMONI PESERTA</span>
            <h1 class="mt-3">Apa Kata Mereka<br>Tentang <span style="color:#C8A34D">Program Kami?</span></h1>
            <p>Para peserta telah membuktikan kualitas pelatihan <?= esc($profile['company_name'] ?? 'BKC') ?></p>
        </div>
    </div>
</section>

<!-- Rating Strip -->
<section class="rating-strip">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-auto">
                <div class="rating-stat">
                    <div class="number"><?= $ratings['total'] ?>+</div>
                    <div class="stars">★★★★★</div>
                    <div class="label">Total Testimoni</div>
                </div>
            </div>
            <div class="col-auto" style="border-left:1px solid rgba(255,255,255,0.3);padding-left:32px;">
                <div class="rating-stat">
                    <div class="number"><?= number_format($ratings['average'], 1) ?></div>
                    <div class="stars">★★★★★</div>
                    <div class="label">Rating Rata-rata</div>
                </div>
            </div>
            <div class="col-auto" style="border-left:1px solid rgba(255,255,255,0.3);padding-left:32px;">
                <div class="rating-stat">
                    <div class="number"><?= esc($profile['total_clients'] ?? '500') ?>+</div>
                    <div class="stars" style="visibility:hidden;">★★★★★</div>
                    <div class="label">Total Peserta</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Grid -->
<section class="testi-grid">
    <div class="container">
        <!-- Filter -->
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4" data-aos="fade-up">
            <h2 style="font-size:1.4rem;font-weight:700;color:#1a202c;margin:0;">Semua Ulasan</h2>
            <div class="rating-filter">
                <button class="filter-btn active" data-rating="all">Semua</button>
                <?php for ($r = 5; $r >= 1; $r--): ?>
                <button class="filter-btn" data-rating="<?= $r ?>"><?= $r ?> ★</button>
                <?php endfor; ?>
            </div>
        </div>

        <?php if (empty($testimonials)): ?>
        <div class="text-center py-5">
            <i class="fas fa-comment-slash fa-4x" style="color:#cbd5e1;"></i>
            <p class="mt-3 text-muted">Belum ada testimoni tersedia.</p>
        </div>
        <?php else: ?>
        <div class="row g-4" id="testiGrid">
            <?php foreach ($testimonials as $i => $testi): ?>
            <div class="col-md-6 col-lg-4 testi-col" data-rating="<?= (int)$testi['rating'] ?>" data-aos="fade-up" data-aos-delay="<?= ($i % 3) * 80 ?>">
                <div class="testi-card <?= $testi['is_featured'] ? 'featured' : '' ?>">
                    <div class="testi-quote">"</div>
                    <div class="testi-stars">
                        <?php for ($s = 1; $s <= 5; $s++): ?>
                            <i class="fas fa-star<?= $s > $testi['rating'] ? '' : '' ?>" style="color:<?= $s <= $testi['rating'] ? '#C8A34D' : '#e2e8f0' ?>;"></i>
                        <?php endfor; ?>
                        <span style="color:#64748b;font-size:0.8rem;margin-left:4px;">(<?= (int)$testi['rating'] ?>/5)</span>
                    </div>
                    <p class="testi-text"><?= esc($testi['comment']) ?></p>
                    <div class="testi-footer">
                        <?php if (!empty($testi['photo'])): ?>
                        <img src="<?= base_url('uploads/testimonials/' . $testi['photo']) ?>" class="testi-avatar" alt="<?= esc($testi['name']) ?>">
                        <?php else: ?>
                        <div class="testi-avatar-placeholder"><?= mb_strtoupper(mb_substr($testi['name'], 0, 1)) ?></div>
                        <?php endif; ?>
                        <div>
                            <div class="testi-name"><?= esc($testi['name']) ?></div>
                            <?php if (!empty($testi['position']) || !empty($testi['company'])): ?>
                            <div class="testi-meta">
                                <?= esc(implode(' · ', array_filter([$testi['position'] ?? '', $testi['company'] ?? '']))) ?>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($testi['training_title'])): ?>
                            <div class="testi-training"><i class="fas fa-graduation-cap me-1"></i><?= esc($testi['training_title']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div id="noTestiResult" class="text-center py-5" style="display:none;">
            <i class="fas fa-filter fa-3x" style="color:#cbd5e1;"></i>
            <p class="mt-3 text-muted">Tidak ada testimoni untuk rating ini.</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="container" data-aos="fade-up">
        <h2>Siap Mengembangkan Kompetensi SDM Anda?</h2>
        <p>Konsultasikan kebutuhan pelatihan instansi Anda dengan tim BKC secara gratis.</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="<?= site_url('pelatihan') ?>" class="btn btn-light btn-lg fw-bold px-4 py-3" style="border-radius:50px;">
                <i class="fas fa-graduation-cap me-2"></i>Lihat Program Pelatihan
            </a>
            <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $profile['whatsapp'] ?? '6281803867430') ?>"
               class="btn btn-success btn-lg fw-bold px-4 py-3" style="border-radius:50px;" target="_blank" rel="noopener">
                <i class="fab fa-whatsapp me-2"></i>Tanya via WhatsApp
            </a>
        </div>
    </div>
</section>

<script>
(function() {
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const rating = this.dataset.rating;
            let found = 0;
            document.querySelectorAll('.testi-col').forEach(col => {
                if (rating === 'all' || col.dataset.rating === rating) {
                    col.style.display = '';
                    found++;
                } else {
                    col.style.display = 'none';
                }
            });
            document.getElementById('noTestiResult').style.display = found === 0 ? '' : 'none';
        });
    });
})();
</script>

<?= $this->endSection() ?>
