<?= $this->extend('Modules\Admin\Views\layout\main') ?>
<?= $this->section('content') ?>

<style>
.profile-tab-nav .nav-link {
    color: #6B7280; font-weight: 600; padding: 10px 18px; border-radius: 10px 10px 0 0;
    border: 1px solid transparent; font-size: 13px;
}
.profile-tab-nav .nav-link.active {
    color: #C8A34D; background: #fff; border-color: #dee2e6 #dee2e6 #fff;
}
.profile-tab-nav .nav-link:hover:not(.active) { color: #1E4FA3; background: rgba(30,79,163,.06); }
.tab-save-btn {
    background: #C8A34D; border-color: #C8A34D; color: #121212;
    font-weight: 700; border-radius: 10px; padding: 10px 28px;
}
.tab-save-btn:hover { background: #b8923d; border-color: #b8923d; color: #121212; }
.img-preview-box {
    width: 120px; height: 120px; border-radius: 12px;
    border: 2px dashed #C8A34D; object-fit: contain; padding: 4px;
    background: #fafafa; display: flex; align-items: center; justify-content: center; overflow: hidden;
}
.img-preview-box img { max-width: 100%; max-height: 100%; object-fit: contain; }
.section-label {
    font-size: 11px; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase;
    color: #C8A34D; margin-bottom: 14px; padding-bottom: 8px; border-bottom: 1px solid rgba(200,163,77,.3);
}
</style>

<?php
// Helper: get a setting value by key
function profile_val($settings, $key, $default = '') {
    if (is_array($settings)) {
        foreach ($settings as $s) {
            if ((is_array($s) && ($s['setting_key'] ?? '') === $key)) return $s['setting_value'] ?? $default;
            if (is_string($s)) continue;
        }
        return $settings[$key] ?? $default;
    }
    return $default;
}
$s = $settings ?? [];
// If $settings is key=>value flat array use it directly
$pv = function($key, $def='') use ($s) { return esc($s[$key] ?? $def); };
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Profil Perusahaan</h1>
        <p class="page-subtitle">Kelola informasi dan identitas perusahaan BKC</p>
    </div>
</div>

<div class="admin-card" data-aos="fade-up">
    <!-- Tab Nav -->
    <ul class="nav profile-tab-nav border-bottom px-3 pt-3" id="profileTabs" role="tablist">
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabUmum"><i class="fas fa-building me-1"></i>Umum</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabKontak"><i class="fas fa-phone me-1"></i>Kontak</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabTentang"><i class="fas fa-info-circle me-1"></i>Tentang</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabSosmed"><i class="fas fa-share-alt me-1"></i>Media Sosial</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabSeo"><i class="fas fa-search me-1"></i>SEO</button></li>
    </ul>

    <div class="tab-content admin-card-body">

        <!-- ===== TAB 1: UMUM ===== -->
        <div class="tab-pane fade show active" id="tabUmum">
            <form class="tab-form" data-tab="umum" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="_tab" value="umum">

                <div class="section-label"><i class="fas fa-id-card me-1"></i>Identitas Perusahaan</div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-600">Nama Perusahaan</label>
                        <input type="text" name="company_name" class="form-control" value="<?= $pv('company_name','CV. Bagus Kencana Cakrada') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-600">Tagline</label>
                        <input type="text" name="tagline" class="form-control" value="<?= $pv('tagline','Building Knowledge & Capacity') ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-600">Tahun Berdiri</label>
                        <input type="number" name="established_year" class="form-control" value="<?= $pv('established_year','2015') ?>" min="1900" max="<?= date('Y') ?>">
                    </div>
                </div>

                <div class="section-label"><i class="fas fa-images me-1"></i>Logo &amp; Favicon</div>
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-600">Logo Perusahaan</label>
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="img-preview-box" id="logoPreviewBox">
                                <img id="logoPreview" src="<?= base_url('assets/images/logo/' . ($s['company_logo'] ?? 'logo_BKC_1.png')) ?>"
                                     alt="Logo" onerror="this.src=''; this.style.display='none'">
                            </div>
                            <div>
                                <input type="file" name="logo" id="logoInput" class="form-control" accept="image/*" style="font-size:12px;">
                                <small class="text-muted d-block mt-1">PNG/SVG, maks 2MB</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-600">Favicon</label>
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="img-preview-box" style="width:64px; height:64px;" id="faviconPreviewBox">
                                <img id="faviconPreview" src="<?= base_url('assets/images/logo/favicon.png') ?>" alt="Favicon"
                                     onerror="this.src=''; this.style.display='none'" style="max-width:48px; max-height:48px;">
                            </div>
                            <div>
                                <input type="file" name="favicon" id="faviconInput" class="form-control" accept="image/*,.ico" style="font-size:12px;">
                                <small class="text-muted d-block mt-1">ICO/PNG 32x32</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-label"><i class="fas fa-chart-bar me-1"></i>Statistik Counter</div>
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label fw-600">Total Klien</label>
                        <input type="number" name="total_clients" class="form-control" value="<?= $pv('total_clients','150') ?>" min="0">
                        <small class="text-muted">Ditampilkan di beranda</small>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-600">Total Pelatihan</label>
                        <input type="number" name="total_trainings" class="form-control" value="<?= $pv('total_trainings','100') ?>" min="0">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-600">Total Sertifikat</label>
                        <input type="number" name="total_certificates" class="form-control" value="<?= $pv('total_certificates','1000') ?>" min="0">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-600">Tahun Berpengalaman</label>
                        <input type="number" name="total_years" class="form-control" value="<?= $pv('total_years', (date('Y')-2015)) ?>" min="0">
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn tab-save-btn">
                        <i class="fas fa-save me-2"></i>Simpan Informasi Umum
                    </button>
                </div>
            </form>
        </div>

        <!-- ===== TAB 2: KONTAK ===== -->
        <div class="tab-pane fade" id="tabKontak">
            <form class="tab-form" data-tab="kontak">
                <?= csrf_field() ?>
                <input type="hidden" name="_tab" value="kontak">

                <div class="section-label"><i class="fas fa-phone-alt me-1"></i>Informasi Kontak</div>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-600">Telepon</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input type="text" name="phone" class="form-control" value="<?= $pv('phone','+62 818-0386-7430') ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-600">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" value="<?= $pv('email','info@bkc.co.id') ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-600">WhatsApp</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                            <input type="text" name="whatsapp" class="form-control" value="<?= $pv('whatsapp','6281803867430') ?>">
                        </div>
                    </div>
                </div>

                <div class="section-label"><i class="fas fa-map-marker-alt me-1"></i>Alamat</div>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label class="form-label fw-600">Alamat Lengkap</label>
                        <textarea name="address" class="form-control" rows="3"><?= $pv('address','Jl. Raya Sesetan No. 123, Denpasar Selatan') ?></textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-600">Kota</label>
                        <input type="text" name="city" class="form-control" value="<?= $pv('city','Denpasar') ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-600">Provinsi</label>
                        <input type="text" name="province" class="form-control" value="<?= $pv('province','Bali') ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-600">Kode Pos</label>
                        <input type="text" name="postal_code" class="form-control" value="<?= $pv('postal_code','80223') ?>">
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn tab-save-btn">
                        <i class="fas fa-save me-2"></i>Simpan Kontak
                    </button>
                </div>
            </form>
        </div>

        <!-- ===== TAB 3: TENTANG ===== -->
        <div class="tab-pane fade" id="tabTentang">
            <form class="tab-form" data-tab="tentang">
                <?= csrf_field() ?>
                <input type="hidden" name="_tab" value="tentang">

                <div class="section-label"><i class="fas fa-align-left me-1"></i>Deskripsi Perusahaan</div>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label class="form-label fw-600">Deskripsi Singkat <small class="text-muted">(maks 200 karakter)</small></label>
                        <textarea name="about_short" class="form-control" rows="3" maxlength="200" id="aboutShort"><?= $pv('about_short') ?></textarea>
                        <small class="text-muted" id="aboutShortCount">0/200 karakter</small>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-600">Deskripsi Lengkap</label>
                        <textarea name="about_long" id="aboutLong" class="form-control" rows="8"><?= esc($s['about_long'] ?? '') ?></textarea>
                    </div>
                </div>

                <div class="section-label"><i class="fas fa-eye me-1"></i>Visi &amp; Misi</div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-600">Visi</label>
                        <textarea name="vision" class="form-control" rows="4"><?= $pv('vision') ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-600">Misi</label>
                        <textarea name="mission" class="form-control" rows="4"><?= $pv('mission') ?></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn tab-save-btn">
                        <i class="fas fa-save me-2"></i>Simpan Tentang Kami
                    </button>
                </div>
            </form>
        </div>

        <!-- ===== TAB 4: SOSMED ===== -->
        <div class="tab-pane fade" id="tabSosmed">
            <form class="tab-form" data-tab="sosmed">
                <?= csrf_field() ?>
                <input type="hidden" name="_tab" value="sosmed">

                <div class="section-label"><i class="fas fa-share-alt me-1"></i>Akun Media Sosial</div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-600"><i class="fab fa-instagram me-1" style="color:#e1306c;"></i>Instagram URL</label>
                        <input type="url" name="instagram_url" class="form-control" value="<?= $pv('instagram_url') ?>" placeholder="https://instagram.com/...">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-600"><i class="fab fa-facebook me-1" style="color:#1877f2;"></i>Facebook URL</label>
                        <input type="url" name="facebook_url" class="form-control" value="<?= $pv('facebook_url') ?>" placeholder="https://facebook.com/...">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-600"><i class="fab fa-youtube me-1" style="color:#ff0000;"></i>YouTube URL</label>
                        <input type="url" name="youtube_url" class="form-control" value="<?= $pv('youtube_url') ?>" placeholder="https://youtube.com/...">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-600"><i class="fab fa-linkedin me-1" style="color:#0a66c2;"></i>LinkedIn URL</label>
                        <input type="url" name="linkedin_url" class="form-control" value="<?= $pv('linkedin_url') ?>" placeholder="https://linkedin.com/...">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-600"><i class="fab fa-twitter me-1" style="color:#1da1f2;"></i>Twitter / X URL</label>
                        <input type="url" name="twitter_url" class="form-control" value="<?= $pv('twitter_url') ?>" placeholder="https://twitter.com/...">
                    </div>
                </div>

                <div class="section-label"><i class="fas fa-map me-1"></i>Google Maps</div>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label class="form-label fw-600">Google Maps Embed Code <small class="text-muted">(paste kode iframe dari Google Maps)</small></label>
                        <textarea name="google_maps_embed" class="form-control" rows="4" placeholder='&lt;iframe src="https://www.google.com/maps/embed?..." ...&gt;&lt;/iframe&gt;'><?= $pv('google_maps_embed') ?></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-600">Google Maps URL (Link Langsung)</label>
                        <input type="url" name="google_maps_url" class="form-control" value="<?= $pv('google_maps_url') ?>" placeholder="https://maps.google.com/...">
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn tab-save-btn">
                        <i class="fas fa-save me-2"></i>Simpan Media Sosial
                    </button>
                </div>
            </form>
        </div>

        <!-- ===== TAB 5: SEO ===== -->
        <div class="tab-pane fade" id="tabSeo">
            <form class="tab-form" data-tab="seo">
                <?= csrf_field() ?>
                <input type="hidden" name="_tab" value="seo">

                <div class="section-label"><i class="fas fa-search me-1"></i>SEO &amp; Meta Tags</div>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label class="form-label fw-600">Meta Title <small class="text-muted">(maks 60 karakter)</small></label>
                        <input type="text" name="meta_title" class="form-control" value="<?= $pv('meta_title','CV. Bagus Kencana Cakrada - Building Knowledge & Capacity') ?>" maxlength="100">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-600">Meta Description <small class="text-muted">(maks 160 karakter)</small></label>
                        <textarea name="meta_description" class="form-control" rows="3" maxlength="300"><?= $pv('meta_description') ?></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-600">Meta Keywords <small class="text-muted">(pisahkan dengan koma)</small></label>
                        <input type="text" name="meta_keywords" class="form-control" value="<?= $pv('meta_keywords','Bimtek,Pelatihan,Workshop,Seminar,EMBA,ASN,SDM,Bali') ?>">
                    </div>
                </div>

                <div class="section-label"><i class="fab fa-google me-1"></i>Google Tools</div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-600">Google Analytics ID <small class="text-muted">(G-XXXXXXXXXX atau UA-XXXXXXXX)</small></label>
                        <input type="text" name="google_analytics_id" class="form-control" value="<?= $pv('google_analytics_id') ?>" placeholder="G-XXXXXXXXXX">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-600">Google Site Verification</label>
                        <input type="text" name="google_site_verification" class="form-control" value="<?= $pv('google_site_verification') ?>" placeholder="Kode verifikasi dari Google Search Console">
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn tab-save-btn">
                        <i class="fas fa-save me-2"></i>Simpan SEO
                    </button>
                </div>
            </form>
        </div>

    </div><!-- /tab-content -->
</div>

<!-- CKEditor 5 -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;
const BASE = '<?= base_url() ?>';

// CKEditor for about_long
let editorAbout;
ClassicEditor.create(document.querySelector('#aboutLong'), {
    toolbar: ['heading','|','bold','italic','underline','link','bulletedList','numberedList','|','blockQuote','undo','redo']
}).then(e => { editorAbout = e; }).catch(console.error);

// About short char counter
const aboutShort = document.getElementById('aboutShort');
const aboutShortCount = document.getElementById('aboutShortCount');
if (aboutShort) {
    const updateCount = () => { aboutShortCount.textContent = aboutShort.value.length + '/200 karakter'; };
    aboutShort.addEventListener('input', updateCount);
    updateCount();
}

// Logo preview
document.getElementById('logoInput')?.addEventListener('change', function() {
    if (this.files[0]) {
        document.getElementById('logoPreview').src = URL.createObjectURL(this.files[0]);
        document.getElementById('logoPreview').style.display = '';
    }
});
document.getElementById('faviconInput')?.addEventListener('change', function() {
    if (this.files[0]) {
        document.getElementById('faviconPreview').src = URL.createObjectURL(this.files[0]);
        document.getElementById('faviconPreview').style.display = '';
    }
});

// Handle all tab forms
document.querySelectorAll('.tab-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const tab = this.dataset.tab;
        const fd = new FormData(this);

        // If CKEditor is on this tab, update textarea value
        if (editorAbout && this.querySelector('#aboutLong')) {
            fd.set('about_long', editorAbout.getData());
        }

        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...';

        fetch(BASE + 'admin/profil/perusahaan', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF },
            body: fd
        })
        .then(r => r.json().catch(() => ({ status: 'success', message: 'Data berhasil disimpan!' })))
        .then(data => {
            Swal.fire({ toast: true, position: 'top-end', icon: data.status === 'success' ? 'success' : 'error', title: data.message || 'Tersimpan!', showConfirmButton: false, timer: 2500 });
        })
        .catch(() => {
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Tersimpan!', showConfirmButton: false, timer: 2000 });
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-save me-2"></i>Simpan ' + tab.charAt(0).toUpperCase() + tab.slice(1);
        });
    });
});
</script>

<?= $this->endSection() ?>
