<?php $this->extend('Modules\Admin\Views\layout\main') ?>
<?php $this->section('content') ?>

<?php
$isEdit     = $isEdit ?? false;
$user       = $user ?? null;
$formAction = $isEdit
    ? base_url('admin/users/update/' . $user['id'])
    : base_url('admin/users/simpan');
?>

<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="page-title mb-1">
            <i class="fas fa-<?= $isEdit ? 'user-edit' : 'user-plus' ?> me-2 text-gold"></i>
            <?= $isEdit ? 'Edit User' : 'Tambah User' ?>
        </h4>
        <p class="text-muted mb-0 small"><?= $isEdit ? 'Perbarui data pengguna' : 'Buat akun admin baru' ?></p>
    </div>
    <a href="<?= base_url('admin/users') ?>" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<!-- Error alert -->
<?php if (session()->getFlashdata('errors')): ?>
<div class="alert alert-danger alert-dismissible fade show">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <strong>Perhatikan kesalahan berikut:</strong>
    <ul class="mb-0 mt-1">
        <?php foreach ((array) session()->getFlashdata('errors') as $err): ?>
        <li><?= esc($err) ?></li>
        <?php endforeach; ?>
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<form action="<?= $formAction ?>" method="POST" enctype="multipart/form-data" id="userForm">
    <?= csrf_field() ?>

    <div class="row g-4">
        <!-- Left: Photo -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm text-center p-4">
                <div class="mb-3">
                    <div id="photoPreviewWrapper" class="mx-auto" style="width:130px;height:130px;position:relative;">
                        <?php if ($isEdit && !empty($user['avatar'])): ?>
                            <img id="photoPreview"
                                 src="<?= base_url('uploads/' . esc($user['avatar'])) ?>"
                                 class="rounded-circle w-100 h-100"
                                 style="object-fit:cover;border:3px solid #C8A34D;" alt="Avatar">
                        <?php else: ?>
                            <div id="photoPlaceholder"
                                 class="rounded-circle bg-gold text-white d-flex align-items-center justify-content-center mx-auto"
                                 style="width:130px;height:130px;font-size:50px;border:3px solid #C8A34D;">
                                <i class="fas fa-user"></i>
                            </div>
                            <img id="photoPreview" src="" class="rounded-circle w-100 h-100"
                                 style="object-fit:cover;border:3px solid #C8A34D;display:none;" alt="Preview">
                        <?php endif; ?>
                        <label for="photoInput"
                               class="position-absolute bottom-0 end-0 bg-gold rounded-circle d-flex align-items-center justify-content-center"
                               style="width:32px;height:32px;cursor:pointer;border:2px solid #fff;" title="Ganti Foto">
                            <i class="fas fa-camera text-white" style="font-size:12px;"></i>
                        </label>
                    </div>
                    <input type="file" id="photoInput" name="photo" accept="image/*" class="d-none">
                </div>
                <p class="text-muted small mb-0">Format: JPG, PNG, GIF<br>Maks: 2 MB</p>
                <?php if ($isEdit && !empty($user['avatar'])): ?>
                <button type="button" class="btn btn-sm btn-outline-danger mt-2" id="removePhoto">
                    <i class="fas fa-times me-1"></i>Hapus Foto
                </button>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right: Form Fields -->
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h6 class="mb-0 fw-semibold"><i class="fas fa-info-circle me-2"></i>Informasi Akun</h6>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <!-- Name -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control"
                                   placeholder="Nama lengkap"
                                   value="<?= old('name', $user['name'] ?? '') ?>" required>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control"
                                   placeholder="email@domain.com"
                                   value="<?= old('email', $user['email'] ?? '') ?>"
                                   <?= $isEdit ? 'readonly' : 'required' ?>>
                            <?php if ($isEdit): ?>
                            <div class="form-text text-muted"><i class="fas fa-lock me-1"></i>Email tidak dapat diubah.</div>
                            <?php endif; ?>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Password <?= $isEdit ? '' : '<span class="text-danger">*</span>' ?>
                            </label>
                            <div class="input-group">
                                <input type="password" name="password" id="passwordInput" class="form-control"
                                       placeholder="<?= $isEdit ? 'Kosongkan jika tidak ingin mengubah' : 'Min. 8 karakter' ?>"
                                       <?= $isEdit ? '' : 'required' ?> minlength="8">
                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="passwordInput">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <!-- Strength Indicator -->
                            <div class="mt-2" id="strengthWrapper" style="display:none;">
                                <div class="d-flex gap-1 mb-1">
                                    <div class="strength-bar flex-fill rounded" id="s1" style="height:4px;"></div>
                                    <div class="strength-bar flex-fill rounded" id="s2" style="height:4px;"></div>
                                    <div class="strength-bar flex-fill rounded" id="s3" style="height:4px;"></div>
                                    <div class="strength-bar flex-fill rounded" id="s4" style="height:4px;"></div>
                                </div>
                                <div id="strengthText" class="form-text"></div>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Konfirmasi Password <?= $isEdit ? '' : '<span class="text-danger">*</span>' ?>
                            </label>
                            <div class="input-group">
                                <input type="password" name="password_confirm" id="passwordConfirmInput" class="form-control"
                                       placeholder="Ulangi password" <?= $isEdit ? '' : 'required' ?>>
                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="passwordConfirmInput">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div id="passMatchMsg" class="form-text"></div>
                        </div>

                        <!-- Role -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
                            <select name="role_id" class="form-select" required>
                                <option value="">— Pilih Role —</option>
                                <?php foreach ($roles as $role): ?>
                                <option value="<?= $role['id'] ?>"
                                    <?= (old('role_id', $user['role_id'] ?? '') == $role['id']) ? 'selected' : '' ?>>
                                    <?= esc($role['name']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Is Active -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status</label>
                            <div class="d-flex align-items-center gap-3 mt-1">
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" name="is_active"
                                           id="isActiveSwitch" role="switch"
                                           <?= old('is_active', $user['is_active'] ?? 1) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="isActiveSwitch">
                                        <span id="activeLabel">
                                            <?= old('is_active', $user['is_active'] ?? 1) ? 'Aktif' : 'Nonaktif' ?>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Buttons -->
                <div class="card-footer bg-transparent border-top d-flex gap-2 justify-content-end py-3">
                    <a href="<?= base_url('admin/users') ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-gold">
                        <i class="fas fa-save me-1"></i>
                        <?= $isEdit ? 'Perbarui User' : 'Simpan User' ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<style>
.text-gold { color: #C8A34D !important; }
.bg-gold   { background-color: #C8A34D !important; }
.btn-gold  { background-color: #C8A34D; border-color: #C8A34D; color: #fff; font-weight: 600; }
.btn-gold:hover { background-color: #b8922d; border-color: #b8922d; color: #fff; }
</style>

<script>
$(function () {
    // Photo preview
    $('#photoInput').on('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            $('#photoPlaceholder').hide();
            $('#photoPreview').attr('src', e.target.result).show();
        };
        reader.readAsDataURL(file);
    });

    // Remove photo
    $('#removePhoto').on('click', function () {
        $('#photoPreview').attr('src', '').hide();
        $('#photoPlaceholder').show();
        $('#photoInput').val('');
    });

    // Toggle password visibility
    $(document).on('click', '.toggle-password', function () {
        const target = $('#' + $(this).data('target'));
        const isText = target.attr('type') === 'text';
        target.attr('type', isText ? 'password' : 'text');
        $(this).find('i').toggleClass('fa-eye fa-eye-slash');
    });

    // Password strength
    $('#passwordInput').on('input', function () {
        const val = $(this).val();
        if (!val) { $('#strengthWrapper').hide(); return; }
        $('#strengthWrapper').show();

        let score = 0;
        if (val.length >= 8)              score++;
        if (/[A-Z]/.test(val))            score++;
        if (/[0-9]/.test(val))            score++;
        if (/[^A-Za-z0-9]/.test(val))     score++;

        const colors = ['#dc3545', '#fd7e14', '#ffc107', '#198754'];
        const labels = ['Sangat Lemah', 'Lemah', 'Cukup Kuat', 'Kuat'];

        for (let i = 1; i <= 4; i++) {
            $('#s' + i).css('background-color', i <= score ? colors[score - 1] : '#dee2e6');
        }
        $('#strengthText').text(labels[score - 1] || '').css('color', colors[score - 1] || '#6c757d');
    });

    // Password match
    $('#passwordConfirmInput').on('input', function () {
        const pass    = $('#passwordInput').val();
        const confirm = $(this).val();
        if (!confirm) { $('#passMatchMsg').text(''); return; }
        if (pass === confirm) {
            $('#passMatchMsg').html('<span class="text-success"><i class="fas fa-check me-1"></i>Password cocok</span>');
        } else {
            $('#passMatchMsg').html('<span class="text-danger"><i class="fas fa-times me-1"></i>Password tidak cocok</span>');
        }
    });

    // Active label update
    $('#isActiveSwitch').on('change', function () {
        $('#activeLabel').text($(this).is(':checked') ? 'Aktif' : 'Nonaktif');
    });
});
</script>

<?php $this->endSection() ?>
