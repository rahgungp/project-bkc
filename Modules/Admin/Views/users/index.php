<?php $this->extend('Modules\Admin\Views\layout\main') ?>
<?php $this->section('content') ?>

<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="page-title mb-1"><i class="fas fa-users-cog me-2 text-gold"></i>User Management</h4>
        <p class="text-muted mb-0 small">Kelola akun pengguna admin panel</p>
    </div>
    <a href="<?= base_url('admin/users/tambah') ?>" class="btn btn-gold">
        <i class="fas fa-plus me-1"></i> Tambah User
    </a>
</div>

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card border-0">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-gold-soft text-gold"><i class="fas fa-users"></i></div>
                <div>
                    <div class="stat-value"><?= count($users) ?></div>
                    <div class="stat-label">Total User</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card border-0">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-success-soft text-success"><i class="fas fa-user-check"></i></div>
                <div>
                    <div class="stat-value"><?= count(array_filter($users, fn($u) => $u['is_active'])) ?></div>
                    <div class="stat-label">User Aktif</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center py-3">
        <h6 class="mb-0 fw-semibold"><i class="fas fa-list me-2"></i>Daftar User</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="usersTable" class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th width="50">No</th>
                        <th>User</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Last Login</th>
                        <th>Login Attempts</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-users fa-3x mb-3 d-block opacity-25"></i>
                            Belum ada user terdaftar.
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($users as $i => $user): ?>
                    <tr id="user-row-<?= $user['id'] ?>">
                        <td class="text-muted small"><?= $i + 1 ?></td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <?php if (!empty($user['avatar'])): ?>
                                    <img src="<?= base_url('uploads/' . esc($user['avatar'])) ?>"
                                         alt="<?= esc($user['name']) ?>"
                                         class="rounded-circle"
                                         style="width:40px;height:40px;object-fit:cover;">
                                <?php else: ?>
                                    <div class="avatar-circle-sm bg-gold text-white">
                                        <?= strtoupper(substr($user['name'], 0, 1)) ?>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <div class="fw-semibold"><?= esc($user['name']) ?></div>
                                    <div class="text-muted small"><?= esc($user['email']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php
                            $roleColors = [
                                'super-admin' => 'danger',
                                'admin'       => 'primary',
                                'editor'      => 'info',
                                'staff'       => 'secondary',
                            ];
                            $roleColor = $roleColors[$user['role_slug'] ?? ''] ?? 'secondary';
                            ?>
                            <span class="badge bg-<?= $roleColor ?>">
                                <?= esc($user['role_name'] ?? 'No Role') ?>
                            </span>
                        </td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input toggle-active"
                                       type="checkbox"
                                       role="switch"
                                       data-id="<?= $user['id'] ?>"
                                       <?= $user['is_active'] ? 'checked' : '' ?>
                                       <?= ((int) session()->get('admin_id') === (int) $user['id']) ? 'disabled' : '' ?>>
                            </div>
                        </td>
                        <td class="small text-muted">
                            <?= $user['last_login'] ? date('d/m/Y H:i', strtotime($user['last_login'])) : '<span class="text-muted">—</span>' ?>
                        </td>
                        <td>
                            <?php if ($user['login_attempts'] > 0): ?>
                                <span class="badge <?= $user['login_attempts'] >= 5 ? 'bg-danger' : 'bg-warning text-dark' ?>">
                                    <?= $user['login_attempts'] ?>x
                                </span>
                            <?php else: ?>
                                <span class="text-muted small">0</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?= base_url('admin/users/edit/' . $user['id']) ?>"
                                   class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button"
                                        class="btn btn-sm btn-outline-warning btn-reset-password"
                                        data-id="<?= $user['id'] ?>"
                                        data-name="<?= esc($user['name']) ?>"
                                        title="Reset Password">
                                    <i class="fas fa-key"></i>
                                </button>
                                <?php if ((int) session()->get('admin_id') !== (int) $user['id']): ?>
                                <button type="button"
                                        class="btn btn-sm btn-outline-danger btn-delete-user"
                                        data-id="<?= $user['id'] ?>"
                                        data-name="<?= esc($user['name']) ?>"
                                        title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if (isset($pager)): ?>
    <div class="card-footer bg-transparent border-top">
        <?= $pager->links('default', 'bootstrap_full') ?>
    </div>
    <?php endif; ?>
</div>

<style>
.avatar-circle-sm {
    width: 40px; height: 40px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; font-weight: 700; flex-shrink: 0;
}
.text-gold { color: #C8A34D !important; }
.bg-gold   { background-color: #C8A34D !important; }
.btn-gold  { background-color: #C8A34D; border-color: #C8A34D; color: #fff; font-weight: 600; }
.btn-gold:hover { background-color: #b8922d; border-color: #b8922d; color: #fff; }
.bg-gold-soft { background: rgba(200,163,77,0.12); }
.bg-success-soft { background: rgba(25,135,84,0.12); }
.stat-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
.stat-value { font-size: 1.6rem; font-weight: 700; line-height: 1; }
.stat-label { font-size: 0.78rem; color: #6c757d; }
</style>

<script>
$(function () {
    // DataTables init
    $('#usersTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
        },
        order: [],
        columnDefs: [{ orderable: false, targets: [0, 3, 6] }],
        pageLength: 20,
    });

    // Toggle Active
    $(document).on('change', '.toggle-active', function () {
        const id     = $(this).data('id');
        const $self  = $(this);

        $.post('<?= base_url('admin/users/toggle-active') ?>/' + id, {
            [csrf_token]: csrf_hash,
        }, function (res) {
            if (res.success) {
                Swal.fire({ icon: 'success', title: res.message, timer: 1500, showConfirmButton: false });
            } else {
                $self.prop('checked', !$self.prop('checked'));
                Swal.fire({ icon: 'error', title: 'Gagal', text: res.message });
            }
        }).fail(function () {
            $self.prop('checked', !$self.prop('checked'));
        });
    });

    // Reset Password
    $(document).on('click', '.btn-reset-password', function () {
        const id   = $(this).data('id');
        const name = $(this).data('name');

        Swal.fire({
            title: 'Reset Password',
            html: `Reset password untuk <strong>${name}</strong>?<br><small class="text-muted">Password sementara akan digenerate secara otomatis.</small>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#C8A34D',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Reset',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('<?= base_url('admin/users/reset-password') ?>/' + id, {
                    [csrf_token]: csrf_hash,
                }, function (res) {
                    if (res.success) {
                        Swal.fire({
                            title: 'Password Baru',
                            html: `
                                <p>Password sementara untuk <strong>${name}</strong>:</p>
                                <div class="input-group mt-2">
                                    <input type="text" id="tempPassInput" class="form-control text-center fw-bold"
                                           value="${res.password}" readonly>
                                    <button class="btn btn-outline-secondary" onclick="copyTempPass()">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                                <p class="mt-3 small text-muted">Salin dan bagikan kepada user. Minta user segera mengganti password.</p>
                            `,
                            icon: 'success',
                            confirmButtonColor: '#C8A34D',
                            confirmButtonText: 'Tutup',
                        });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: res.message });
                    }
                });
            }
        });
    });

    // Delete User
    $(document).on('click', '.btn-delete-user', function () {
        const id   = $(this).data('id');
        const name = $(this).data('name');

        Swal.fire({
            title: 'Hapus User',
            html: `Hapus user <strong>${name}</strong>?<br><small class="text-muted">Data tidak dapat dikembalikan.</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url:  '<?= base_url('admin/users/hapus') ?>/' + id,
                    type: 'DELETE',
                    data: { [csrf_token]: csrf_hash },
                    success: function (res) {
                        if (res.success) {
                            $('#user-row-' + id).fadeOut(400, function () { $(this).remove(); });
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

function copyTempPass() {
    const input = document.getElementById('tempPassInput');
    input.select();
    document.execCommand('copy');
    Swal.showValidationMessage('Disalin!');
}

// CSRF helpers
const csrf_token = '<?= csrf_token() ?>';
const csrf_hash  = '<?= csrf_hash() ?>';
</script>

<?php $this->endSection() ?>
