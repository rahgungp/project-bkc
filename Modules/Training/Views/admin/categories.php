<?= $this->extend('Modules\Admin\Views\layout\main') ?>
<?= $this->section('content') ?>

<div class="page-header d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
    <div>
        <h1 class="page-title mb-1">Kategori Pelatihan</h1>
        <p class="page-subtitle text-muted mb-0">Kelola kategori program pelatihan BKC</p>
    </div>
    <button class="btn fw-700" style="background:#C8A34D;color:#121212;border-radius:10px;padding:10px 20px;"
            onclick="openCatModal()">
        <i class="fas fa-plus me-2"></i>Tambah Kategori
    </button>
</div>

<div class="admin-card" data-aos="fade-up">
    <div class="admin-card-header">
        <h6 class="admin-card-title mb-0"><i class="fas fa-tags me-2"></i>Daftar Kategori</h6>
    </div>
    <div class="admin-card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="categoriesTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ikon</th>
                        <th>Nama Kategori</th>
                        <th>Slug</th>
                        <th>Urutan</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $i => $cat): ?>
                    <tr id="row-cat-<?= $cat['id'] ?>">
                        <td class="text-muted"><?= $i + 1 ?></td>
                        <td>
                            <div style="width:36px;height:36px;border-radius:8px;background:<?= esc($cat['color'] ?? '#C8A34D') ?>20;display:flex;align-items:center;justify-content:center;">
                                <i class="fas <?= esc($cat['icon'] ?? 'fa-book') ?>" style="color:<?= esc($cat['color'] ?? '#C8A34D') ?>;"></i>
                            </div>
                        </td>
                        <td>
                            <div class="fw-700"><?= esc($cat['name']) ?></div>
                        </td>
                        <td><code style="font-size:12px;"><?= esc($cat['slug']) ?></code></td>
                        <td><?= (int) $cat['sort_order'] ?></td>
                        <td class="text-center">
                            <span class="badge" style="background:<?= $cat['is_active'] ? 'rgba(25,135,84,.15)' : 'rgba(108,117,125,.15)' ?>;color:<?= $cat['is_active'] ? '#198754' : '#6c757d' ?>;">
                                <?= $cat['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                <button class="btn btn-sm" style="background:rgba(200,163,77,.1);color:#C8A34D;border-radius:8px;"
                                        onclick="editCat(<?= $cat['id'] ?>, <?= htmlspecialchars(json_encode($cat), ENT_QUOTES) ?>)"
                                        title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm" style="background:rgba(220,53,69,.1);color:#dc3545;border-radius:8px;"
                                        onclick="deleteCat(<?= $cat['id'] ?>, '<?= esc($cat['name'], 'js') ?>')"
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

<!-- Category Modal -->
<div class="modal fade" id="catModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-700" id="catModalTitle">Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="catForm">
                    <?= csrf_field() ?>
                    <input type="hidden" id="catId" name="cat_id">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-600">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="catName" class="form-control" placeholder="Manajemen SDM" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-600">Ikon Font Awesome</label>
                            <input type="text" name="icon" id="catIcon" class="form-control" placeholder="fa-book">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-600">Warna</label>
                            <input type="color" name="color" id="catColor" class="form-control form-control-color w-100" value="#C8A34D">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Deskripsi</label>
                            <textarea name="description" id="catDescription" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-600">Urutan</label>
                            <input type="number" name="sort_order" id="catSortOrder" class="form-control" value="0" min="0">
                        </div>
                        <div class="col-6 d-flex align-items-end pb-1">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="catIsActive" value="1" checked>
                                <label class="form-check-label fw-600" for="catIsActive">Aktif</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn px-4" style="border:1.5px solid #e5e7eb;border-radius:10px;" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn px-4 fw-700" style="background:#C8A34D;color:#121212;border-radius:10px;" onclick="saveCat()">
                    <i class="fas fa-save me-2"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->section('extra_js') ?>
<script>
$(function() {
    $('#categoriesTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json' },
        order: [[4, 'asc']],
        columnDefs: [{ orderable: false, targets: [1, 5, 6] }],
    });
});

let catModal = null;

function openCatModal() {
    resetCatForm();
    document.getElementById('catModalTitle').textContent = 'Tambah Kategori';
    if (!catModal) catModal = new bootstrap.Modal(document.getElementById('catModal'));
    catModal.show();
}

function editCat(id, data) {
    resetCatForm();
    document.getElementById('catModalTitle').textContent = 'Edit Kategori';
    document.getElementById('catId').value          = id;
    document.getElementById('catName').value         = data.name || '';
    document.getElementById('catIcon').value         = data.icon || 'fa-book';
    document.getElementById('catColor').value        = data.color || '#C8A34D';
    document.getElementById('catDescription').value  = data.description || '';
    document.getElementById('catSortOrder').value    = data.sort_order || 0;
    document.getElementById('catIsActive').checked   = !!parseInt(data.is_active);
    if (!catModal) catModal = new bootstrap.Modal(document.getElementById('catModal'));
    catModal.show();
}

function resetCatForm() {
    document.getElementById('catForm').reset();
    document.getElementById('catId').value = '';
    document.getElementById('catIsActive').checked = true;
    document.getElementById('catColor').value = '#C8A34D';
}

function saveCat() {
    const id  = document.getElementById('catId').value;
    const url = id
        ? '<?= base_url('admin/kategori-pelatihan/update') ?>/' + id
        : '<?= base_url('admin/kategori-pelatihan/simpan') ?>';

    const fd = new FormData(document.getElementById('catForm'));
    if (!fd.get('is_active')) fd.set('is_active', '0');

    $.ajax({
        url: url,
        method: 'POST',
        data: fd,
        processData: false,
        contentType: false,
        success: function(res) {
            if (res.status === 'success') {
                catModal.hide();
                Swal.fire({ title: 'Berhasil!', text: res.message, icon: 'success', timer: 1500, showConfirmButton: false })
                    .then(() => location.reload());
            } else {
                Swal.fire('Gagal', res.message || 'Terjadi kesalahan.', 'error');
            }
        },
        error: function() { Swal.fire('Error', 'Terjadi kesalahan server.', 'error'); },
    });
}

function deleteCat(id, name) {
    Swal.fire({
        title: 'Hapus Kategori?',
        html: '<strong>' + name + '</strong> akan dihapus dari sistem.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',
    }).then(function(result) {
        if (!result.isConfirmed) return;
        $.ajax({
            url: '<?= base_url('admin/kategori-pelatihan/hapus') ?>/' + id,
            method: 'DELETE',
            success: function(res) {
                if (res.status === 'success') {
                    $('#row-cat-' + id).fadeOut(300, function() { $(this).remove(); });
                    Swal.fire({ title: 'Berhasil!', text: res.message, icon: 'success', timer: 1500, showConfirmButton: false });
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
