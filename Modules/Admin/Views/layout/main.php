<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <title><?= isset($title) ? esc($title) . ' | BKC Admin' : 'BKC Admin Panel' ?></title>
    <link rel="icon" href="<?= base_url('assets/images/logo/favicon.png') ?>" type="image/png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- AOS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">

    <!-- Admin Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">

    <?= isset($extra_css) ? $extra_css : '' ?>
</head>
<body>
    <!-- Sidebar Overlay (Mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <!-- Sidebar Header -->
        <div class="sidebar-header">
            <a href="<?= base_url('admin') ?>" class="sidebar-logo">
                <img src="<?= base_url('assets/images/logo/logo_BKC_1.png') ?>" alt="BKC" class="logo-img" onerror="this.style.display='none'">
                <div class="logo-text">
                    <span class="logo-name">BKC</span>
                    <span class="logo-tagline">Admin Panel</span>
                </div>
            </a>
            <button class="sidebar-toggle-btn" onclick="toggleSidebar()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- User Info -->
        <div class="sidebar-user">
            <div class="user-avatar">
                <?php if (session()->get('admin_avatar')): ?>
                    <img src="<?= base_url('assets/uploads/' . session()->get('admin_avatar')) ?>" alt="Avatar">
                <?php else: ?>
                    <div class="avatar-initials"><?= strtoupper(substr(session()->get('admin_name', 'A'), 0, 1)) ?></div>
                <?php endif; ?>
            </div>
            <div class="user-info">
                <span class="user-name"><?= esc(session()->get('admin_name')) ?></span>
                <span class="user-role"><?= esc(session()->get('admin_role_name')) ?></span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="sidebar-nav">

            <a href="<?= base_url('admin/dashboard') ?>" class="nav-item <?= (uri_string() === 'admin/dashboard' || uri_string() === 'admin') ? 'active' : '' ?>">
                <i class="fas fa-tachometer-alt nav-icon"></i>
                <span>Dashboard</span>
            </a>

            <div class="nav-section-label">Konten</div>

            <div class="nav-item-group <?= str_starts_with(uri_string(), 'admin/pelatihan') ? 'open' : '' ?>">
                <button class="nav-item nav-group-toggle">
                    <i class="fas fa-graduation-cap nav-icon"></i>
                    <span>Pelatihan</span>
                    <i class="fas fa-chevron-right nav-arrow"></i>
                </button>
                <div class="nav-submenu">
                    <a href="<?= base_url('admin/pelatihan') ?>" class="nav-subitem">Daftar Pelatihan</a>
                    <a href="<?= base_url('admin/pelatihan/tambah') ?>" class="nav-subitem">Tambah Pelatihan</a>
                    <a href="<?= base_url('admin/kategori-pelatihan') ?>" class="nav-subitem">Kategori</a>
                </div>
            </div>

            <div class="nav-item-group <?= str_starts_with(uri_string(), 'admin/berita') ? 'open' : '' ?>">
                <button class="nav-item nav-group-toggle">
                    <i class="fas fa-newspaper nav-icon"></i>
                    <span>Berita</span>
                    <i class="fas fa-chevron-right nav-arrow"></i>
                </button>
                <div class="nav-submenu">
                    <a href="<?= base_url('admin/berita') ?>" class="nav-subitem">Daftar Berita</a>
                    <a href="<?= base_url('admin/berita/tambah') ?>" class="nav-subitem">Tambah Berita</a>
                </div>
            </div>

            <a href="<?= base_url('admin/galeri') ?>" class="nav-item <?= str_starts_with(uri_string(), 'admin/galeri') ? 'active' : '' ?>">
                <i class="fas fa-images nav-icon"></i>
                <span>Galeri</span>
            </a>

            <a href="<?= base_url('admin/testimoni') ?>" class="nav-item <?= str_starts_with(uri_string(), 'admin/testimoni') ? 'active' : '' ?>">
                <i class="fas fa-star nav-icon"></i>
                <span>Testimoni</span>
            </a>

            <a href="<?= base_url('admin/faq') ?>" class="nav-item <?= str_starts_with(uri_string(), 'admin/faq') ? 'active' : '' ?>">
                <i class="fas fa-question-circle nav-icon"></i>
                <span>FAQ</span>
            </a>

            <div class="nav-section-label">Pendaftaran</div>

            <a href="<?= base_url('admin/pendaftaran') ?>" class="nav-item <?= str_starts_with(uri_string(), 'admin/pendaftaran') ? 'active' : '' ?>">
                <i class="fas fa-clipboard-list nav-icon"></i>
                <span>Pendaftaran</span>
                <span class="nav-badge" id="pendingBadge" style="display:none;">0</span>
            </a>

            <a href="<?= base_url('admin/peserta') ?>" class="nav-item <?= str_starts_with(uri_string(), 'admin/peserta') ? 'active' : '' ?>">
                <i class="fas fa-users nav-icon"></i>
                <span>Peserta</span>
            </a>

            <a href="<?= base_url('admin/sertifikat') ?>" class="nav-item <?= str_starts_with(uri_string(), 'admin/sertifikat') ? 'active' : '' ?>">
                <i class="fas fa-certificate nav-icon"></i>
                <span>Sertifikat</span>
            </a>

            <div class="nav-section-label">Master Data</div>

            <a href="<?= base_url('admin/narasumber') ?>" class="nav-item <?= str_starts_with(uri_string(), 'admin/narasumber') ? 'active' : '' ?>">
                <i class="fas fa-chalkboard-teacher nav-icon"></i>
                <span>Narasumber</span>
            </a>

            <a href="<?= base_url('admin/lokasi') ?>" class="nav-item <?= str_starts_with(uri_string(), 'admin/lokasi') ? 'active' : '' ?>">
                <i class="fas fa-map-marker-alt nav-icon"></i>
                <span>Lokasi</span>
            </a>

            <a href="<?= base_url('admin/banner') ?>" class="nav-item <?= str_starts_with(uri_string(), 'admin/banner') ? 'active' : '' ?>">
                <i class="fas fa-image nav-icon"></i>
                <span>Banner</span>
            </a>

            <a href="<?= base_url('admin/media') ?>" class="nav-item <?= str_starts_with(uri_string(), 'admin/media') ? 'active' : '' ?>">
                <i class="fas fa-folder-open nav-icon"></i>
                <span>Media Manager</span>
            </a>

            <div class="nav-section-label">Profil</div>

            <a href="<?= base_url('admin/profil-perusahaan') ?>" class="nav-item <?= str_starts_with(uri_string(), 'admin/profil-perusahaan') ? 'active' : '' ?>">
                <i class="fas fa-building nav-icon"></i>
                <span>Profil Perusahaan</span>
            </a>

            <a href="<?= base_url('admin/profil-pendiri') ?>" class="nav-item <?= str_starts_with(uri_string(), 'admin/profil-pendiri') ? 'active' : '' ?>">
                <i class="fas fa-user-tie nav-icon"></i>
                <span>Profil Pendiri</span>
            </a>

            <div class="nav-section-label">Sistem</div>

            <a href="<?= base_url('admin/users') ?>" class="nav-item <?= str_starts_with(uri_string(), 'admin/users') ? 'active' : '' ?>">
                <i class="fas fa-users-cog nav-icon"></i>
                <span>User Management</span>
            </a>

            <a href="<?= base_url('admin/roles') ?>" class="nav-item <?= str_starts_with(uri_string(), 'admin/roles') ? 'active' : '' ?>">
                <i class="fas fa-shield-alt nav-icon"></i>
                <span>Roles & Permission</span>
            </a>

            <a href="<?= base_url('admin/activity-log') ?>" class="nav-item <?= str_starts_with(uri_string(), 'admin/activity-log') ? 'active' : '' ?>">
                <i class="fas fa-history nav-icon"></i>
                <span>Activity Log</span>
            </a>

            <a href="<?= base_url('admin/pengaturan') ?>" class="nav-item <?= str_starts_with(uri_string(), 'admin/pengaturan') ? 'active' : '' ?>">
                <i class="fas fa-cog nav-icon"></i>
                <span>Pengaturan</span>
            </a>

            <a href="<?= base_url('admin/visibilitas') ?>" class="nav-item <?= str_starts_with(uri_string(), 'admin/visibilitas') ? 'active' : '' ?>">
                <i class="fas fa-eye-slash nav-icon"></i>
                <span>Visibilitas</span>
            </a>

            <div class="sidebar-footer">
                <a href="<?= base_url() ?>" target="_blank" class="nav-item">
                    <i class="fas fa-external-link-alt nav-icon"></i>
                    <span>Lihat Website</span>
                </a>
                <a href="<?= base_url('admin/logout') ?>" class="nav-item nav-logout" onclick="return confirmLogout(event)">
                    <i class="fas fa-sign-out-alt nav-icon"></i>
                    <span>Logout</span>
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="admin-main" id="adminMain">
        <!-- Top Bar -->
        <header class="admin-topbar">
            <div class="topbar-left">
                <button class="topbar-menu-btn" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <nav class="breadcrumb-nav" aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Dashboard</a></li>
                        <?php if (isset($breadcrumbs)): ?>
                            <?php foreach ($breadcrumbs as $crumb): ?>
                                <?php if (isset($crumb['url'])): ?>
                                    <li class="breadcrumb-item"><a href="<?= $crumb['url'] ?>"><?= esc($crumb['title']) ?></a></li>
                                <?php else: ?>
                                    <li class="breadcrumb-item active"><?= esc($crumb['title']) ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ol>
                </nav>
            </div>

            <div class="topbar-right">
                <!-- Theme Toggle -->
                <button class="topbar-btn theme-toggle" onclick="toggleTheme()" title="Toggle Dark/Light Mode">
                    <i class="fas fa-moon" id="themeIcon"></i>
                </button>

                <!-- Notifications -->
                <div class="dropdown">
                    <button class="topbar-btn" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        <span class="notif-dot"></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end notif-dropdown">
                        <div class="notif-header">
                            <span>Notifikasi</span>
                            <a href="#">Tandai semua dibaca</a>
                        </div>
                        <div class="notif-list">
                            <div class="notif-item unread">
                                <div class="notif-icon bg-gold"><i class="fas fa-user-plus"></i></div>
                                <div class="notif-content">
                                    <div class="notif-text">Pendaftaran baru menunggu konfirmasi</div>
                                    <div class="notif-time">Baru saja</div>
                                </div>
                            </div>
                        </div>
                        <div class="notif-footer">
                            <a href="<?= base_url('admin/pendaftaran') ?>">Lihat semua pendaftaran</a>
                        </div>
                    </div>
                </div>

                <!-- User Dropdown -->
                <div class="dropdown">
                    <button class="topbar-user" data-bs-toggle="dropdown">
                        <div class="topbar-avatar">
                            <?php if (session()->get('admin_avatar')): ?>
                                <img src="<?= base_url('assets/uploads/' . session()->get('admin_avatar')) ?>" alt="">
                            <?php else: ?>
                                <span><?= strtoupper(substr(session()->get('admin_name', 'A'), 0, 1)) ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="topbar-user-info d-none d-md-flex">
                            <span class="topbar-user-name"><?= esc(session()->get('admin_name')) ?></span>
                            <span class="topbar-user-role"><?= esc(session()->get('admin_role_name')) ?></span>
                        </div>
                        <i class="fas fa-chevron-down ms-2 d-none d-md-block" style="font-size:10px; opacity:0.5;"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="<?= base_url('admin/profil') ?>">
                            <i class="fas fa-user me-2"></i> Profil Saya
                        </a>
                        <a class="dropdown-item" href="<?= base_url('admin/pengaturan') ?>">
                            <i class="fas fa-cog me-2"></i> Pengaturan
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="<?= base_url('admin/logout') ?>" onclick="return confirmLogout(event)">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="admin-content">
            <!-- Flash Messages -->
            <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?= esc(session()->getFlashdata('success')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i><?= esc(session()->getFlashdata('error')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <!-- Page View -->
            <?= $this->renderSection('content') ?>
        </main>

        <!-- Footer -->
        <footer class="admin-footer">
            <span>&copy; <?= date('Y') ?> CV. Bagus Kencana Cakrada</span>
            <span>Powered by <strong>BKC CMS</strong> v1.0</span>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Admin Custom JS -->
    <script src="<?= base_url('assets/js/admin.js') ?>"></script>

    <?= $this->renderSection('extra_js') ?>

    <script>
        AOS.init({ once: true, duration: 400 });

        // Set CSRF token for AJAX
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        function confirmLogout(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: 'Anda yakin ingin keluar dari panel admin?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#C8A34D',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= base_url("admin/logout") ?>';
                }
            });
            return false;
        }
    </script>
</body>
</html>
