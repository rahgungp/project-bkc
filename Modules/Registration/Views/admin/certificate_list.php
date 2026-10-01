<?= $this->extend('Modules\Admin\Views\layout\main') ?>
<?= $this->section('content') ?>

<style>
.cert-stat-card {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 14px;
    padding: 20px 24px;
    display: flex;
    align-items: center;
    gap: 16px;
}
.cert-stat-icon {
    width: 48px; height: 48px;
    border-radius: 12px;
    background: rgba(200,163,77,0.15);
    display: flex; align-items: center; justify-content: center;
    font-size: 20px;
    color: #C8A34D;
    flex-shrink: 0;
}
.cert-stat-value { font-size: 26px; font-weight: 800; color: var(--text-primary); line-height: 1; }
.cert-stat-label { font-size: 12px; color: var(--text-secondary); margin-top: 2px; }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">Kelola Sertifikat</h1>
        <p class="page-subtitle">Daftar peserta yang berhak mendapatkan sertifikat keikutsertaan</p>
    </div>
</div>

<!-- Stats -->
<div class="row g-3 mb-4" data-aos="fade-up">
    <div class="col-6 col-md-3">
        <div class="cert-stat-card">
            <div class="cert-stat-icon"><i class="fas fa-certificate"></i></div>
            <div>
                <div class="cert-stat-value"><?= count($registrations) ?></div>
                <div class="cert-stat-label">Total Eligible</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="cert-stat-card">
            <div class="cert-stat-icon" style="background:rgba(30,79,163,0.12); color:#1E4FA3;"><i class="fas fa-check-double"></i></div>
            <div>
                <div class="cert-stat-value" style="color:#1E4FA3;"><?= $stats['completed'] ?></div>
                <div class="cert-stat-label">Completed</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="cert-stat-card">
            <div class="cert-stat-icon" style="background:rgba(25,135,84,0.12); color:#198754;"><i class="fas fa-money-bill-wave"></i></div>
            <div>
                <div class="cert-stat-value" style="color:#198754;"><?= $stats['paid'] ?></div>
                <div class="cert-stat-label">Paid</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="cert-stat-card">
            <div class="cert-stat-icon" style="background:rgba(200,163,77,0.12); color:#C8A34D;"><i class="fas fa-download"></i></div>
            <div>
                <div class="cert-stat-value"><?= array_sum(array_column($registrations, 'certificate_issued')) ?></div>
                <div class="cert-stat-label">Sudah Diunduh</div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="admin-card mb-3" data-aos="fade-up">
    <div class="admin-card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-600" style="font-size:12px;">Filter Pelatihan</label>
                <input type="text" class="form-control form-control-sm" id="filterTraining" placeholder="Nama pelatihan...">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-600" style="font-size:12px;">Filter Status</label>
                <select class="form-select form-select-sm" id="filterStatus">
                    <option value="">Semua Status</option>
                    <option value="completed">Completed</option>
                    <option value="paid">Paid</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-600" style="font-size:12px;">Tanggal Pendaftaran</label>
                <input type="date" class="form-control form-control-sm" id="filterDate">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-sm btn-outline-secondary w-100" onclick="resetFilters()">
                    <i class="fas fa-redo me-1"></i>Reset
                </button>
            </div>
        </form>
    </div>
</div>

<div class="admin-card" data-aos="fade-up">
    <div class="admin-card-header">
        <h6 class="admin-card-title"><i class="fas fa-certificate me-2" style="color:#C8A34D;"></i>Daftar Sertifikat</h6>
    </div>
    <div class="admin-card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="certTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Registrasi</th>
                        <th>Nama Peserta</th>
                        <th>Judul Pelatihan</th>
                        <th>Tgl Selesai</th>
                        <th>Status</th>
                        <th>Sertifikat</th>
                        <th>Aksi</th>
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
                        <td>
                            <div class="fw-600" style="font-size:13px;"><?= esc($reg['participant_name']) ?></div>
                            <small class="text-muted"><?= esc($reg['participant_email']) ?></small>
                        </td>
                        <td style="font-size:12px; max-width:220px;">
                            <span title="<?= esc($reg['training_title']) ?>"><?= esc(mb_substr($reg['training_title'] ?? '-', 0, 50)) ?><?= mb_strlen($reg['training_title'] ?? '') > 50 ? '…' : '' ?></span>
                        </td>
                        <td style="font-size:12px; white-space:nowrap;">
                            <?= $reg['end_date'] ? date('d/m/Y', strtotime($reg['end_date'])) : (date('d/m/Y', strtotime($reg['created_at']))) ?>
                        </td>
                        <td>
                            <?php if ($reg['status'] === 'completed'): ?>
                                <span class="badge rounded-pill" style="background:rgba(25,135,84,0.15); color:#198754;">Completed</span>
                            <?php else: ?>
                                <span class="badge rounded-pill" style="background:rgba(30,79,163,0.15); color:#1E4FA3;">Paid</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($reg['certificate_issued']): ?>
                                <span class="badge rounded-pill" style="background:rgba(200,163,77,0.15); color:#C8A34D;">
                                    <i class="fas fa-check me-1"></i>Issued
                                </span>
                            <?php else: ?>
                                <span class="badge rounded-pill bg-secondary bg-opacity-10 text-secondary">Belum</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?= base_url('admin/sertifikat/preview/' . $reg['id']) ?>"
                                   class="btn btn-sm btn-outline-primary"
                                   style="border-radius:8px; padding:5px 10px; font-size:12px;"
                                   title="Preview Sertifikat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?= base_url('admin/sertifikat/download/' . $reg['id']) ?>"
                                   class="btn btn-sm"
                                   style="border-radius:8px; padding:5px 10px; font-size:12px; background:#C8A34D; color:#fff; border:none;"
                                   title="Download PDF">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            </div>
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
    var table = $('#certTable').DataTable({
        order: [],
        pageLength: 25,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: { previous: "Prev", next: "Next" },
        }
    });

    // Custom column filters
    $('#filterTraining').on('keyup', function () {
        table.column(3).search(this.value).draw();
    });
    $('#filterStatus').on('change', function () {
        table.column(5).search(this.value).draw();
    });
    $('#filterDate').on('change', function () {
        table.column(4).search(this.value).draw();
    });
});

function resetFilters() {
    $('#filterTraining, #filterDate').val('');
    $('#filterStatus').val('');
    $('#certTable').DataTable().search('').columns().search('').draw();
}
</script>

<?= $this->endSection() ?>
