<?php $this->extend('Modules\Admin\Views\layout\main') ?>
<?php $this->section('content') ?>

<?php
$s = function(string $key, $default = '') use ($settings) {
    return esc($settings[$key] ?? $default);
};
?>

<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="page-title mb-1"><i class="fas fa-cog me-2 text-gold"></i>Pengaturan Sistem</h4>
        <p class="text-muted mb-0 small">Konfigurasi informasi perusahaan, SEO, dan sistem</p>
    </div>
</div>

<!-- Tabs Navigation -->
<ul class="nav nav-tabs nav-tabs-premium mb-4" id="settingsTabs">
    <li class="nav-item">
        <a class="nav-link active" href="#tab-umum" data-bs-toggle="tab">
            <i class="fas fa-building me-2"></i>Umum
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#tab-tentang" data-bs-toggle="tab">
            <i class="fas fa-info-circle me-2"></i>Tentang
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#tab-kontak" data-bs-toggle="tab">
            <i class="fas fa-share-alt me-2"></i>Kontak & Sosial
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#tab-seo" data-bs-toggle="tab">
            <i class="fas fa-search me-2"></i>SEO
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#tab-sistem" data-bs-toggle="tab">
            <i class="fas fa-server me-2"></i>Sistem
        </a>
    </li>
</ul>

<div class="tab-content">

    <!-- ─── Tab Umum ──────────────────────────────────────────────────── -->
    <div class="tab-pane fade show active" id="tab-umum">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom py-3">
                <h6 class="mb-0 fw-semibold"><i class="fas fa-building me-2"></i>Informasi Perusahaan</h6>
            </div>
            <div class="card-body p-4">
                <form id="formUmum" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_tab" value="umum">

                    <div class="row g-4">
                        <!-- Logo -->
                        <div class="col-lg-4 text-center">
                            <label class="form-label fw-semibold d-block mb-2">Logo Perusahaan</label>
                            <div class="logo-preview-wrapper mx-auto mb-3"
                                 style="width:200px;height:100px;border:2px dashed #C8A34D;border-radius:8px;
                                        display:flex;align-items:center;justify-content:center;overflow:hidden;">
                                <?php if (!empty($settings['logo'])): ?>
                                    <img id="logoPreview" src="<?= base_url(esc($settings['logo'])) ?>"
                                         style="max-width:100%;max-height:100%;object-fit:contain;" alt="Logo">
                                <?php else: ?>
                                    <div id="logoPlaceholder" class="text-muted text-center">
                                        <i class="fas fa-image fa-2x d-block mb-1"></i>
                                        <small>Upload Logo</small>
                                    </div>
                                    <img id="logoPreview" src="" style="max-width:100%;max-height:100%;object-fit:contain;display:none;" alt="Logo">
                                <?php endif; ?>
                            </div>
                            <input type="file" name="logo" id="logoInput" accept="image/*" class="form-control form-control-sm">
                            <div class="form-text text-muted">PNG/SVG transparan, maks 2MB</div>

                            <div class="mt-4">
                                <label class="form-label fw-semibold d-block mb-2">Favicon</label>
                                <div class="mx-auto mb-2"
                                     style="width:60px;height:60px;border:2px dashed #dee2e6;border-radius:8px;
                                            display:flex;align-items:center;justify-content:center;overflow:hidden;">
                                    <?php if (!empty($settings['favicon'])): ?>
                                        <img id="faviconPreview" src="<?= base_url(esc($settings['favicon'])) ?>"
                                             style="max-width:100%;max-height:100%;" alt="Favicon">
                                    <?php else: ?>
                                        <i class="fas fa-star text-muted" id="faviconPlaceholder"></i>
                                        <img id="faviconPreview" src="" style="max-width:100%;max-height:100%;display:none;" alt="Favicon">
                                    <?php endif; ?>
                                </div>
                                <input type="file" name="favicon" id="faviconInput" accept="image/*" class="form-control form-control-sm">
                                <div class="form-text text-muted">ICO/PNG 32×32px</div>
                            </div>
                        </div>

                        <!-- Company Details -->
                        <div class="col-lg-8">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nama Perusahaan</label>
                                    <input type="text" name="company_name" class="form-control"
                                           value="<?= $s('company_name') ?>" placeholder="CV. Bagus Kencana Cakrada">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tagline</label>
                                    <input type="text" name="tagline" class="form-control"
                                           value="<?= $s('tagline') ?>" placeholder="Slogan perusahaan">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nomor Telepon</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        <input type="text" name="phone" class="form-control"
                                               value="<?= $s('phone') ?>" placeholder="+62 21 xxxxxxx">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">WhatsApp</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                                        <input type="text" name="whatsapp" class="form-control"
                                               value="<?= $s('whatsapp') ?>" placeholder="+6281xxxxxxxxx">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" name="email" class="form-control"
                                               value="<?= $s('email') ?>" placeholder="info@perusahaan.com">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tahun Berdiri</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        <input type="number" name="established_year" class="form-control"
                                               value="<?= $s('established_year') ?>" placeholder="2010" min="1900" max="<?= date('Y') ?>">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Alamat</label>
                                    <textarea name="address" class="form-control" rows="3"
                                              placeholder="Alamat lengkap perusahaan..."><?= $s('address') ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-gold btn-save-tab" data-form="formUmum">
                            <i class="fas fa-save me-1"></i>Simpan Informasi Umum
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ─── Tab Tentang ───────────────────────────────────────────────── -->
    <div class="tab-pane fade" id="tab-tentang">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom py-3">
                <h6 class="mb-0 fw-semibold"><i class="fas fa-info-circle me-2"></i>Tentang Perusahaan</h6>
            </div>
            <div class="card-body p-4">
                <form id="formTentang">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_tab" value="tentang">

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Deskripsi Singkat</label>
                            <textarea name="about" id="aboutEditor" class="form-control" rows="6"
                                      placeholder="Deskripsi perusahaan..."><?= $s('about') ?></textarea>
                            <div class="form-text text-muted">Mendukung editor teks kaya (CKEditor jika tersedia)</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Visi</label>
                            <textarea name="vision" class="form-control" rows="3"
                                      placeholder="Visi perusahaan..."><?= $s('vision') ?></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Misi</label>
                            <textarea name="mission" class="form-control" rows="4"
                                      placeholder="Misi perusahaan (satu per baris)..."><?= $s('mission') ?></textarea>
                        </div>

                        <div class="col-12">
                            <h6 class="fw-semibold mt-2 mb-3 text-gold">
                                <i class="fas fa-chart-bar me-2"></i>Counter Statistik (Homepage)
                            </h6>
                        </div>
                        <div class="col-sm-6 col-xl-3">
                            <label class="form-label fw-semibold">Total Klien</label>
                            <input type="number" name="total_clients" class="form-control"
                                   value="<?= $s('total_clients', '0') ?>" min="0">
                        </div>
                        <div class="col-sm-6 col-xl-3">
                            <label class="form-label fw-semibold">Total Pelatihan</label>
                            <input type="number" name="total_trainings" class="form-control"
                                   value="<?= $s('total_trainings', '0') ?>" min="0">
                        </div>
                        <div class="col-sm-6 col-xl-3">
                            <label class="form-label fw-semibold">Total Sertifikat</label>
                            <input type="number" name="total_certificates" class="form-control"
                                   value="<?= $s('total_certificates', '0') ?>" min="0">
                        </div>
                        <div class="col-sm-6 col-xl-3">
                            <label class="form-label fw-semibold">Pengalaman (Tahun)</label>
                            <input type="number" name="total_years" class="form-control"
                                   value="<?= $s('total_years', '0') ?>" min="0">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-gold btn-save-tab" data-form="formTentang">
                            <i class="fas fa-save me-1"></i>Simpan Informasi Tentang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ─── Tab Kontak & Sosial ───────────────────────────────────────── -->
    <div class="tab-pane fade" id="tab-kontak">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom py-3">
                <h6 class="mb-0 fw-semibold"><i class="fas fa-share-alt me-2"></i>Kontak & Media Sosial</h6>
            </div>
            <div class="card-body p-4">
                <form id="formKontak">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_tab" value="kontak">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="fab fa-instagram me-1 text-danger"></i>Instagram</label>
                            <div class="input-group">
                                <span class="input-group-text">https://instagram.com/</span>
                                <input type="text" name="instagram" class="form-control"
                                       value="<?= $s('instagram') ?>" placeholder="username">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="fab fa-facebook me-1 text-primary"></i>Facebook</label>
                            <div class="input-group">
                                <span class="input-group-text">https://facebook.com/</span>
                                <input type="text" name="facebook" class="form-control"
                                       value="<?= $s('facebook') ?>" placeholder="page-name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="fab fa-youtube me-1 text-danger"></i>YouTube</label>
                            <div class="input-group">
                                <span class="input-group-text">https://youtube.com/</span>
                                <input type="text" name="youtube" class="form-control"
                                       value="<?= $s('youtube') ?>" placeholder="@channel">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="fab fa-linkedin me-1 text-primary"></i>LinkedIn</label>
                            <div class="input-group">
                                <span class="input-group-text">https://linkedin.com/company/</span>
                                <input type="text" name="linkedin" class="form-control"
                                       value="<?= $s('linkedin') ?>" placeholder="company-name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="fab fa-twitter me-1"></i>Twitter / X</label>
                            <div class="input-group">
                                <span class="input-group-text">https://twitter.com/</span>
                                <input type="text" name="twitter" class="form-control"
                                       value="<?= $s('twitter') ?>" placeholder="username">
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold"><i class="fas fa-map-marked-alt me-1 text-danger"></i>Google Maps Embed URL</label>
                            <textarea name="maps_embed" class="form-control" rows="3"
                                      placeholder="https://www.google.com/maps/embed?pb=..."><?= $s('maps_embed') ?></textarea>
                            <div class="form-text text-muted">Salin URL embed dari Google Maps (Share → Embed a map → Copy HTML → ambil URL src="...")</div>
                        </div>
                        <?php if (!empty($settings['maps_embed'])): ?>
                        <div class="col-12">
                            <div class="ratio ratio-16x9" style="max-height:250px;">
                                <iframe src="<?= $s('maps_embed') ?>" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-gold btn-save-tab" data-form="formKontak">
                            <i class="fas fa-save me-1"></i>Simpan Kontak & Sosial
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ─── Tab SEO ────────────────────────────────────────────────────── -->
    <div class="tab-pane fade" id="tab-seo">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom py-3">
                <h6 class="mb-0 fw-semibold"><i class="fas fa-search me-2"></i>Pengaturan SEO</h6>
            </div>
            <div class="card-body p-4">
                <form id="formSeo">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_tab" value="seo">

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" id="metaTitleInput"
                                   value="<?= $s('meta_title') ?>" placeholder="Judul SEO (50-60 karakter ideal)">
                            <div class="d-flex justify-content-between mt-1">
                                <span class="form-text text-muted">Ditampilkan di tab browser & hasil pencarian Google</span>
                                <span class="form-text" id="metaTitleCount">0/60</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="3" id="metaDescInput"
                                      placeholder="Deskripsi halaman (150-160 karakter ideal)..."><?= $s('meta_description') ?></textarea>
                            <div class="d-flex justify-content-between mt-1">
                                <span class="form-text text-muted">Ditampilkan di bawah judul pada hasil Google</span>
                                <span class="form-text" id="metaDescCount">0/160</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Meta Keywords</label>
                            <input type="text" name="meta_keywords" class="form-control"
                                   value="<?= $s('meta_keywords') ?>" placeholder="pelatihan, sertifikasi, kompetensi, ...">
                            <div class="form-text text-muted">Pisahkan dengan koma</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Google Analytics ID</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fab fa-google"></i></span>
                                <input type="text" name="google_analytics_id" class="form-control"
                                       value="<?= $s('google_analytics_id') ?>" placeholder="G-XXXXXXXXXX">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Google Site Verification</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                                <input type="text" name="google_site_verification" class="form-control"
                                       value="<?= $s('google_site_verification') ?>" placeholder="Kode verifikasi">
                            </div>
                        </div>

                        <!-- SERP Preview -->
                        <div class="col-12">
                            <div class="p-3 bg-white border rounded" style="font-family: Arial, sans-serif;">
                                <div class="text-muted small mb-2 fw-semibold"><i class="fas fa-eye me-1"></i>Preview SERP Google</div>
                                <div style="color:#1a0dab;font-size:18px;line-height:1.3;" id="serpTitle"><?= $s('meta_title', 'Judul Website') ?></div>
                                <div style="color:#006621;font-size:14px;margin:2px 0;"><?= base_url() ?></div>
                                <div style="color:#545454;font-size:14px;line-height:1.5;" id="serpDesc"><?= $s('meta_description', 'Deskripsi website akan muncul di sini...') ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-gold btn-save-tab" data-form="formSeo">
                            <i class="fas fa-save me-1"></i>Simpan SEO
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ─── Tab Sistem ────────────────────────────────────────────────── -->
    <div class="tab-pane fade" id="tab-sistem">
        <div class="row g-4">
            <!-- Cache Management -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-bottom py-3">
                        <h6 class="mb-0 fw-semibold"><i class="fas fa-database me-2"></i>Cache Management</h6>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-muted small mb-4">
                            Cache menyimpan data sementara untuk mempercepat loading website.
                            Hapus cache jika perubahan tidak muncul di website.
                        </p>
                        <div class="d-flex align-items-center gap-3">
                            <button type="button" class="btn btn-warning" id="clearCacheBtn">
                                <i class="fas fa-trash-alt me-2"></i>Bersihkan Cache
                            </button>
                            <div id="cacheResult" class="small"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Info -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-bottom py-3">
                        <h6 class="mb-0 fw-semibold"><i class="fas fa-info me-2"></i>Informasi Sistem</h6>
                    </div>
                    <div class="card-body p-4">
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <td class="text-muted small fw-semibold">PHP Version</td>
                                <td><code><?= PHP_VERSION ?></code></td>
                            </tr>
                            <tr>
                                <td class="text-muted small fw-semibold">CodeIgniter</td>
                                <td><code><?= \CodeIgniter\CodeIgniter::CI_VERSION ?></code></td>
                            </tr>
                            <tr>
                                <td class="text-muted small fw-semibold">Server</td>
                                <td class="small"><?= esc($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted small fw-semibold">Timezone</td>
                                <td><code><?= date_default_timezone_get() ?></code></td>
                            </tr>
                            <tr>
                                <td class="text-muted small fw-semibold">Session Expiry</td>
                                <td class="small"><?= ini_get('session.gc_maxlifetime') / 60 ?> menit</td>
                            </tr>
                            <tr>
                                <td class="text-muted small fw-semibold">Upload Max Size</td>
                                <td><code><?= ini_get('upload_max_filesize') ?></code></td>
                            </tr>
                            <tr>
                                <td class="text-muted small fw-semibold">Memory Limit</td>
                                <td><code><?= ini_get('memory_limit') ?></code></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div><!-- end tab-content -->

<style>
.text-gold { color: #C8A34D !important; }
.bg-gold   { background-color: #C8A34D !important; }
.btn-gold  { background-color: #C8A34D; border-color: #C8A34D; color: #fff; font-weight: 600; }
.btn-gold:hover { background-color: #b8922d; border-color: #b8922d; color: #fff; }

.nav-tabs-premium .nav-link {
    color: #6c757d; border: none; border-bottom: 3px solid transparent;
    padding: .5rem 1rem; font-weight: 500;
}
.nav-tabs-premium .nav-link.active,
.nav-tabs-premium .nav-link:hover {
    color: #C8A34D; border-bottom-color: #C8A34D; background: transparent;
}
.nav-tabs-premium { border-bottom: 2px solid #dee2e6; }
</style>

<script>
$(function () {
    // Tab AJAX save
    $(document).on('click', '.btn-save-tab', function () {
        const formId = $(this).data('form');
        const $form  = $('#' + formId);
        const $btn   = $(this);

        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...');

        $.ajax({
            url:         '<?= base_url('admin/pengaturan/update') ?>',
            type:        'POST',
            data:        new FormData($form[0]),
            contentType: false,
            processData: false,
            headers:     { 'X-CSRF-TOKEN': '<?= csrf_hash() ?>' },
            success: function (res) {
                if (res.success) {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer: 2000, showConfirmButton: false });
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: res.message || 'Terjadi kesalahan.' });
                }
            },
            error: function () {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal menghubungi server.' });
            },
            complete: function () {
                $btn.prop('disabled', false).html('<i class="fas fa-save me-1"></i>Simpan');
            },
        });
    });

    // Logo preview
    $('#logoInput').on('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            $('#logoPlaceholder').hide();
            $('#logoPreview').attr('src', e.target.result).show();
        };
        reader.readAsDataURL(file);
    });

    // Favicon preview
    $('#faviconInput').on('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            $('#faviconPlaceholder').hide();
            $('#faviconPreview').attr('src', e.target.result).show();
        };
        reader.readAsDataURL(file);
    });

    // Meta counters + SERP preview
    function updateMeta() {
        const title = $('#metaTitleInput').val();
        const desc  = $('#metaDescInput').val();
        $('#metaTitleCount').text(title.length + '/60').toggleClass('text-danger', title.length > 60);
        $('#metaDescCount').text(desc.length + '/160').toggleClass('text-danger', desc.length > 160);
        $('#serpTitle').text(title || 'Judul Website');
        $('#serpDesc').text(desc || 'Deskripsi website akan muncul di sini...');
    }
    $('#metaTitleInput, #metaDescInput').on('input', updateMeta);
    updateMeta();

    // Clear Cache
    $('#clearCacheBtn').on('click', function () {
        Swal.fire({
            title: 'Bersihkan Cache?',
            text:  'Semua cache akan dihapus. Website tetap berjalan normal.',
            icon:  'question',
            showCancelButton: true,
            confirmButtonColor: '#C8A34D',
            cancelButtonColor:  '#6c757d',
            confirmButtonText: 'Ya, Bersihkan',
            cancelButtonText:  'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                $('#clearCacheBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Membersihkan...');
                $.post('<?= base_url('admin/pengaturan/clear-cache') ?>', {
                    [csrf_token]: csrf_hash,
                }, function (res) {
                    if (res.success) {
                        $('#cacheResult').html('<span class="text-success"><i class="fas fa-check me-1"></i>' + res.message + '</span>');
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer: 2000, showConfirmButton: false });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: res.message });
                    }
                }).always(() => {
                    $('#clearCacheBtn').prop('disabled', false).html('<i class="fas fa-trash-alt me-2"></i>Bersihkan Cache');
                });
            }
        });
    });
});

const csrf_token = '<?= csrf_token() ?>';
const csrf_hash  = '<?= csrf_hash() ?>';
</script>

<?php $this->endSection() ?>
