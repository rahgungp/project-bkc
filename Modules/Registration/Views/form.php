<?= $this->extend('Modules\Website\Views\layout\main') ?>
<?= $this->section('content') ?>

<style>
:root {
    --gold: #C8A34D;
    --gold-light: rgba(200,163,77,0.12);
    --royal: #1E4FA3;
    --royal-light: rgba(30,79,163,0.08);
    --dark: #121212;
}

/* ---- Hero ---- */
.reg-hero {
    background: linear-gradient(135deg, #0a0a1a 0%, #0d1b3e 50%, #121212 100%);
    padding: 100px 0 60px;
    position: relative;
    overflow: hidden;
}
.reg-hero::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse 55% 55% at 80% 50%, rgba(200,163,77,0.08) 0%, transparent 60%),
                radial-gradient(ellipse 45% 45% at 15% 70%, rgba(30,79,163,0.10) 0%, transparent 60%);
}
.reg-hero-badge {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 6px 18px;
    background: rgba(200,163,77,0.15); border: 1px solid rgba(200,163,77,0.3);
    border-radius: 100px; font-size: 12px; font-weight: 600; letter-spacing: 1.2px;
    text-transform: uppercase; color: #C8A34D; margin-bottom: 18px;
}
.reg-hero-title { font-size: clamp(30px,4vw,52px); font-weight: 900; color: #fff; margin-bottom: 14px; }
.reg-hero-title span { color: #C8A34D; }
.reg-hero-sub { color: rgba(255,255,255,.7); font-size: 16px; max-width: 520px; }

/* ---- Training Info Card ---- */
.training-info-card {
    background: linear-gradient(135deg, #fff, #f8f9fa);
    border-left: 4px solid #C8A34D;
    border-radius: 14px;
    padding: 22px 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,.08);
    margin-bottom: 28px;
}
.training-info-title { font-size: 18px; font-weight: 800; color: #1E4FA3; margin-bottom: 10px; }
.training-meta-item { display: flex; align-items: center; gap: 10px; font-size: 14px; color: #555; margin-bottom: 6px; }
.training-meta-item i { color: #C8A34D; width: 18px; flex-shrink: 0; }
.training-price-display { font-size: 22px; font-weight: 800; color: #C8A34D; }
.spots-remaining { background: rgba(200,163,77,.12); border: 1px solid rgba(200,163,77,.3); color: #7a5a1a; font-size: 12px; font-weight: 700; border-radius: 30px; padding: 4px 14px; display: inline-flex; align-items: center; gap: 6px; }
.spots-remaining.urgent { background: rgba(220,53,69,.1); border-color: rgba(220,53,69,.3); color: #dc3545; }

/* ---- Form Card ---- */
.reg-form-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 8px 40px rgba(0,0,0,.1);
    overflow: hidden;
}
.reg-form-header {
    background: linear-gradient(135deg, #1E4FA3, #0d3280);
    padding: 28px 32px;
    color: #fff;
}
.reg-form-header h2 { font-size: 22px; font-weight: 800; margin: 0; }
.reg-form-header p { color: rgba(255,255,255,.75); margin: 6px 0 0; font-size: 14px; }
.reg-form-body { padding: 32px; }
.form-section-title {
    font-size: 12px; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase;
    color: #C8A34D; margin-bottom: 16px; padding-bottom: 8px;
    border-bottom: 1px solid rgba(200,163,77,.3);
}
.form-label { font-weight: 600; font-size: 14px; color: #333; margin-bottom: 6px; }
.form-control, .form-select {
    border-radius: 10px; border: 1.5px solid #dee2e6; padding: 10px 14px; font-size: 14px;
    transition: border-color .2s, box-shadow .2s;
}
.form-control:focus, .form-select:focus {
    border-color: #C8A34D; box-shadow: 0 0 0 3px rgba(200,163,77,.15); outline: none;
}
.form-control.is-invalid { border-color: #dc3545; }
.invalid-feedback { font-size: 12px; font-weight: 500; }
.input-group-text { border-radius: 10px 0 0 10px; border: 1.5px solid #dee2e6; border-right: none; background: #f8f9fa; color: #6B7280; }
.input-group .form-control { border-radius: 0 10px 10px 0; }

/* Training select option styling */
select[name="training_id"] option { padding: 8px; }

/* ---- Submit Button ---- */
.btn-register {
    background: linear-gradient(135deg, #C8A34D, #e0b85a);
    color: #121212; font-weight: 800; font-size: 16px; padding: 16px 32px;
    border: none; border-radius: 12px; width: 100%; cursor: pointer;
    transition: all .25s; box-shadow: 0 4px 18px rgba(200,163,77,.35);
    display: flex; align-items: center; justify-content: center; gap: 10px;
}
.btn-register:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(200,163,77,.45); }
.btn-register:disabled { opacity: .7; cursor: not-allowed; transform: none; }

/* ---- WA Direct Button ---- */
.btn-wa-direct {
    background: #25d366; color: #fff; font-weight: 700; font-size: 14px;
    padding: 14px 24px; border: none; border-radius: 12px; cursor: pointer;
    transition: all .25s; display: inline-flex; align-items: center; gap: 10px;
    text-decoration: none; box-shadow: 0 4px 14px rgba(37,211,102,.3);
}
.btn-wa-direct:hover { background: #20b858; color: #fff; transform: translateY(-2px); }

/* ---- Right Info Panel ---- */
.reg-info-panel { padding-left: 24px; }
.info-step {
    display: flex; gap: 16px; margin-bottom: 22px;
}
.info-step-num {
    width: 38px; height: 38px; border-radius: 50%; background: var(--gold-light);
    border: 2px solid rgba(200,163,77,.4); color: #C8A34D; font-weight: 800; font-size: 16px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.info-step-text h6 { font-size: 14px; font-weight: 700; color: #212529; margin-bottom: 3px; }
.info-step-text p { font-size: 12px; color: #6B7280; margin: 0; }

.guarantee-badge {
    background: #f8f9fa; border-radius: 12px; padding: 18px;
    border: 1px solid #e9ecef; text-align: center;
}
.guarantee-badge i { font-size: 28px; color: #C8A34D; margin-bottom: 8px; }
.guarantee-badge h6 { font-size: 13px; font-weight: 700; color: #333; margin-bottom: 4px; }
.guarantee-badge p { font-size: 12px; color: #6B7280; margin: 0; }
</style>

<!-- HERO -->
<section class="reg-hero">
    <div class="container position-relative">
        <div class="row">
            <div class="col-lg-7" data-aos="fade-up">
                <div class="reg-hero-badge">
                    <i class="fas fa-clipboard-list"></i>
                    Formulir Pendaftaran
                </div>
                <h1 class="reg-hero-title">
                    Daftar <span>Pelatihan</span><br>Sekarang
                </h1>
                <p class="reg-hero-sub">
                    Isi formulir di bawah ini untuk mendaftar. Tim kami akan segera mengkonfirmasi pendaftaran Anda via WhatsApp.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- FORM SECTION -->
<section style="background: #f5f7fa; padding: 60px 0 80px;">
    <div class="container">
        <div class="row g-5">

            <!-- FORM CARD -->
            <div class="col-lg-7" data-aos="fade-up">

                <!-- Training Info Card (shown when training is pre-selected) -->
                <?php if(!empty($training)): ?>
                <div class="training-info-card" data-aos="fade-up">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                        <div class="flex-grow-1">
                            <div class="training-info-title"><?= esc($training['title']) ?></div>
                            <div class="training-meta-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span>
                                    <?= !empty($training['start_date']) ? date('d F Y', strtotime($training['start_date'])) : '' ?>
                                    <?= (!empty($training['start_date']) && !empty($training['end_date'])) ? ' – ' . date('d F Y', strtotime($training['end_date'])) : '' ?>
                                </span>
                            </div>
                            <?php if(!empty($training['location_name'])): ?>
                            <div class="training-meta-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?= esc($training['location_name']) ?></span>
                            </div>
                            <?php endif; ?>
                            <?php if(!empty($training['category_name'])): ?>
                            <div class="training-meta-item">
                                <i class="fas fa-tag"></i>
                                <span><?= esc($training['category_name']) ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="text-end">
                            <div class="training-price-display">
                                <?php if(($training['price'] ?? 0) == 0): ?>
                                    <span style="color:#198754;">Gratis</span>
                                <?php else: ?>
                                    Rp <?= number_format((int)$training['price'], 0, ',', '.') ?>
                                <?php endif; ?>
                            </div>
                            <?php if(isset($spotsLeft)): ?>
                            <div class="mt-2">
                                <span class="spots-remaining <?= $spotsLeft <= 5 ? 'urgent' : '' ?>">
                                    <i class="fas fa-users"></i>
                                    <?= $spotsLeft ?> sisa kursi
                                </span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Main Form -->
                <div class="reg-form-card">
                    <div class="reg-form-header">
                        <h2><i class="fas fa-user-plus me-2"></i>Form Pendaftaran</h2>
                        <p>Lengkapi data di bawah ini dengan benar dan lengkap</p>
                    </div>
                    <div class="reg-form-body">
                        <form id="registrationForm">
                            <?= csrf_field() ?>

                            <!-- Pelatihan -->
                            <div class="form-section-title"><i class="fas fa-graduation-cap me-1"></i>Pilih Pelatihan</div>
                            <div class="mb-4">
                                <label class="form-label">Pelatihan yang Diminati <span class="text-danger">*</span></label>
                                <?php if(!empty($training)): ?>
                                    <!-- Pre-selected training -->
                                    <input type="hidden" name="training_id" value="<?= (int)$training['id'] ?>">
                                    <div class="form-control" style="background:#f8f9fa; cursor:default; color:#333;">
                                        <i class="fas fa-check-circle me-2" style="color:#198754;"></i>
                                        <?= esc($training['title']) ?>
                                    </div>
                                <?php else: ?>
                                    <select name="training_id" class="form-select" required id="trainingSelect">
                                        <option value="">-- Pilih Pelatihan --</option>
                                        <?php if(!empty($trainings)): foreach($trainings as $tr): ?>
                                        <option value="<?= $tr['id'] ?>"
                                            <?= (isset($_GET['training_id']) && $_GET['training_id'] == $tr['id']) ? 'selected' : '' ?>>
                                            <?= esc($tr['title']) ?>
                                            <?= !empty($tr['start_date']) ? ' | ' . date('d M Y', strtotime($tr['start_date'])) : '' ?>
                                            <?= !empty($tr['price']) ? ' | Rp ' . number_format($tr['price'],0,',','.') : ' | Gratis' ?>
                                        </option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                    <div class="invalid-feedback">Pilih pelatihan terlebih dahulu.</div>
                                <?php endif; ?>
                            </div>

                            <!-- Data Peserta -->
                            <div class="form-section-title"><i class="fas fa-user me-1"></i>Data Peserta</div>
                            <div class="row g-3 mb-4">
                                <div class="col-12">
                                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="Nama sesuai KTP / identitas" required>
                                    <div class="invalid-feedback">Nama lengkap wajib diisi.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" name="email" class="form-control" placeholder="email@contoh.com" required>
                                    </div>
                                    <div class="invalid-feedback">Email wajib diisi dengan format yang benar.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nomor HP / WhatsApp <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                                        <input type="tel" name="phone" class="form-control" placeholder="08xx-xxxx-xxxx" required>
                                    </div>
                                    <div class="invalid-feedback">Nomor HP wajib diisi.</div>
                                </div>
                            </div>

                            <!-- Data Instansi -->
                            <div class="form-section-title"><i class="fas fa-building me-1"></i>Data Instansi</div>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Instansi / Perusahaan <span class="text-danger">*</span></label>
                                    <input type="text" name="institution" class="form-control" placeholder="Nama instansi atau perusahaan" required>
                                    <div class="invalid-feedback">Instansi wajib diisi.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jabatan / Posisi</label>
                                    <input type="text" name="position" class="form-control" placeholder="Contoh: Staff, Kepala Dinas...">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Alamat</label>
                                    <textarea name="address" class="form-control" rows="2" placeholder="Alamat instansi..."></textarea>
                                </div>
                            </div>

                            <!-- Informasi Tambahan -->
                            <div class="form-section-title"><i class="fas fa-info-circle me-1"></i>Informasi Tambahan</div>
                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <label class="form-label">Jumlah Peserta</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-users"></i></span>
                                        <input type="number" name="participant_count" class="form-control" value="1" min="1" max="50">
                                    </div>
                                    <small class="text-muted" style="font-size:11px;">Untuk pendaftaran grup, hubungi kami</small>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label">Catatan / Permintaan Khusus</label>
                                    <textarea name="special_request" class="form-control" rows="2" placeholder="Misalnya: kebutuhan aksesibilitas, alergi makanan, dll."></textarea>
                                </div>
                            </div>

                            <!-- Error Messages Area -->
                            <div id="formErrors" style="display:none;" class="alert alert-danger">
                                <ul id="errorList" class="mb-0" style="font-size:13px; padding-left:18px;"></ul>
                            </div>

                            <!-- Submit -->
                            <button type="submit" class="btn-register" id="submitBtn">
                                <i class="fab fa-whatsapp" style="font-size:20px;"></i>
                                Daftar Sekarang via WhatsApp
                            </button>

                            <div class="text-center mt-3">
                                <small class="text-muted">
                                    <i class="fas fa-lock me-1"></i>
                                    Data Anda aman dan terlindungi. Dengan mendaftar, Anda menyetujui syarat &amp; ketentuan kami.
                                </small>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Direct WA Option -->
                <div class="text-center mt-4">
                    <p class="text-muted mb-3" style="font-size:14px;">Atau hubungi kami langsung:</p>
                    <a href="https://wa.me/6281803867430?text=<?= urlencode('Halo Admin BKC, saya ingin mendaftar pelatihan. Mohon informasinya. Terima kasih.') ?>"
                       target="_blank" rel="noopener" class="btn-wa-direct">
                        <i class="fab fa-whatsapp fa-lg"></i>
                        Chat via WhatsApp: +62 818-0386-7430
                    </a>
                </div>

            </div>

            <!-- RIGHT INFO PANEL -->
            <div class="col-lg-5" data-aos="fade-up" data-aos-delay="100">
                <div class="reg-info-panel">
                    <h5 style="font-weight:800; color:#1E4FA3; margin-bottom:24px;">
                        <i class="fas fa-list-check me-2" style="color:#C8A34D;"></i>
                        Langkah Pendaftaran
                    </h5>

                    <div class="info-step">
                        <div class="info-step-num">1</div>
                        <div class="info-step-text">
                            <h6>Isi Formulir</h6>
                            <p>Lengkapi data diri dan pilih pelatihan yang Anda inginkan</p>
                        </div>
                    </div>
                    <div class="info-step">
                        <div class="info-step-num">2</div>
                        <div class="info-step-text">
                            <h6>Konfirmasi via WhatsApp</h6>
                            <p>Setelah form terkirim, Anda akan diarahkan ke WhatsApp untuk konfirmasi otomatis</p>
                        </div>
                    </div>
                    <div class="info-step">
                        <div class="info-step-num">3</div>
                        <div class="info-step-text">
                            <h6>Terima Kode Pendaftaran</h6>
                            <p>Tim kami akan mengirimkan kode pendaftaran dan detail pembayaran</p>
                        </div>
                    </div>
                    <div class="info-step">
                        <div class="info-step-num">4</div>
                        <div class="info-step-text">
                            <h6>Selesaikan Pembayaran</h6>
                            <p>Lakukan pembayaran sesuai instruksi dan kirimkan bukti transfer</p>
                        </div>
                    </div>
                    <div class="info-step">
                        <div class="info-step-num">5</div>
                        <div class="info-step-text">
                            <h6>Ikuti Pelatihan</h6>
                            <p>Hadir di waktu yang telah ditentukan dan dapatkan sertifikat</p>
                        </div>
                    </div>

                    <hr style="border-color: rgba(200,163,77,.3); margin: 28px 0;">

                    <!-- Guarantees -->
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="guarantee-badge">
                                <i class="fas fa-certificate d-block"></i>
                                <h6>Sertifikat Resmi</h6>
                                <p>Diakui instansi pemerintah &amp; swasta</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="guarantee-badge">
                                <i class="fas fa-chalkboard-teacher d-block"></i>
                                <h6>Narasumber Ahli</h6>
                                <p>Praktisi &amp; akademisi berpengalaman</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="guarantee-badge">
                                <i class="fas fa-shield-alt d-block"></i>
                                <h6>Terjamin</h6>
                                <p>Uang kembali jika tidak puas</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="guarantee-badge">
                                <i class="fab fa-whatsapp d-block"></i>
                                <h6>Dukungan WA</h6>
                                <p>Respon cepat 08.00–17.00 WITA</p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Card -->
                    <div class="mt-4 p-4" style="background:#1E4FA3; border-radius:14px; color:#fff;">
                        <h6 style="font-weight:800; margin-bottom:14px;"><i class="fas fa-headset me-2" style="color:#C8A34D;"></i>Butuh Bantuan?</h6>
                        <div style="font-size:13px; color:rgba(255,255,255,.85); margin-bottom:8px;">
                            <i class="fab fa-whatsapp me-2" style="color:#25d366;"></i>
                            <strong>+62 818-0386-7430</strong>
                        </div>
                        <div style="font-size:13px; color:rgba(255,255,255,.85); margin-bottom:8px;">
                            <i class="fas fa-envelope me-2" style="color:#C8A34D;"></i>
                            info@bkc.co.id
                        </div>
                        <div style="font-size:12px; color:rgba(255,255,255,.6);">
                            <i class="fas fa-clock me-2"></i>
                            Senin – Jumat, 08.00 – 17.00 WITA
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '';
const BASE = '<?= base_url() ?>';

document.getElementById('registrationForm').addEventListener('submit', function(e) {
    e.preventDefault();

    // Clear previous errors
    const errBox = document.getElementById('formErrors');
    const errList = document.getElementById('errorList');
    errBox.style.display = 'none';
    errList.innerHTML = '';
    document.querySelectorAll('.form-control.is-invalid, .form-select.is-invalid').forEach(el => el.classList.remove('is-invalid'));

    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';

    const fd = new FormData(this);
    fd.set('<?= csrf_token() ?>', CSRF);

    fetch(BASE + 'daftar', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': CSRF },
        body: fd
    })
    .then(r => r.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Pendaftaran Berhasil!',
                html: `
                    <div style="text-align:center; padding: 10px 0;">
                        <div style="font-size:14px; color:#555; margin-bottom:16px;">Kode pendaftaran Anda:</div>
                        <div style="font-size:28px; font-weight:900; font-family:monospace; color:#C8A34D; letter-spacing:3px; margin-bottom:12px;">
                            ${data.registration_code}
                        </div>
                        <div style="font-size:13px; color:#6B7280;">Simpan kode ini untuk referensi.</div>
                    </div>`,
                confirmButtonText: '<i class="fab fa-whatsapp me-1"></i> Lanjut ke WhatsApp',
                confirmButtonColor: '#25d366',
                showCancelButton: true,
                cancelButtonText: 'Nanti',
                cancelButtonColor: '#6c757d',
                allowOutsideClick: false
            }).then(result => {
                if (result.isConfirmed && data.wa_url) {
                    window.open(data.wa_url, '_blank');
                }
                // Redirect to home or thank you page
                window.location.href = BASE;
            });
        } else {
            // Show errors
            const errors = data.errors || [data.message || 'Terjadi kesalahan, coba lagi.'];
            if (Array.isArray(errors)) {
                errors.forEach(err => {
                    const li = document.createElement('li');
                    li.textContent = err;
                    errList.appendChild(li);
                });
            } else {
                Object.entries(errors).forEach(([field, msg]) => {
                    const li = document.createElement('li');
                    li.textContent = msg;
                    errList.appendChild(li);
                    // Highlight field
                    const input = document.querySelector('[name="' + field + '"]');
                    if (input) input.classList.add('is-invalid');
                });
            }
            errBox.style.display = 'block';
            errBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    })
    .catch(() => {
        Swal.fire({ icon: 'error', title: 'Koneksi Bermasalah', text: 'Periksa koneksi internet Anda dan coba lagi.' });
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fab fa-whatsapp" style="font-size:20px;"></i> Daftar Sekarang via WhatsApp';
    });
});
</script>

<?= $this->endSection() ?>
