<?= $this->extend('Modules\Website\Views\layout\main') ?>
<?= $this->section('content') ?>

<!-- Page Hero -->
<section class="page-hero" style="background: linear-gradient(135deg, #121212 0%, #1a1a2e 50%, #16213e 100%); padding: 100px 0 60px; position: relative; overflow: hidden;">
    <div class="container position-relative">
        <div class="text-center" data-aos="fade-up">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb justify-content-center" style="background:transparent;">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>" style="color:rgba(255,255,255,0.6);">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('galeri') ?>" style="color:rgba(255,255,255,0.6);">Galeri</a></li>
                    <li class="breadcrumb-item active" style="color:#C8A34D;"><?= esc($album['name']) ?></li>
                </ol>
            </nav>
            <span class="badge mb-3 px-3 py-2" style="background:rgba(200,163,77,0.15);color:#C8A34D;border:1px solid rgba(200,163,77,0.3);border-radius:50px;font-size:13px;letter-spacing:1px;">ALBUM GALERI</span>
            <h1 class="fw-800 text-white mb-3" style="font-size: clamp(1.8rem, 4vw, 3rem); line-height: 1.2;">
                <?= esc($album['name']) ?>
            </h1>
            <?php if (!empty($album['description'])): ?>
            <p class="text-white-50 mb-0" style="font-size:1rem; max-width:600px; margin:0 auto;">
                <?= esc($album['description']) ?>
            </p>
            <?php endif; ?>
            <div class="mt-3">
                <span style="color:rgba(255,255,255,0.5); font-size:14px;">
                    <i class="fas fa-images me-1" style="color:#C8A34D;"></i>
                    <?= count($media) ?> item
                </span>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Grid -->
<section class="py-5" style="background:#f8f9fa;">
    <div class="container">

        <?php if (empty($media)): ?>
        <div class="text-center py-5" data-aos="fade-up">
            <div style="width:80px;height:80px;background:rgba(200,163,77,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
                <i class="fas fa-images" style="font-size:2rem;color:#C8A34D;"></i>
            </div>
            <h4 class="text-muted">Belum ada media dalam album ini</h4>
            <a href="<?= base_url('galeri') ?>" class="btn mt-3" style="background:#C8A34D;color:#121212;font-weight:600;border-radius:10px;">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Galeri
            </a>
        </div>
        <?php else: ?>

        <!-- Masonry Grid -->
        <div class="row g-3" id="galleryGrid">
            <?php foreach ($media as $i => $item): ?>
            <div class="col-6 col-sm-4 col-lg-3" data-aos="fade-up" data-aos-delay="<?= ($i % 4) * 50 ?>">
                <div class="gallery-item" style="
                    border-radius: 12px;
                    overflow: hidden;
                    cursor: pointer;
                    position: relative;
                    aspect-ratio: 1/1;
                    background: #ddd;
                    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                " onclick="openLightbox(<?= $i ?>)"
                   onmouseover="this.style.transform='scale(1.03)';this.style.boxShadow='0 8px 30px rgba(0,0,0,0.2)'"
                   onmouseout="this.style.transform='scale(1)';this.style.boxShadow='0 2px 10px rgba(0,0,0,0.1)'">

                    <?php if ($item['type'] === 'video'): ?>
                        <?php $thumb = $item['thumbnail_path'] ?? $item['thumbnail'] ?? null; ?>
                        <?php if ($thumb): ?>
                        <img src="<?= base_url('uploads/gallery/' . esc($thumb)) ?>"
                             alt="<?= esc($item['title'] ?? 'Video') ?>"
                             style="width:100%;height:100%;object-fit:cover;">
                        <?php else: ?>
                        <div style="width:100%;height:100%;background:linear-gradient(135deg,#1E4FA3,#121212);display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-play-circle" style="font-size:3rem;color:rgba(255,255,255,0.7);"></i>
                        </div>
                        <?php endif; ?>
                        <!-- Video Play Overlay -->
                        <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.3);">
                            <div style="width:50px;height:50px;background:rgba(200,163,77,0.9);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-play" style="color:#121212;margin-left:3px;"></i>
                            </div>
                        </div>
                    <?php else: ?>
                        <img src="<?= base_url('uploads/gallery/' . esc($item['file_path'])) ?>"
                             alt="<?= esc($item['title'] ?? 'Foto') ?>"
                             style="width:100%;height:100%;object-fit:cover;"
                             loading="lazy">
                    <?php endif; ?>

                    <!-- Hover Overlay -->
                    <div class="gallery-hover" style="
                        position:absolute;inset:0;
                        background:linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 50%);
                        opacity:0;transition:opacity 0.3s;
                        display:flex;align-items:flex-end;padding:12px;
                    ">
                        <?php if (!empty($item['title'])): ?>
                        <span style="color:#fff;font-size:12px;font-weight:600;"><?= esc($item['title']) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php endif; ?>

        <div class="text-center mt-5">
            <a href="<?= base_url('galeri') ?>" class="btn px-4 py-2" style="background:transparent;color:#1E4FA3;border:2px solid #1E4FA3;border-radius:10px;font-weight:600;transition:all 0.3s;"
               onmouseover="this.style.background='#1E4FA3';this.style.color='#fff'"
               onmouseout="this.style.background='transparent';this.style.color='#1E4FA3'">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Galeri
            </a>
        </div>
    </div>
</section>

<!-- Lightbox Modal -->
<div class="modal fade" id="lightboxModal" tabindex="-1" aria-hidden="true" style="--bs-modal-bg: transparent;">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 90vw;">
        <div class="modal-content" style="background: rgba(10,10,10,0.95); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; backdrop-filter: blur(20px);">
            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-2">
                    <span id="lightboxCounter" style="color:rgba(255,255,255,0.5);font-size:13px;"></span>
                    <span id="lightboxTitle" style="color:#C8A34D;font-weight:600;font-size:14px;"></span>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 text-center position-relative" style="min-height: 300px;">
                <!-- Prev Button -->
                <button id="lightboxPrev" onclick="changeLightbox(-1)" style="
                    position:absolute;left:10px;top:50%;transform:translateY(-50%);
                    z-index:10;background:rgba(255,255,255,0.1);border:none;
                    color:#fff;width:44px;height:44px;border-radius:50%;
                    display:flex;align-items:center;justify-content:center;
                    cursor:pointer;transition:background 0.2s;backdrop-filter:blur(4px);
                " onmouseover="this.style.background='rgba(200,163,77,0.5)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                    <i class="fas fa-chevron-left"></i>
                </button>

                <!-- Media Container -->
                <div id="lightboxMedia" style="max-height: 75vh; display:flex; align-items:center; justify-content:center;">
                    <img id="lightboxImg" src="" alt="" style="max-width:100%;max-height:75vh;object-fit:contain;border-radius:8px;display:none;">
                    <video id="lightboxVideo" controls style="max-width:100%;max-height:75vh;border-radius:8px;display:none;"></video>
                </div>

                <!-- Next Button -->
                <button id="lightboxNext" onclick="changeLightbox(1)" style="
                    position:absolute;right:10px;top:50%;transform:translateY(-50%);
                    z-index:10;background:rgba(255,255,255,0.1);border:none;
                    color:#fff;width:44px;height:44px;border-radius:50%;
                    display:flex;align-items:center;justify-content:center;
                    cursor:pointer;transition:background 0.2s;backdrop-filter:blur(4px);
                " onmouseover="this.style.background='rgba(200,163,77,0.5)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.gallery-item:hover .gallery-hover { opacity: 1 !important; }
</style>

<script>
// Build media data array from PHP
const galleryMedia = <?= json_encode(array_map(function($m) {
    return [
        'type'      => $m['type'],
        'file_path' => base_url('uploads/gallery/' . $m['file_path']),
        'thumb'     => base_url('uploads/gallery/' . ($m['thumbnail_path'] ?? $m['thumbnail'] ?? $m['file_path'])),
        'title'     => $m['title'] ?? '',
    ];
}, $media)) ?>;

let currentIndex = 0;
let lightboxModal = null;

function openLightbox(index) {
    currentIndex = index;
    if (!lightboxModal) {
        lightboxModal = new bootstrap.Modal(document.getElementById('lightboxModal'));
    }
    renderLightbox();
    lightboxModal.show();
}

function renderLightbox() {
    const item  = galleryMedia[currentIndex];
    const img   = document.getElementById('lightboxImg');
    const video = document.getElementById('lightboxVideo');
    const title = document.getElementById('lightboxTitle');
    const counter = document.getElementById('lightboxCounter');

    counter.textContent = (currentIndex + 1) + ' / ' + galleryMedia.length;
    title.textContent   = item.title || '';

    if (item.type === 'video') {
        img.style.display   = 'none';
        video.style.display = 'block';
        video.src           = item.file_path;
        video.load();
    } else {
        video.style.display = 'none';
        video.src           = '';
        img.style.display   = 'block';
        img.src             = item.file_path;
        img.alt             = item.title || 'Foto';
    }

    // Show/hide nav buttons
    document.getElementById('lightboxPrev').style.display = galleryMedia.length > 1 ? 'flex' : 'none';
    document.getElementById('lightboxNext').style.display = galleryMedia.length > 1 ? 'flex' : 'none';
}

function changeLightbox(dir) {
    // Pause video if playing
    const video = document.getElementById('lightboxVideo');
    video.pause();

    currentIndex = (currentIndex + dir + galleryMedia.length) % galleryMedia.length;
    renderLightbox();
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    if (!document.getElementById('lightboxModal').classList.contains('show')) return;
    if (e.key === 'ArrowLeft')  changeLightbox(-1);
    if (e.key === 'ArrowRight') changeLightbox(1);
    if (e.key === 'Escape') {
        const v = document.getElementById('lightboxVideo');
        v.pause();
    }
});
</script>

<?= $this->endSection() ?>
