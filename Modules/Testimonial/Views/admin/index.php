<?= $this->extend('Modules\Admin\Views\layout\main') ?>
<?= $this->section('content') ?>

<style>
.star-gold { color: #C8A34D; }
.star-empty { color: #dee2e6; }
.toggle-switch { cursor: pointer; user-select: none; }
.toggle-switch input { display: none; }
.toggle-switch .slider {
    display: inline-block; width: 42px; height: 22px;
    background: #dee2e6; border-radius: 100px; position: relative;
    transition: background .25s;
}
.toggle-switch .slider::after {
    content: ''; position: absolute; left: 3px; top: 3px;
    width: 16px; height: 16px; border-radius: 50%;
    background: #fff; transition: left .25s; box-shadow: 0 1px 3px rgba(0,0,0,.3);
}
.toggle-switch input:checked + .slider { background: #C8A34D; }
.toggle-switch input:checked + .slider::after { left: 23px; }
.toggle-switch.blue input:checked + .slider { background: #1E4FA3; }
.comment-cell { max-width: 200px; }
.comment-short { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px; display: block; }
.stat-strip {
    display: flex; gap: 16px; margin-bottom: 20px; flex-wrap: wrap;
}
.stat-strip-item {
    background: #fff; border-radius: 12px; padding: 14px 20px;
    box-shadow: 0 1px 4px rgba(0,0,0,.07); display: flex; align-items: center; gap: 12px;
    flex: 1; min-width: 160px;
}
.stat-strip-icon { font-size: 22px; }
.stat-strip-val { font-size: 22px; font-weight: 700; color: #121212; }
.stat-strip-lbl { font-size: 12px; color: #6B7280; font-weight: 500; }
.photo-thumb {
    width: 46px; height: 46px; border-radius: 50%; object-fit: cover;
    border: 2px solid #C8A34D;
}
.photo-fallback {
    width: 46px; height: 46px; border-radius: 50%; background: rgba(200,163,77,.15);
    display: inline-flex; align-items: center; justify-content: center; color: #C8A34D; font-size: 18px;
}
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">Kelola Testimoni</h1>
        <p class="page-subtitle">Manajemen testimoni peserta pelatihan BKC</p>
    </div>
    <div class="page-actions">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"
            style="background:var(--gold,#C8A34D); border-color:var(--gold,#C8A34D); color:#121212; font-weight:700; border-radius:10px; padding:10px 20px;">
            <i class="fas fa-plus me-2"></i>Tambah Testimoni
        </button>
    </div>
</div>

<!-- Stats Strip -->
<div class="stat-strip" data-aos="fade-up">
    <div class="stat-strip-item">
        <span class="stat-strip-icon" style="color:#C8A34D;"><i class="fas fa-comments"></i></span>
        <div>
            <div class="stat-strip-val"><?= count($testimonials) ?></div>
            <div class="stat-strip-lbl">Total Testimoni</div>
        </div>
    </div>
    <div class="stat-strip-item">
        <span class="stat-strip-icon" style="color:#C8A34D;"><i class="fas fa-star"></i></span>
        <div>
            <div class="stat-strip-val" style="color:#C8A34D;">
                <?php
                $avg = count($testimonials) ? round(array_sum(array_column($testimonials, 'rating')) / count($testimonials), 1) : 0;
                echo $avg; ?> <small style="font-size:14px;">/ 5</small>
            </div>
            <div class="stat-strip-lbl">Rata-rata Rating</div>
        </div>
    </div>
    <div class="stat-strip-item">
        <span class="stat-strip-icon" style="color:#f59e0b;"><i class="fas fa-clock"></i></span>
        <div>
            <div class="stat-strip-val">
                <?= count(array_filter($testimonials, fn($t) => !$t['is_approved'])) ?>
            </div>
            <div class="stat-strip-lbl">Menunggu Approval</div>
        </div>
    </div>
    <div class="stat-strip-item">
        <span class="stat-strip-icon" style="color:#1E4FA3;"><i class="fas fa-thumbtack"></i></span>
        <div>
            <div class="stat-strip-val">
                <?= count(array_filter($testimonials, fn($t) => $t['is_featured'])) ?>
            </div>
            <div class="stat-strip-lbl">Featured</div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="admin-card mb-3" data-aos="fade-up">
    <div class="admin-card-body py-3">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-600 mb-1" style="font-size:13px;">Filter Rating</label>
                <select id="filterRating" class="form-select form-select-sm">
                    <option value="">Semua Rating</option>
                    <option value="5">⭐⭐⭐⭐⭐ (5 Bintang)</option>
                    <option value="4">⭐⭐⭐⭐ (4 Bintang)</option>
                    <option value="3">⭐⭐⭐ (3 Bintang)</option>
                    <option value="2">⭐⭐ (2 Bintang)</option>
                    <option value="1">⭐ (1 Bintang)</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-600 mb-1" style="font-size:13px;">Filter Status</label>
                <select id="filterStatus" class="form-select form-select-sm">
                    <option value="">Semua Status</option>
                    <option value="1">Disetujui</option>
                    <option value="0">Menunggu</option>
                </select>
            </div>
            <div class="col-md-4">
                <button onclick="resetFilters()" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-redo me-1"></i>Reset Filter
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Table -->
<div class="admin-card" data-aos="fade-up">
    <div class="admin-card-header">
        <h6 class="admin-card-title"><i class="fas fa-star me-2"></i>Daftar Testimoni</h6>
    </div>
    <div class="admin-card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="testiTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Foto</th>
                        <th>Peserta</th>
                        <th>Pelatihan</th>
                        <th>Rating</th>
                        <th>Komentar</th>
                        <th>Approved</th>
                        <th>Featured</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($testimonials as $i => $t): ?>
                    <tr id="row-<?= $t['id'] ?>">
                        <td><?= $i + 1 ?></td>
                        <td>
                            <?php if (!empty($t['photo'])): ?>
                                <img src="<?= base_url('assets/uploads/testimonials/' . esc($t['photo'])) ?>"
                                     class="photo-thumb" alt="" onerror="this.outerHTML='<span class=\'photo-fallback\'><i class=\'fas fa-user-circle\'></i></span>'">
                            <?php else: ?>
                                <span class="photo-fallback"><i class="fas fa-user-circle"></i></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="fw-600" style="font-size:13px;"><?= esc($t['name']) ?></div>
                            <small class="text-muted"><?= esc($t['position'] ?? '') ?><?= (!empty($t['position']) && !empty($t['institution'])) ? ' — ' : '' ?><?= esc($t['institution'] ?? '') ?></small>
                        </td>
                        <td style="font-size:12px; max-width:160px;">
                            <?php $trainingName = $t['training_title'] ?? $t['training_name'] ?? '-'; ?>
                            <span title="<?= esc($trainingName) ?>"><?= esc(mb_strlen($trainingName) > 40 ? mb_substr($trainingName,0,40).'…' : $trainingName) ?></span>
                        </td>
                        <td>
                            <?php $r = (int)($t['rating'] ?? 5); for($s=1;$s<=5;$s++): ?>
                                <i class="fas fa-star <?= $s<=$r?'star-gold':'star-empty' ?>" style="font-size:12px;"></i>
                            <?php endfor; ?>
                            <div style="font-size:10px; color:#6B7280;"><?= $r ?>/5</div>
                        </td>
                        <td class="comment-cell">
                            <?php $comment = $t['comment'] ?? ''; ?>
                            <span class="comment-short" style="max-width:180px; font-size:12px;" title="<?= esc($comment) ?>">
                                <?= esc(mb_strlen($comment)>80 ? mb_substr($comment,0,80).'…' : $comment) ?>
                            </span>
                            <?php if(mb_strlen($comment)>80): ?>
                            <a href="#" class="text-primary" style="font-size:11px;" onclick="showComment(event,'<?= esc(addslashes($comment)) ?>')">Lihat</a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <label class="toggle-switch">
                                <input type="checkbox" <?= $t['is_approved'] ? 'checked' : '' ?>
                                    onchange="toggleApprove(<?= $t['id'] ?>, this)">
                                <span class="slider"></span>
                            </label>
                        </td>
                        <td>
                            <label class="toggle-switch blue">
                                <input type="checkbox" <?= $t['is_featured'] ? 'checked' : '' ?>
                                    onchange="toggleFeatured(<?= $t['id'] ?>, this)">
                                <span class="slider"></span>
                            </label>
                        </td>
                        <td style="font-size:12px; white-space:nowrap;"><?= date('d/m/Y', strtotime($t['created_at'])) ?></td>
                        <td>
                            <div class="d-flex gap-1">
                                <button class="btn btn-sm btn-outline-primary" style="border-radius:8px; padding:5px 10px;"
                                    onclick="openEdit(<?= htmlspecialchars(json_encode($t), ENT_QUOTES) ?>)"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" style="border-radius:8px; padding:5px 10px;"
                                    onclick="deleteRecord(<?= $t['id'] ?>)"
                                    title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus me-2" style="color:#C8A34D;"></i>Tambah Testimoni</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addForm" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Peserta <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jabatan / Posisi</label>
                            <input type="text" name="position" class="form-control" placeholder="Contoh: Kepala Dinas">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Instansi / Perusahaan</label>
                            <input type="text" name="institution" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Foto</label>
                            <input type="file" name="photo" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Nama Pelatihan</label>
                            <input type="text" name="training_name" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Rating</label>
                            <select name="rating" class="form-select">
                                <?php for($r=5;$r>=1;$r--): ?>
                                <option value="<?= $r ?>" <?= $r==5?'selected':'' ?>><?= $r ?> Bintang</option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="0">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Komentar <span class="text-danger">*</span></label>
                            <textarea name="comment" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_approved" id="addApproved" value="1" checked>
                                <label class="form-check-label" for="addApproved">Setujui Testimoni</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_featured" id="addFeatured" value="1">
                                <label class="form-check-label" for="addFeatured">Tampilkan di Beranda (Featured)</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" style="background:#C8A34D; border-color:#C8A34D; color:#121212; font-weight:700;">
                        <i class="fas fa-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit me-2" style="color:#C8A34D;"></i>Edit Testimoni</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="_edit_id" id="editId">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Peserta <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="editName" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jabatan / Posisi</label>
                            <input type="text" name="position" id="editPosition" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Instansi / Perusahaan</label>
                            <input type="text" name="institution" id="editInstitution" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Foto Baru (opsional)</label>
                            <input type="file" name="photo" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Rating</label>
                            <select name="rating" id="editRating" class="form-select">
                                <?php for($r=5;$r>=1;$r--): ?>
                                <option value="<?= $r ?>"><?= $r ?> Bintang</option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" id="editSortOrder" class="form-control" value="0">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Komentar <span class="text-danger">*</span></label>
                            <textarea name="comment" id="editComment" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_approved" id="editApproved" value="1">
                                <label class="form-check-label" for="editApproved">Setujui Testimoni</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_featured" id="editFeatured" value="1">
                                <label class="form-check-label" for="editFeatured">Featured</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" style="background:#C8A34D; border-color:#C8A34D; color:#121212; font-weight:700;">
                        <i class="fas fa-save me-1"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;
const BASE = '<?= base_url() ?>';

$(document).ready(function() {
    var table = $('#testiTable').DataTable({
        order: [],
        columnDefs: [{ orderable: false, targets: [1,6,7,9] }],
        language: { search: 'Cari:', lengthMenu: 'Tampil _MENU_ data', info: 'Menampilkan _START_–_END_ dari _TOTAL_ data' }
    });

    $('#filterRating').on('change', function() { table.column(4).search(this.value).draw(); });
    $('#filterStatus').on('change', function() { table.column(6).search('').draw(); /* custom filter */ filterByApproval(this.value, table); });
});

function filterByApproval(val, table) {
    // re-render or use column search on text
    table.draw();
}

function resetFilters() {
    $('#filterRating').val(''); $('#filterStatus').val('');
    $('#testiTable').DataTable().search('').columns().search('').draw();
}

function showComment(e, text) {
    e.preventDefault();
    Swal.fire({ title: 'Komentar Lengkap', text: text, icon: 'info', confirmButtonColor: '#C8A34D' });
}

function openEdit(data) {
    $('#editId').val(data.id);
    $('#editName').val(data.name);
    $('#editPosition').val(data.position || '');
    $('#editInstitution').val(data.institution || '');
    $('#editRating').val(data.rating || 5);
    $('#editSortOrder').val(data.sort_order || 0);
    $('#editComment').val(data.comment || '');
    $('#editApproved').prop('checked', data.is_approved == 1);
    $('#editFeatured').prop('checked', data.is_featured == 1);
    new bootstrap.Modal(document.getElementById('editModal')).show();
}

$('#addForm').on('submit', function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    $.ajax({
        url: BASE + 'admin/testimoni/simpan',
        method: 'POST',
        data: fd,
        processData: false,
        contentType: false,
        headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
        success: function(r) {
            if (r.status === 'success') {
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: r.message, timer: 1800, showConfirmButton: false });
                bootstrap.Modal.getInstance(document.getElementById('addModal')).hide();
                setTimeout(() => location.reload(), 1800);
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: r.message });
            }
        }
    });
});

$('#editForm').on('submit', function(e) {
    e.preventDefault();
    const id = $('#editId').val();
    const fd = new FormData(this);
    $.ajax({
        url: BASE + 'admin/testimoni/update/' + id,
        method: 'POST',
        data: fd,
        processData: false,
        contentType: false,
        headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
        success: function(r) {
            if (r.status === 'success') {
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: r.message, timer: 1800, showConfirmButton: false });
                bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
                setTimeout(() => location.reload(), 1800);
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: r.message });
            }
        }
    });
});

function toggleApprove(id, el) {
    $.post(BASE + 'admin/testimoni/approve/' + id, { [csrf_token_name()]: CSRF_TOKEN }, function(r) {
        toast(r.status === 'success' ? 'success' : 'error', r.message);
        if (r.status !== 'success') el.checked = !el.checked;
    });
}

function toggleFeatured(id, el) {
    $.post(BASE + 'admin/testimoni/featured/' + id, { [csrf_token_name()]: CSRF_TOKEN }, function(r) {
        toast(r.status === 'success' ? 'success' : 'error', r.message);
        if (r.status !== 'success') el.checked = !el.checked;
    });
}

function deleteRecord(id) {
    Swal.fire({
        title: 'Hapus Testimoni?',
        text: 'Data yang dihapus tidak dapat dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: BASE + 'admin/testimoni/hapus/' + id,
                method: 'POST',
                data: { _method: 'DELETE', [csrf_token_name()]: CSRF_TOKEN },
                success: function(r) {
                    if (r.status === 'success') {
                        $('#row-' + id).fadeOut(400, function() { $(this).remove(); });
                        toast('success', r.message);
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: r.message });
                    }
                }
            });
        }
    });
}

function csrf_token_name() { return '<?= csrf_token() ?>'; }

function toast(icon, text) {
    Swal.fire({ toast: true, position: 'top-end', icon: icon, title: text, showConfirmButton: false, timer: 2000 });
}
</script>

<?= $this->endSection() ?>
