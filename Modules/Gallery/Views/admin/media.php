<?= $this->extend('Modules\Admin\Views\layout\main') ?>
<?= $this->section('content') ?>

<div class="page-header d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
    <div>
        <h1 class="page-title mb-1">Media Album</h1>
        <p class="page-subtitle text-muted mb-0">
            <a href="<?= base_url('admin/galeri') ?>" style="color:#C8A34D;text-decoration:none;">
                <i class="fas fa-arrow-left me-1"></i>Galeri
            </a>
            &rsaquo; <?= esc($album['name']) ?>
        </p>
    </div>
</div>

<div class="row g-4">

    <!-- Upload Zone -->
    <div class="col-12 col-lg-4">
        <div class="admin-card sticky-top" style="top:80px;" data-aos="fade-up">
            <div class="admin-card-header">
                <h6 class="admin-card-title mb-0"><i class="fas fa-cloud-upload-alt me-2"></i>Upload Media</h6>
            </div>
            <div class="admin-card-body">

                <!-- Drop Zone -->
                <div id="dropZone"
                     style="border:2px dashed var(--border-color,#e5e7eb);border-radius:12px;padding:32px 16px;text-align:center;cursor:pointer;transition:all 0.2s;"
                     onclick="document.getElementById('fileInput').click()"
                     ondragover="event.preventDefault();this.style.borderColor='#C8A34D';this.style.background='rgba(200,163,77,0.05)'"
                     ondragleave="this.style.borderColor='var(--border-color,#e5e7eb)';this.style.background=''"
                     ondrop="handleDrop(event)">
                    <i class="fas fa-cloud-upload-alt" style="font-size:2.5rem;color:#C8A34D;"></i>
                    <p class="mt-2 mb-1 fw-600">Drag & drop file di sini</p>
                    <p class="text-muted mb-0" style="font-size:12px;">atau klik untuk memilih file</p>
                    <p class="text-muted mt-1" style="font-size:11px;">JPG, PNG, GIF, WEBP, MP4 — maks. 10 MB</p>
                </div>

                <input type="file" id="fileInput" accept="image/*,video/mp4" multiple style="display:none;" onchange="handleFileSelect(this.files)">

                <!-- Upload Queue -->
                <div id="uploadQueue" class="mt-3" style="display:none;">
                    <div class="fw-600 mb-2" style="font-size:13px;">Antrian Upload</div>
                    <div id="queueList"></div>
                    <button onclick="uploadAll()" class="btn w-100 mt-3 fw-700" style="background:#C8A34D;color:#121212;border-radius:10px;">
                        <i class="fas fa-upload me-2"></i>Upload Semua
                    </button>
                </div>

                <!-- Upload Progress -->
                <div id="uploadProgress" class="mt-3" style="display:none;">
                    <div class="d-flex justify-content-between mb-1">
                        <small class="fw-600">Mengupload...</small>
                        <small id="progressText">0%</small>
                    </div>
                    <div class="progress" style="height:6px;border-radius:6px;">
                        <div id="progressBar" class="progress-bar" role="progressbar" style="width:0%;background:#C8A34D;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Media Grid -->
    <div class="col-12 col-lg-8">
        <div class="admin-card" data-aos="fade-up">
            <div class="admin-card-header d-flex align-items-center justify-content-between">
                <h6 class="admin-card-title mb-0"><i class="fas fa-th me-2"></i>Media dalam Album</h6>
                <span class="badge" style="background:rgba(200,163,77,0.15);color:#C8A34D;padding:6px 12px;border-radius:20px;" id="mediaCount">
                    <?= count($media) ?> item
                </span>
            </div>
            <div class="admin-card-body">
                <div class="row g-3" id="mediaGrid">
                    <?php if (empty($media)): ?>
                    <div class="col-12 text-center py-5" id="emptyState">
                        <div style="width:70px;height:70px;background:rgba(200,163,77,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                            <i class="fas fa-images" style="font-size:1.8rem;color:#C8A34D;"></i>
                        </div>
                        <p class="text-muted mb-0">Belum ada media. Upload foto atau video di panel kiri.</p>
                    </div>
                    <?php else: ?>
                    <?php foreach ($media as $item): ?>
                    <div class="col-6 col-sm-4 col-xl-3" id="media-item-<?= $item['id'] ?>">
                        <?php $isVideo = ($item['type'] === 'video'); ?>
                        <?php $thumb   = $item['thumbnail_path'] ?? $item['thumbnail'] ?? null; ?>
                        <?php $src     = $isVideo && $thumb ? $thumb : ($isVideo ? null : $item['file_path']); ?>
                        <div style="border-radius:10px;overflow:hidden;position:relative;aspect-ratio:1/1;background:var(--bg-primary,#f8f9fa);">
                            <?php if ($src): ?>
                            <img src="<?= base_url('uploads/gallery/' . esc($src)) ?>"
                                 style="width:100%;height:100%;object-fit:cover;"
                                 alt="<?= esc($item['title'] ?? '') ?>"
                                 loading="lazy">
                            <?php else: ?>
                            <div style="width:100%;height:100%;background:linear-gradient(135deg,#1E4FA3,#121212);display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-film" style="font-size:2rem;color:rgba(255,255,255,0.5);"></i>
                            </div>
                            <?php endif; ?>

                            <?php if ($isVideo): ?>
                            <div style="position:absolute;top:8px;left:8px;">
                                <span style="background:rgba(0,0,0,0.7);color:#fff;padding:2px 8px;border-radius:20px;font-size:10px;">
                                    <i class="fas fa-video me-1"></i>Video
                                </span>
                            </div>
                            <?php endif; ?>

                            <!-- Delete button -->
                            <button onclick="deleteMedia(<?= $item['id'] ?>)"
                                    style="position:absolute;top:8px;right:8px;background:rgba(220,53,69,0.85);border:none;color:#fff;width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:11px;"
                                    title="Hapus media">
                                <i class="fas fa-times"></i>
                            </button>

                            <!-- Title overlay -->
                            <?php if (!empty($item['title'])): ?>
                            <div style="position:absolute;bottom:0;left:0;right:0;background:linear-gradient(transparent,rgba(0,0,0,0.7));padding:20px 8px 8px;">
                                <span style="color:#fff;font-size:11px;font-weight:600;"><?= esc(substr($item['title'], 0, 30)) ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->section('extra_js') ?>
<script>
const UPLOAD_URL = '<?= base_url('admin/galeri/album/' . $album['id'] . '/upload') ?>';
const CSRF_TOKEN_NAME = '<?= csrf_token() ?>';
let CSRF_HASH = '<?= csrf_hash() ?>';
const DELETE_URL_BASE = '<?= base_url('admin/galeri/media/hapus') ?>/';

let fileQueue = [];
let mediaCount = <?= count($media) ?>;

function updateMediaCount() {
    document.getElementById('mediaCount').textContent = mediaCount + ' item';
    const empty = document.getElementById('emptyState');
    if (empty && mediaCount > 0) empty.remove();
}

function handleDrop(e) {
    e.preventDefault();
    const dropZone = document.getElementById('dropZone');
    dropZone.style.borderColor = 'var(--border-color,#e5e7eb)';
    dropZone.style.background  = '';
    handleFileSelect(e.dataTransfer.files);
}

function handleFileSelect(files) {
    if (!files || files.length === 0) return;
    Array.from(files).forEach(function(file) {
        const allowed = ['image/jpeg','image/png','image/gif','image/webp','video/mp4'];
        if (!allowed.includes(file.type)) {
            Swal.fire('Format Tidak Didukung', 'File ' + file.name + ' tidak didukung.', 'warning');
            return;
        }
        if (file.size > 10 * 1024 * 1024) {
            Swal.fire('File Terlalu Besar', 'File ' + file.name + ' melebihi batas 10 MB.', 'warning');
            return;
        }
        fileQueue.push(file);
        renderQueue();
    });
}

function renderQueue() {
    const queueDiv = document.getElementById('uploadQueue');
    const list     = document.getElementById('queueList');
    if (fileQueue.length === 0) { queueDiv.style.display = 'none'; return; }
    queueDiv.style.display = 'block';
    list.innerHTML = fileQueue.map(function(f, i) {
        return '<div class="d-flex align-items-center gap-2 mb-2 p-2" style="background:var(--bg-primary,#f8f9fa);border-radius:8px;">' +
            '<i class="fas fa-' + (f.type.startsWith('video') ? 'video' : 'image') + '" style="color:#C8A34D;flex-shrink:0;"></i>' +
            '<span style="flex:1;font-size:12px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">' + f.name + '</span>' +
            '<small class="text-muted" style="flex-shrink:0;">' + (f.size / 1024 / 1024).toFixed(1) + 'MB</small>' +
            '<button onclick="removeFromQueue(' + i + ')" style="background:none;border:none;color:#dc3545;cursor:pointer;padding:0;font-size:12px;"><i class="fas fa-times"></i></button>' +
            '</div>';
    }).join('');
}

function removeFromQueue(index) {
    fileQueue.splice(index, 1);
    renderQueue();
}

async function uploadAll() {
    if (fileQueue.length === 0) return;

    const progressWrap = document.getElementById('uploadProgress');
    const bar          = document.getElementById('progressBar');
    const text         = document.getElementById('progressText');
    progressWrap.style.display = 'block';

    let uploaded = 0;
    const total  = fileQueue.length;

    for (const file of fileQueue) {
        const fd = new FormData();
        fd.append('file', file);
        fd.append(CSRF_TOKEN_NAME, CSRF_HASH);

        try {
            const res = await fetch(UPLOAD_URL, { method: 'POST', body: fd });
            const data = await res.json();

            // Refresh CSRF hash
            CSRF_HASH = data.csrf_hash || CSRF_HASH;

            if (data.success) {
                appendMediaToGrid(data.media);
                mediaCount++;
                updateMediaCount();
            } else {
                Swal.fire('Upload Gagal', data.message || 'Terjadi kesalahan.', 'error');
            }
        } catch (err) {
            console.error(err);
        }

        uploaded++;
        const pct = Math.round((uploaded / total) * 100);
        bar.style.width  = pct + '%';
        text.textContent = pct + '%';
    }

    fileQueue = [];
    renderQueue();
    setTimeout(function() { progressWrap.style.display = 'none'; bar.style.width = '0%'; }, 1500);
}

function appendMediaToGrid(media) {
    const grid = document.getElementById('mediaGrid');
    const col  = document.createElement('div');
    col.className = 'col-6 col-sm-4 col-xl-3';
    col.id = 'media-item-' + media.id;

    const imgSrc = media.thumbnail_path
        ? '<?= base_url('uploads/gallery/') ?>' + media.thumbnail_path
        : '<?= base_url('uploads/gallery/') ?>' + media.file_path;

    col.innerHTML =
        '<div style="border-radius:10px;overflow:hidden;position:relative;aspect-ratio:1/1;background:var(--bg-primary,#f8f9fa);">' +
            '<img src="' + imgSrc + '" style="width:100%;height:100%;object-fit:cover;" loading="lazy">' +
            '<button onclick="deleteMedia(' + media.id + ')" style="position:absolute;top:8px;right:8px;background:rgba(220,53,69,0.85);border:none;color:#fff;width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:11px;" title="Hapus">' +
                '<i class="fas fa-times"></i>' +
            '</button>' +
        '</div>';

    grid.insertBefore(col, grid.firstChild);
}

function deleteMedia(id) {
    Swal.fire({
        title: 'Hapus Media?',
        text: 'File media akan dihapus secara permanen.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
    }).then(function(result) {
        if (!result.isConfirmed) return;

        $.ajax({
            url: DELETE_URL_BASE + id,
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(res) {
                if (res.success) {
                    $('#media-item-' + id).fadeOut(300, function() {
                        $(this).remove();
                        mediaCount = Math.max(0, mediaCount - 1);
                        updateMediaCount();
                    });
                } else {
                    Swal.fire('Gagal', res.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Terjadi kesalahan.', 'error');
            },
        });
    });
}
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
