<?= $this->extend('Modules\Admin\Views\layout\main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1 class="page-title">Data Peserta</h1>
        <p class="page-subtitle">Kelola data peserta yang telah mendaftar pelatihan</p>
    </div>
    <div class="page-actions">
        <a href="<?= base_url('admin/peserta/export') ?>" class="btn btn-outline-success" style="border-radius:10px; padding:8px 18px; font-size:13px;">
            <i class="fas fa-file-excel me-2"></i>Export Excel
        </a>
    </div>
</div>

<div class="admin-card" data-aos="fade-up">
    <div class="admin-card-header">
        <h6 class="admin-card-title"><i class="fas fa-users me-2"></i>Daftar Peserta</h6>
        <div class="d-flex align-items-center gap-2">
            <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Cari nama / email / instansi..." style="width:260px; border-radius:8px;">
        </div>
    </div>
    <div class="admin-card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="participantTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Peserta</th>
                        <th>No. HP</th>
                        <th>Instansi</th>
                        <th>Pendaftaran</th>
                        <th>Terakhir Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($participants as $i => $p): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-initials" style="width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,#C8A34D,#e8c46d);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:14px;flex-shrink:0;">
                                    <?= strtoupper(substr($p['name'], 0, 1)) ?>
                                </div>
                                <div>
                                    <div class="fw-600" style="font-size:13px;"><?= esc($p['name']) ?></div>
                                    <small class="text-muted"><?= esc($p['email']) ?></small>
                                </div>
                            </div>
                        </td>
                        <td style="font-size:13px;"><?= esc($p['phone'] ?? '-') ?></td>
                        <td style="font-size:12px; max-width:180px;"><?= esc($p['institution'] ?? '-') ?></td>
                        <td>
                            <a href="<?= base_url('admin/peserta/detail/' . $p['id']) ?>"
                               class="badge rounded-pill text-decoration-none"
                               style="background:rgba(30,79,163,0.12); color:#1E4FA3; font-size:12px; padding:4px 12px;">
                                <i class="fas fa-list-ul me-1"></i><?= $p['registration_count'] ?> Pendaftaran
                            </a>
                        </td>
                        <td style="font-size:12px; white-space:nowrap;">
                            <?= $p['last_registration_date'] ? date('d/m/Y', strtotime($p['last_registration_date'])) : '-' ?>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?= base_url('admin/peserta/detail/' . $p['id']) ?>"
                                   class="btn btn-sm btn-outline-primary"
                                   style="border-radius:8px; padding:5px 10px;" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?= base_url('admin/peserta/edit/' . $p['id']) ?>"
                                   class="btn btn-sm btn-outline-secondary"
                                   style="border-radius:8px; padding:5px 10px;" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="deletePeserta(<?= $p['id'] ?>, '<?= esc($p['name']) ?>')"
                                        class="btn btn-sm btn-outline-danger"
                                        style="border-radius:8px; padding:5px 10px;" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
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
    var table = $('#participantTable').DataTable({
        order: [[1, 'asc']],
        pageLength: 30,
        dom: '<"d-flex justify-content-between mb-2"lp>rt<"d-flex justify-content-between mt-2"ip>',
        language: {
            search: "",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ – _END_ dari _TOTAL_ peserta",
            paginate: { previous: "Prev", next: "Next" },
            zeroRecords: "Tidak ada peserta ditemukan",
        }
    });

    // Wire up custom search box
    $('#searchInput').on('keyup', function () {
        table.search(this.value).draw();
    });
});

function deletePeserta(id, name) {
    Swal.fire({
        title: 'Hapus Peserta?',
        html: 'Anda akan menghapus peserta <strong>' + name + '</strong>.<br><small class="text-muted">Peserta yang masih memiliki pendaftaran aktif tidak dapat dihapus.</small>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (!result.isConfirmed) return;

        fetch('<?= base_url('admin/peserta/hapus') ?>/' + id, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: new URLSearchParams({ '<?= csrf_token() ?>': document.querySelector('meta[name="csrf-token"]').content })
        })
        .then(r => r.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message, timer: 1800, showConfirmButton: false })
                    .then(() => location.reload());
            } else {
                Swal.fire({ icon: 'error', title: 'Gagal', text: data.message });
            }
        });
    });
}
</script>

<?= $this->endSection() ?>
