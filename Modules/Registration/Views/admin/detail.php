<?= $this->extend('Modules\Admin\Views\layout\main') ?>
<?= $this->section('content') ?>

<style>
.timeline-steps {
    display: flex; align-items: center; gap: 0; margin: 20px 0;
}
.timeline-step {
    flex: 1; text-align: center; position: relative;
}
.timeline-step:not(:last-child)::after {
    content: ''; position: absolute; top: 20px; left: 50%; width: 100%; height: 3px;
    background: #dee2e6; z-index: 0;
}
.timeline-step.done:not(:last-child)::after { background: #C8A34D; }
.timeline-dot {
    width: 40px; height: 40px; border-radius: 50%; background: #dee2e6; color: #adb5bd;
    display: inline-flex; align-items: center; justify-content: center; font-size: 14px;
    position: relative; z-index: 1; font-weight: 700; border: 3px solid #dee2e6; transition: all .3s;
}
.timeline-step.done .timeline-dot {
    background: #C8A34D; color: #fff; border-color: #C8A34D;
}
.timeline-step.active .timeline-dot {
    background: #1E4FA3; color: #fff; border-color: #1E4FA3;
    box-shadow: 0 0 0 4px rgba(30,79,163,.2);
}
.timeline-label {
    font-size: 11px; font-weight: 600; margin-top: 8px; color: #6B7280;
}
.timeline-step.done .timeline-label, .timeline-step.active .timeline-label { color: #212529; }
.info-label {
    font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .8px; color: #6B7280; margin-bottom: 3px;
}
.info-val { font-size: 14px; font-weight: 500; color: #212529; margin-bottom: 14px; }
.status-badge-lg {
    display: inline-block; padding: 6px 18px; border-radius: 30px; font-weight: 700; font-size: 13px;
}
.status-pending    { background: rgba(245,158,11,.15); color: #b45309; }
.status-confirmed  { background: rgba(30,79,163,.12); color: #1E4FA3; }
.status-paid       { background: rgba(25,135,84,.12); color: #198754; }
.status-completed  { background: rgba(200,163,77,.18); color: #7a5a1a; }
.status-rejected, .status-cancelled { background: rgba(220,53,69,.1); color: #dc3545; }
.detail-card { border-radius: 14px; box-shadow: 0 2px 10px rgba(0,0,0,.06); }
.payment-proof-thumb {
    width: 100%; max-height: 220px; object-fit: cover; border-radius: 10px; cursor: pointer; border: 1px solid #dee2e6;
}
.action-btn-row .btn { border-radius: 10px; font-weight: 600; font-size: 13px; padding: 10px 18px; }
.reg-code-badge {
    font-size: 22px; font-weight: 800; font-family: monospace; background: rgba(200,163,77,.12);
    color: #C8A34D; border: 2px solid rgba(200,163,77,.3); border-radius: 10px; padding: 8px 20px; letter-spacing: 2px;
}
</style>

<?php
$reg = $reg ?? [];
$statusSteps = ['pending','confirmed','paid','completed'];
$currentStepIdx = array_search($reg['status'] ?? 'pending', $statusSteps);
if ($currentStepIdx === false) $currentStepIdx = -1; // rejected/cancelled

$statusLabels = [
    'pending' => ['label' => 'Menunggu', 'icon' => 'fa-clock'],
    'confirmed' => ['label' => 'Dikonfirmasi', 'icon' => 'fa-check-circle'],
    'paid' => ['label' => 'Lunas', 'icon' => 'fa-money-bill-wave'],
    'completed' => ['label' => 'Selesai', 'icon' => 'fa-award'],
];

$allStatuses = ['pending','confirmed','paid','completed','rejected','cancelled'];
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Detail Pendaftaran</h1>
        <p class="page-subtitle">
            <span class="reg-code-badge"><?= esc($reg['registration_code'] ?? 'N/A') ?></span>
        </p>
    </div>
    <div class="page-actions">
        <a href="<?= base_url('admin/pendaftaran') ?>" class="btn btn-outline-secondary" style="border-radius:10px; padding:9px 16px; font-size:13px;">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
        <a href="<?= base_url('admin/pendaftaran/export-pdf') ?>" target="_blank" class="btn btn-outline-danger" style="border-radius:10px; padding:9px 16px; font-size:13px;">
            <i class="fas fa-print me-1"></i>Cetak
        </a>
    </div>
</div>

<div class="row g-4">

    <!-- ====== LEFT COLUMN ====== -->
    <div class="col-lg-8">

        <!-- Registration Info Card -->
        <div class="admin-card detail-card mb-4" data-aos="fade-up">
            <div class="admin-card-header">
                <h6 class="admin-card-title"><i class="fas fa-graduation-cap me-2"></i>Informasi Pelatihan</h6>
                <span class="status-badge-lg status-<?= esc($reg['status'] ?? 'pending') ?>">
                    <?= ucfirst(esc($reg['status'] ?? 'pending')) ?>
                </span>
            </div>
            <div class="admin-card-body">
                <div class="row g-3">
                    <div class="col-md-12">
                        <div class="info-label">Judul Pelatihan</div>
                        <div class="info-val" style="font-size:16px; font-weight:700; color:#1E4FA3;"><?= esc($reg['training_title'] ?? '-') ?></div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-label">Tanggal Mulai</div>
                        <div class="info-val">
                            <i class="fas fa-calendar me-1" style="color:#C8A34D;"></i>
                            <?= !empty($reg['start_date']) ? date('d F Y', strtotime($reg['start_date'])) : '-' ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-label">Tanggal Selesai</div>
                        <div class="info-val">
                            <i class="fas fa-calendar-check me-1" style="color:#C8A34D;"></i>
                            <?= !empty($reg['end_date']) ? date('d F Y', strtotime($reg['end_date'])) : '-' ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-label">Lokasi</div>
                        <div class="info-val">
                            <i class="fas fa-map-marker-alt me-1" style="color:#C8A34D;"></i>
                            <?= esc($reg['location_name'] ?? $reg['location'] ?? '-') ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-label">Tanggal Daftar</div>
                        <div class="info-val">
                            <i class="fas fa-clock me-1"></i>
                            <?= !empty($reg['created_at']) ? date('d/m/Y H:i', strtotime($reg['created_at'])) : '-' ?>
                        </div>
                    </div>
                    <?php if(!empty($reg['confirmed_at'])): ?>
                    <div class="col-md-4">
                        <div class="info-label">Dikonfirmasi Pada</div>
                        <div class="info-val">
                            <i class="fas fa-check me-1" style="color:#198754;"></i>
                            <?= date('d/m/Y H:i', strtotime($reg['confirmed_at'])) ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if(!empty($reg['special_request'])): ?>
                    <div class="col-12">
                        <div class="info-label">Catatan / Permintaan Khusus</div>
                        <div class="info-val"><?= nl2br(esc($reg['special_request'])) ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Status Timeline -->
        <div class="admin-card detail-card mb-4" data-aos="fade-up">
            <div class="admin-card-header">
                <h6 class="admin-card-title"><i class="fas fa-stream me-2"></i>Timeline Status</h6>
            </div>
            <div class="admin-card-body">
                <div class="timeline-steps">
                    <?php foreach($statusSteps as $i => $step):
                        $isDone = $currentStepIdx > $i;
                        $isActive = $currentStepIdx === $i;
                        $stepClass = $isDone ? 'done' : ($isActive ? 'active' : '');
                        $info = $statusLabels[$step];
                    ?>
                    <div class="timeline-step <?= $stepClass ?>">
                        <div class="timeline-dot">
                            <i class="fas <?= $isDone ? 'fa-check' : $info['icon'] ?>"></i>
                        </div>
                        <div class="timeline-label"><?= $info['label'] ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <?php if(in_array($reg['status'] ?? '', ['rejected','cancelled'])): ?>
                <div class="alert alert-danger mt-3 mb-0">
                    <i class="fas fa-ban me-2"></i>
                    Pendaftaran ini berstatus <strong><?= ucfirst(esc($reg['status'])) ?></strong>.
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Status Update Form -->
        <div class="admin-card detail-card mb-4" data-aos="fade-up">
            <div class="admin-card-header">
                <h6 class="admin-card-title"><i class="fas fa-edit me-2"></i>Update Status Pendaftaran</h6>
            </div>
            <div class="admin-card-body">
                <form id="statusUpdateForm">
                    <?= csrf_field() ?>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-600">Status Baru</label>
                            <select name="status" class="form-select" id="newStatusSelect">
                                <?php foreach($allStatuses as $st): ?>
                                <option value="<?= $st ?>" <?= ($reg['status'] ?? '') === $st ? 'selected' : '' ?>>
                                    <?= ucfirst($st) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-600">Catatan (opsional)</label>
                            <input type="text" name="notes" class="form-control" placeholder="Tambahkan catatan untuk perubahan status ini...">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn" style="background:#C8A34D; color:#121212; font-weight:700; border-radius:10px; padding:10px 24px;">
                                <i class="fas fa-save me-2"></i>Simpan Status
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Previous Registrations -->
        <?php if(!empty($reg['participant_email'])): ?>
        <div class="admin-card detail-card" data-aos="fade-up">
            <div class="admin-card-header">
                <h6 class="admin-card-title"><i class="fas fa-history me-2"></i>Riwayat Pendaftaran Peserta</h6>
                <small class="text-muted"><?= esc($reg['participant_email'] ?? '') ?></small>
            </div>
            <div class="admin-card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0" id="historyTable">
                        <thead>
                            <tr><th>Kode</th><th>Pelatihan</th><th>Status</th><th>Tanggal</th></tr>
                        </thead>
                        <tbody id="historyBody">
                            <tr><td colspan="4" class="text-center py-3 text-muted">
                                <i class="fas fa-spinner fa-spin me-1"></i>Memuat riwayat...
                            </td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div><!-- /col-lg-8 -->

    <!-- ====== RIGHT COLUMN ====== -->
    <div class="col-lg-4">

        <!-- Participant Card -->
        <div class="admin-card detail-card mb-4" data-aos="fade-up">
            <div class="admin-card-header">
                <h6 class="admin-card-title"><i class="fas fa-user me-2"></i>Data Peserta</h6>
                <button class="btn btn-sm btn-outline-primary" style="border-radius:8px; font-size:12px; padding:4px 10px;"
                    onclick="toggleEditParticipant()">
                    <i class="fas fa-edit me-1"></i>Edit
                </button>
            </div>
            <div class="admin-card-body">
                <!-- View Mode -->
                <div id="participantView">
                    <div class="info-label">Nama</div>
                    <div class="info-val"><?= esc($reg['participant_name'] ?? '-') ?></div>

                    <div class="info-label">Email</div>
                    <div class="info-val">
                        <a href="mailto:<?= esc($reg['participant_email'] ?? '') ?>"><?= esc($reg['participant_email'] ?? '-') ?></a>
                    </div>

                    <div class="info-label">Telepon / WA</div>
                    <div class="info-val">
                        <a href="tel:<?= esc($reg['participant_phone'] ?? '') ?>"><?= esc($reg['participant_phone'] ?? '-') ?></a>
                    </div>

                    <div class="info-label">Instansi / Organisasi</div>
                    <div class="info-val"><?= esc($reg['participant_institution'] ?? '-') ?></div>

                    <div class="info-label">Jabatan</div>
                    <div class="info-val"><?= esc($reg['participant_position'] ?? $reg['position'] ?? '-') ?></div>

                    <div class="info-label">Alamat</div>
                    <div class="info-val"><?= nl2br(esc($reg['participant_address'] ?? $reg['address'] ?? '-')) ?></div>
                </div>

                <!-- Edit Mode -->
                <form id="editParticipantForm" style="display:none;">
                    <?= csrf_field() ?>
                    <div class="mb-2">
                        <label class="form-label fw-600" style="font-size:12px;">Nama</label>
                        <input type="text" name="name" class="form-control form-control-sm" value="<?= esc($reg['participant_name'] ?? '') ?>">
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-600" style="font-size:12px;">Email</label>
                        <input type="email" name="email" class="form-control form-control-sm" value="<?= esc($reg['participant_email'] ?? '') ?>">
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-600" style="font-size:12px;">Telepon</label>
                        <input type="text" name="phone" class="form-control form-control-sm" value="<?= esc($reg['participant_phone'] ?? '') ?>">
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-600" style="font-size:12px;">Instansi</label>
                        <input type="text" name="institution" class="form-control form-control-sm" value="<?= esc($reg['participant_institution'] ?? '') ?>">
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-600" style="font-size:12px;">Jabatan</label>
                        <input type="text" name="position" class="form-control form-control-sm" value="<?= esc($reg['participant_position'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600" style="font-size:12px;">Alamat</label>
                        <textarea name="address" class="form-control form-control-sm" rows="2"><?= esc($reg['participant_address'] ?? '') ?></textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-sm" style="background:#C8A34D; color:#121212; font-weight:700; border-radius:8px;">
                            <i class="fas fa-save me-1"></i>Simpan
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;" onclick="toggleEditParticipant()">Batal</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Payment Info -->
        <div class="admin-card detail-card mb-4" data-aos="fade-up">
            <div class="admin-card-header">
                <h6 class="admin-card-title"><i class="fas fa-credit-card me-2"></i>Informasi Pembayaran</h6>
            </div>
            <div class="admin-card-body">
                <div class="info-label">Total Biaya</div>
                <div class="info-val" style="font-size:20px; font-weight:800; color:#C8A34D;">
                    Rp <?= number_format((int)($reg['amount'] ?? 0), 0, ',', '.') ?>
                </div>

                <div class="info-label">Metode Pembayaran</div>
                <div class="info-val"><?= esc($reg['payment_method'] ?? '-') ?></div>

                <div class="info-label">Tanggal Bayar</div>
                <div class="info-val">
                    <?= !empty($reg['payment_date']) ? date('d/m/Y', strtotime($reg['payment_date'])) : '<span class="text-muted">Belum dibayar</span>' ?>
                </div>

                <?php if(!empty($reg['payment_proof'])): ?>
                <div class="info-label">Bukti Pembayaran</div>
                <div class="info-val">
                    <?php
                    $proofFile = $reg['payment_proof'];
                    $proofExt = strtolower(pathinfo($proofFile, PATHINFO_EXTENSION));
                    $isImage = in_array($proofExt, ['jpg','jpeg','png','webp','gif']);
                    ?>
                    <?php if($isImage): ?>
                    <img src="<?= base_url('assets/uploads/payments/' . esc($proofFile)) ?>"
                         class="payment-proof-thumb"
                         onclick="window.open(this.src,'_blank')"
                         alt="Bukti Pembayaran"
                         title="Klik untuk lihat ukuran penuh">
                    <div style="font-size:11px; color:#6B7280; margin-top:4px;"><i class="fas fa-expand me-1"></i>Klik gambar untuk memperbesar</div>
                    <?php else: ?>
                    <a href="<?= base_url('assets/uploads/payments/' . esc($proofFile)) ?>" target="_blank" class="btn btn-sm btn-outline-primary" style="border-radius:8px;">
                        <i class="fas fa-file-pdf me-1"></i>Lihat Bukti Pembayaran (PDF)
                    </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="admin-card detail-card" data-aos="fade-up">
            <div class="admin-card-header">
                <h6 class="admin-card-title"><i class="fas fa-bolt me-2"></i>Aksi</h6>
            </div>
            <div class="admin-card-body">
                <div class="d-grid gap-2 action-btn-row">
                    <?php if(($reg['status'] ?? '') === 'completed'): ?>
                    <a href="<?= base_url('admin/pendaftaran/' . ($reg['id'] ?? 0) . '/sertifikat') ?>"
                       class="btn btn-warning" style="background:#C8A34D; border-color:#C8A34D; color:#121212;">
                        <i class="fas fa-certificate me-2"></i>Download Sertifikat
                    </a>
                    <?php endif; ?>

                    <?php
                    $waText = urlencode(
                        "Halo *" . ($reg['participant_name'] ?? 'Peserta') . "*,\n\n" .
                        "Terima kasih telah mendaftar pelatihan:\n" .
                        "📚 *" . ($reg['training_title'] ?? 'Pelatihan BKC') . "*\n" .
                        "🎫 *Kode:* " . ($reg['registration_code'] ?? '') . "\n" .
                        "📊 *Status:* " . ucfirst($reg['status'] ?? 'pending') . "\n\n" .
                        "Untuk informasi lebih lanjut, silakan hubungi kami.\n" .
                        "— Tim CV. Bagus Kencana Cakrada"
                    );
                    $waPhone = preg_replace('/[^0-9]/', '', $reg['participant_phone'] ?? '');
                    if (substr($waPhone, 0, 1) === '0') $waPhone = '62' . substr($waPhone, 1);
                    ?>
                    <a href="https://wa.me/<?= $waPhone ?>?text=<?= $waText ?>"
                       target="_blank" rel="noopener"
                       class="btn btn-success">
                        <i class="fab fa-whatsapp me-2"></i>Kirim WA Konfirmasi
                    </a>

                    <a href="<?= base_url('admin/pendaftaran/export-pdf') ?>"
                       target="_blank"
                       class="btn btn-outline-secondary">
                        <i class="fas fa-file-pdf me-2"></i>Download PDF
                    </a>

                    <button onclick="deleteRegistration(<?= $reg['id'] ?? 0 ?>)" class="btn btn-outline-danger">
                        <i class="fas fa-trash me-2"></i>Hapus Pendaftaran
                    </button>
                </div>
            </div>
        </div>

    </div><!-- /col-lg-4 -->
</div>

<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;
const BASE = '<?= base_url() ?>';
const REG_ID = <?= (int)($reg['id'] ?? 0) ?>;

// Status Update
document.getElementById('statusUpdateForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    $.ajax({
        url: BASE + 'admin/pendaftaran/status/' + REG_ID,
        method: 'POST',
        data: fd,
        processData: false,
        contentType: false,
        headers: { 'X-CSRF-TOKEN': CSRF },
        success: function(r) {
            if (r.status === 'success') {
                Swal.fire({ icon:'success', title:'Status Diperbarui!', text: r.message, confirmButtonColor:'#C8A34D' })
                    .then(() => location.reload());
            } else {
                Swal.fire({ icon:'error', title:'Error', text: r.message });
            }
        }
    });
});

// Edit Participant Toggle
function toggleEditParticipant() {
    const view = document.getElementById('participantView');
    const form = document.getElementById('editParticipantForm');
    const isHidden = form.style.display === 'none';
    view.style.display = isHidden ? 'none' : 'block';
    form.style.display = isHidden ? 'block' : 'none';
}

// Participant form save (AJAX)
document.getElementById('editParticipantForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    fd.append('_method', 'POST');
    $.ajax({
        url: BASE + 'admin/pendaftaran/peserta/' + REG_ID,
        method: 'POST',
        data: fd,
        processData: false,
        contentType: false,
        headers: { 'X-CSRF-TOKEN': CSRF },
        success: function(r) {
            Swal.fire({ toast:true, position:'top-end', icon:'success', title:'Data peserta diperbarui!', timer:2000, showConfirmButton:false });
            setTimeout(() => location.reload(), 1500);
        },
        error: function() {
            Swal.fire({ toast:true, position:'top-end', icon:'error', title:'Gagal menyimpan!', timer:2000, showConfirmButton:false });
        }
    });
});

// Delete
function deleteRegistration(id) {
    Swal.fire({
        title: 'Hapus Pendaftaran?',
        text: 'Data pendaftaran ini akan dihapus permanen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then(result => {
        if (result.isConfirmed) {
            $.post(BASE + 'admin/pendaftaran/hapus/' + id, {
                _method: 'DELETE',
                '<?= csrf_token() ?>': CSRF
            }, function(r) {
                window.location.href = BASE + 'admin/pendaftaran';
            });
        }
    });
}

// Load participant history
<?php if(!empty($reg['participant_email'])): ?>
$.get(BASE + 'admin/pendaftaran/riwayat', { email: '<?= esc($reg["participant_email"] ?? "", "js") ?>' }, function(data) {
    if (data && data.data && data.data.length) {
        let html = '';
        data.data.forEach(function(h) {
            const statusClass = 'status-' + h.status;
            html += `<tr>
                <td><code style="font-size:11px;">${h.registration_code}</code></td>
                <td style="font-size:12px; max-width:160px;">${h.training_title || '-'}</td>
                <td><span class="status-badge-lg ${statusClass}" style="font-size:10px; padding:3px 10px;">${h.status}</span></td>
                <td style="font-size:11px;">${h.created_at ? h.created_at.substring(0,10) : '-'}</td>
            </tr>`;
        });
        document.getElementById('historyBody').innerHTML = html;
    } else {
        document.getElementById('historyBody').innerHTML = '<tr><td colspan="4" class="text-center py-3 text-muted">Tidak ada riwayat lain</td></tr>';
    }
}).fail(function() {
    document.getElementById('historyBody').innerHTML = '<tr><td colspan="4" class="text-center py-3 text-muted">Tidak ada riwayat lain.</td></tr>';
});
<?php endif; ?>
</script>

<?= $this->endSection() ?>
