<?= $this->extend('Modules\Admin\Views\layout\main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1 class="page-title"><?= $training ? 'Edit Pelatihan' : 'Tambah Pelatihan' ?></h1>
        <p class="page-subtitle"><?= $training ? 'Perbarui informasi program pelatihan' : 'Buat program pelatihan baru' ?></p>
    </div>
    <div class="page-actions">
        <a href="<?= base_url('admin/pelatihan') ?>" class="btn btn-outline-secondary" style="border-radius:10px;">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<form action="<?= $training ? base_url('admin/pelatihan/update/' . $training['id']) : base_url('admin/pelatihan/simpan') ?>"
      method="POST" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="row g-4">
        <!-- Left Column -->
        <div class="col-lg-8">
            <!-- Basic Info -->
            <div class="admin-card mb-4" data-aos="fade-up">
                <div class="admin-card-header">
                    <h6 class="admin-card-title"><i class="fas fa-info-circle me-2"></i>Informasi Dasar</h6>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-600">Judul Pelatihan <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control"
                                   value="<?= esc($training['title'] ?? old('title')) ?>"
                                   placeholder="Judul program pelatihan..." required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Kategori <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Pilih Kategori</option>
                                <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= ($training['category_id'] ?? old('category_id')) == $cat['id'] ? 'selected' : '' ?>>
                                    <?= esc($cat['name']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Lokasi</label>
                            <select name="location_id" class="form-select">
                                <option value="">Pilih Lokasi</option>
                                <?php foreach ($locations as $loc): ?>
                                <option value="<?= $loc['id'] ?>" <?= ($training['location_id'] ?? old('location_id')) == $loc['id'] ? 'selected' : '' ?>>
                                    <?= esc($loc['name']) ?> - <?= esc($loc['city']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Deskripsi Singkat</label>
                            <textarea name="short_description" class="form-control" rows="3"
                                      placeholder="Deskripsi singkat pelatihan (maks. 200 karakter)..."><?= esc($training['short_description'] ?? old('short_description')) ?></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Deskripsi Lengkap</label>
                            <textarea name="description" id="descEditor" class="form-control" rows="8"><?= $training['description'] ?? old('description') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Benefits & Materials -->
            <div class="admin-card mb-4" data-aos="fade-up">
                <div class="admin-card-header">
                    <h6 class="admin-card-title"><i class="fas fa-list-check me-2"></i>Manfaat & Materi</h6>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-600">Manfaat Pelatihan</label>
                            <textarea name="benefits" class="form-control" rows="6"
                                      placeholder="Tulis manfaat, satu per baris..."><?= esc($training['benefits'] ?? old('benefits')) ?></textarea>
                            <small class="text-muted">Satu manfaat per baris</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Materi Pelatihan</label>
                            <textarea name="materials" class="form-control" rows="6"
                                      placeholder="Tulis materi, satu per baris..."><?= esc($training['materials'] ?? old('materials')) ?></textarea>
                            <small class="text-muted">Satu materi per baris</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO -->
            <div class="admin-card mb-4" data-aos="fade-up">
                <div class="admin-card-header">
                    <h6 class="admin-card-title"><i class="fas fa-search me-2"></i>SEO</h6>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-600">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control"
                                   value="<?= esc($training['meta_title'] ?? old('meta_title')) ?>"
                                   placeholder="Judul untuk mesin pencari...">
                            <small class="text-muted">Optimal: 50-60 karakter</small>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="2"
                                      placeholder="Deskripsi untuk mesin pencari..."><?= esc($training['meta_description'] ?? old('meta_description')) ?></textarea>
                            <small class="text-muted">Optimal: 150-160 karakter</small>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Meta Keywords</label>
                            <input type="text" name="meta_keywords" class="form-control"
                                   value="<?= esc($training['meta_keywords'] ?? old('meta_keywords')) ?>"
                                   placeholder="keyword1, keyword2, keyword3...">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-lg-4">
            <!-- Status & Settings -->
            <div class="admin-card mb-4" data-aos="fade-up">
                <div class="admin-card-header">
                    <h6 class="admin-card-title"><i class="fas fa-cog me-2"></i>Pengaturan</h6>
                </div>
                <div class="admin-card-body">
                    <div class="mb-3">
                        <label class="form-label fw-600">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="draft" <?= ($training['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Draft</option>
                            <option value="published" <?= ($training['status'] ?? '') === 'published' ? 'selected' : '' ?>>Published</option>
                            <option value="upcoming" <?= ($training['status'] ?? '') === 'upcoming' ? 'selected' : '' ?>>Upcoming</option>
                            <option value="ongoing" <?= ($training['status'] ?? '') === 'ongoing' ? 'selected' : '' ?>>Ongoing</option>
                            <option value="completed" <?= ($training['status'] ?? '') === 'completed' ? 'selected' : '' ?>>Completed</option>
                            <option value="cancelled" <?= ($training['status'] ?? '') === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_featured" value="1"
                                   <?= ($training['is_featured'] ?? 0) ? 'checked' : '' ?>>
                            <label class="form-check-label">Featured (tampilkan di beranda)</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_online" value="1" id="isOnline"
                                   <?= ($training['is_online'] ?? 0) ? 'checked' : '' ?>>
                            <label class="form-check-label">Pelatihan Online</label>
                        </div>
                    </div>
                    <div id="onlineLinkWrap" class="mb-3" style="<?= ($training['is_online'] ?? 0) ? '' : 'display:none' ?>">
                        <label class="form-label fw-600">Link Meeting</label>
                        <input type="url" name="online_link" class="form-control form-control-sm"
                               value="<?= esc($training['online_link'] ?? '') ?>" placeholder="https://zoom.us/...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600">Urutan</label>
                        <input type="number" name="sort_order" class="form-control form-control-sm"
                               value="<?= esc($training['sort_order'] ?? 0) ?>" min="0">
                    </div>
                </div>
            </div>

            <!-- Cover Image -->
            <div class="admin-card mb-4" data-aos="fade-up">
                <div class="admin-card-header">
                    <h6 class="admin-card-title"><i class="fas fa-image me-2"></i>Cover Pelatihan</h6>
                </div>
                <div class="admin-card-body">
                    <?php if (!empty($training['cover'])): ?>
                    <img src="<?= base_url('assets/uploads/training/' . $training['cover']) ?>"
                         id="coverPreview" class="img-fluid rounded-3 mb-3" style="width:100%; height:160px; object-fit:cover;">
                    <?php else: ?>
                    <div id="coverPreview" style="width:100%; height:160px; background:var(--bg-primary); border-radius:12px; display:flex; align-items:center; justify-content:center; margin-bottom:12px; border:2px dashed var(--border-color);">
                        <i class="fas fa-image" style="font-size:36px; color:var(--text-secondary);"></i>
                    </div>
                    <?php endif; ?>
                    <input type="file" name="cover" class="form-control form-control-sm img-upload-input"
                           data-preview="#coverPreview" accept="image/*">
                    <small class="text-muted">JPG, PNG, WebP. Maks 2MB. Ukuran: 800x400px</small>
                </div>
            </div>

            <!-- Schedule Info -->
            <div class="admin-card mb-4" data-aos="fade-up">
                <div class="admin-card-header">
                    <h6 class="admin-card-title"><i class="fas fa-calendar me-2"></i>Jadwal & Kuota</h6>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-600">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-control form-control-sm"
                                   value="<?= esc($training['start_date'] ?? '') ?>">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-600">Tanggal Selesai</label>
                            <input type="date" name="end_date" class="form-control form-control-sm"
                                   value="<?= esc($training['end_date'] ?? '') ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Batas Pendaftaran</label>
                            <input type="date" name="registration_deadline" class="form-control form-control-sm"
                                   value="<?= esc($training['registration_deadline'] ?? '') ?>">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-600">Durasi (hari)</label>
                            <input type="number" name="duration_days" class="form-control form-control-sm"
                                   value="<?= esc($training['duration_days'] ?? 1) ?>" min="1">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-600">Jam/hari</label>
                            <input type="number" name="duration_hours" class="form-control form-control-sm"
                                   value="<?= esc($training['duration_hours'] ?? 8) ?>" min="1" max="24">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-600">Max Peserta</label>
                            <input type="number" name="max_participants" class="form-control form-control-sm"
                                   value="<?= esc($training['max_participants'] ?? 30) ?>" min="1">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-600">Harga (Rp)</label>
                            <input type="number" name="price" class="form-control form-control-sm"
                                   value="<?= esc($training['price'] ?? 0) ?>" min="0" step="1000">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Info Harga</label>
                            <input type="text" name="price_info" class="form-control form-control-sm"
                                   value="<?= esc($training['price_info'] ?? '') ?>"
                                   placeholder="contoh: Termasuk materi, sertifikat, konsumsi">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Narasumber -->
            <div class="admin-card mb-4" data-aos="fade-up">
                <div class="admin-card-header">
                    <h6 class="admin-card-title"><i class="fas fa-chalkboard-teacher me-2"></i>Narasumber</h6>
                </div>
                <div class="admin-card-body">
                    <?php foreach ($speakers as $spk): ?>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="speaker_ids[]"
                               value="<?= $spk['id'] ?>"
                               <?= in_array($spk['id'], $assignedSpeakers ?? []) ? 'checked' : '' ?>>
                        <label class="form-check-label" style="font-size:13px;">
                            <?= esc($spk['name']) ?>
                            <?php if ($spk['title']): ?>
                            <small class="text-muted">(<?= esc($spk['title']) ?>)</small>
                            <?php endif; ?>
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Brochure -->
            <div class="admin-card mb-4" data-aos="fade-up">
                <div class="admin-card-header">
                    <h6 class="admin-card-title"><i class="fas fa-file-pdf me-2"></i>Brosur PDF</h6>
                </div>
                <div class="admin-card-body">
                    <?php if (!empty($training['brochure'])): ?>
                    <div class="alert alert-info py-2 px-3" style="font-size:12px; border-radius:8px;">
                        <i class="fas fa-check-circle me-1"></i>Brosur sudah ada
                    </div>
                    <?php endif; ?>
                    <input type="file" name="brochure" class="form-control form-control-sm" accept=".pdf">
                    <small class="text-muted">PDF saja. Maks 5MB.</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Submit -->
    <div class="d-flex gap-3 justify-content-end mb-4">
        <a href="<?= base_url('admin/pelatihan') ?>" class="btn btn-outline-secondary" style="border-radius:10px; padding:10px 24px;">Batal</a>
        <button type="submit" class="btn btn-primary" style="background:var(--gold); border-color:var(--gold); color:#121212; font-weight:700; border-radius:10px; padding:10px 32px;">
            <i class="fas fa-save me-2"></i><?= $training ? 'Perbarui' : 'Simpan' ?> Pelatihan
        </button>
    </div>
</form>

<?= $this->section('extra_js') ?>
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('#descEditor'), {
        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo'],
    }).catch(console.error);

    document.getElementById('isOnline').addEventListener('change', function() {
        document.getElementById('onlineLinkWrap').style.display = this.checked ? '' : 'none';
    });

    // Image preview
    document.querySelector('.img-upload-input').addEventListener('change', function() {
        const preview = document.querySelector(this.dataset.preview);
        if (this.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                if (preview.tagName === 'IMG') {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                } else {
                    preview.innerHTML = '<img src="'+e.target.result+'" style="width:100%;height:100%;object-fit:cover;border-radius:12px;">';
                }
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
