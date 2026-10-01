<?= $this->extend('Modules\Admin\Views\layout\main') ?>
<?= $this->section('content') ?>

<?php
$statusColors = [
    'draft'     => '#6c757d',
    'published' => '#198754',
    'upcoming'  => '#0d6efd',
    'completed' => '#6610f2',
];
$statusColor = $statusColors[$training['status'] ?? ''] ?? '#6c757d';
?>

<div class="page-header d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
    <div>
        <h1 class="page-title mb-1"><?= esc($training['title']) ?></h1>
        <p class="page-subtitle text-muted mb-0">Detail program pelatihan</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('admin/pelatihan/edit/' . $training['id']) ?>"
           class="btn fw-700" style="background:#C8A34D;color:#121212;border-radius:10px;padding:10px 20px;">
            <i class="fas fa-edit me-2"></i>Edit Pelatihan
        </a>
        <a href="<?= base_url('admin/pelatihan') ?>"
           class="btn" style="border:1.5px solid var(--border-color,#e5e7eb);border-radius:10px;padding:10px 20px;">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="row g-4">

    <!-- Left: Cover + Status -->
    <div class="col-lg-4">
        <div class="admin-card">
            <div class="admin-card-body text-center p-3">
                <?php if (!empty($training['cover'])): ?>
                <img src="<?= base_url('assets/uploads/training/' . esc($training['cover'])) ?>"
                     alt="<?= esc($training['title']) ?>"
                     style="width:100%;max-height:220px;object-fit:cover;border-radius:10px;margin-bottom:14px;"
                     onerror="this.style.display='none'">
                <?php else: ?>
                <div style="width:100%;height:160px;background:rgba(200,163,77,0.1);border-radius:10px;display:flex;align-items:center;justify-content:center;margin-bottom:14px;">
                    <i class="fas fa-image" style="font-size:2.5rem;color:#C8A34D;"></i>
                </div>
                <?php endif; ?>

                <span class="badge px-3 py-2 mb-3" style="background:<?= $statusColor ?>;font-size:13px;border-radius:20px;">
                    <?= ucfirst($training['status'] ?? 'draft') ?>
                </span>

                <div class="text-start mt-3">
                    <div class="mb-2 d-flex gap-2 align-items-center">
                        <i class="fas fa-tag" style="color:#C8A34D;width:18px;"></i>
                        <span class="text-muted" style="font-size:13px;"><?= esc($training['category_name'] ?? '-') ?></span>
                    </div>
                    <?php if (!empty($training['location_name'])): ?>
                    <div class="mb-2 d-flex gap-2 align-items-center">
                        <i class="fas fa-map-marker-alt" style="color:#C8A34D;width:18px;"></i>
                        <span class="text-muted" style="font-size:13px;"><?= esc($training['location_name']) ?><?= !empty($training['location_city']) ? ', ' . esc($training['location_city']) : '' ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($training['start_date'])): ?>
                    <div class="mb-2 d-flex gap-2 align-items-center">
                        <i class="fas fa-calendar-alt" style="color:#C8A34D;width:18px;"></i>
                        <span class="text-muted" style="font-size:13px;"><?= date('d M Y', strtotime($training['start_date'])) ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="mb-2 d-flex gap-2 align-items-center">
                        <i class="fas fa-clock" style="color:#C8A34D;width:18px;"></i>
                        <span class="text-muted" style="font-size:13px;"><?= (int)($training['duration_days'] ?? 1) ?> hari / <?= (int)($training['duration_hours'] ?? 8) ?> jam</span>
                    </div>
                    <div class="mb-2 d-flex gap-2 align-items-center">
                        <i class="fas fa-users" style="color:#C8A34D;width:18px;"></i>
                        <span class="text-muted" style="font-size:13px;">Maks. <?= number_format((int)($training['max_participants'] ?? 0)) ?> peserta</span>
                    </div>
                    <div class="mb-2 d-flex gap-2 align-items-center">
                        <i class="fas fa-money-bill" style="color:#C8A34D;width:18px;"></i>
                        <span class="text-muted" style="font-size:13px;">
                            <?= !empty($training['price']) ? 'Rp ' . number_format((float)$training['price'], 0, ',', '.') : 'Hubungi Kami' ?>
                        </span>
                    </div>
                    <?php if (!empty($training['is_online'])): ?>
                    <div class="mb-2 d-flex gap-2 align-items-center">
                        <i class="fas fa-video" style="color:#C8A34D;width:18px;"></i>
                        <span class="text-muted" style="font-size:13px;">Online / Daring</span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Speakers -->
        <?php if (!empty($speakers)): ?>
        <div class="admin-card mt-4">
            <div class="admin-card-header">
                <h6 class="admin-card-title mb-0"><i class="fas fa-chalkboard-teacher me-2"></i>Narasumber</h6>
            </div>
            <div class="admin-card-body">
                <?php foreach ($speakers as $spk): ?>
                <div class="d-flex align-items-center gap-3 mb-3">
                    <?php if (!empty($spk['photo'])): ?>
                    <img src="<?= base_url('uploads/speakers/' . esc($spk['photo'])) ?>"
                         style="width:42px;height:42px;border-radius:50%;object-fit:cover;flex-shrink:0;"
                         onerror="this.outerHTML='<div style=\'width:42px;height:42px;border-radius:50%;background:rgba(200,163,77,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;\'><i class=\'fas fa-user\' style=\'color:#C8A34D;\'></i></div>'"
                         alt="<?= esc($spk['name']) ?>">
                    <?php else: ?>
                    <div style="width:42px;height:42px;border-radius:50%;background:rgba(200,163,77,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-user" style="color:#C8A34D;"></i>
                    </div>
                    <?php endif; ?>
                    <div>
                        <div class="fw-600" style="font-size:13px;"><?= esc($spk['name']) ?></div>
                        <?php if (!empty($spk['title'])): ?>
                        <div class="text-muted" style="font-size:12px;"><?= esc($spk['title']) ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Right: Description + Meta -->
    <div class="col-lg-8">
        <?php if (!empty($training['short_description'])): ?>
        <div class="admin-card mb-4">
            <div class="admin-card-header">
                <h6 class="admin-card-title mb-0"><i class="fas fa-align-left me-2"></i>Deskripsi Singkat</h6>
            </div>
            <div class="admin-card-body">
                <p class="mb-0"><?= esc($training['short_description']) ?></p>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($training['description'])): ?>
        <div class="admin-card mb-4">
            <div class="admin-card-header">
                <h6 class="admin-card-title mb-0"><i class="fas fa-file-alt me-2"></i>Deskripsi Lengkap</h6>
            </div>
            <div class="admin-card-body">
                <div class="content-body"><?= $training['description'] ?></div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($training['benefits'])): ?>
        <div class="admin-card mb-4">
            <div class="admin-card-header">
                <h6 class="admin-card-title mb-0"><i class="fas fa-star me-2"></i>Manfaat</h6>
            </div>
            <div class="admin-card-body">
                <div class="content-body"><?= $training['benefits'] ?></div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($training['materials'])): ?>
        <div class="admin-card mb-4">
            <div class="admin-card-header">
                <h6 class="admin-card-title mb-0"><i class="fas fa-list-ul me-2"></i>Materi</h6>
            </div>
            <div class="admin-card-body">
                <div class="content-body"><?= $training['materials'] ?></div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Meta SEO -->
        <?php if (!empty($training['meta_title']) || !empty($training['meta_description'])): ?>
        <div class="admin-card">
            <div class="admin-card-header">
                <h6 class="admin-card-title mb-0"><i class="fas fa-search me-2"></i>SEO / Meta</h6>
            </div>
            <div class="admin-card-body">
                <dl class="row mb-0" style="font-size:13px;">
                    <?php if (!empty($training['meta_title'])): ?>
                    <dt class="col-sm-3 text-muted">Meta Title</dt>
                    <dd class="col-sm-9"><?= esc($training['meta_title']) ?></dd>
                    <?php endif; ?>
                    <?php if (!empty($training['meta_description'])): ?>
                    <dt class="col-sm-3 text-muted">Meta Desc</dt>
                    <dd class="col-sm-9"><?= esc($training['meta_description']) ?></dd>
                    <?php endif; ?>
                    <?php if (!empty($training['meta_keywords'])): ?>
                    <dt class="col-sm-3 text-muted">Keywords</dt>
                    <dd class="col-sm-9"><?= esc($training['meta_keywords']) ?></dd>
                    <?php endif; ?>
                    <dt class="col-sm-3 text-muted">Slug</dt>
                    <dd class="col-sm-9"><code><?= esc($training['slug']) ?></code></dd>
                </dl>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
