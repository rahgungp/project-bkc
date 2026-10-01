<?= $this->extend('Modules\Admin\Views\layout\main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1 class="page-title">Manajemen Pendaftaran</h1>
        <p class="page-subtitle">Kelola pendaftaran peserta pelatihan</p>
    </div>
    <div class="page-actions">
        <a href="<?= base_url('admin/pendaftaran/export-excel') ?>" class="btn btn-outline-success" style="border-radius:10px; padding:8px 16px; font-size:13px;">
            <i class="fas fa-file-excel me-2"></i>Excel
        </a>
        <a href="<?= base_url('admin/pendaftaran/export-pdf') ?>" class="btn btn-outline-danger" style="border-radius:10px; padding:8px 16px; font-size:13px;">
            <i class="fas fa-file-pdf me-2"></i>PDF
        </a>
    </div>
</div>

<!-- Stats -->
<div class="stats-grid mb-4" data-aos="fade-up">
    <div class="stat-card stat-orange">
        <div class="stat-icon"><i class="fas fa-clock"></i></div>
        <div class="stat-info">
            <div class="stat-value"><?= $stats['pending'] ?></div>
            <div class="stat-label">Pending</div>
        </div>
    </div>
    <div class="stat-card stat-blue">
        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
        <div class="stat-info">
            <div class="stat-value"><?= $stats['confirmed'] ?></div>
            <div class="stat-label">Dikonfirmasi</div>
        </div>
    </div>
    <div class="stat-card stat-green">
        <div class="stat-icon"><i class="fas fa-money-bill"></i></div>
        <div class="stat-info">
            <div class="stat-value"><?= $stats['paid'] ?></div>
            <div class="stat-label">Lunas</div>
        </div>
    </div>
    <div class="stat-card stat-gold">
        <div class="stat-icon"><i class="fas fa-users"></i></div>
        <div class="stat-info">
            <div class="stat-value"><?= $stats['total'] ?></div>
            <div class="stat-label">Total Pendaftaran</div>
        </div>
    </div>
</div>

<div class="admin-card" data-aos="fade-up">
    <div class="admin-card-header">
        <h6 class="admin-card-title"><i class="fas fa-clipboard-list me-2"></i>Daftar Pendaftaran</h6>
        <select class="form-select form-select-sm" style="width:auto;" id="statusFilter">
            <option value="">Semua Status</option>
            <option value="pending">Pending</option>
            <option value="confirmed">Confirmed</option>
            <option value="paid">Paid</option>
            <option value="rejected">Rejected</option>
            <option value="completed">Completed</option>
        </select>
    </div>
    <div class="admin-card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="regTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Peserta</th>
                        <th>Pelatihan</th>
                        <th>Instansi</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($registrations as $i => $reg): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><code style="font-size:11px;"><?= esc($reg['registration_code']) ?></code></td>
                        <td>
                            <div class="fw-600" style="font-size:13px;"><?= esc($reg['participant_name']) ?></div>
                            <small class="text-muted"><?= esc($reg['participant_email']) ?></small>
                        </td>
                        <td style="font-size:12px; max-width:200px;"><?= esc(substr($reg['training_title'] ?? '-', 0, 40)) ?>...</td>
                        <td style="font-size:12px;"><?= esc($reg['participant_institution'] ?? '-') ?></td>
                        <td>
                            <select class="form-select form-select-sm status-select" style="width:120px; font-size:11px;"
                                    data-id="<?= $reg['id'] ?>" onchange="updateStatus(<?= $reg['id'] ?>, this.value)">
                                <?php foreach (['pending', 'confirmed', 'rejected', 'paid', 'completed', 'cancelled'] as $s): ?>
                                <option value="<?= $s ?>" <?= $reg['status'] === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td style="font-size:12px;"><?= date('d/m/Y', strtotime($reg['created_at'])) ?></td>
                        <td>
                            <a href="<?= base_url('admin/pendaftaran/detail/' . $reg['id']) ?>" class="btn btn-sm btn-outline-primary" style="border-radius:8px; padding:5px 10px;"><i class="fas fa-eye"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    var table = $('#regTable').DataTable({order:[]});
    $('#statusFilter').on('change', function() { table.column(5).search(this.value).draw(); });
});

async function updateStatus(id, status) {
    const res = await fetch('<?= base_url('admin/pendaftaran/status') ?>/' + id, {
        method: 'POST',
        body: new FormData(Object.assign(document.createElement('form'), {
            innerHTML: '<input name="status" value="' + status + '"><input name="<?= csrf_token() ?>" value="' + document.querySelector('meta[name="csrf-token"]').content + '">'
        }))
    });
    const data = await res.json();
    if (data.status === 'success') {
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message, timer: 1500, showConfirmButton: false });
    } else {
        Swal.fire({ icon: 'error', title: 'Error', text: data.message });
    }
}
</script>

<?= $this->endSection() ?>
