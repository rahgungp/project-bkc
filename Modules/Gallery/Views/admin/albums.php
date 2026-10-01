<?= $this->extend('Modules\Admin\Views\layout\main') ?>
<?= $this->section('content') ?>

<div class="page-header d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
    <div>
        <h1 class="page-title mb-1">Manajemen Galeri</h1>
        <p class="page-subtitle text-muted mb-0">Kelola album foto dan video kegiatan BKC</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('admin/galeri/tambah') ?>" class="btn fw-700" style="background:var(--gold,#C8A34D);border-color:var(--gold,#C8A34D);color:#121212;border-radius:10px;padding:10px 20px;">
            <i class="fas fa-plus me-2"></i>Tambah Album
        </a>
    </div>
</div>

<div class="admin-card" data-aos="fade-up">
    <div class="admin-card-header d-flex align-items-center justify-content-between">
        <h6 class="admin-card-title mb-0"><i class="fas fa-images me-2"></i>Daftar Album</h6>
    </div>
    <div class="admin-card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="albumsTable">
                <thead>
                    <tr>
                        <th style="width:50px;">#</th>
                        <th>Cover</th>
                        <th>Nama Album</th>
                        <th>Slug</th>
                        <th class="text-center">Media</th>
                        <th class="text-center">Urutan</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($albums as $i => $album): ?>
                    <tr id="row-album-<?= $album['id'] ?>">
                        <td class="text-muted"><?= $i + 1 ?></td>
                        <td>
                            <?php $cover = $album['cover_image'] ?? $album['cover'] ?? null; ?>
                            <?php if ($cover): ?>
                            <img src="<?= base_url('uploads/gallery/' . esc($cover)) ?>"
                                 style="width:52px;height:40px;object-fit:cover;border-radius:8px;"
                                 alt=""
                                 onerror="this.outerHTML='<div style=\'width:52px;height:40px;background:rgba(200,163,77,0.15);border-radius:8px;display:flex;align-items:center;justify-content:center;\'><i class=\'fas fa-images\' style=\'color:#C8A34D;font-size:18px;\'></i></div>'">
                            <?php else: ?>
                            <div style="width:52px;height:40px;background:rgba(200,163,77,0.15);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-images" style="color:#C8A34D;font-size:18px;"></i>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="fw-600"><?= esc($album['name']) ?></div>
                            <?php if (!empty($album['description'])): ?>
                            <small class="text-muted"><?= esc(substr($album['description'], 0, 60)) ?><?= strlen($album['description']) > 60 ? '...' : '' ?></small>
                            <?php endif; ?>
                        </td>
                        <td><code style="font-size:12px;"><?= esc($album['slug']) ?></code></td>
                        <td class="text-center">
                            <a href="<?= base_url('admin/galeri/album/' . $album['id'] . '/media') ?>"
                               class="badge text-decoration-none"
                               style="background:rgba(30,79,163,0.15);color:#1E4FA3;padding:6px 14px;border-radius:20px;font-size:13px;font-weight:600;">
                                <i class="fas fa-images me-1"></i>
                                <?= (int) ($album['media_count'] ?? 0) ?>
                            </a>
                        </td>
                        <td class="text-center">
                            <input type="number"
                                   value="<?= (int) $album['sort_order'] ?>"
                                   min="0"
                                   style="width:65px;border:1px solid var(--border-color,#e5e7eb);border-radius:8px;padding:4px 8px;text-align:center;font-size:13px;"
                                   onchange="updateSortOrder(<?= $album['id'] ?>, this.value)">
                        </td>
                        <td class="text-center">
                            <div class="form-check form-switch d-flex justify-content-center mb-0">
                                <input class="form-check-input" type="checkbox" role="switch"
                                       id="active-<?= $album['id'] ?>"
                                       <?= $album['is_active'] ? 'checked' : '' ?>
                                       onchange="toggleActive(<?= $album['id'] ?>, this.checked)">
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="<?= base_url('admin/galeri/album/' . $album['id'] . '/media') ?>"
                                   class="btn btn-sm" style="background:rgba(30,79,163,0.1);color:#1E4FA3;border-radius:8px;" title="Kelola Media">
                                    <i class="fas fa-photo-video"></i>
                                </a>
                                <a href="<?= base_url('admin/galeri/album/edit/' . $album['id']) ?>"
                                   class="btn btn-sm" style="background:rgba(200,163,77,0.1);color:#C8A34D;border-radius:8px;" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm" style="background:rgba(220,53,69,0.1);color:#dc3545;border-radius:8px;"
                                        onclick="deleteAlbum(<?= $album['id'] ?>, '<?= esc($album['name'], 'js') ?>')" title="Hapus">
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

<?= $this->section('extra_js') ?>
<script>
$(function() {
    $('#albumsTable').DataTable({
        order: [[5, 'asc']],
        columnDefs: [
            { orderable: false, targets: [1, 6, 7] },
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
        },
    });
});

function toggleActive(id, isChecked) {
    $.post('<?= base_url('admin/galeri/album/toggle') ?>' , {
        id: id,
        is_active: isChecked ? 1 : 0,
        '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
    }).fail(function() {
        // Revert on failure
        document.getElementById('active-' + id).checked = !isChecked;
        Swal.fire('Gagal', 'Gagal mengubah status.', 'error');
    });
}

function updateSortOrder(id, value) {
    $.post('<?= base_url('admin/galeri/album/sort') ?>', {
        id: id,
        sort_order: value,
        '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
    });
}

function deleteAlbum(id, name) {
    Swal.fire({
        title: 'Hapus Album?',
        html: 'Album <strong>' + name + '</strong> dan semua medianya akan dihapus. Tindakan ini tidak bisa dibatalkan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
    }).then(function(result) {
        if (!result.isConfirmed) return;

        $.ajax({
            url: '<?= base_url('admin/galeri/album/hapus') ?>/' + id,
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(res) {
                if (res.success) {
                    $('#row-album-' + id).fadeOut(400, function() { $(this).remove(); });
                    Swal.fire({ title: 'Berhasil!', text: res.message, icon: 'success', timer: 2000, showConfirmButton: false });
                } else {
                    Swal.fire('Gagal', res.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Terjadi kesalahan saat menghapus album.', 'error');
            },
        });
    });
}
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
