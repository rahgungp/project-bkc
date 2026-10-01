<?= $this->extend('Modules\Admin\Views\layout\main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1 class="page-title"><?= $article ? 'Edit Berita' : 'Tambah Berita' ?></h1>
    </div>
    <a href="<?= base_url('admin/berita') ?>" class="btn btn-outline-secondary" style="border-radius:10px;"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
</div>

<form action="<?= $article ? base_url('admin/berita/update/'.$article['id']) : base_url('admin/berita/simpan') ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="admin-card mb-4">
                <div class="admin-card-header"><h6 class="admin-card-title">Konten Artikel</h6></div>
                <div class="admin-card-body">
                    <div class="mb-3">
                        <label class="form-label fw-600">Judul Artikel <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="<?= esc($article['title'] ?? '') ?>" required placeholder="Judul berita...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600">Ringkasan (Excerpt)</label>
                        <textarea name="excerpt" class="form-control" rows="3" placeholder="Ringkasan singkat artikel..."><?= esc($article['excerpt'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600">Konten Lengkap</label>
                        <textarea name="content" id="contentEditor" class="form-control" rows="12"><?= $article['content'] ?? '' ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600">Tags</label>
                        <input type="text" name="tags" class="form-control" value="<?= esc($article['tags'] ?? '') ?>" placeholder="pelatihan, bimtek, seminar (pisahkan dengan koma)">
                    </div>
                </div>
            </div>
            <div class="admin-card mb-4">
                <div class="admin-card-header"><h6 class="admin-card-title"><i class="fas fa-search me-2"></i>SEO</h6></div>
                <div class="admin-card-body">
                    <div class="mb-3">
                        <label class="form-label fw-600">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control" value="<?= esc($article['meta_title'] ?? '') ?>" placeholder="Judul SEO...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600">Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="2" placeholder="Deskripsi SEO..."><?= esc($article['meta_description'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="admin-card mb-4">
                <div class="admin-card-header"><h6 class="admin-card-title">Pengaturan</h6></div>
                <div class="admin-card-body">
                    <div class="mb-3">
                        <label class="form-label fw-600">Kategori</label>
                        <select name="category_id" class="form-select">
                            <option value="">Tanpa Kategori</option>
                            <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= ($article['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>><?= esc($cat['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600">Status</label>
                        <select name="status" class="form-select">
                            <option value="draft" <?= ($article['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Draft</option>
                            <option value="published" <?= ($article['status'] ?? '') === 'published' ? 'selected' : '' ?>>Published</option>
                            <option value="archived" <?= ($article['status'] ?? '') === 'archived' ? 'selected' : '' ?>>Archived</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_featured" value="1" <?= ($article['is_featured'] ?? 0) ? 'checked' : '' ?>>
                            <label class="form-check-label">Featured</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="admin-card mb-4">
                <div class="admin-card-header"><h6 class="admin-card-title">Thumbnail</h6></div>
                <div class="admin-card-body">
                    <?php if (!empty($article['thumbnail'])): ?>
                    <img src="<?= base_url('assets/uploads/news/' . $article['thumbnail']) ?>" id="thumbPreview" class="img-fluid rounded-3 mb-3" style="width:100%; height:160px; object-fit:cover;">
                    <?php else: ?>
                    <div id="thumbPreview" style="width:100%; height:160px; background:var(--bg-primary); border-radius:12px; display:flex; align-items:center; justify-content:center; margin-bottom:12px; border:2px dashed var(--border-color);">
                        <i class="fas fa-image" style="font-size:36px; color:var(--text-secondary);"></i>
                    </div>
                    <?php endif; ?>
                    <input type="file" name="thumbnail" class="form-control form-control-sm img-upload-input" data-preview="#thumbPreview" accept="image/*">
                    <small class="text-muted">JPG, PNG, WebP. Maks 2MB.</small>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex gap-3 justify-content-end mb-4">
        <a href="<?= base_url('admin/berita') ?>" class="btn btn-outline-secondary" style="border-radius:10px; padding:10px 24px;">Batal</a>
        <button type="submit" class="btn btn-primary" style="background:var(--gold); border-color:var(--gold); color:#121212; font-weight:700; border-radius:10px; padding:10px 32px;">
            <i class="fas fa-save me-2"></i><?= $article ? 'Perbarui' : 'Simpan' ?>
        </button>
    </div>
</form>

<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>ClassicEditor.create(document.querySelector('#contentEditor')).catch(console.error);</script>

<?= $this->endSection() ?>
