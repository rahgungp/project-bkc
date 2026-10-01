<?= $this->extend('Modules\Admin\Views\layout\main') ?>

<?= $this->section('content') ?>

<style>
.media-toolbar {
    background: white;
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}
.folder-tab {
    padding: 6px 16px;
    border-radius: 50px;
    border: 2px solid #e2e8f0;
    background: white;
    color: #64748b;
    font-size: 0.85rem;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s;
}
.folder-tab.active, .folder-tab:hover {
    border-color: var(--primary-color, #C8A34D);
    background: var(--primary-color, #C8A34D);
    color: white;
}
.upload-zone {
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 32px;
    text-align: center;
    background: #f8fafc;
    cursor: pointer;
    transition: all 0.3s;
    margin-bottom: 24px;
}
.upload-zone:hover, .upload-zone.dragover {
    border-color: var(--primary-color, #C8A34D);
    background: rgba(200,163,77,0.05);
}
.upload-zone i { font-size: 2.5rem; color: #94a3b8; margin-bottom: 12px; }
.upload-zone p { color: #64748b; margin: 0; }
#fileInput { display: none; }

.media-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 16px; }
.media-item {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    transition: all 0.2s;
    position: relative;
    cursor: pointer;
}
.media-item:hover { box-shadow: 0 6px 20px rgba(0,0,0,0.12); transform: translateY(-2px); }
.media-item:hover .media-actions { opacity: 1; }
.media-thumb {
    width: 100%; height: 120px; object-fit: cover;
    background: #f1f5f9;
    display: flex; align-items: center; justify-content: center;
}
.media-thumb img { width: 100%; height: 100%; object-fit: cover; }
.media-thumb .fa-file-pdf { font-size: 2.5rem; color: #ef4444; }
.media-info { padding: 10px; }
.media-name { font-size: 0.78rem; color: #4a5568; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.media-meta { font-size: 0.72rem; color: #94a3b8; }
.media-actions {
    position: absolute; top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.5);
    display: flex; align-items: center; justify-content: center; gap: 8px;
    opacity: 0; transition: all 0.2s;
}
.media-actions button {
    width: 36px; height: 36px; border-radius: 50%; border: none;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: 0.9rem;
}
.btn-copy { background: white; color: #1E4FA3; }
.btn-delete-media { background: #ef4444; color: white; }
.upload-progress {
    background: #e2e8f0;
    border-radius: 50px;
    height: 6px;
    overflow: hidden;
    margin-top: 12px;
    display: none;
}
.upload-progress-bar {
    height: 100%;
    background: linear-gradient(135deg, #C8A34D, #a8842d);
    border-radius: 50px;
    transition: width 0.3s;
    width: 0;
}
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><?= esc($title) ?></h4>
        <p class="text-muted mb-0">Kelola semua file media yang diupload ke sistem.</p>
    </div>
    <button class="btn btn-primary" onclick="document.getElementById('fileInput').click()">
        <i class="fas fa-upload me-2"></i>Upload File
    </button>
</div>

<!-- Toolbar -->
<div class="media-toolbar">
    <span class="text-muted fw-500 me-2" style="font-size:0.9rem;">Folder:</span>
    <?php foreach ($folders as $f): ?>
    <a href="?folder=<?= $f ?>" class="folder-tab <?= $folder === $f ? 'active' : '' ?>">
        <?= ucfirst($f) ?>
    </a>
    <?php endforeach; ?>
    <div class="ms-auto">
        <input type="text" class="form-control form-control-sm" id="mediaSearch" placeholder="Cari file..." style="width:200px;">
    </div>
</div>

<!-- Upload Zone -->
<div class="upload-zone" id="uploadZone" onclick="document.getElementById('fileInput').click()">
    <input type="file" id="fileInput" multiple accept="image/*,.pdf">
    <i class="fas fa-cloud-upload-alt d-block"></i>
    <p class="mt-2 fw-600">Klik atau drag & drop file ke sini</p>
    <p class="mt-1" style="font-size:0.85rem;">Mendukung JPG, PNG, GIF, WebP, PDF (max 10MB)</p>
    <div class="upload-progress" id="uploadProgress">
        <div class="upload-progress-bar" id="uploadBar"></div>
    </div>
</div>

<!-- Media Grid -->
<?php if (empty($mediaFiles)): ?>
<div class="text-center py-5">
    <i class="fas fa-images fa-4x text-muted mb-3"></i>
    <p class="text-muted">Belum ada file di folder ini. Upload file pertama Anda!</p>
</div>
<?php else: ?>
<div class="media-grid" id="mediaGrid">
    <?php foreach ($mediaFiles as $media): ?>
    <div class="media-item" data-name="<?= esc(strtolower($media['original_name'])) ?>">
        <div class="media-thumb">
            <?php if (strpos($media['mime_type'], 'image/') === 0): ?>
            <img src="<?= base_url($media['file_path']) ?>" alt="<?= esc($media['original_name']) ?>" loading="lazy">
            <?php else: ?>
            <div class="d-flex align-items-center justify-content-center" style="height:100%;">
                <i class="fas fa-file-pdf"></i>
            </div>
            <?php endif; ?>
        </div>
        <div class="media-info">
            <div class="media-name" title="<?= esc($media['original_name']) ?>"><?= esc($media['original_name']) ?></div>
            <div class="media-meta"><?= number_format($media['file_size'] / 1024, 0) ?>KB</div>
        </div>
        <div class="media-actions">
            <button class="btn-copy" onclick="copyUrl('<?= esc($media['file_url']) ?>')" title="Salin URL">
                <i class="fas fa-copy"></i>
            </button>
            <button class="btn-delete-media" onclick="deleteMedia(<?= $media['id'] ?>, this)" title="Hapus">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<script>
const currentFolder = '<?= esc($folder) ?>';

// Drag & drop
const uploadZone = document.getElementById('uploadZone');
uploadZone.addEventListener('dragover', e => { e.preventDefault(); uploadZone.classList.add('dragover'); });
uploadZone.addEventListener('dragleave', () => uploadZone.classList.remove('dragover'));
uploadZone.addEventListener('drop', e => {
    e.preventDefault();
    uploadZone.classList.remove('dragover');
    if (e.dataTransfer.files.length) uploadFiles(e.dataTransfer.files);
});
document.getElementById('fileInput').addEventListener('change', e => {
    if (e.target.files.length) uploadFiles(e.target.files);
});

function uploadFiles(files) {
    const progress = document.getElementById('uploadProgress');
    const bar = document.getElementById('uploadBar');
    progress.style.display = 'block';

    const promises = Array.from(files).map((file, i) => {
        const fd = new FormData();
        fd.append('file', file);
        fd.append('folder', currentFolder);
        fd.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
        return fetch('<?= site_url('admin/media/upload') ?>', { method: 'POST', body: fd })
            .then(r => r.json())
            .then(data => {
                bar.style.width = ((i + 1) / files.length * 100) + '%';
                return data;
            });
    });

    Promise.all(promises).then(results => {
        const ok = results.filter(r => r.success).length;
        const fail = results.length - ok;
        progress.style.display = 'none';
        bar.style.width = '0';
        Swal.fire({
            icon: ok > 0 ? 'success' : 'error',
            title: ok > 0 ? `${ok} file berhasil diupload` : 'Upload gagal',
            text: fail > 0 ? `${fail} file gagal.` : '',
            timer: 2000, showConfirmButton: false
        }).then(() => location.reload());
    });
}

function copyUrl(url) {
    navigator.clipboard.writeText(url).then(() => {
        Swal.fire({ icon: 'success', title: 'URL disalin!', timer: 1500, showConfirmButton: false });
    });
}

function deleteMedia(id, btn) {
    Swal.fire({
        title: 'Hapus file ini?',
        text: 'File akan dihapus permanen dari server.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then(result => {
        if (!result.isConfirmed) return;
        fetch('<?= site_url('admin/media/hapus') ?>/' + id, {
            method: 'DELETE',
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': '<?= csrf_hash() ?>' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                btn.closest('.media-item').remove();
                Swal.fire({ icon: 'success', title: 'Terhapus!', timer: 1500, showConfirmButton: false });
            }
        });
    });
}

// Search
document.getElementById('mediaSearch').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.media-item').forEach(item => {
        item.style.display = !q || item.dataset.name.includes(q) ? '' : 'none';
    });
});
</script>

<?= $this->endSection() ?>
