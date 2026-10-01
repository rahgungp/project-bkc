<?= $this->extend('Modules\Admin\Views\layout\main') ?>
<?= $this->section('content') ?>

<style>
.participant-info-card {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 18px;
    padding: 28px 30px;
    margin-bottom: 24px;
}
.p-avatar-lg {
    width: 80px; height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #C8A34D, #e8c46d);
    display: flex; align-items: center; justify-content: center;
    font-size: 32px; font-weight: 800; color: #fff;
    flex-shrink: 0;
}
.p-info-label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-secondary); margin-bottom: 3px; }
.p-info-value { font-size: 14px; font-weight: 600; color: var(--text-primary); }

.stat-mini-card {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 14px;
    padding: 18px 20px;
    text-align: center;
}
.stat-mini-value { font-size: 26px; font-weight: 800; color: var(--text-primary); line-height: 1; }
.stat-mini-label { font-size: 12px; color: var(--text-secondary); margin-top: 4px; }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">Detail Peserta</h1>
        <p class="page-subtitle">Informasi lengkap dan riwayat pendaftaran</p>
    </div>
    <div class="page-actions">
        <a href="<?= base_url('admin/peserta') ?>" class="btn btn-outline-secondary" style="border-radius:10px; padding:8px 18px; font-size:13px;">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
        <a href="<?= base_url('admin/peserta/edit/' . $participant['id']) ?>" class="btn btn-primary" style="background:#1E4FA3; border:none; border-radius:10px; padding:8px 18px; font-size:13px; font-weight:700;">
            <i class="fas fa-edit me-2"></i>Edit Peserta
        </a>
    </div>
</div>

<!-- Stats Row -->
<div class="row g-3 mb-4" data-aos="fade-up">
    <div class="col-6 col-md-3">
        <div class="stat-mini-card">
            <div class="stat-mini-value"><?= $stats['total'] ?></div>
            <div class="stat-mini-label">Total Pendaftaran</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-mini-card">
            <div class="stat-mini-value" style="color:#198754;"><?= $stats['completed'] ?></div>
            <div class="stat-mini-label">Pelatihan Selesai</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-mini-card">
            <div class="stat-mini-value" style="color:#C8A34D;"><?= $stats['total'] > 0 ? round(($stats['completed'] / $stats['total']) * 100) : 0 ?>%</div>
            <div class="stat-mini-label">Completion Rate</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-mini-card">
            <div class="stat-mini-value" style="color:#1E4FA3;">
                Rp <?= number_format($stats['total_spent'], 0, ',', '.') ?>
            </div>
            <div class="stat-mini-label">Total Transaksi</div>
        </div>
    </div>
</div>

<!-- Info Card -->
<div class="participant-info-card" data-aos="fade-up">
    <div class="d-flex align-items-start gap-4 flex-wrap">
        <div class="p-avatar-lg"><?= strtoupper(substr($participant['name'], 0, 1)) ?></div>
        <div class="flex-grow-1">
            <h4 style="font-size:1.3rem; font-weight:800; color:var(--text-primary); margin-bottom:4px;"><?= esc($participant['name']) ?></h4>
            <div style="font-size:13px; color:#C8A34D; font-weight:600; margin-bottom:16px;"><?= esc($participant['position'] ?? 'Peserta Pelatihan') ?></div>
            <div class="row g-3">
                <div class="col-sm-6 col-md-3">
                    <div class="p-info-label"><i class="fas fa-envelope me-1"></i>Email</div>
                    <div class="p-info-value"><?= esc($participant['email']) ?></div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="p-info-label"><i class="fas fa-phone me-1"></i>No. HP</div>
                    <div class="p-info-value"><?= esc($participant['phone'] ?? '-') ?></div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="p-info-label"><i class="fas fa-building me-1"></i>Instansi</div>
                    <div class="p-info-value"><?= esc($participant['institution'] ?? '-') ?></div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="p-info-label"><i class="fas fa-map-marker-alt me-1"></i>Alamat</div>
                    <div class="p-info-value"><?= esc($participant['address'] ?? '-') ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Registration History -->
<div class="admin-card" data-aos="fade-up">
    <div class="admin-card-header">
        <h6 class="admin-card-title"><i class="fas fa-history me-2"></i>Riwayat Pendaftaran</h6>
    </div>
    <div class="admin-card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="histTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Judul Pelatihan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Biaya</th>
                        <th>Sertifikat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($registrations as $i => $reg): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>
                            <code style="font-size:11px; background:rgba(200,163,77,0.1); color:#C8A34D; padding:2px 6px; border-radius:4px;">
                                <?= esc($reg['registration_code']) ?>
                            </code>
                        </td>
                        <td style="font-size:13px; max-width:240px;">
                            <span title="<?= esc($reg['training_title']) ?>"><?= esc(mb_substr($reg['training_title'] ?? '-', 0, 50)) ?><?= mb_strlen($reg['training_title'] ?? '') > 50 ? '…' : '' ?></span>
                            <?php if ($reg['start_date']): ?>
                            <br><small class="text-muted"><?= date('d M Y', strtotime($reg['start_date'])) ?></small>
                            <?php endif; ?>
                        </td>
                        <td style="font-size:12px; white-space:nowrap;"><?= date('d/m/Y', strtotime($reg['created_at'])) ?></td>
                        <td>
                            <?php
                            $statusColors = [
                                'pending'   => 'warning',
                                'confirmed' => 'primary',
                                'paid'      => 'success',
                                'completed' => 'success',
                                'rejected'  => 'danger',
                                'cancelled' => 'secondary',
                            ];
                            $color = $statusColors[$reg['status']] ?? 'secondary';
                            ?>
                            <span class="badge rounded-pill bg-<?= $color ?> bg-opacity-10 text-<?= $color ?>" style="font-size:11px; padding:4px 10px; border:1px solid currentColor;">
                                <?= ucfirst($reg['status']) ?>
                            </span>
                        </td>
                        <td style="font-size:13px; white-space:nowrap;">
                            <?= $reg['amount'] ? 'Rp ' . number_format($reg['amount'], 0, ',', '.') : '-' ?>
                        </td>
                        <td>
                            <?php if (in_array($reg['status'], ['completed', 'paid'])): ?>
                            <a href="<?= base_url('sertifikat/' . $reg['registration_code']) ?>"
                               target="_blank"
                               class="btn btn-sm"
                               style="border-radius:8px; padding:4px 10px; font-size:11px; background:#C8A34D; color:#121212; border:none; font-weight:700;"
                               title="Download Sertifikat">
                                <i class="fas fa-file-pdf me-1"></i>PDF
                            </a>
                            <?php else: ?>
                            <span style="font-size:11px; color:#aaa;">N/A</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#histTable').DataTable({
        order: [[3, 'desc']],
        pageLength: 10,
        language: { search: "Cari:", info: "Menampilkan _START_–_END_ dari _TOTAL_ pendaftaran" },
    });
});
</script>

<?= $this->endSection() ?>
