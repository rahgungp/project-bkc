<?= $this->extend('Modules\Admin\Views\layout\main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1 class="page-title">Edit Peserta</h1>
        <p class="page-subtitle">Perbarui informasi data peserta</p>
    </div>
    <div class="page-actions">
        <a href="<?= base_url('admin/peserta/detail/' . $participant['id']) ?>" class="btn btn-outline-secondary" style="border-radius:10px; padding:8px 18px; font-size:13px;">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('error')): ?>
<div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i><?= esc(session()->getFlashdata('error')) ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('errors')): ?>
<div class="alert alert-danger">
    <?php foreach ((array) session()->getFlashdata('errors') as $err): ?>
    <div><i class="fas fa-times-circle me-1"></i><?= esc($err) ?></div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<div class="admin-card" data-aos="fade-up">
    <div class="admin-card-header">
        <h6 class="admin-card-title"><i class="fas fa-user-edit me-2"></i>Form Edit Peserta</h6>
    </div>
    <div class="admin-card-body">
        <form action="<?= base_url('admin/peserta/update/' . $participant['id']) ?>" method="POST">
            <?= csrf_field() ?>

            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label fw-600">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control"
                           value="<?= esc(old('name', $participant['name'])) ?>"
                           required minlength="2" maxlength="200">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-600">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control"
                           value="<?= esc(old('email', $participant['email'])) ?>"
                           required maxlength="200">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-600">No. Telepon / HP</label>
                    <input type="tel" name="phone" class="form-control"
                           value="<?= esc(old('phone', $participant['phone'])) ?>"
                           maxlength="20">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-600">Jabatan / Posisi</label>
                    <input type="text" name="position" class="form-control"
                           value="<?= esc(old('position', $participant['position'])) ?>"
                           maxlength="200">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-600">Instansi / Organisasi</label>
                    <input type="text" name="institution" class="form-control"
                           value="<?= esc(old('institution', $participant['institution'])) ?>"
                           maxlength="200">
                </div>

                <div class="col-12">
                    <label class="form-label fw-600">Alamat</label>
                    <textarea name="address" class="form-control" rows="3" maxlength="500"><?= esc(old('address', $participant['address'])) ?></textarea>
                </div>

                <div class="col-12 d-flex gap-3 justify-content-end">
                    <a href="<?= base_url('admin/peserta/detail/' . $participant['id']) ?>"
                       class="btn btn-outline-secondary" style="border-radius:10px; padding:10px 24px;">
                        Batal
                    </a>
                    <button type="submit" class="btn" style="background:#C8A34D; color:#121212; font-weight:700; border-radius:10px; padding:10px 28px; border:none;">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
