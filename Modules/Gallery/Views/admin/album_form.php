<?= $this->extend('Modules\Admin\Views\layout\main') ?>
<?= $this->section('content') ?>

<div class="page-header mb-4">
    <div>
        <h1 class="page-title mb-1"><?= isset($album) && $album ? 'Edit Album' : 'Tambah Album' ?></h1>
        <p class="page-subtitle text-muted mb-0">Kelola informasi album galeri</p>
    </div>
</div>

<div class="row g-4">
    <!-- Form Column -->
    <div class="col-12 col-lg-8">
        <div class="admin-card" data-aos="fade-up">
            <div class="admin-card-header">
                <h6 class="admin-card-title mb-0">
                    <i class="fas fa-<?= $album ? 'edit' : 'plus' ?> me-2"></i>
                    <?= $album ? 'Edit Album' : 'Tambah Album Baru' ?>
                </h6>
            </div>
            <div class="admin-card-body">
                <?php
                    $formAction = $album
                        ? base_url('admin/galeri/album/update/' . $album['id'])
                        : base_url('admin/galeri/album/simpan');
                // Routes: POST galeri/album/simpan -> storeAlbum | POST galeri/album/update/{id} -> updateAlbum
                ?>
                <form action="<?= $formAction ?>" method="post" enctype="multipart/form-data" id="albumForm">
                    <?= csrf_field() ?>

                    <!-- Album Name -->
                    <div class="mb-4">
                        <label class="form-label fw-600">Nama Album <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control"
                               placeholder="Contoh: Workshop Manajemen ASN 2025"
                               value="<?= esc($album['name'] ?? old('name')) ?>"
                               required>
                        <small class="text-muted">Nama akan otomatis dijadikan slug URL.</small>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label class="form-label fw-600">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="4"
                                  placeholder="Deskripsi singkat tentang album ini..."><?= esc($album['description'] ?? old('description')) ?></textarea>
                    </div>

                    <!-- Cover Image -->
                    <div class="mb-4">
                        <label class="form-label fw-600">Cover Image</label>
                        <div class="cover-upload-area" id="coverUploadArea"
                             style="border:2px dashed var(--border-color,#e5e7eb);border-radius:12px;padding:24px;text-align:center;cursor:pointer;transition:border-color 0.2s;"
                             onclick="document.getElementById('coverInput').click()"
                             ondragover="this.style.borderColor='#C8A34D'" ondragleave="this.style.borderColor='var(--border-color,#e5e7eb)'">
                            <div id="coverPreviewWrap">
                                <?php $cover = $album['cover_image'] ?? $album['cover'] ?? null; ?>
                                <?php if ($cover): ?>
                                <img id="coverPreview" src="<?= base_url('uploads/gallery/' . esc($cover)) ?>"
                                     style="max-height:200px;max-width:100%;border-radius:8px;object-fit:contain;">
                                <p class="text-muted mt-2 mb-0" style="font-size:13px;">Klik atau drag untuk mengganti gambar</p>
                                <?php else: ?>
                                <div id="coverPlaceholder">
                                    <i class="fas fa-cloud-upload-alt" style="font-size:2.5rem;color:#C8A34D;"></i>
                                    <p class="mt-2 mb-0 text-muted">Klik atau drag gambar cover ke sini</p>
                                    <p class="text-muted" style="font-size:12px;">JPG, PNG, WEBP — maks. 10 MB</p>
                                </div>
                                <img id="coverPreview" src="" style="max-height:200px;max-width:100%;border-radius:8px;display:none;">
                                <?php endif; ?>
                            </div>
                        </div>
                        <input type="file" id="coverInput" name="cover_image" accept="image/*" style="display:none;"
                               onchange="previewCover(this)">
                    </div>

                    <div class="row g-4">
                        <!-- Sort Order -->
                        <div class="col-6">
                            <label class="form-label fw-600">Urutan</label>
                            <input type="number" name="sort_order" class="form-control" min="0"
                                   placeholder="0"
                                   value="<?= esc($album['sort_order'] ?? old('sort_order', 0)) ?>">
                            <small class="text-muted">Angka kecil tampil lebih dulu.</small>
                        </div>

                        <!-- Status -->
                        <div class="col-6">
                            <label class="form-label fw-600">Status</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" role="switch"
                                       id="isActive" name="is_active" value="1"
                                       <?= (!$album || $album['is_active']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="isActive">Album Aktif</label>
                            </div>
                            <small class="text-muted">Album aktif tampil di halaman galeri.</small>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-4 pt-3 border-top">
                        <button type="submit" class="btn px-4 py-2 fw-700" style="background:#C8A34D;color:#121212;border-radius:10px;">
                            <i class="fas fa-save me-2"></i>
                            <?= $album ? 'Simpan Perubahan' : 'Tambah Album' ?>
                        </button>
                        <a href="<?= base_url('admin/galeri') ?>" class="btn px-4 py-2 fw-600" style="background:transparent;border:1.5px solid var(--border-color,#e5e7eb);border-radius:10px;">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tips Sidebar -->
    <div class="col-12 col-lg-4">
        <div class="admin-card" data-aos="fade-up" data-aos-delay="100">
            <div class="admin-card-header">
                <h6 class="admin-card-title mb-0"><i class="fas fa-lightbulb me-2" style="color:#C8A34D;"></i>Tips</h6>
            </div>
            <div class="admin-card-body">
                <ul class="list-unstyled mb-0" style="font-size:13px;">
                    <li class="mb-3 d-flex gap-2">
                        <i class="fas fa-check-circle mt-1" style="color:#C8A34D;flex-shrink:0;"></i>
                        <span>Gunakan nama album yang deskriptif, misalnya nama event dan tahun.</span>
                    </li>
                    <li class="mb-3 d-flex gap-2">
                        <i class="fas fa-check-circle mt-1" style="color:#C8A34D;flex-shrink:0;"></i>
                        <span>Cover image idealnya berukuran 800×600 px dengan rasio 4:3.</span>
                    </li>
                    <li class="mb-3 d-flex gap-2">
                        <i class="fas fa-check-circle mt-1" style="color:#C8A34D;flex-shrink:0;"></i>
                        <span>Urutan dimulai dari 0. Album dengan urutan terkecil tampil pertama.</span>
                    </li>
                    <li class="d-flex gap-2">
                        <i class="fas fa-check-circle mt-1" style="color:#C8A34D;flex-shrink:0;"></i>
                        <span>Setelah album dibuat, tambahkan foto via menu <strong>Media</strong> pada tabel daftar album.</span>
                    </li>
                </ul>
            </div>
        </div>

        <?php if ($album): ?>
        <div class="admin-card mt-4" data-aos="fade-up" data-aos-delay="150">
            <div class="admin-card-header">
                <h6 class="admin-card-title mb-0"><i class="fas fa-info-circle me-2"></i>Info Album</h6>
            </div>
            <div class="admin-card-body">
                <div class="mb-2">
                    <small class="text-muted d-block">Slug</small>
                    <code style="font-size:12px;"><?= esc($album['slug']) ?></code>
                </div>
                <div class="mb-2">
                    <small class="text-muted d-block">Dibuat</small>
                    <span style="font-size:13px;"><?= date('d M Y, H:i', strtotime($album['created_at'])) ?></span>
                </div>
                <a href="<?= base_url('admin/galeri/album/' . $album['id'] . '/media') ?>"
                   class="btn btn-sm w-100 mt-2" style="background:rgba(30,79,163,0.1);color:#1E4FA3;border-radius:8px;">
                    <i class="fas fa-photo-video me-2"></i>Kelola Media Album
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->section('extra_js') ?>
<script>
function previewCover(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        const img = document.getElementById('coverPreview');
        img.src = e.target.result;
        img.style.display = 'block';
        const placeholder = document.getElementById('coverPlaceholder');
        if (placeholder) placeholder.style.display = 'none';
    };
    reader.readAsDataURL(input.files[0]);
}

// Drag and drop
const area = document.getElementById('coverUploadArea');
if (area) {
    area.addEventListener('drop', function(e) {
        e.preventDefault();
        this.style.borderColor = 'var(--border-color,#e5e7eb)';
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            const input = document.getElementById('coverInput');
            const dt = new DataTransfer();
            dt.items.add(file);
            input.files = dt.files;
            previewCover(input);
        }
    });
    area.addEventListener('dragover', function(e) { e.preventDefault(); });
}
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
