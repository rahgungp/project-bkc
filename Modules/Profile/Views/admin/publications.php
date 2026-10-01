<?= $this->extend('Modules\Admin\Views\layout\main') ?>
<?= $this->section('content') ?>

<style>
.pub-type-badge {
    font-size: 10px; font-weight: 700; padding: 3px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: .5px;
}
.pub-type-journal  { background: rgba(30,79,163,.12); color: #1E4FA3; }
.pub-type-book     { background: rgba(200,163,77,.15); color: #b8832a; }
.pub-type-article  { background: rgba(25,135,84,.12); color: #198754; }
.pub-type-proceeding { background: rgba(102,16,242,.1); color: #6610f2; }
.pub-type-other    { background: #f0f0f0; color: #555; }
.cover-thumb {
    width: 52px; height: 68px; object-fit: cover; border-radius: 6px;
    border: 1px solid #dee2e6;
}
.cover-fallback {
    width: 52px; height: 68px; background: rgba(200,163,77,.1); border-radius: 6px;
    display: inline-flex; align-items: center; justify-content: center; color: #C8A34D;
    border: 1px dashed rgba(200,163,77,.5);
}
.toggle-switch { cursor: pointer; user-select: none; }
.toggle-switch input { display: none; }
.toggle-switch .slider {
    display: inline-block; width: 38px; height: 20px;
    background: #dee2e6; border-radius: 100px; position: relative; transition: background .25s;
}
.toggle-switch .slider::after {
    content: ''; position: absolute; left: 3px; top: 3px;
    width: 14px; height: 14px; border-radius: 50%;
    background: #fff; transition: left .25s;
}
.toggle-switch input:checked + .slider { background: #C8A34D; }
.toggle-switch input:checked + .slider::after { left: 21px; }
.cover-preview-container {
    width: 100%; max-width: 180px; min-height: 120px;
    border: 2px dashed #C8A34D; border-radius: 10px; overflow: hidden;
    display: flex; align-items: center; justify-content: center; background: #fafafa;
}
.cover-preview-container img { max-width: 100%; max-height: 200px; object-fit: contain; }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">Publikasi</h1>
        <p class="page-subtitle">
            <?php if(!empty($founder)): ?>Publikasi oleh <strong><?= esc($founder['name']) ?></strong><?php endif; ?>
        </p>
    </div>
    <div class="page-actions">
        <a href="<?= base_url('admin/profil/pendiri') ?>" class="btn btn-outline-secondary" style="border-radius:10px; padding:9px 16px; font-size:13px;">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPubModal"
            style="background:#C8A34D; border-color:#C8A34D; color:#121212; font-weight:700; border-radius:10px; padding:10px 20px;">
            <i class="fas fa-plus me-2"></i>Tambah Publikasi
        </button>
    </div>
</div>

<div class="admin-card" data-aos="fade-up">
    <div class="admin-card-header">
        <h6 class="admin-card-title"><i class="fas fa-book me-2"></i>Daftar Publikasi</h6>
    </div>
    <div class="admin-card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="pubTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cover</th>
                        <th>Judul &amp; Penerbit</th>
                        <th>Tipe</th>
                        <th>Tahun</th>
                        <th>Featured</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($publications)): foreach($publications as $i => $pub): ?>
                    <tr id="pubrow-<?= $pub['id'] ?>">
                        <td><?= $i+1 ?></td>
                        <td>
                            <?php if(!empty($pub['cover'])): ?>
                                <img src="<?= base_url('assets/uploads/publications/' . esc($pub['cover'])) ?>"
                                     class="cover-thumb" alt=""
                                     onerror="this.outerHTML='<span class=\'cover-fallback\'><i class=\'fas fa-book\'></i></span>'">
                            <?php else: ?>
                                <span class="cover-fallback"><i class="fas fa-book"></i></span>
                            <?php endif; ?>
                        </td>
                        <td style="max-width:280px;">
                            <div class="fw-600" style="font-size:13px;"><?= esc(mb_substr($pub['title'],0,60)) ?><?= mb_strlen($pub['title'])>60?'…':'' ?></div>
                            <small class="text-muted"><?= esc($pub['publisher'] ?? $pub['journal'] ?? '-') ?></small>
                            <?php if(!empty($pub['url'])): ?>
                            <a href="<?= esc($pub['url']) ?>" target="_blank" class="d-block" style="font-size:11px; color:#1E4FA3;"><i class="fas fa-external-link-alt me-1"></i>Lihat</a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php
                            $typeMap = ['journal'=>['label'=>'Jurnal','class'=>'journal'],'book'=>['label'=>'Buku','class'=>'book'],'article'=>['label'=>'Artikel','class'=>'article'],'proceeding'=>['label'=>'Prosiding','class'=>'proceeding'],'other'=>['label'=>'Lainnya','class'=>'other']];
                            $typeInfo = $typeMap[$pub['type'] ?? 'other'] ?? $typeMap['other'];
                            ?>
                            <span class="pub-type-badge pub-type-<?= $typeInfo['class'] ?>"><?= $typeInfo['label'] ?></span>
                        </td>
                        <td><?= esc($pub['year'] ?? $pub['published_year'] ?? '-') ?></td>
                        <td>
                            <label class="toggle-switch">
                                <input type="checkbox" <?= !empty($pub['is_featured']) ? 'checked' : '' ?>
                                    onchange="toggleFeatured(<?= $pub['id'] ?>, this)">
                                <span class="slider"></span>
                            </label>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <button class="btn btn-sm btn-outline-primary" style="border-radius:8px; padding:5px 10px;"
                                    onclick="openEditPub(<?= htmlspecialchars(json_encode($pub), ENT_QUOTES) ?>)" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" style="border-radius:8px; padding:5px 10px;"
                                    onclick="deletePub(<?= $pub['id'] ?>)" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="7" class="text-center py-5 text-muted">Belum ada publikasi. Klik "Tambah Publikasi" untuk memulai.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ADD Publication Modal -->
<div class="modal fade" id="addPubModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus me-2" style="color:#C8A34D;"></i>Tambah Publikasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addPubForm" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-600">Judul Publikasi <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Tipe Publikasi</label>
                            <select name="type" class="form-select" id="addPubType">
                                <option value="journal">Jurnal</option>
                                <option value="book">Buku</option>
                                <option value="article">Artikel</option>
                                <option value="proceeding">Prosiding</option>
                                <option value="other">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Penerbit / Jurnal</label>
                            <input type="text" name="publisher" class="form-control" placeholder="Nama penerbit atau nama jurnal...">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-600">Tahun Terbit</label>
                            <input type="number" name="year" class="form-control" value="<?= date('Y') ?>" min="2000" max="2030">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-600">URL / Link Publikasi</label>
                            <input type="url" name="url" class="form-control" placeholder="https://...">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Deskripsi / Abstrak</label>
                            <textarea name="abstract" class="form-control" rows="4" placeholder="Deskripsi singkat publikasi..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">DOI</label>
                            <input type="text" name="doi" class="form-control" placeholder="10.xxxx/xxxxx">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-600">ISBN</label>
                            <input type="text" name="isbn" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-600">ISSN</label>
                            <input type="text" name="issn" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Cover Image</label>
                            <input type="file" name="cover" id="addCoverInput" class="form-control" accept="image/*">
                            <div class="mt-2">
                                <div class="cover-preview-container" id="addCoverPreviewBox">
                                    <span class="text-muted" style="font-size:12px;"><i class="fas fa-image me-1"></i>Preview</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="w-100">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="is_scopus" id="addIsScopus" value="1">
                                    <label class="form-check-label" for="addIsScopus">Terindeks Scopus</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_featured" id="addIsFeatured" value="1">
                                    <label class="form-check-label" for="addIsFeatured">Featured (tampilkan di beranda)</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn" style="background:#C8A34D; color:#121212; font-weight:700;">
                        <i class="fas fa-save me-1"></i>Simpan Publikasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- EDIT Publication Modal -->
<div class="modal fade" id="editPubModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit me-2" style="color:#C8A34D;"></i>Edit Publikasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editPubForm" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="POST">
                <input type="hidden" name="_edit_pub_id" id="editPubId">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-600">Judul Publikasi <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="editPubTitle" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Tipe Publikasi</label>
                            <select name="type" id="editPubType" class="form-select">
                                <option value="journal">Jurnal</option>
                                <option value="book">Buku</option>
                                <option value="article">Artikel</option>
                                <option value="proceeding">Prosiding</option>
                                <option value="other">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Penerbit / Jurnal</label>
                            <input type="text" name="publisher" id="editPubPublisher" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-600">Tahun Terbit</label>
                            <input type="number" name="year" id="editPubYear" class="form-control" min="2000" max="2030">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-600">URL / Link Publikasi</label>
                            <input type="url" name="url" id="editPubUrl" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Deskripsi / Abstrak</label>
                            <textarea name="abstract" id="editPubAbstract" class="form-control" rows="4"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">DOI</label>
                            <input type="text" name="doi" id="editPubDoi" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-600">ISBN</label>
                            <input type="text" name="isbn" id="editPubIsbn" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-600">ISSN</label>
                            <input type="text" name="issn" id="editPubIssn" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Cover Baru (opsional)</label>
                            <input type="file" name="cover" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="w-100">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="is_scopus" id="editIsScopus" value="1">
                                    <label class="form-check-label" for="editIsScopus">Terindeks Scopus</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_featured" id="editIsFeatured" value="1">
                                    <label class="form-check-label" for="editIsFeatured">Featured</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn" style="background:#C8A34D; color:#121212; font-weight:700;">
                        <i class="fas fa-save me-1"></i>Update Publikasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;
const BASE = '<?= base_url() ?>';

$(document).ready(function() {
    $('#pubTable').DataTable({
        order: [],
        columnDefs: [{ orderable: false, targets: [1,5,6] }],
        language: { search: 'Cari:', lengthMenu: 'Tampil _MENU_ data' }
    });
});

// Cover preview
document.getElementById('addCoverInput')?.addEventListener('change', function() {
    const box = document.getElementById('addCoverPreviewBox');
    if (this.files[0]) {
        box.innerHTML = '<img src="' + URL.createObjectURL(this.files[0]) + '" alt="Preview">';
    }
});

function openEditPub(data) {
    $('#editPubId').val(data.id);
    $('#editPubTitle').val(data.title);
    $('#editPubType').val(data.type || 'journal');
    $('#editPubPublisher').val(data.publisher || data.journal || '');
    $('#editPubYear').val(data.year || data.published_year || '');
    $('#editPubUrl').val(data.url || '');
    $('#editPubAbstract').val(data.abstract || '');
    $('#editPubDoi').val(data.doi || '');
    $('#editPubIsbn').val(data.isbn || '');
    $('#editPubIssn').val(data.issn || '');
    $('#editIsScopus').prop('checked', data.is_scopus == 1);
    $('#editIsFeatured').prop('checked', data.is_featured == 1);
    new bootstrap.Modal(document.getElementById('editPubModal')).show();
}

$('#addPubForm').on('submit', function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    $.ajax({
        url: BASE + 'admin/profil/publikasi',
        method: 'POST',
        data: fd,
        processData: false,
        contentType: false,
        headers: { 'X-CSRF-TOKEN': CSRF },
        success: function(r) {
            if (r.status === 'success') {
                Swal.fire({ icon:'success', title:'Berhasil!', text: r.message, timer:1800, showConfirmButton:false });
                bootstrap.Modal.getInstance(document.getElementById('addPubModal')).hide();
                setTimeout(() => location.reload(), 1800);
            } else { Swal.fire({ icon:'error', title:'Error', text: r.message }); }
        }
    });
});

$('#editPubForm').on('submit', function(e) {
    e.preventDefault();
    const id = $('#editPubId').val();
    const fd = new FormData(this);
    $.ajax({
        url: BASE + 'admin/profil/publikasi/' + id,
        method: 'POST',
        data: fd,
        processData: false,
        contentType: false,
        headers: { 'X-CSRF-TOKEN': CSRF },
        success: function(r) {
            if (r.status === 'success') {
                Swal.fire({ icon:'success', title:'Berhasil!', text: r.message, timer:1800, showConfirmButton:false });
                bootstrap.Modal.getInstance(document.getElementById('editPubModal')).hide();
                setTimeout(() => location.reload(), 1800);
            } else { Swal.fire({ icon:'error', title:'Error', text: r.message }); }
        }
    });
});

function toggleFeatured(id, el) {
    $.post(BASE + 'admin/profil/publikasi/' + id + '/toggle-featured', { '<?= csrf_token() ?>': CSRF }, function(r) {
        toast(r.status === 'success' ? 'success' : 'error', r.message);
        if (r.status !== 'success') el.checked = !el.checked;
    });
}

function deletePub(id) {
    Swal.fire({
        title: 'Hapus Publikasi?',
        text: 'Data yang dihapus tidak dapat dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then(result => {
        if (result.isConfirmed) {
            $.post(BASE + 'admin/profil/publikasi/' + id + '/hapus', {
                _method: 'DELETE',
                '<?= csrf_token() ?>': CSRF
            }, function(r) {
                if (r.status === 'success') {
                    $('#pubrow-' + id).fadeOut(300, function() { $(this).remove(); });
                    toast('success', r.message);
                } else { Swal.fire({ icon:'error', title:'Error', text: r.message }); }
            });
        }
    });
}

function toast(icon, text) {
    Swal.fire({ toast:true, position:'top-end', icon, title:text, showConfirmButton:false, timer:2200 });
}
</script>

<?= $this->endSection() ?>
