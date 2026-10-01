<?= $this->extend('Modules\Admin\Views\layout\main') ?>

<?= $this->section('content') ?>

<style>
.profile-card {
    background: white;
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
}
.avatar-wrap {
    position: relative;
    display: inline-block;
    margin-bottom: 20px;
}
.avatar-img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--primary-color, #C8A34D);
}
.avatar-placeholder {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, #1E4FA3, #C8A34D);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.2rem;
    font-weight: 700;
    color: white;
    border: 3px solid var(--primary-color, #C8A34D);
}
.form-section-title {
    font-size: 1rem;
    font-weight: 700;
    color: #1a202c;
    margin-bottom: 16px;
    padding-bottom: 8px;
    border-bottom: 2px solid #f1f5f9;
}
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Profil Saya</h4>
        <p class="text-muted mb-0">Kelola informasi akun dan keamanan Anda.</p>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
    <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="row g-4">
    <!-- Profile Info -->
    <div class="col-lg-8">
        <div class="profile-card">
            <h6 class="form-section-title">Informasi Akun</h6>
            <form action="<?= site_url('admin/profil/update') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="text-center mb-4">
                    <div class="avatar-wrap">
                        <?php $adminName = session()->get('admin_name') ?? 'Admin'; ?>
                        <?php if (!empty(session()->get('admin_photo'))): ?>
                        <img src="<?= base_url('uploads/users/' . session()->get('admin_photo')) ?>" class="avatar-img" alt="Photo">
                        <?php else: ?>
                        <div class="avatar-placeholder"><?= mb_strtoupper(mb_substr($adminName, 0, 1)) ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mt-2">
                        <label class="btn btn-sm btn-outline-secondary" style="border-radius:50px;cursor:pointer;">
                            <i class="fas fa-camera me-1"></i>Ganti Foto
                            <input type="file" name="photo" accept="image/*" style="display:none;" onchange="previewAvatar(this)">
                        </label>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-600">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="<?= esc($adminName) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-600">Email</label>
                        <input type="email" class="form-control" value="<?= esc(session()->get('admin_email') ?? '') ?>" readonly style="background:#f8fafc;">
                        <small class="text-muted">Email tidak dapat diubah di sini.</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-600">Role</label>
                        <input type="text" class="form-control" value="<?= esc(session()->get('admin_role') ?? '') ?>" readonly style="background:#f8fafc;">
                    </div>
                </div>

                <hr class="my-4">
                <h6 class="form-section-title">Ganti Password</h6>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-600">Password Lama</label>
                        <div class="input-group">
                            <input type="password" name="current_password" class="form-control" id="curPass">
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePw('curPass')"><i class="fas fa-eye"></i></button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-600">Password Baru</label>
                        <div class="input-group">
                            <input type="password" name="new_password" class="form-control" id="newPass" minlength="8">
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePw('newPass')"><i class="fas fa-eye"></i></button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-600">Konfirmasi Password</label>
                        <div class="input-group">
                            <input type="password" name="confirm_password" class="form-control" id="confPass">
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePw('confPass')"><i class="fas fa-eye"></i></button>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Info Sidebar -->
    <div class="col-lg-4">
        <div class="profile-card mb-4">
            <h6 class="form-section-title">Info Sesi</h6>
            <div class="d-flex flex-column gap-3">
                <div>
                    <div class="text-muted" style="font-size:0.8rem;">Login sebagai</div>
                    <div class="fw-700"><?= esc($adminName) ?></div>
                </div>
                <div>
                    <div class="text-muted" style="font-size:0.8rem;">Role</div>
                    <span class="badge" style="background:rgba(200,163,77,0.15);color:#C8A34D;font-size:0.85rem;"><?= esc(session()->get('admin_role') ?? 'Admin') ?></span>
                </div>
                <div>
                    <div class="text-muted" style="font-size:0.8rem;">Terakhir Login</div>
                    <div class="fw-600" style="font-size:0.9rem;"><?= esc(session()->get('admin_last_login') ?? '-') ?></div>
                </div>
            </div>
        </div>

        <div class="profile-card">
            <h6 class="form-section-title">Keamanan</h6>
            <p class="text-muted" style="font-size:0.85rem;">Tips keamanan akun:</p>
            <ul class="list-unstyled" style="font-size:0.85rem;">
                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Gunakan password minimal 8 karakter</li>
                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Kombinasikan huruf besar, kecil, angka</li>
                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Jangan bagikan password ke orang lain</li>
                <li><i class="fas fa-check-circle text-success me-2"></i>Logout setelah selesai bekerja</li>
            </ul>
            <a href="<?= site_url('admin/logout') ?>" class="btn btn-danger btn-sm w-100 mt-2">
                <i class="fas fa-sign-out-alt me-2"></i>Logout Sekarang
            </a>
        </div>
    </div>
</div>

<script>
function togglePw(id) {
    const el = document.getElementById(id);
    el.type = el.type === 'password' ? 'text' : 'password';
}
function previewAvatar(input) {
    if (!input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const placeholder = document.querySelector('.avatar-placeholder');
        const img = document.querySelector('.avatar-img');
        if (placeholder) {
            const newImg = document.createElement('img');
            newImg.src = e.target.result;
            newImg.className = 'avatar-img';
            newImg.alt = 'Photo';
            placeholder.replaceWith(newImg);
        } else if (img) {
            img.src = e.target.result;
        }
    };
    reader.readAsDataURL(input.files[0]);
}
</script>

<?= $this->endSection() ?>
