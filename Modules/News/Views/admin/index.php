<?= $this->extend('Modules\Admin\Views\layout\main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1 class="page-title">Manajemen Berita</h1>
        <p class="page-subtitle">Kelola artikel dan berita BKC</p>
    </div>
    <div class="page-actions">
        <a href="<?= base_url('admin/berita/tambah') ?>" class="btn btn-primary" style="background:var(--gold); border-color:var(--gold); color:#121212; font-weight:700; border-radius:10px; padding:10px 20px;">
            <i class="fas fa-plus me-2"></i>Tambah Berita
        </a>
    </div>
</div>

<div class="admin-card" data-aos="fade-up">
    <div class="admin-card-header">
        <h6 class="admin-card-title"><i class="fas fa-newspaper me-2"></i>Daftar Berita</h6>
    </div>
    <div class="admin-card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="newsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Artikel</th>
                        <th>Kategori</th>
                        <th>Penulis</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th><i class="fas fa-eye me-1"></i>Views</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($news as $i => $article): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <?php if ($article['thumbnail']): ?>
                                <img src="<?= base_url('assets/uploads/news/' . $article['thumbnail']) ?>" style="width:52px; height:40px; object-fit:cover; border-radius:8px; flex-shrink:0;" alt="">
                                <?php else: ?>
                                <div style="width:52px; height:40px; background:var(--bg-primary); border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                    <i class="fas fa-newspaper" style="color:var(--gold);"></i>
                                </div>
                                <?php endif; ?>
                                <div>
                                    <div class="fw-600" style="font-size:13px;"><?= esc(substr($article['title'], 0, 50)) ?><?= strlen($article['title']) > 50 ? '...' : '' ?></div>
                                    <?php if ($article['is_featured']): ?>
                                    <span class="badge" style="background:rgba(200,163,77,0.2); color:var(--gold); font-size:9px;">Featured</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td><?= esc($article['category_name'] ?? '-') ?></td>
                        <td><?= esc($article['author_name'] ?? '-') ?></td>
                        <td><span class="status-badge status-<?= $article['status'] ?>"><?= ucfirst($article['status']) ?></span></td>
                        <td style="font-size:12px;"><?= $article['published_at'] ? date('d/m/Y', strtotime($article['published_at'])) : date('d/m/Y', strtotime($article['created_at'])) ?></td>
                        <td style="font-size:13px;font-weight:600;color:var(--gold);"><?= number_format($article['views'] ?? 0) ?></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?= base_url('admin/berita/edit/' . $article['id']) ?>" class="btn btn-sm btn-outline-primary" style="border-radius:8px; padding:5px 10px;"><i class="fas fa-edit"></i></a>
                                <a href="<?= base_url('berita/' . $article['slug']) ?>" target="_blank" class="btn btn-sm btn-outline-success" style="border-radius:8px; padding:5px 10px;"><i class="fas fa-external-link-alt"></i></a>
                                <button onclick="deleteRecord('<?= base_url('admin/berita/hapus/' . $article['id']) ?>')" class="btn btn-sm btn-outline-danger" style="border-radius:8px; padding:5px 10px;"><i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>$(document).ready(function(){
    $('#newsTable').DataTable({
        order: [[6, 'desc']],
        columnDefs: [
            { orderable: false, targets: [1, 7] }
        ]
    });
});</script>

<?= $this->endSection() ?>
