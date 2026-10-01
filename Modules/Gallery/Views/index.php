<?= $this->extend('Modules\Website\Views\layout\main') ?>
<?= $this->section('content') ?>

<!-- Page Hero -->
<section class="page-hero" style="background: linear-gradient(135deg, #121212 0%, #1a1a2e 50%, #16213e 100%); padding: 100px 0 60px; position: relative; overflow: hidden;">
    <div class="hero-bg-pattern" style="position:absolute;inset:0;background:url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><circle cx=\"50\" cy=\"50\" r=\"1\" fill=\"rgba(200,163,77,0.08)\"/></svg>') repeat; opacity:0.5;"></div>
    <div class="container position-relative">
        <div class="text-center" data-aos="fade-up">
            <span class="badge mb-3 px-3 py-2" style="background: rgba(200,163,77,0.15); color: #C8A34D; border: 1px solid rgba(200,163,77,0.3); border-radius: 50px; font-size: 13px; letter-spacing: 1px;">GALERI FOTO & VIDEO</span>
            <h1 class="fw-800 text-white mb-3" style="font-size: clamp(2rem, 5vw, 3.5rem); line-height: 1.2;">
                Galeri Kegiatan <span style="color:#C8A34D;">BKC</span>
            </h1>
            <p class="text-white-50 mb-0" style="font-size: 1.1rem; max-width: 600px; margin: 0 auto;">
                Dokumentasi kegiatan pelatihan, workshop, seminar, dan bimtek yang telah kami selenggarakan.
            </p>
        </div>
    </div>
</section>

<!-- Gallery Albums Section -->
<section class="py-5" style="background: #f8f9fa;">
    <div class="container">

        <?php if (empty($albums)): ?>
        <div class="text-center py-5" data-aos="fade-up">
            <div style="width:80px;height:80px;background:rgba(200,163,77,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
                <i class="fas fa-images" style="font-size:2rem;color:#C8A34D;"></i>
            </div>
            <h4 class="text-muted">Belum ada album galeri</h4>
            <p class="text-muted">Album foto dan video akan segera hadir.</p>
        </div>
        <?php else: ?>

        <div class="row g-4">
            <?php foreach ($albums as $i => $album): ?>
            <div class="col-12 col-sm-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= ($i % 3) * 100 ?>">
                <a href="<?= base_url('galeri/' . $album['slug']) ?>" class="text-decoration-none">
                    <div class="album-card" style="
                        background: #fff;
                        border-radius: 16px;
                        overflow: hidden;
                        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
                        transition: transform 0.3s ease, box-shadow 0.3s ease;
                        cursor: pointer;
                    " onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 40px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 20px rgba(0,0,0,0.08)'">
                        <!-- Cover Image -->
                        <div style="position: relative; overflow: hidden; aspect-ratio: 4/3;">
                            <?php
                                $cover = $album['cover_image'] ?? $album['cover'] ?? null;
                            ?>
                            <?php if ($cover): ?>
                            <img src="<?= base_url('uploads/gallery/' . esc($cover)) ?>"
                                 alt="<?= esc($album['name']) ?>"
                                 style="width:100%; height:100%; object-fit:cover; transition: transform 0.4s ease;"
                                 class="album-cover-img"
                                 onerror="this.parentElement.innerHTML='<div style=\'width:100%;height:100%;background:linear-gradient(135deg,#1E4FA3,#C8A34D);display:flex;align-items:center;justify-content:center\'><i class=\'fas fa-images\' style=\'font-size:3rem;color:rgba(255,255,255,0.5)\'></i></div>'">
                            <?php else: ?>
                            <div style="width:100%;height:100%;background:linear-gradient(135deg,#1E4FA3,#C8A34D);display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-images" style="font-size:3rem;color:rgba(255,255,255,0.5);"></i>
                            </div>
                            <?php endif; ?>

                            <!-- Media Count Badge -->
                            <div style="position:absolute;top:12px;right:12px;">
                                <span style="
                                    background: rgba(0,0,0,0.65);
                                    backdrop-filter: blur(8px);
                                    color: #fff;
                                    padding: 4px 12px;
                                    border-radius: 50px;
                                    font-size: 12px;
                                    font-weight: 600;
                                    border: 1px solid rgba(255,255,255,0.15);
                                ">
                                    <i class="fas fa-image me-1" style="color:#C8A34D;font-size:10px;"></i>
                                    <?= (int) ($album['media_count'] ?? 0) ?> foto
                                </span>
                            </div>

                            <!-- Overlay -->
                            <div style="
                                position:absolute;inset:0;
                                background:linear-gradient(to top, rgba(0,0,0,0.6) 0%, transparent 50%);
                                opacity:0; transition:opacity 0.3s;
                            " class="album-overlay"></div>
                        </div>

                        <!-- Card Body -->
                        <div style="padding: 20px;">
                            <h5 class="fw-700 mb-1" style="color:#1a1a2e; font-size:16px; line-height:1.3;">
                                <?= esc($album['name']) ?>
                            </h5>
                            <?php if (!empty($album['description'])): ?>
                            <p class="text-muted mb-0" style="font-size:13px; line-height:1.5;">
                                <?= esc(substr($album['description'], 0, 80)) ?><?= strlen($album['description']) > 80 ? '...' : '' ?>
                            </p>
                            <?php endif; ?>
                            <div class="mt-3 d-flex align-items-center justify-content-between">
                                <span style="color:#C8A34D; font-size:13px; font-weight:600;">
                                    Lihat Album <i class="fas fa-arrow-right ms-1" style="font-size:11px;"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>

        <?php endif; ?>
    </div>
</section>

<style>
.album-card:hover .album-cover-img { transform: scale(1.05); }
.album-card:hover .album-overlay { opacity: 1 !important; }
</style>

<?= $this->endSection() ?>
