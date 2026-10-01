<?= $this->extend('Modules\Admin\Views\layout\main') ?>
<?= $this->section('content') ?>

<style>
.photo-upload-circle {
    width: 160px; height: 160px; border-radius: 50%; overflow: hidden;
    border: 3px solid #C8A34D; position: relative; cursor: pointer;
    background: #f8f9fa; display: flex; align-items: center; justify-content: center;
}
.photo-upload-circle img { width: 100%; height: 100%; object-fit: cover; }
.photo-upload-circle .overlay {
    position: absolute; inset: 0; background: rgba(0,0,0,.45);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; transition: opacity .2s; border-radius: 50%;
    color: #fff; font-size: 24px; flex-direction: column; gap: 4px;
}
.photo-upload-circle:hover .overlay { opacity: 1; }
.photo-upload-circle .overlay span { font-size: 11px; font-weight: 600; }
.char-counter { font-size: 11px; color: #6B7280; }
.char-counter.warning { color: #dc3545; }
.section-label {
    font-size: 11px; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase;
    color: #C8A34D; margin: 24px 0 14px; padding-bottom: 8px; border-bottom: 1px solid rgba(200,163,77,.3);
}
.dynamic-row {
    background: #fafafa; border: 1px solid #e9ecef; border-radius: 10px;
    padding: 16px 18px; margin-bottom: 12px; position: relative;
}
.remove-row-btn {
    position: absolute; top: 10px; right: 12px;
    background: none; border: none; color: #dc3545; cursor: pointer; font-size: 14px;
    padding: 4px 6px;
}
.add-row-btn {
    background: rgba(200,163,77,.12); border: 1px dashed #C8A34D; color: #C8A34D;
    border-radius: 8px; padding: 8px 18px; font-weight: 600; font-size: 13px;
    cursor: pointer; transition: background .2s;
}
.add-row-btn:hover { background: rgba(200,163,77,.22); }
</style>

<?php
$founder = $founder ?? [];
$edu = is_array($founder['education'] ?? null) ? $founder['education'] : [];
$exp = is_array($founder['experience'] ?? null) ? $founder['experience'] : [];
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Profil Pendiri</h1>
        <p class="page-subtitle">Kelola informasi profil pendiri / direktur BKC</p>
    </div>
    <div class="page-actions">
        <a href="<?= base_url('admin/profil-pendiri/publikasi') ?>" class="btn btn-outline-primary" style="border-radius:10px; padding:9px 18px; font-size:13px;">
            <i class="fas fa-book me-1"></i>Kelola Publikasi
        </a>
    </div>
</div>

<form id="founderForm" method="POST" action="<?= base_url('admin/profil-pendiri/update') ?>" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <!-- Hidden fields to hold JSON education & experience before submit -->
    <input type="hidden" name="education_json" id="educationJson">
    <input type="hidden" name="experience_json" id="experienceJson">

    <div class="row g-4">

        <!-- LEFT: Photo + Basic Info -->
        <div class="col-lg-4">
            <div class="admin-card h-100">
                <div class="admin-card-header">
                    <h6 class="admin-card-title"><i class="fas fa-user-tie me-2"></i>Foto &amp; Identitas</h6>
                </div>
                <div class="admin-card-body text-center">
                    <!-- Photo -->
                    <div class="d-flex justify-content-center mb-3">
                        <label class="photo-upload-circle" for="founderPhotoInput">
                            <img id="founderPhotoPreview"
                                 src="<?= !empty($founder['photo']) ? base_url('assets/uploads/' . esc($founder['photo'])) : base_url('assets/images/logo/logo_BKC_1.png') ?>"
                                 alt="Foto Pendiri"
                                 onerror="this.src='<?= base_url('assets/images/logo/logo_BKC_1.png') ?>'">
                            <div class="overlay">
                                <i class="fas fa-camera"></i>
                                <span>Ganti Foto</span>
                            </div>
                        </label>
                        <input type="file" name="photo" id="founderPhotoInput" accept="image/*" style="display:none;">
                    </div>
                    <small class="text-muted d-block mb-3">Klik foto untuk mengubah. Rasio 1:1, min. 200×200px</small>

                    <div class="mb-3 text-start">
                        <label class="form-label fw-600">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="<?= esc($founder['name'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label fw-600">Jabatan / Title</label>
                        <input type="text" name="title" class="form-control" value="<?= esc($founder['title'] ?? '') ?>" placeholder="Contoh: Direktur Utama">
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label fw-600">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= esc($founder['email'] ?? '') ?>">
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label fw-600">Telepon</label>
                        <input type="text" name="phone" class="form-control" value="<?= esc($founder['phone'] ?? '') ?>">
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label fw-600">LinkedIn URL</label>
                        <input type="url" name="linkedin" class="form-control" value="<?= esc($founder['linkedin'] ?? '') ?>" placeholder="https://linkedin.com/in/...">
                    </div>
                    <div class="text-start">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="founderIsActive" value="1"
                                <?= !empty($founder['is_active']) ? 'checked' : '' ?>>
                            <label class="form-check-label fw-600" for="founderIsActive">Profil Aktif</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT: Bio + Education + Experience -->
        <div class="col-lg-8">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h6 class="admin-card-title"><i class="fas fa-align-left me-2"></i>Biografi &amp; Riwayat</h6>
                </div>
                <div class="admin-card-body">

                    <!-- Bio Short -->
                    <div class="mb-3">
                        <label class="form-label fw-600">
                            Bio Singkat
                            <small class="text-muted">(maks 300 karakter)</small>
                        </label>
                        <textarea name="bio_short" class="form-control" rows="3" maxlength="300" id="bioShort"><?= esc($founder['bio_short'] ?? $founder['bio'] ?? '') ?></textarea>
                        <div class="char-counter" id="bioShortCount">0/300</div>
                    </div>

                    <!-- Bio Full (CKEditor) -->
                    <div class="mb-4">
                        <label class="form-label fw-600">Biografi Lengkap</label>
                        <textarea name="bio" id="bioFull" class="form-control" rows="8"><?= esc($founder['bio_full'] ?? $founder['bio'] ?? '') ?></textarea>
                    </div>

                    <!-- Achievements -->
                    <div class="mb-4">
                        <label class="form-label fw-600">Pencapaian / Penghargaan <small class="text-muted">(satu per baris)</small></label>
                        <textarea name="achievements" class="form-control" rows="4" placeholder="Penghargaan Nasional 2022&#10;Sertifikasi XYZ&#10;..."><?= esc($founder['achievements'] ?? '') ?></textarea>
                    </div>

                    <!-- Education Section -->
                    <div class="section-label"><i class="fas fa-graduation-cap me-1"></i>Riwayat Pendidikan</div>
                    <div id="educationContainer">
                        <?php if(empty($edu)): ?>
                        <!-- empty placeholder, JS will render rows -->
                        <?php else: foreach($edu as $i => $ed): ?>
                        <div class="dynamic-row edu-row" data-index="<?= $i ?>">
                            <button type="button" class="remove-row-btn" onclick="removeRow(this)"><i class="fas fa-times"></i></button>
                            <div class="row g-2">
                                <div class="col-md-5">
                                    <label class="form-label" style="font-size:12px;">Institusi / Universitas</label>
                                    <input type="text" class="form-control edu-institution" value="<?= esc($ed['institution'] ?? $ed['university'] ?? '') ?>" placeholder="Nama universitas...">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" style="font-size:12px;">Gelar / Jenjang</label>
                                    <input type="text" class="form-control edu-degree" value="<?= esc($ed['degree'] ?? '') ?>" placeholder="S1 / S2 / S3 / D3...">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" style="font-size:12px;">Bidang Studi</label>
                                    <input type="text" class="form-control edu-field" value="<?= esc($ed['field_of_study'] ?? $ed['field'] ?? '') ?>" placeholder="Manajemen...">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" style="font-size:12px;">Tahun Mulai</label>
                                    <input type="number" class="form-control edu-year-start" value="<?= esc($ed['year_start'] ?? $ed['year_from'] ?? '') ?>" placeholder="2000" min="1970" max="<?= date('Y') ?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" style="font-size:12px;">Tahun Selesai</label>
                                    <input type="number" class="form-control edu-year-end" value="<?= esc($ed['year_end'] ?? $ed['year'] ?? '') ?>" placeholder="<?= date('Y') ?>" min="1970" max="<?= date('Y')+5 ?>">
                                </div>
                            </div>
                        </div>
                        <?php endforeach; endif; ?>
                    </div>
                    <button type="button" class="add-row-btn mb-4" onclick="addEduRow()">
                        <i class="fas fa-plus me-1"></i>Tambah Pendidikan
                    </button>

                    <!-- Experience Section -->
                    <div class="section-label"><i class="fas fa-briefcase me-1"></i>Riwayat Pengalaman</div>
                    <div id="experienceContainer">
                        <?php if(empty($exp)): ?>
                        <?php else: foreach($exp as $i => $ex): ?>
                        <div class="dynamic-row exp-row" data-index="<?= $i ?>">
                            <button type="button" class="remove-row-btn" onclick="removeRow(this)"><i class="fas fa-times"></i></button>
                            <div class="row g-2">
                                <div class="col-md-5">
                                    <label class="form-label" style="font-size:12px;">Perusahaan / Instansi</label>
                                    <input type="text" class="form-control exp-company" value="<?= esc($ex['company'] ?? '') ?>" placeholder="Nama perusahaan...">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" style="font-size:12px;">Jabatan / Posisi</label>
                                    <input type="text" class="form-control exp-position" value="<?= esc($ex['position'] ?? '') ?>" placeholder="Direktur...">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" style="font-size:12px;">Tahun Mulai</label>
                                    <input type="number" class="form-control exp-year-start" value="<?= esc($ex['year_start'] ?? '') ?>" placeholder="2010" min="1970" max="<?= date('Y') ?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" style="font-size:12px;">Tahun Selesai</label>
                                    <input type="text" class="form-control exp-year-end" value="<?= esc($ex['year_end'] ?? '') ?>" placeholder="<?= date('Y') ?> / Sekarang">
                                </div>
                                <div class="col-12">
                                    <label class="form-label" style="font-size:12px;">Deskripsi (opsional)</label>
                                    <textarea class="form-control exp-description" rows="2" placeholder="Deskripsi singkat pekerjaan..."><?= esc($ex['description'] ?? '') ?></textarea>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; endif; ?>
                    </div>
                    <button type="button" class="add-row-btn mb-4" onclick="addExpRow()">
                        <i class="fas fa-plus me-1"></i>Tambah Pengalaman
                    </button>

                </div>
            </div>
        </div>
    </div>

    <!-- Submit Bar -->
    <div class="admin-card mt-4">
        <div class="admin-card-body d-flex justify-content-between align-items-center">
            <p class="mb-0 text-muted" style="font-size:13px;">
                <i class="fas fa-info-circle me-1"></i>
                Pastikan semua data sudah benar sebelum menyimpan.
            </p>
            <button type="submit" class="btn" style="background:#C8A34D; color:#121212; font-weight:700; border-radius:10px; padding:12px 32px; font-size:14px;" id="founderSubmitBtn">
                <i class="fas fa-save me-2"></i>Simpan Profil Pendiri
            </button>
        </div>
    </div>
</form>

<!-- CKEditor 5 -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
let editorBio;
ClassicEditor.create(document.querySelector('#bioFull'), {
    toolbar: ['heading','|','bold','italic','underline','link','bulletedList','numberedList','|','blockQuote','undo','redo']
}).then(e => { editorBio = e; }).catch(console.error);

// Char counter
const bioShort = document.getElementById('bioShort');
const bioShortCount = document.getElementById('bioShortCount');
if (bioShort) {
    const upd = () => {
        const len = bioShort.value.length;
        bioShortCount.textContent = len + '/300';
        bioShortCount.className = 'char-counter' + (len > 270 ? ' warning' : '');
    };
    bioShort.addEventListener('input', upd); upd();
}

// Photo preview
document.getElementById('founderPhotoInput').addEventListener('change', function() {
    if (this.files[0]) {
        document.getElementById('founderPhotoPreview').src = URL.createObjectURL(this.files[0]);
    }
});

// Dynamic rows
function addEduRow() {
    const container = document.getElementById('educationContainer');
    const idx = container.querySelectorAll('.edu-row').length;
    const row = document.createElement('div');
    row.className = 'dynamic-row edu-row'; row.dataset.index = idx;
    row.innerHTML = `
        <button type="button" class="remove-row-btn" onclick="removeRow(this)"><i class="fas fa-times"></i></button>
        <div class="row g-2">
            <div class="col-md-5">
                <label class="form-label" style="font-size:12px;">Institusi / Universitas</label>
                <input type="text" class="form-control edu-institution" placeholder="Nama universitas...">
            </div>
            <div class="col-md-4">
                <label class="form-label" style="font-size:12px;">Gelar / Jenjang</label>
                <input type="text" class="form-control edu-degree" placeholder="S1 / S2 / S3 / D3...">
            </div>
            <div class="col-md-3">
                <label class="form-label" style="font-size:12px;">Bidang Studi</label>
                <input type="text" class="form-control edu-field" placeholder="Manajemen...">
            </div>
            <div class="col-md-3">
                <label class="form-label" style="font-size:12px;">Tahun Mulai</label>
                <input type="number" class="form-control edu-year-start" placeholder="2000" min="1970" max="<?= date('Y') ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label" style="font-size:12px;">Tahun Selesai</label>
                <input type="number" class="form-control edu-year-end" placeholder="<?= date('Y') ?>" min="1970" max="<?= date('Y')+5 ?>">
            </div>
        </div>`;
    container.appendChild(row);
}

function addExpRow() {
    const container = document.getElementById('experienceContainer');
    const idx = container.querySelectorAll('.exp-row').length;
    const row = document.createElement('div');
    row.className = 'dynamic-row exp-row'; row.dataset.index = idx;
    row.innerHTML = `
        <button type="button" class="remove-row-btn" onclick="removeRow(this)"><i class="fas fa-times"></i></button>
        <div class="row g-2">
            <div class="col-md-5">
                <label class="form-label" style="font-size:12px;">Perusahaan / Instansi</label>
                <input type="text" class="form-control exp-company" placeholder="Nama perusahaan...">
            </div>
            <div class="col-md-4">
                <label class="form-label" style="font-size:12px;">Jabatan / Posisi</label>
                <input type="text" class="form-control exp-position" placeholder="Direktur...">
            </div>
            <div class="col-md-3">
                <label class="form-label" style="font-size:12px;">Tahun Mulai</label>
                <input type="number" class="form-control exp-year-start" placeholder="2010" min="1970" max="<?= date('Y') ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label" style="font-size:12px;">Tahun Selesai</label>
                <input type="text" class="form-control exp-year-end" placeholder="<?= date('Y') ?> / Sekarang">
            </div>
            <div class="col-12">
                <label class="form-label" style="font-size:12px;">Deskripsi (opsional)</label>
                <textarea class="form-control exp-description" rows="2" placeholder="Deskripsi singkat pekerjaan..."></textarea>
            </div>
        </div>`;
    container.appendChild(row);
}

function removeRow(btn) {
    btn.closest('.dynamic-row').remove();
}

// Serialize education and experience before submit
document.getElementById('founderForm').addEventListener('submit', function(e) {
    // Serialize education
    const education = [];
    document.querySelectorAll('.edu-row').forEach(row => {
        const institution = row.querySelector('.edu-institution')?.value?.trim();
        if (institution) {
            education.push({
                institution,
                degree: row.querySelector('.edu-degree')?.value?.trim() || '',
                field_of_study: row.querySelector('.edu-field')?.value?.trim() || '',
                year_start: row.querySelector('.edu-year-start')?.value?.trim() || '',
                year_end: row.querySelector('.edu-year-end')?.value?.trim() || ''
            });
        }
    });
    document.getElementById('educationJson').value = JSON.stringify(education);

    // Serialize experience
    const experience = [];
    document.querySelectorAll('.exp-row').forEach(row => {
        const company = row.querySelector('.exp-company')?.value?.trim();
        if (company) {
            experience.push({
                company,
                position: row.querySelector('.exp-position')?.value?.trim() || '',
                year_start: row.querySelector('.exp-year-start')?.value?.trim() || '',
                year_end: row.querySelector('.exp-year-end')?.value?.trim() || '',
                description: row.querySelector('.exp-description')?.value?.trim() || ''
            });
        }
    });
    document.getElementById('experienceJson').value = JSON.stringify(experience);

    // Update CKEditor value
    if (editorBio) {
        document.querySelector('[name="bio"]').value = editorBio.getData();
    }

    // Disable submit button
    const btn = document.getElementById('founderSubmitBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
});
</script>

<?= $this->endSection() ?>
