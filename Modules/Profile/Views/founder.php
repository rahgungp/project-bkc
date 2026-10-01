<?= $this->extend('Modules\Website\Views\layout\main') ?>
<?= $this->section('content') ?>

<style>
/* ===== FOUNDER PAGE ===== */
.founder-hero {
    background: linear-gradient(135deg,#1E4FA3 0%,#152f6b 60%,#0d1f45 100%);
    padding: 100px 0 60px;
    position: relative;
    overflow: hidden;
}
.founder-hero::before {
    content:'';
    position:absolute; inset:0;
    background-image: radial-gradient(circle at 80% 30%, rgba(200,163,77,0.12) 0%, transparent 50%);
}
.founder-hero-photo {
    width: 180px; height: 180px;
    border-radius: 50%;
    object-fit: cover;
    border: 5px solid #C8A34D;
    box-shadow: 0 16px 50px rgba(0,0,0,0.4);
}
.founder-hero-placeholder {
    width: 180px; height: 180px;
    border-radius: 50%;
    background: rgba(200,163,77,0.15);
    border: 5px solid #C8A34D;
    display: flex; align-items: center; justify-content: center;
    font-size: 60px; color: #C8A34D;
    box-shadow: 0 16px 50px rgba(0,0,0,0.3);
}
.founder-hero-name { font-size: clamp(1.6rem, 4vw, 2.4rem); font-weight: 800; color: #fff; margin: 20px 0 6px; }
.founder-hero-title { font-size: 14px; color: #C8A34D; font-weight: 700; letter-spacing: 0.5px; }
.founder-hero-headline { font-size: 14px; color: rgba(255,255,255,0.7); max-width: 500px; margin: 12px auto 0; }
.founder-hero-links { display: flex; justify-content: center; gap: 12px; margin-top: 24px; }
.fhl {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);
    color: #fff; padding: 7px 18px; border-radius: 50px; font-size: 13px;
    text-decoration: none; transition: all 0.3s;
}
.fhl:hover { background: #C8A34D; border-color: #C8A34D; color: #121212; }

/* ===== Content area ===== */
.founder-content { padding: 80px 0; background: #f5f7fa; }

.section-title-sm { font-size: 1.2rem; font-weight: 800; color: #1a1a2e; margin-bottom: 4px; }
.gold-bar { width: 40px; height: 3px; background: linear-gradient(to right,#C8A34D,#e8c46d); border-radius: 2px; margin-bottom: 24px; }

.founder-bio-card {
    background: #fff;
    border-radius: 18px;
    padding: 32px 34px;
    margin-bottom: 24px;
    border: 1px solid rgba(0,0,0,0.05);
    box-shadow: 0 2px 16px rgba(0,0,0,0.05);
}
.founder-bio-text { font-size: 15px; color: #444; line-height: 1.9; }

/* Timeline */
.timeline { position: relative; padding-left: 32px; }
.timeline::before {
    content: '';
    position: absolute;
    left: 10px; top: 0; bottom: 0;
    width: 2px;
    background: linear-gradient(to bottom, #C8A34D, rgba(200,163,77,0.1));
}
.timeline-item { position: relative; margin-bottom: 28px; }
.timeline-dot {
    position: absolute;
    left: -26px; top: 6px;
    width: 14px; height: 14px;
    border-radius: 50%;
    background: #C8A34D;
    border: 3px solid #fff;
    box-shadow: 0 0 0 2px #C8A34D;
}
.timeline-card {
    background: #fff;
    border: 1px solid rgba(0,0,0,0.06);
    border-radius: 14px;
    padding: 18px 22px;
    transition: all 0.3s;
}
.timeline-card:hover { box-shadow: 0 4px 20px rgba(200,163,77,0.12); border-color: rgba(200,163,77,0.3); }
.timeline-year {
    display: inline-block;
    background: rgba(200,163,77,0.1);
    color: #C8A34D;
    font-size: 11px;
    font-weight: 700;
    padding: 2px 10px;
    border-radius: 20px;
    margin-bottom: 8px;
}
.timeline-title { font-size: 14px; font-weight: 700; color: #1a1a2e; margin-bottom: 4px; }
.timeline-sub { font-size: 13px; color: #888; }

/* Achievements */
.achievement-item {
    display: flex; align-items: flex-start; gap: 14px;
    background: #fff; border-radius: 14px; padding: 16px 20px;
    border: 1px solid rgba(0,0,0,0.05);
    margin-bottom: 12px;
    transition: all 0.3s;
}
.achievement-item:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.06); }
.achievement-icon { font-size: 20px; color: #C8A34D; flex-shrink: 0; margin-top: 2px; }
.achievement-text { font-size: 14px; color: #444; line-height: 1.6; }

/* Publications snippet */
.pub-card-mini {
    background: #fff;
    border: 1px solid rgba(0,0,0,0.06);
    border-left: 3px solid #C8A34D;
    border-radius: 10px;
    padding: 14px 18px;
    margin-bottom: 12px;
    font-size: 13.5px;
}
.pub-type-badge {
    display: inline-block;
    font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;
    padding: 2px 8px; border-radius: 4px; margin-bottom: 6px;
}
.badge-jurnal { background: rgba(30,79,163,0.1); color: #1E4FA3; }
.badge-buku { background: rgba(200,163,77,0.15); color: #b38b30; }
.badge-artikel { background: rgba(25,135,84,0.1); color: #198754; }
.badge-prosiding { background: rgba(111,66,193,0.1); color: #6f42c1; }

/* CTA Banner */
.wa-cta-banner {
    background: linear-gradient(135deg,#25d366,#128c7e);
    border-radius: 20px;
    padding: 32px 36px;
    display: flex; align-items: center; gap: 20px;
    flex-wrap: wrap;
}
.wa-cta-text { flex: 1; min-width: 200px; }
.wa-cta-title { font-size: 1.2rem; font-weight: 800; color: #fff; margin-bottom: 4px; }
.wa-cta-sub { font-size: 14px; color: rgba(255,255,255,0.8); }
.wa-cta-btn {
    background: #fff; color: #128c7e; font-weight: 700;
    border: none; border-radius: 50px; padding: 12px 28px; font-size: 15px;
    text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
    transition: all 0.3s;
    white-space: nowrap;
}
.wa-cta-btn:hover { background: rgba(255,255,255,0.9); color: #128c7e; box-shadow: 0 4px 16px rgba(0,0,0,0.15); }

@media (max-width: 768px) {
    .founder-content { padding: 50px 0; }
    .founder-bio-card { padding: 22px 18px; }
}
</style>

<!-- ===== HERO ===== -->
<section class="founder-hero">
    <div class="container position-relative text-center">
        <div data-aos="fade-up">
            <?php if (!empty($founder['photo'])): ?>
            <img src="<?= base_url('assets/uploads/' . $founder['photo']) ?>" alt="<?= esc($founder['name']) ?>" class="founder-hero-photo" loading="eager">
            <?php else: ?>
            <div class="founder-hero-placeholder mx-auto"><i class="fas fa-user-tie"></i></div>
            <?php endif; ?>

            <div class="founder-hero-name"><?= esc($founder['name'] ?? '') ?></div>
            <div class="founder-hero-title"><?= esc($founder['title'] ?? 'Direktur & Pendiri CV. Bagus Kencana Cakrada') ?></div>
            <p class="founder-hero-headline">Akademisi, Praktisi, dan Pakar Pengembangan SDM Profesional</p>

            <div class="founder-hero-links">
                <?php if (!empty($founder['email'])): ?>
                <a href="mailto:<?= esc($founder['email']) ?>" class="fhl"><i class="fas fa-envelope"></i> Email</a>
                <?php endif; ?>
                <?php if (!empty($founder['linkedin'])): ?>
                <a href="<?= esc($founder['linkedin']) ?>" target="_blank" rel="noopener" class="fhl"><i class="fab fa-linkedin-in"></i> LinkedIn</a>
                <?php endif; ?>
                <?php if (!empty($founder['google_scholar'])): ?>
                <a href="<?= esc($founder['google_scholar']) ?>" target="_blank" rel="noopener" class="fhl"><i class="fas fa-graduation-cap"></i> Scholar</a>
                <?php endif; ?>
                <?php if (!empty($founder['scopus_id'])): ?>
                <a href="https://www.scopus.com/authid/detail.uri?authorId=<?= esc($founder['scopus_id']) ?>" target="_blank" rel="noopener" class="fhl"><i class="fas fa-microscope"></i> Scopus</a>
                <?php endif; ?>
                <?php if (!empty($founder['orcid'])): ?>
                <a href="https://orcid.org/<?= esc($founder['orcid']) ?>" target="_blank" rel="noopener" class="fhl"><i class="fas fa-id-badge"></i> ORCID</a>
                <?php endif; ?>
            </div>

            <nav aria-label="breadcrumb" class="mt-4">
                <ol class="breadcrumb justify-content-center" style="background:none; font-size:13px;">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>" style="color:rgba(255,255,255,0.6);">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('tentang') ?>" style="color:rgba(255,255,255,0.6);">Tentang</a></li>
                    <li class="breadcrumb-item active" style="color:rgba(255,255,255,0.9);">Profil Pendiri</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- ===== CONTENT ===== -->
<section class="founder-content">
    <div class="container">
        <div class="row g-5">
            <!-- Left Column: Bio + Education + Experience -->
            <div class="col-lg-8">

                <!-- Bio -->
                <?php if (!empty($founder['bio'])): ?>
                <div class="founder-bio-card" data-aos="fade-up">
                    <div class="section-title-sm"><i class="fas fa-user me-2" style="color:#C8A34D;"></i>Biografi</div>
                    <div class="gold-bar"></div>
                    <p class="founder-bio-text"><?= nl2br(esc($founder['bio'])) ?></p>
                </div>
                <?php endif; ?>

                <!-- Education Timeline -->
                <?php if (!empty($founder['education'])): ?>
                <div class="founder-bio-card" data-aos="fade-up">
                    <div class="section-title-sm"><i class="fas fa-university me-2" style="color:#C8A34D;"></i>Riwayat Pendidikan</div>
                    <div class="gold-bar"></div>
                    <div class="timeline">
                        <?php foreach ($founder['education'] as $edu): ?>
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-card">
                                <?php $eduYear = $edu['year_end'] ?? $edu['year_start'] ?? $edu['year'] ?? ''; ?>
                                <?php if (!empty($eduYear)): ?>
                                <span class="timeline-year"><?= esc($eduYear) ?></span>
                                <?php endif; ?>
                                <div class="timeline-title"><?= esc($edu['degree'] ?? '') ?></div>
                                <div class="timeline-sub"><?= esc($edu['institution'] ?? $edu['university'] ?? '') ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Experience Timeline -->
                <?php if (!empty($founder['experience'])): ?>
                <div class="founder-bio-card" data-aos="fade-up">
                    <div class="section-title-sm"><i class="fas fa-briefcase me-2" style="color:#C8A34D;"></i>Pengalaman Kerja</div>
                    <div class="gold-bar"></div>
                    <div class="timeline">
                        <?php foreach ($founder['experience'] as $exp): ?>
                        <div class="timeline-item">
                            <div class="timeline-dot" style="background:#1E4FA3; box-shadow:0 0 0 2px #1E4FA3;"></div>
                            <div class="timeline-card">
                                <?php
                                    $expText = is_string($exp) ? $exp : (($exp['position'] ?? '') . ($exp['company'] ?? '') . ($exp['year'] ?? ''));
                                    if (is_array($exp)):
                                ?>
                                <?php $expYear = $exp['year_start'] ?? $exp['year'] ?? ''; $expYearEnd = $exp['year_end'] ?? ''; ?>
                                <?php if (!empty($expYear)): ?><span class="timeline-year" style="background:rgba(30,79,163,0.1); color:#1E4FA3;"><?= esc($expYear . ($expYearEnd ? ' – ' . $expYearEnd : '')) ?></span><?php endif; ?>
                                <?php if (!empty($exp['position'])): ?><div class="timeline-title"><?= esc($exp['position']) ?></div><?php endif; ?>
                                <?php if (!empty($exp['company'])): ?><div class="timeline-sub"><?= esc($exp['company']) ?></div><?php endif; ?>
                                <?php if (!empty($exp['description'])): ?><div style="font-size:13px; color:#888; margin-top:4px;"><?= esc($exp['description']) ?></div><?php endif; ?>
                                <?php else: ?>
                                <div class="timeline-title"><?= esc($exp) ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>

            <!-- Right Column: Achievements + Publications -->
            <div class="col-lg-4">

                <!-- Achievements -->
                <?php if (!empty($founder['achievements'])): ?>
                <div class="founder-bio-card mb-4" data-aos="fade-up">
                    <div class="section-title-sm"><i class="fas fa-trophy me-2" style="color:#C8A34D;"></i>Pencapaian</div>
                    <div class="gold-bar"></div>
                    <?php foreach ((array)$founder['achievements'] as $ach): ?>
                    <div class="achievement-item">
                        <div class="achievement-icon"><i class="fas fa-star"></i></div>
                        <div class="achievement-text"><?= esc(is_array($ach) ? ($ach['title'] ?? json_encode($ach)) : $ach) ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Publications snippet -->
                <?php if (!empty($publications)): ?>
                <div class="founder-bio-card mb-4" data-aos="fade-up">
                    <div class="section-title-sm"><i class="fas fa-book-open me-2" style="color:#C8A34D;"></i>Publikasi Terbaru</div>
                    <div class="gold-bar"></div>
                    <?php foreach (array_slice($publications, 0, 3) as $pub): ?>
                    <div class="pub-card-mini">
                        <span class="pub-type-badge badge-<?= esc(strtolower($pub['type'] ?? 'artikel')) ?>"><?= esc(ucfirst($pub['type'] ?? 'Artikel')) ?></span>
                        <div style="font-size:13.5px; font-weight:700; color:#1a1a2e; margin-bottom:4px; line-height:1.4;">
                            <?= esc($pub['title']) ?>
                        </div>
                        <div style="font-size:12px; color:#888;"><?= esc($pub['journal'] ?? $pub['publisher'] ?? '') ?> &bull; <?= esc($pub['year'] ?? '') ?></div>
                    </div>
                    <?php endforeach; ?>
                    <a href="<?= base_url('publikasi') ?>" style="font-size:13px; font-weight:700; color:#1E4FA3; text-decoration:none; display:inline-flex; align-items:center; gap:6px; margin-top:8px;">
                        Lihat semua publikasi <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <?php endif; ?>

                <!-- WA CTA -->
                <?php
                $wa = $profile['whatsapp'] ?? $profile['phone'] ?? '';
                $waClean = preg_replace('/[^0-9]/', '', $wa);
                if (substr($waClean, 0, 1) === '0') $waClean = '62' . substr($waClean, 1);
                ?>
                <div class="wa-cta-banner" data-aos="fade-up">
                    <div class="wa-cta-text">
                        <div class="wa-cta-title"><i class="fab fa-whatsapp me-2"></i>Konsultasi Langsung</div>
                        <div class="wa-cta-sub">Chat sekarang dan diskusikan kebutuhan pelatihan Anda.</div>
                    </div>
                    <a href="https://wa.me/<?= $waClean ?>?text=<?= urlencode('Halo, saya ingin berkonsultasi dengan ' . ($founder['name'] ?? 'Pendiri BKC')) ?>"
                       target="_blank" rel="noopener" class="wa-cta-btn">
                        <i class="fab fa-whatsapp"></i>Chat WA
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
