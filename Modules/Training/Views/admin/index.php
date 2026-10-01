<?= $this->extend('Modules\Admin\Views\layout\main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1 class="page-title">Manajemen Pelatihan</h1>
        <p class="page-subtitle">Kelola seluruh program pelatihan BKC</p>
    </div>
    <div class="page-actions">
        <a href="<?= base_url('admin/pelatihan/tambah') ?>" class="btn btn-primary" style="background:var(--gold); border-color:var(--gold); color:#121212; font-weight:700; border-radius:10px; padding:10px 20px;">
            <i class="fas fa-plus me-2"></i>Tambah Pelatihan
        </a>
    </div>
</div>

<div class="admin-card" data-aos="fade-up">
    <div class="admin-card-header">
        <h6 class="admin-card-title"><i class="fas fa-graduation-cap me-2"></i>Daftar Pelatihan</h6>
        <div class="d-flex gap-2">
            <select class="form-select form-select-sm" style="width:auto;" id="statusFilter">
                <option value="">Semua Status</option>
                <option value="draft">Draft</option>
                <option value="published">Published</option>
                <option value="upcoming">Upcoming</option>
                <option value="completed">Completed</option>
            </select>
        </div>
    </div>
    <div class="admin-card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="trainingTable">
                <thead>
                    <tr>
                        <th width="60">#</th>
                        <th>Pelatihan</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Kuota</th>
                        <th>Status</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($trainings as $i => $training): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <?php if ($training['cover']): ?>
                                <img src="<?= base_url('assets/uploads/training/' . $training['cover']) ?>"
                                     style="width:52px; height:40px; object-fit:cover; border-radius:8px; flex-shrink:0;" alt="">
                                <?php else: ?>
                                <div style="width:52px; height:40px; background:var(--bg-primary); border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                    <i class="fas fa-graduation-cap" style="color:var(--gold);"></i>
                                </div>
                                <?php endif; ?>
                                <div>
                                    <div class="fw-600" style="font-size:13px;"><?= esc($training['title']) ?></div>
                                    <small class="text-muted"><?= esc($training['location_name'] ?? '-') ?></small>
                                    <?php if ($training['is_featured']): ?>
                                    <span class="badge ms-1" style="background:rgba(200,163,77,0.2); color:var(--gold); font-size:9px;">Featured</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="status-badge" style="background:<?= esc($training['category_color'] ?? '#C8A34D') ?>20; color:<?= esc($training['category_color'] ?? '#C8A34D') ?>;">
                                <?= esc($training['category_name'] ?? '-') ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($training['start_date']): ?>
                            <div style="font-size:12px;"><?= date('d M Y', strtotime($training['start_date'])) ?></div>
                            <small class="text-muted"><?= date('d M Y', strtotime($training['end_date'] ?? $training['start_date'])) ?></small>
                            <?php else: ?>
                            <span class="text-muted" style="font-size:12px;">Belum ditentukan</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div style="font-size:12px; font-weight:600;"><?= $training['current_participants'] ?>/<?= $training['max_participants'] ?></div>
                            <div style="width:80px; height:4px; background:var(--border-color); border-radius:4px; margin-top:4px;">
                                <?php $pct = $training['max_participants'] > 0 ? min(round($training['current_participants']/$training['max_participants']*100), 100) : 0; ?>
                                <div style="width:<?= $pct ?>%; height:100%; background:var(--gold); border-radius:4px;"></div>
                            </div>
                        </td>
                        <td><span class="status-badge status-<?= $training['status'] ?>"><?= ucfirst($training['status']) ?></span></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?= base_url('admin/pelatihan/edit/' . $training['id']) ?>" class="btn btn-sm btn-outline-primary" title="Edit" style="border-radius:8px; padding:5px 10px;">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= base_url('admin/pelatihan/detail/' . $training['id']) ?>" class="btn btn-sm btn-outline-secondary" title="Detail" style="border-radius:8px; padding:5px 10px;">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?= base_url('pelatihan/' . $training['slug']) ?>" target="_blank" class="btn btn-sm btn-outline-success" title="Lihat di Website" style="border-radius:8px; padding:5px 10px;">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <button onclick="deleteRecord('<?= base_url('admin/pelatihan/hapus/' . $training['id']) ?>')" class="btn btn-sm btn-outline-danger" title="Hapus" style="border-radius:8px; padding:5px 10px;">
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
$(document).ready(function() {
    var table = $('#trainingTable').DataTable({ order: [] });

    $('#statusFilter').on('change', function() {
        table.column(5).search(this.value).draw();
    });
});
</script>

<?= $this->endSection() ?>
