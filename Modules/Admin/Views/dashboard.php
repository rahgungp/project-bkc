<?= $this->extend('Modules\Admin\Views\layout\main') ?>
<?= $this->section('content') ?>

<div class="page-header" data-aos="fade-down">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Selamat datang, <?= esc(session()->get('admin_name')) ?>! Ini adalah ringkasan aktivitas website BKC.</p>
    </div>
    <div class="page-actions">
        <span class="badge-datetime">
            <i class="fas fa-calendar-alt me-1"></i>
            <?= date('l, d F Y') ?>
        </span>
    </div>
</div>

<!-- Stats Grid -->
<div class="stats-grid" data-aos="fade-up" data-aos-delay="100">

    <div class="stat-card stat-gold">
        <div class="stat-icon"><i class="fas fa-graduation-cap"></i></div>
        <div class="stat-info">
            <div class="stat-value"><?= $stats['total_trainings'] ?></div>
            <div class="stat-label">Total Pelatihan</div>
            <div class="stat-sub"><?= $stats['published_trainings'] ?> dipublikasikan</div>
        </div>
        <a href="<?= base_url('admin/pelatihan') ?>" class="stat-link">
            <i class="fas fa-arrow-right"></i>
        </a>
    </div>

    <div class="stat-card stat-blue">
        <div class="stat-icon"><i class="fas fa-clipboard-list"></i></div>
        <div class="stat-info">
            <div class="stat-value"><?= $stats['total_registrations'] ?></div>
            <div class="stat-label">Total Pendaftaran</div>
            <div class="stat-sub"><?= $stats['pending_registrations'] ?> menunggu konfirmasi</div>
        </div>
        <?php if ($stats['pending_registrations'] > 0): ?>
        <span class="stat-badge"><?= $stats['pending_registrations'] ?></span>
        <?php endif; ?>
        <a href="<?= base_url('admin/pendaftaran') ?>" class="stat-link">
            <i class="fas fa-arrow-right"></i>
        </a>
    </div>

    <div class="stat-card stat-green">
        <div class="stat-icon"><i class="fas fa-newspaper"></i></div>
        <div class="stat-info">
            <div class="stat-value"><?= $stats['total_news'] ?></div>
            <div class="stat-label">Total Berita</div>
            <div class="stat-sub">Artikel & publikasi</div>
        </div>
        <a href="<?= base_url('admin/berita') ?>" class="stat-link">
            <i class="fas fa-arrow-right"></i>
        </a>
    </div>

    <div class="stat-card stat-orange">
        <div class="stat-icon"><i class="fas fa-star"></i></div>
        <div class="stat-info">
            <div class="stat-value"><?= $stats['total_testimonials'] ?></div>
            <div class="stat-label">Testimoni</div>
            <div class="stat-sub"><?= $stats['pending_testimonials'] ?> menunggu persetujuan</div>
        </div>
        <a href="<?= base_url('admin/testimoni') ?>" class="stat-link">
            <i class="fas fa-arrow-right"></i>
        </a>
    </div>

</div>

<!-- Row 2 - Chart + Upcoming -->
<div class="row g-4 mt-1">

    <!-- Chart -->
    <div class="col-xl-8" data-aos="fade-up" data-aos-delay="200">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h6 class="admin-card-title"><i class="fas fa-chart-area me-2"></i>Pendaftaran 7 Hari Terakhir</h6>
                <a href="<?= base_url('admin/pendaftaran') ?>" class="btn btn-sm btn-outline-gold">Lihat Semua</a>
            </div>
            <div class="admin-card-body">
                <canvas id="registrationChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Upcoming Trainings -->
    <div class="col-xl-4" data-aos="fade-up" data-aos-delay="300">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h6 class="admin-card-title"><i class="fas fa-calendar-check me-2"></i>Pelatihan Upcoming</h6>
                <a href="<?= base_url('admin/pelatihan') ?>" class="btn btn-sm btn-outline-gold">Lihat Semua</a>
            </div>
            <div class="admin-card-body p-0">
                <?php if (!empty($upcomingTrainings)): ?>
                <?php foreach ($upcomingTrainings as $training): ?>
                <div class="upcoming-item">
                    <div class="upcoming-date">
                        <span class="date-day"><?= date('d', strtotime($training['start_date'])) ?></span>
                        <span class="date-month"><?= date('M', strtotime($training['start_date'])) ?></span>
                    </div>
                    <div class="upcoming-info">
                        <div class="upcoming-title"><?= esc(substr($training['title'], 0, 40)) ?>...</div>
                        <div class="upcoming-meta">
                            <span class="badge-category" style="background:<?= esc($training['category_color'] ?? '#C8A34D') ?>20; color:<?= esc($training['category_color'] ?? '#C8A34D') ?>;">
                                <?= esc($training['category_name']) ?>
                            </span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <div class="empty-state-sm">
                    <i class="fas fa-calendar-times"></i>
                    <p>Belum ada pelatihan upcoming</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<!-- Row 3 - Recent Registrations -->
<div class="row g-4 mt-1">
    <div class="col-12" data-aos="fade-up" data-aos-delay="400">
        <div class="admin-card">
            <div class="admin-card-header">
                <h6 class="admin-card-title"><i class="fas fa-clipboard-list me-2"></i>Pendaftaran Terbaru</h6>
                <a href="<?= base_url('admin/pendaftaran') ?>" class="btn btn-sm btn-outline-gold">Lihat Semua</a>
            </div>
            <div class="admin-card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
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
                            <?php if (!empty($recentRegistrations)): ?>
                            <?php foreach ($recentRegistrations as $reg): ?>
                            <tr>
                                <td><code><?= esc($reg['registration_code']) ?></code></td>
                                <td>
                                    <div class="fw-600"><?= esc($reg['participant_name']) ?></div>
                                    <small class="text-muted"><?= esc($reg['participant_email']) ?></small>
                                </td>
                                <td><?= esc(substr($reg['training_title'] ?? '-', 0, 35)) ?>...</td>
                                <td><?= esc($reg['participant_institution'] ?? '-') ?></td>
                                <td>
                                    <span class="status-badge status-<?= $reg['status'] ?>">
                                        <?= ucfirst($reg['status']) ?>
                                    </span>
                                </td>
                                <td><?= date('d/m/Y', strtotime($reg['created_at'])) ?></td>
                                <td>
                                    <a href="<?= base_url('admin/pendaftaran/detail/' . $reg['id']) ?>" class="btn btn-xs btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada pendaftaran</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Registration Chart
const ctx = document.getElementById('registrationChart').getContext('2d');
const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
const textColor = isDark ? 'rgba(255,255,255,0.6)' : 'rgba(0,0,0,0.6)';
const gridColor = isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)';

new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= is_array($chartLabels) ? json_encode($chartLabels) : $chartLabels ?>,
        datasets: [{
            label: 'Pendaftaran',
            data: <?= is_array($chartData) ? json_encode($chartData) : $chartData ?>,
            borderColor: '#C8A34D',
            backgroundColor: 'rgba(200, 163, 77, 0.1)',
            borderWidth: 2.5,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#C8A34D',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 5,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#1a1a2e',
                titleColor: '#C8A34D',
                bodyColor: '#fff',
                borderColor: 'rgba(200, 163, 77, 0.3)',
                borderWidth: 1,
                padding: 12,
            }
        },
        scales: {
            x: {
                grid: { color: gridColor },
                ticks: { color: textColor }
            },
            y: {
                beginAtZero: true,
                grid: { color: gridColor },
                ticks: { color: textColor, stepSize: 1 }
            }
        }
    }
});
</script>

<?= $this->endSection() ?>
