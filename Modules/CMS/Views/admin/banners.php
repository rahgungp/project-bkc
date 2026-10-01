<?= $this->extend('Modules\Admin\Views\layout\main') ?>
<?= $this->section('content') ?>

<div class="page-header d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
    <div>
        <h1 class="page-title mb-1">Manajemen Banner</h1>
        <p class="page-subtitle text-muted mb-0">Kelola banner/slider halaman utama</p>
    </div>
    <button class="btn fw-700" style="background:#C8A34D;color:#121212;border-radius:10px;padding:10px 20px;"
            onclick="openBannerModal()">
        <i class="fas fa-plus me-2"></i>Tambah Banner
    </button>
</div>

<!-- Drag-to-reorder Banner List -->
<div class="admin-card" data-aos="fade-up">
    <div class="admin-card-header d-flex align-items-center justify-content-between">
        <h6 class="admin-card-title mb-0"><i class="fas fa-image me-2"></i>Daftar Banner</h6>
        <button id="saveOrderBtn" onclick="saveOrder()" style="display:none;" class="btn btn-sm fw-600"
                style="background:rgba(200,163,77,0.15);color:#C8A34D;border-radius:8px;">
            <i class="fas fa-save me-1"></i>Simpan Urutan
        </button>
    </div>
    <div class="admin-card-body">
        <?php if (empty($banners)): ?>
        <div class="text-center py-5">
            <div style="width:70px;height:70px;background:rgba(200,163,77,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                <i class="fas fa-image" style="font-size:1.8rem;color:#C8A34D;"></i>
            </div>
            <p class="text-muted mb-0">Belum ada banner. Tambah banner pertama.</p>
        </div>
        <?php else: ?>
        <div id="bannerList" style="display:flex;flex-direction:column;gap:12px;">
            <?php foreach ($banners as $banner): ?>
            <div class="banner-row" data-id="<?= $banner['id'] ?>"
                 style="display:flex;align-items:center;gap:16px;padding:14px;background:var(--bg-secondary,#f8f9fa);border-radius:12px;border:1px solid var(--border-color,#e5e7eb);transition:box-shadow 0.2s;cursor:grab;">
                <!-- Drag Handle -->
                <div style="color:var(--text-muted,#6c757d);font-size:18px;flex-shrink:0;">
                    <i class="fas fa-grip-vertical"></i>
                </div>

                <!-- Image -->
                <div style="flex-shrink:0;">
                    <?php if ($banner['image']): ?>
                    <img src="<?= base_url('uploads/banners/' . esc($banner['image'])) ?>"
                         style="width:100px;height:60px;object-fit:cover;border-radius:8px;"
                         alt="<?= esc($banner['title']) ?>"
                         onerror="this.outerHTML='<div style=\'width:100px;height:60px;background:rgba(200,163,77,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;\'><i class=\'fas fa-image\' style=\'color:#C8A34D;\'></i></div>'">
                    <?php else: ?>
                    <div style="width:100px;height:60px;background:rgba(200,163,77,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-image" style="color:#C8A34D;font-size:24px;"></i>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Content -->
                <div style="flex:1;min-width:0;">
                    <div class="fw-700" style="font-size:14px;"><?= esc($banner['title']) ?></div>
                    <?php if (!empty($banner['subtitle'])): ?>
                    <div class="text-muted" style="font-size:12px;"><?= esc(substr($banner['subtitle'], 0, 80)) ?></div>
                    <?php endif; ?>
                    <?php $url = $banner['link'] ?? ''; ?>
                    <?php if ($url): ?>
                    <div style="font-size:11px;color:#1E4FA3;margin-top:2px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?= esc($url) ?></div>
                    <?php endif; ?>
                </div>

                <!-- Status Toggle -->
                <div style="flex-shrink:0;">
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" role="switch"
                               id="banner-active-<?= $banner['id'] ?>"
                               <?= $banner['is_active'] ? 'checked' : '' ?>
                               onchange="toggleBanner(<?= $banner['id'] ?>, this.checked)">
                    </div>
                </div>

                <!-- Actions -->
                <div style="flex-shrink:0;display:flex;gap:6px;">
                    <button class="btn btn-sm" style="background:rgba(200,163,77,0.1);color:#C8A34D;border-radius:8px;"
                            onclick="editBanner(<?= $banner['id'] ?>, <?= htmlspecialchars(json_encode($banner), ENT_QUOTES) ?>)"
                            title="Edit">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm" style="background:rgba(220,53,69,0.1);color:#dc3545;border-radius:8px;"
                            onclick="deleteBanner(<?= $banner['id'] ?>, '<?= esc($banner['title'], 'js') ?>')"
                            title="Hapus">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="mt-3 text-muted" style="font-size:12px;">
            <i class="fas fa-info-circle me-1"></i>
            Drag baris untuk mengubah urutan, lalu klik "Simpan Urutan".
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Banner Modal (Create/Edit) -->
<div class="modal fade" id="bannerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius:16px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-700" id="bannerModalTitle">Tambah Banner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="bannerForm" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" id="bannerId" name="banner_id">

                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-600">Judul <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="bannerTitle" class="form-control" placeholder="Judul banner" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-600">Sub-Judul</label>
                            <input type="text" name="subtitle" id="bannerSubtitle" class="form-control" placeholder="Sub-judul atau tagline">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-600">Teks Tombol</label>
                            <input type="text" name="button_text" id="bannerBtnText" class="form-control" placeholder="Contoh: Daftar Sekarang">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-600">URL Tombol</label>
                            <input type="text" name="button_url" id="bannerBtnUrl" class="form-control" placeholder="/pelatihan">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Gambar Banner</label>
                            <div id="bannerImgPreviewWrap" style="display:none;margin-bottom:8px;">
                                <img id="bannerImgPreview" src="" style="max-height:150px;border-radius:8px;object-fit:contain;">
                            </div>
                            <input type="file" name="image" id="bannerImageInput" class="form-control" accept="image/*"
                                   onchange="previewBannerImage(this)">
                            <small class="text-muted">Ukuran ideal: 1920×600 px. JPG/PNG/WEBP, maks. 10 MB.</small>
                        </div>
                        <div class="col-6 col-md-4">
                            <label class="form-label fw-600">Urutan</label>
                            <input type="number" name="sort_order" id="bannerSortOrder" class="form-control" min="0" value="0">
                        </div>
                        <div class="col-6 col-md-4 d-flex align-items-end pb-1">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="bannerIsActive" value="1" checked>
                                <label class="form-check-label fw-600" for="bannerIsActive">Aktif</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn px-4" style="background:transparent;border:1.5px solid var(--border-color,#e5e7eb);border-radius:10px;" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn px-4 fw-700" style="background:#C8A34D;color:#121212;border-radius:10px;" onclick="saveBanner()">
                    <i class="fas fa-save me-2"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->section('extra_js') ?>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
// ─── Sortable ────────────────────────────────────────────────────────────────
const bannerListEl = document.getElementById('bannerList');
let orderChanged = false;

if (bannerListEl) {
    Sortable.create(bannerListEl, {
        animation: 150,
        handle: '.banner-row',
        onEnd: function() {
            orderChanged = true;
            document.getElementById('saveOrderBtn').style.display = 'inline-flex';
        },
    });
}

function saveOrder() {
    const rows  = bannerListEl.querySelectorAll('.banner-row');
    const items = Array.from(rows).map(function(r, i) {
        return { id: parseInt(r.dataset.id), sort_order: i };
    });

    $.ajax({
        url: '<?= base_url('admin/banner/reorder') ?>',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(items),
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(res) {
            if (res.success) {
                document.getElementById('saveOrderBtn').style.display = 'none';
                Swal.fire({ title: 'Berhasil!', text: res.message, icon: 'success', timer: 1500, showConfirmButton: false });
            }
        },
    });
}

// ─── Modal ───────────────────────────────────────────────────────────────────
let bannerModal = null;

function openBannerModal() {
    resetBannerForm();
    document.getElementById('bannerModalTitle').textContent = 'Tambah Banner';
    if (!bannerModal) bannerModal = new bootstrap.Modal(document.getElementById('bannerModal'));
    bannerModal.show();
}

function editBanner(id, data) {
    resetBannerForm();
    document.getElementById('bannerModalTitle').textContent = 'Edit Banner';
    document.getElementById('bannerId').value        = id;
    document.getElementById('bannerTitle').value     = data.title || '';
    document.getElementById('bannerSubtitle').value  = data.subtitle || '';
    document.getElementById('bannerBtnText').value   = data.button_text || '';
    document.getElementById('bannerBtnUrl').value    = data.button_url || data.link || '';
    document.getElementById('bannerSortOrder').value = data.sort_order || 0;
    document.getElementById('bannerIsActive').checked = !!parseInt(data.is_active);

    if (data.image) {
        document.getElementById('bannerImgPreview').src = '<?= base_url('uploads/banners/') ?>' + data.image;
        document.getElementById('bannerImgPreviewWrap').style.display = 'block';
    }

    if (!bannerModal) bannerModal = new bootstrap.Modal(document.getElementById('bannerModal'));
    bannerModal.show();
}

function resetBannerForm() {
    document.getElementById('bannerForm').reset();
    document.getElementById('bannerId').value = '';
    document.getElementById('bannerImgPreviewWrap').style.display = 'none';
    document.getElementById('bannerImgPreview').src = '';
    document.getElementById('bannerIsActive').checked = true;
}

function previewBannerImage(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('bannerImgPreview').src = e.target.result;
        document.getElementById('bannerImgPreviewWrap').style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
}

function saveBanner() {
    const id  = document.getElementById('bannerId').value;
    const url = id
        ? '<?= base_url('admin/banner/update') ?>/' + id
        : '<?= base_url('admin/banner/simpan') ?>';

    const fd = new FormData(document.getElementById('bannerForm'));
    if (!fd.get('is_active')) fd.set('is_active', '0');

    $.ajax({
        url: url,
        method: 'POST',
        data: fd,
        processData: false,
        contentType: false,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(res) {
            if (res.success) {
                bannerModal.hide();
                Swal.fire({
                    title: 'Berhasil!',
                    text: res.message,
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false,
                }).then(function() { location.reload(); });
            } else {
                const errHtml = res.errors ? Object.values(res.errors).join('<br>') : (res.message || 'Gagal menyimpan banner.');
                Swal.fire('Gagal', errHtml, 'error');
            }
        },
        error: function() { Swal.fire('Error', 'Terjadi kesalahan server.', 'error'); },
    });
}

function toggleBanner(id, isChecked) {
    $.post('<?= base_url('admin/banner/toggle') ?>/' + id, {
        is_active: isChecked ? 1 : 0,
        '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
    }).fail(function() {
        document.getElementById('banner-active-' + id).checked = !isChecked;
        Swal.fire('Gagal', 'Gagal mengubah status.', 'error');
    });
}

function deleteBanner(id, name) {
    Swal.fire({
        title: 'Hapus Banner?',
        html: 'Banner <strong>' + name + '</strong> akan dihapus.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',
    }).then(function(result) {
        if (!result.isConfirmed) return;
        $.ajax({
            url: '<?= base_url('admin/banner/hapus') ?>/' + id,
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(res) {
                if (res.success) {
                    location.reload();
                } else {
                    Swal.fire('Gagal', res.message, 'error');
                }
            },
        });
    });
}
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
