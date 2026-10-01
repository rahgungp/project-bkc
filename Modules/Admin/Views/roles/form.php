<?php $this->extend('Modules\Admin\Views\layout\main') ?>
<?php $this->section('content') ?>

<?php
$isEdit     = $isEdit ?? false;
$role       = $role ?? null;
$formAction = $isEdit
    ? base_url('admin/roles/update/' . $role['id'])
    : base_url('admin/roles/simpan');
$currentPerms = is_array($role['permissions'] ?? null) ? $role['permissions'] : [];

// Group permissions by module
$groups = [];
foreach ($availablePermissions as $key => $label) {
    $parts   = explode('.', $key);
    $group   = $parts[0];
    $groups[$group][$key] = $label;
}
$groupLabels = [
    'dashboard'    => 'Dashboard',
    'training'     => 'Pelatihan',
    'news'         => 'Berita',
    'registration' => 'Pendaftaran',
    'gallery'      => 'Galeri',
    'testimonial'  => 'Testimoni',
    'faq'          => 'FAQ',
    'profile'      => 'Profil',
    'user'         => 'User',
    'role'         => 'Role',
    'settings'     => 'Pengaturan',
    'log'          => 'Log Aktivitas',
];
?>

<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="page-title mb-1">
            <i class="fas fa-<?= $isEdit ? 'edit' : 'plus-circle' ?> me-2 text-gold"></i>
            <?= $isEdit ? 'Edit Role' : 'Tambah Role' ?>
        </h4>
        <p class="text-muted mb-0 small"><?= $isEdit ? 'Perbarui role dan permission' : 'Buat role baru dengan permission tertentu' ?></p>
    </div>
    <a href="<?= base_url('admin/roles') ?>" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<?php if (session()->getFlashdata('errors')): ?>
<div class="alert alert-danger alert-dismissible fade show">
    <i class="fas fa-exclamation-triangle me-2"></i><strong>Perhatikan kesalahan:</strong>
    <ul class="mb-0 mt-1">
        <?php foreach ((array) session()->getFlashdata('errors') as $err): ?>
        <li><?= esc($err) ?></li>
        <?php endforeach; ?>
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<form action="<?= $formAction ?>" method="POST" id="roleForm">
    <?= csrf_field() ?>

    <div class="row g-4">
        <!-- Role Details -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h6 class="mb-0 fw-semibold"><i class="fas fa-info-circle me-2"></i>Detail Role</h6>
                </div>
                <div class="card-body p-4">
                    <!-- Name -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Role <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="roleName" class="form-control"
                               placeholder="Contoh: Editor"
                               value="<?= old('name', $role['name'] ?? '') ?>" required>
                    </div>

                    <!-- Slug -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Slug <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-link"></i></span>
                            <input type="text" name="slug" id="roleSlug" class="form-control"
                                   placeholder="editor"
                                   value="<?= old('slug', $role['slug'] ?? '') ?>" required>
                        </div>
                        <div class="form-text text-muted">Auto-generate dari nama. Hanya huruf kecil, angka, dan tanda hubung.</div>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3"
                                  placeholder="Deskripsi singkat tentang role ini..."><?= old('description', $role['description'] ?? '') ?></textarea>
                    </div>

                    <!-- Is Active -->
                    <div class="mb-0">
                        <label class="form-label fw-semibold d-block">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active"
                                   id="isActiveSwitch" role="switch"
                                   <?= old('is_active', $role['is_active'] ?? 1) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="isActiveSwitch" id="activeLabel">
                                <?= old('is_active', $role['is_active'] ?? 1) ? 'Aktif' : 'Nonaktif' ?>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top d-flex gap-2 justify-content-end py-3">
                    <a href="<?= base_url('admin/roles') ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-gold">
                        <i class="fas fa-save me-1"></i>
                        <?= $isEdit ? 'Perbarui Role' : 'Simpan Role' ?>
                    </button>
                </div>
            </div>
        </div>

        <!-- Permissions -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center py-3">
                    <h6 class="mb-0 fw-semibold"><i class="fas fa-key me-2"></i>Permissions</h6>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-outline-success" id="selectAllPerms">
                            <i class="fas fa-check-double me-1"></i>Pilih Semua
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="clearAllPerms">
                            <i class="fas fa-times me-1"></i>Hapus Semua
                        </button>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <?php foreach ($groups as $groupKey => $groupPerms): ?>
                        <div class="col-md-6">
                            <div class="permission-group p-3 rounded border">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0 fw-semibold text-gold small">
                                        <i class="fas fa-folder me-1"></i>
                                        <?= esc($groupLabels[$groupKey] ?? ucfirst($groupKey)) ?>
                                    </h6>
                                    <button type="button" class="btn btn-link btn-sm p-0 text-muted select-group-btn"
                                            data-group="<?= $groupKey ?>">Pilih semua</button>
                                </div>
                                <?php foreach ($groupPerms as $permKey => $permLabel): ?>
                                <div class="form-check mb-1">
                                    <input class="form-check-input perm-checkbox perm-group-<?= $groupKey ?>"
                                           type="checkbox"
                                           name="permissions[]"
                                           value="<?= $permKey ?>"
                                           id="perm_<?= str_replace('.', '_', $permKey) ?>"
                                           <?= in_array($permKey, $currentPerms) ? 'checked' : '' ?>>
                                    <label class="form-check-label small" for="perm_<?= str_replace('.', '_', $permKey) ?>">
                                        <?= esc($permLabel) ?>
                                    </label>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-3 p-3 bg-light rounded">
                        <i class="fas fa-info-circle text-muted me-1"></i>
                        <small class="text-muted">
                            Pilih permission yang akan diberikan kepada role ini.
                            Izin akan diterapkan pada semua user dengan role ini.
                        </small>
                    </div>
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
.permission-group { background: rgba(248,249,250,0.5); border-color: #dee2e6 !important; }
.permission-group:hover { border-color: #C8A34D !important; }
</style>

<script>
$(function () {
    // Auto-generate slug from name
    $('#roleName').on('input', function () {
        if (!$('#roleSlug').data('manual')) {
            const slug = $(this).val()
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .trim()
                .replace(/\s+/g, '-');
            $('#roleSlug').val(slug);
        }
    });

    $('#roleSlug').on('input', function () {
        $(this).data('manual', true);
        $(this).val($(this).val().toLowerCase().replace(/[^a-z0-9-]/g, ''));
    });

    // Select all permissions
    $('#selectAllPerms').on('click', function () {
        $('.perm-checkbox').prop('checked', true);
    });

    // Clear all permissions
    $('#clearAllPerms').on('click', function () {
        $('.perm-checkbox').prop('checked', false);
    });

    // Select group
    $(document).on('click', '.select-group-btn', function () {
        const group    = $(this).data('group');
        const $boxes   = $('.perm-group-' + group);
        const allCheck = $boxes.filter(':checked').length === $boxes.length;
        $boxes.prop('checked', !allCheck);
        $(this).text(allCheck ? 'Pilih semua' : 'Hapus semua');
    });

    // Active label
    $('#isActiveSwitch').on('change', function () {
        $('#activeLabel').text($(this).is(':checked') ? 'Aktif' : 'Nonaktif');
    });
});
</script>

<?php $this->endSection() ?>
