<?php $this->extend('Modules\Admin\Views\layout\main') ?>
<?php $this->section('content') ?>

<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="page-title mb-1"><i class="fas fa-shield-alt me-2 text-gold"></i>Role Management</h4>
        <p class="text-muted mb-0 small">Kelola hak akses dan permission pengguna</p>
    </div>
    <a href="<?= base_url('admin/roles/tambah') ?>" class="btn btn-gold">
        <i class="fas fa-plus me-1"></i> Tambah Role
    </a>
</div>

<!-- Roles Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center py-3">
        <h6 class="mb-0 fw-semibold"><i class="fas fa-list me-2"></i>Daftar Role</h6>
        <span class="badge bg-gold-soft text-gold"><?= count($roles) ?> Role</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="rolesTable" class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Role</th>
                        <th>Slug</th>
                        <th>User</th>
                        <th>Permissions</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th width="130">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($roles)): ?>
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fas fa-shield-alt fa-3x mb-3 d-block opacity-25"></i>
                            Belum ada role yang dibuat.
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($roles as $i => $role): ?>
                    <?php
                    $perms      = json_decode($role['permissions'] ?? '[]', true) ?: [];
                    $permLabels = [];
                    foreach ($perms as $p) {
                        $permLabels[] = $availablePermissions[$p] ?? $p;
                    }
                    $maxShow   = 4;
                    $showPerms = array_slice($permLabels, 0, $maxShow);
                    $extraCount = count($permLabels) - $maxShow;
                    ?>
                    <tr id="role-row-<?= $role['id'] ?>">
                        <td class="text-muted small"><?= $i + 1 ?></td>
                        <td>
                            <div class="fw-semibold"><?= esc($role['name']) ?></div>
                        </td>
                        <td>
                            <code class="small"><?= esc($role['slug']) ?></code>
                        </td>
                        <td>
                            <span class="badge bg-primary">
                                <i class="fas fa-users me-1"></i><?= (int) $role['user_count'] ?>
                            </span>
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-1">
                                <?php if (in_array('*', $perms)): ?>
                                    <span class="badge bg-danger">Super Admin (All)</span>
                                <?php elseif (empty($perms)): ?>
                                    <span class="text-muted small">—</span>
                                <?php else: ?>
                                    <?php foreach ($showPerms as $pl): ?>
                                    <span class="badge bg-secondary-soft text-dark" style="font-size:0.7rem;"><?= esc($pl) ?></span>
                                    <?php endforeach; ?>
                                    <?php if ($extraCount > 0): ?>
                                    <span class="badge bg-gold-soft text-gold" title="<?= esc(implode(', ', array_slice($permLabels, $maxShow))) ?>">+<?= $extraCount ?> lagi</span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="small text-muted">
                            <?= $role['description'] ? esc(mb_substr($role['description'], 0, 60)) . '…' : '—' ?>
                        </td>
                        <td>
                            <?php if ($role['is_active']): ?>
                                <span class="badge bg-success">Aktif</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?= base_url('admin/roles/edit/' . $role['id']) ?>"
                                   class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button"
                                        class="btn btn-sm btn-outline-danger btn-delete-role"
                                        data-id="<?= $role['id'] ?>"
                                        data-name="<?= esc($role['name']) ?>"
                                        data-users="<?= (int) $role['user_count'] ?>"
                                        title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.text-gold { color: #C8A34D !important; }
.bg-gold   { background-color: #C8A34D !important; }
.btn-gold  { background-color: #C8A34D; border-color: #C8A34D; color: #fff; font-weight: 600; }
.btn-gold:hover { background-color: #b8922d; border-color: #b8922d; color: #fff; }
.bg-gold-soft { background: rgba(200,163,77,0.12); }
.bg-secondary-soft { background: rgba(108,117,125,0.12); }
</style>

<script>
$(function () {
    $('#rolesTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json' },
        order: [],
        columnDefs: [{ orderable: false, targets: [4, 7] }],
    });

    $(document).on('click', '.btn-delete-role', function () {
        const id    = $(this).data('id');
        const name  = $(this).data('name');
        const users = $(this).data('users');

        if (users > 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Tidak Dapat Dihapus',
                html: `Role <strong>${name}</strong> masih digunakan oleh <strong>${users} user</strong>.<br>Ubah role user tersebut terlebih dahulu.`,
                confirmButtonColor: '#C8A34D',
            });
            return;
        }

        Swal.fire({
            title: 'Hapus Role',
            html: `Hapus role <strong>${name}</strong>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url:  '<?= base_url('admin/roles/hapus') ?>/' + id,
                    type: 'DELETE',
                    data: { [csrf_token]: csrf_hash },
                    success: function (res) {
                        if (res.success) {
                            $('#role-row-' + id).fadeOut(400, function () { $(this).remove(); });
                            Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer: 1800, showConfirmButton: false });
                        } else {
                            Swal.fire({ icon: 'error', title: 'Gagal', text: res.message });
                        }
                    },
                });
            }
        });
    });
});

const csrf_token = '<?= csrf_token() ?>';
const csrf_hash  = '<?= csrf_hash() ?>';
</script>

<?php $this->endSection() ?>
