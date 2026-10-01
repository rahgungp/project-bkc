<?= $this->extend('Modules\Website\Views\layout\main') ?>
<?= $this->section('content') ?>

<style>
/* ===== CONTACT PAGE STYLES ===== */
.contact-hero {
    background: linear-gradient(135deg, #1E4FA3 0%, #152f6b 60%, #0d1f45 100%);
    padding: 100px 0 70px;
    position: relative;
    overflow: hidden;
    text-align: center;
}
.contact-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23C8A34D' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity: 0.6;
}
.contact-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(200,163,77,0.15);
    border: 1px solid rgba(200,163,77,0.4);
    color: #C8A34D;
    padding: 6px 18px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin-bottom: 20px;
}
.contact-hero h1 {
    font-size: clamp(2rem, 5vw, 3.5rem);
    font-weight: 800;
    color: #fff;
    margin-bottom: 16px;
}
.contact-hero p {
    font-size: 16px;
    color: rgba(255,255,255,0.7);
    max-width: 500px;
    margin: 0 auto;
}

/* Breadcrumb in hero */
.contact-hero-breadcrumb {
    margin-top: 24px;
    display: flex;
    justify-content: center;
    gap: 8px;
    font-size: 13px;
    color: rgba(255,255,255,0.5);
}
.contact-hero-breadcrumb a { color: rgba(255,255,255,0.7); text-decoration: none; }
.contact-hero-breadcrumb a:hover { color: #C8A34D; }
.contact-hero-breadcrumb span { color: rgba(255,255,255,0.4); }

/* Contact section */
.contact-section { padding: 80px 0; background: var(--bg-body, #f5f7fa); }

/* Info cards */
.contact-info-card {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    background: #fff;
    border: 1px solid rgba(0,0,0,0.06);
    border-radius: 16px;
    padding: 20px 22px;
    margin-bottom: 16px;
    transition: all 0.3s ease;
    text-decoration: none;
    color: inherit;
}
.contact-info-card:hover {
    border-color: #C8A34D;
    box-shadow: 0 4px 20px rgba(200,163,77,0.15);
    transform: translateY(-2px);
    color: inherit;
}
.contact-info-icon {
    width: 50px; height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #C8A34D, #e8c46d);
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
    color: #fff;
    flex-shrink: 0;
}
.contact-info-label {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #C8A34D;
    font-weight: 700;
    margin-bottom: 3px;
}
.contact-info-value {
    font-size: 14px;
    color: #1a1a2e;
    font-weight: 600;
    line-height: 1.4;
}

/* Office hours */
.office-hours {
    background: linear-gradient(135deg, #1E4FA3, #2563eb);
    border-radius: 16px;
    padding: 22px;
    color: #fff;
    margin-top: 8px;
}
.office-hours-title {
    font-size: 14px;
    font-weight: 700;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.hours-row {
    display: flex;
    justify-content: space-between;
    font-size: 13px;
    padding: 6px 0;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}
.hours-row:last-child { border-bottom: none; }
.hours-status {
    font-size: 11px;
    padding: 2px 10px;
    border-radius: 20px;
    font-weight: 600;
}
.hours-open { background: rgba(25,135,84,0.25); color: #6ddfa6; }
.hours-closed { background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.6); }

/* Social */
.social-row {
    display: flex;
    gap: 10px;
    margin-top: 16px;
}
.social-link {
    width: 42px; height: 42px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px;
    text-decoration: none;
    transition: all 0.3s;
    color: #fff;
}
.social-link.instagram { background: linear-gradient(135deg,#833ab4,#fd1d1d,#fcb045); }
.social-link.facebook { background: #1877f2; }
.social-link.youtube { background: #ff0000; }
.social-link.linkedin { background: #0a66c2; }
.social-link:hover { transform: scale(1.15); box-shadow: 0 4px 14px rgba(0,0,0,0.25); color: #fff; }

/* Contact form card */
.contact-form-card {
    background: #fff;
    border-radius: 20px;
    padding: 36px 40px;
    box-shadow: 0 4px 30px rgba(0,0,0,0.07);
    border: 1px solid rgba(0,0,0,0.05);
}
.contact-form-card .form-label { font-weight: 600; font-size: 13px; color: #333; margin-bottom: 6px; }
.contact-form-card .form-control,
.contact-form-card .form-select {
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    padding: 11px 14px;
    font-size: 14px;
    transition: border-color 0.2s;
}
.contact-form-card .form-control:focus,
.contact-form-card .form-select:focus {
    border-color: #1E4FA3;
    box-shadow: 0 0 0 3px rgba(30,79,163,0.1);
}
.contact-form-card textarea.form-control { min-height: 130px; resize: vertical; }
.btn-contact-submit {
    background: linear-gradient(135deg, #C8A34D, #e8c46d);
    border: none;
    color: #121212;
    font-weight: 700;
    padding: 13px 32px;
    border-radius: 50px;
    font-size: 15px;
    width: 100%;
    transition: all 0.3s;
    cursor: pointer;
}
.btn-contact-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(200,163,77,0.4);
}
.btn-contact-submit:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }
.field-error { font-size: 11.5px; color: #dc3545; margin-top: 4px; display: none; }
.field-error.show { display: block; }

/* Maps */
.contact-maps { padding: 0; }
.contact-maps iframe { display: block; width: 100%; height: 420px; border: none; }

/* Responsive */
@media (max-width: 768px) {
    .contact-form-card { padding: 24px 20px; }
    .contact-section { padding: 50px 0; }
}
</style>

<!-- ===== HERO ===== -->
<section class="contact-hero">
    <div class="container position-relative">
        <div data-aos="fade-up">
            <div class="contact-hero-badge">
                <i class="fas fa-headset"></i>
                Customer Support
            </div>
            <h1>Hubungi Kami</h1>
            <p>Kami siap membantu Anda. Kirimkan pesan atau kunjungi kantor kami di Bali.</p>
            <div class="contact-hero-breadcrumb">
                <a href="<?= base_url() ?>">Beranda</a>
                <span>/</span>
                <span style="color:rgba(255,255,255,0.9);">Kontak</span>
            </div>
        </div>
    </div>
</section>

<!-- ===== CONTACT MAIN SECTION ===== -->
<section class="contact-section">
    <div class="container">
        <div class="row g-5 align-items-start">

            <!-- ===== LEFT: Contact Info ===== -->
            <div class="col-lg-5" data-aos="fade-right">

                <div class="mb-4">
                    <div style="font-size:12px; text-transform:uppercase; letter-spacing:2px; color:#C8A34D; font-weight:700; margin-bottom:8px;">Informasi Kontak</div>
                    <h2 style="font-size:1.8rem; font-weight:800; color:#1a1a2e; margin-bottom:12px;">Kami Ada Untuk Anda</h2>
                    <p style="color:#666; font-size:14px; line-height:1.7;">Hubungi kami melalui salah satu saluran berikut atau kunjungi kantor kami langsung.</p>
                </div>

                <!-- Phone -->
                <?php if (!empty($profile['phone'])): ?>
                <a href="tel:<?= esc($profile['phone']) ?>" class="contact-info-card">
                    <div class="contact-info-icon"><i class="fas fa-phone-alt"></i></div>
                    <div>
                        <div class="contact-info-label">Telepon</div>
                        <div class="contact-info-value"><?= esc($profile['phone']) ?></div>
                    </div>
                </a>
                <?php endif; ?>

                <!-- Email -->
                <?php if (!empty($profile['email'])): ?>
                <a href="mailto:<?= esc($profile['email']) ?>" class="contact-info-card">
                    <div class="contact-info-icon" style="background:linear-gradient(135deg,#1E4FA3,#3b82f6);"><i class="fas fa-envelope"></i></div>
                    <div>
                        <div class="contact-info-label" style="color:#1E4FA3;">Email</div>
                        <div class="contact-info-value"><?= esc($profile['email']) ?></div>
                    </div>
                </a>
                <?php endif; ?>

                <!-- WhatsApp -->
                <?php $wa = $profile['whatsapp'] ?? $profile['phone'] ?? ''; ?>
                <?php if (!empty($wa)): ?>
                <?php $waClean = preg_replace('/[^0-9]/', '', $wa); if (substr($waClean, 0, 1) === '0') $waClean = '62' . substr($waClean, 1); ?>
                <a href="https://wa.me/<?= $waClean ?>?text=<?= urlencode('Halo Admin CV Bagus Kencana Cakrada. Saya ingin menanyakan informasi pelatihan.') ?>"
                   target="_blank" rel="noopener" class="contact-info-card">
                    <div class="contact-info-icon" style="background:linear-gradient(135deg,#25d366,#128c7e);"><i class="fab fa-whatsapp"></i></div>
                    <div>
                        <div class="contact-info-label" style="color:#25d366;">WhatsApp</div>
                        <div class="contact-info-value"><?= esc($wa) ?></div>
                        <div style="font-size:11px; color:#25d366; margin-top:2px;">Klik untuk chat langsung</div>
                    </div>
                </a>
                <?php endif; ?>

                <!-- Address -->
                <?php if (!empty($profile['address'])): ?>
                <div class="contact-info-card">
                    <div class="contact-info-icon" style="background:linear-gradient(135deg,#ef4444,#f97316);"><i class="fas fa-map-marker-alt"></i></div>
                    <div>
                        <div class="contact-info-label" style="color:#ef4444;">Alamat</div>
                        <div class="contact-info-value"><?= esc($profile['address']) ?></div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Social Media -->
                <div class="mt-3">
                    <div style="font-size:12px; font-weight:700; color:#888; text-transform:uppercase; letter-spacing:1px; margin-bottom:10px;">Ikuti Kami</div>
                    <div class="social-row">
                        <?php if (!empty($profile['instagram'])): ?>
                        <a href="<?= esc($profile['instagram']) ?>" target="_blank" rel="noopener" class="social-link instagram" title="Instagram"><i class="fab fa-instagram"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($profile['facebook'])): ?>
                        <a href="<?= esc($profile['facebook']) ?>" target="_blank" rel="noopener" class="social-link facebook" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($profile['youtube'])): ?>
                        <a href="<?= esc($profile['youtube']) ?>" target="_blank" rel="noopener" class="social-link youtube" title="YouTube"><i class="fab fa-youtube"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($profile['linkedin'])): ?>
                        <a href="<?= esc($profile['linkedin']) ?>" target="_blank" rel="noopener" class="social-link linkedin" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Office Hours -->
                <div class="office-hours mt-4">
                    <div class="office-hours-title">
                        <i class="fas fa-clock" style="color:#C8A34D;"></i>
                        Jam Operasional
                    </div>
                    <div class="hours-row">
                        <span>Senin – Jumat</span>
                        <div class="d-flex align-items-center gap-2">
                            <span>08:00 – 17:00 WITA</span>
                            <span class="hours-status hours-open">Buka</span>
                        </div>
                    </div>
                    <div class="hours-row">
                        <span>Sabtu</span>
                        <div class="d-flex align-items-center gap-2">
                            <span>08:00 – 13:00 WITA</span>
                            <span class="hours-status hours-open">Buka</span>
                        </div>
                    </div>
                    <div class="hours-row">
                        <span>Minggu / Hari Libur</span>
                        <div class="d-flex align-items-center gap-2">
                            <span>Tutup</span>
                            <span class="hours-status hours-closed">Tutup</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ===== RIGHT: Contact Form ===== -->
            <div class="col-lg-7" data-aos="fade-left">
                <div class="contact-form-card">
                    <div class="mb-4">
                        <div style="font-size:12px; text-transform:uppercase; letter-spacing:2px; color:#1E4FA3; font-weight:700; margin-bottom:6px;">Kirim Pesan</div>
                        <h3 style="font-size:1.5rem; font-weight:800; color:#1a1a2e; margin-bottom:6px;">Ada yang Bisa Kami Bantu?</h3>
                        <p style="color:#777; font-size:13px;">Isi formulir di bawah ini dan tim kami akan merespons dalam 1×24 jam kerja.</p>
                    </div>

                    <form id="contactForm" novalidate>
                        <?= csrf_field() ?>

                        <div class="row g-3">
                            <!-- Nama -->
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="name"
                                       placeholder="Nama lengkap Anda" required minlength="3" maxlength="200">
                                <div class="field-error" id="err_name"></div>
                            </div>
                            <!-- Email -->
                            <div class="col-md-6">
                                <label class="form-label">Alamat Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" id="email"
                                       placeholder="email@domain.com" required>
                                <div class="field-error" id="err_email"></div>
                            </div>
                            <!-- Phone -->
                            <div class="col-md-6">
                                <label class="form-label">No. Telepon / WhatsApp</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="border-radius:10px 0 0 10px; background:#f8fafc; border:1.5px solid #e2e8f0; border-right:none; color:#666;">
                                        <i class="fab fa-whatsapp" style="color:#25d366;"></i>
                                    </span>
                                    <input type="tel" class="form-control" name="phone" id="phone"
                                           placeholder="+62 8xx xxxx xxxx"
                                           style="border-radius:0 10px 10px 0; border-left:none;">
                                </div>
                            </div>
                            <!-- Subject -->
                            <div class="col-md-6">
                                <label class="form-label">Subjek <span class="text-danger">*</span></label>
                                <select class="form-select" name="subject" id="subject" required>
                                    <option value="" disabled selected>Pilih subjek...</option>
                                    <option value="Informasi Pelatihan">Informasi Pelatihan</option>
                                    <option value="Pendaftaran">Pendaftaran Pelatihan</option>
                                    <option value="Kerjasama">Kerjasama / In-House Training</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                <div class="field-error" id="err_subject"></div>
                            </div>
                            <!-- Message -->
                            <div class="col-12">
                                <label class="form-label">Pesan <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="message" id="message"
                                          placeholder="Tulis pesan Anda di sini... (minimal 20 karakter)"
                                          required minlength="20"></textarea>
                                <div class="field-error" id="err_message"></div>
                                <div style="font-size:11px; color:#aaa; margin-top:4px;">
                                    <span id="charCount">0</span> karakter (minimal 20)
                                </div>
                            </div>
                            <!-- Submit -->
                            <div class="col-12">
                                <button type="submit" class="btn-contact-submit" id="submitBtn">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Kirim Pesan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== GOOGLE MAPS ===== -->
<section class="contact-maps">
    <?php if (!empty($profile['google_maps_embed'])): ?>
        <?= $profile['google_maps_embed'] ?>
    <?php else: ?>
        <!-- Default: Denpasar, Bali -->
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.082063453636!2d115.20555761478461!3d-8.67116999369076!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd23f6b26ef5d0f%3A0x9d2ffe0f0a1bf21e!2sDenpasar%2C%20Bali!5e0!3m2!1sid!2sid!4v1697123456789!5m2!1sid!2sid"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            title="Lokasi CV. Bagus Kencana Cakrada">
        </iframe>
    <?php endif; ?>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form        = document.getElementById('contactForm');
    const submitBtn   = document.getElementById('submitBtn');
    const messageArea = document.getElementById('message');
    const charCount   = document.getElementById('charCount');

    // Live character counter
    messageArea.addEventListener('input', function () {
        charCount.textContent = this.value.length;
        charCount.style.color = this.value.length >= 20 ? '#198754' : '#aaa';
    });

    // Clear error helper
    function clearErrors() {
        document.querySelectorAll('.field-error').forEach(el => {
            el.textContent = '';
            el.classList.remove('show');
        });
        document.querySelectorAll('.form-control, .form-select').forEach(el => {
            el.classList.remove('is-invalid');
        });
    }

    function showError(field, msg) {
        const el = document.getElementById('err_' + field);
        if (el) { el.textContent = msg; el.classList.add('show'); }
        const input = document.getElementById(field);
        if (input) input.classList.add('is-invalid');
    }

    // AJAX submit
    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        clearErrors();

        // Client-side validation
        let valid = true;
        const name    = document.getElementById('name').value.trim();
        const email   = document.getElementById('email').value.trim();
        const subject = document.getElementById('subject').value;
        const message = document.getElementById('message').value.trim();

        if (name.length < 3) { showError('name', 'Nama minimal 3 karakter.'); valid = false; }
        if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { showError('email', 'Email tidak valid.'); valid = false; }
        if (!subject) { showError('subject', 'Silakan pilih subjek.'); valid = false; }
        if (message.length < 20) { showError('message', 'Pesan minimal 20 karakter.'); valid = false; }

        if (!valid) return;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';

        try {
            const formData = new FormData(form);
            const res = await fetch('<?= base_url('kontak/kirim') ?>', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await res.json();

            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Pesan Terkirim!',
                    text: data.message || 'Kami akan menghubungi Anda segera.',
                    confirmButtonColor: '#C8A34D',
                    confirmButtonText: 'OK',
                }).then(() => {
                    form.reset();
                    charCount.textContent = '0';
                    charCount.style.color = '#aaa';
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: data.message || 'Terjadi kesalahan. Silakan coba lagi.',
                    confirmButtonColor: '#1E4FA3',
                });
            }
        } catch (err) {
            Swal.fire({
                icon: 'error',
                title: 'Koneksi Gagal',
                text: 'Tidak dapat terhubung ke server. Silakan coba beberapa saat lagi.',
                confirmButtonColor: '#1E4FA3',
            });
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Kirim Pesan';
        }
    });
});
</script>

<?= $this->endSection() ?>
