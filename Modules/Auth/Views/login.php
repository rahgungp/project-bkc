<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <link rel="icon" href="<?= base_url('assets/images/logo/favicon.png') ?>" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        :root {
            --gold: #C8A34D;
            --gold-light: #D4B76A;
            --royal-blue: #1E4FA3;
            --dark: #121212;
            --dark-2: #1a1a2e;
            --dark-3: #16213e;
            --white: #FFFFFF;
            --gray: #6c757d;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Animated Background */
        .bg-animated {
            position: fixed;
            inset: 0;
            z-index: 0;
            background: linear-gradient(135deg, #0a0a1a 0%, #121212 30%, #0d1b2a 60%, #1a0a0a 100%);
            overflow: hidden;
        }

        .bg-animated::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(200, 163, 77, 0.15) 0%, transparent 70%);
            top: -100px;
            left: -100px;
            animation: float1 8s ease-in-out infinite;
        }

        .bg-animated::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(30, 79, 163, 0.15) 0%, transparent 70%);
            bottom: -100px;
            right: -100px;
            animation: float2 10s ease-in-out infinite;
        }

        .bg-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            pointer-events: none;
        }

        .bg-orb-1 {
            width: 300px; height: 300px;
            background: rgba(200, 163, 77, 0.1);
            top: 20%; right: 20%;
            animation: float3 12s ease-in-out infinite;
        }

        .bg-orb-2 {
            width: 200px; height: 200px;
            background: rgba(30, 79, 163, 0.12);
            bottom: 30%; left: 15%;
            animation: float4 9s ease-in-out infinite;
        }

        @keyframes float1 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(30px, 30px); } }
        @keyframes float2 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(-30px, -30px); } }
        @keyframes float3 { 0%, 100% { transform: translate(0, 0) scale(1); } 50% { transform: translate(-20px, 20px) scale(1.1); } }
        @keyframes float4 { 0%, 100% { transform: translate(0, 0) scale(1); } 50% { transform: translate(20px, -20px) scale(0.9); } }

        /* Login Container */
        .login-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
            padding: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(200, 163, 77, 0.2);
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: 0 32px 64px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.05);
        }

        /* Logo Area */
        .logo-area {
            text-align: center;
            margin-bottom: 36px;
        }

        .logo-img {
            width: 120px;
            height: auto;
            margin-bottom: 16px;
            filter: drop-shadow(0 4px 12px rgba(200, 163, 77, 0.3));
        }

        .logo-tagline {
            font-size: 11px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--gold);
            font-weight: 500;
            opacity: 0.8;
        }

        /* Form Header */
        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 8px;
        }

        .login-subtitle {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.5);
        }

        /* Form */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.3);
            font-size: 14px;
            z-index: 1;
            transition: color 0.3s;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px 14px 44px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: var(--white);
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(200, 163, 77, 0.5);
            box-shadow: 0 0 0 3px rgba(200, 163, 77, 0.1);
        }

        .form-control:focus + .input-icon,
        .input-wrapper:focus-within .input-icon {
            color: var(--gold);
        }

        .form-control::placeholder { color: rgba(255, 255, 255, 0.3); }

        .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.3);
            cursor: pointer;
            font-size: 14px;
            transition: color 0.3s;
        }

        .toggle-password:hover { color: var(--gold); }

        /* Remember & Forgot */
        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .remember-label input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--gold);
            cursor: pointer;
        }

        .remember-label span {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.6);
        }

        .forgot-link {
            font-size: 13px;
            color: var(--gold);
            text-decoration: none;
            transition: opacity 0.3s;
        }

        .forgot-link:hover { opacity: 0.8; }

        /* Submit Button */
        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, var(--gold) 0%, #a8813a 100%);
            border: none;
            border-radius: 12px;
            color: var(--dark);
            font-size: 15px;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.5px;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, transparent 100%);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .btn-login:hover::before { opacity: 1; }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(200, 163, 77, 0.4);
        }

        .btn-login:active { transform: translateY(0); }

        .btn-login .spinner {
            display: none;
            width: 18px;
            height: 18px;
            border: 2px solid rgba(0,0,0,0.3);
            border-top-color: var(--dark);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        /* Divider */
        .login-divider {
            text-align: center;
            margin-top: 28px;
            padding-top: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .login-divider a {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.4);
            text-decoration: none;
            transition: color 0.3s;
        }

        .login-divider a:hover { color: var(--gold); }

        /* Alert flash */
        .alert-flash {
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: rgba(76, 175, 80, 0.15);
            border: 1px solid rgba(76, 175, 80, 0.3);
            color: #81c784;
        }

        .alert-error {
            background: rgba(244, 67, 54, 0.15);
            border: 1px solid rgba(244, 67, 54, 0.3);
            color: #e57373;
        }

        /* Security badge */
        .security-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 20px;
            font-size: 11px;
            color: rgba(255, 255, 255, 0.3);
        }

        .security-badge i { color: var(--gold); font-size: 10px; }

        /* Copyright */
        .login-copyright {
            text-align: center;
            margin-top: 24px;
            font-size: 11px;
            color: rgba(255, 255, 255, 0.2);
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-card { padding: 36px 24px; }
            .login-title { font-size: 20px; }
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="bg-animated">
        <div class="bg-orb bg-orb-1"></div>
        <div class="bg-orb bg-orb-2"></div>
    </div>

    <!-- Login Wrapper -->
    <div class="login-wrapper">
        <div class="login-card">

            <!-- Logo -->
            <div class="logo-area">
                <img src="<?= base_url('assets/images/logo/logo_BKC_1.png') ?>" alt="BKC Logo" class="logo-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='block'">
                <div style="display:none; font-size:24px; font-weight:800; color:var(--gold); margin-bottom:8px;">BKC</div>
                <div class="logo-tagline">Building Knowledge & Capacity</div>
            </div>

            <!-- Header -->
            <div class="login-header">
                <h1 class="login-title">Selamat Datang</h1>
                <p class="login-subtitle">Masuk ke panel administrasi BKC</p>
            </div>

            <!-- Flash Messages -->
            <?php if (session()->getFlashdata('error')): ?>
            <div class="alert-flash alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
            <div class="alert-flash alert-success">
                <i class="fas fa-check-circle"></i>
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
            <?php endif; ?>

            <!-- Form -->
            <form id="loginForm" novalidate>
                <?= csrf_field() ?>

                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email"
                               name="email"
                               class="form-control"
                               placeholder="admin@bkc.co.id"
                               autocomplete="email"
                               required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password"
                               name="password"
                               id="passwordInput"
                               class="form-control"
                               placeholder="••••••••"
                               autocomplete="current-password"
                               required>
                        <button type="button" class="toggle-password" onclick="togglePassword()">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="form-options">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" value="1">
                        <span>Ingat saya</span>
                    </label>
                    <a href="#" class="forgot-link">Lupa password?</a>
                </div>

                <button type="submit" class="btn-login" id="loginBtn">
                    <span id="btnText"><i class="fas fa-sign-in-alt" style="margin-right:8px;"></i>Masuk ke Dashboard</span>
                    <div class="spinner" id="btnSpinner"></div>
                </button>
            </form>

            <!-- Security Badge -->
            <div class="security-badge">
                <i class="fas fa-shield-alt"></i>
                Dilindungi enkripsi Argon2id & CSRF Protection
            </div>

            <div class="login-divider">
                <a href="<?= base_url() ?>"><i class="fas fa-arrow-left" style="margin-right:6px;"></i>Kembali ke Website</a>
            </div>
        </div>

        <div class="login-copyright">
            &copy; <?= date('Y') ?> CV. Bagus Kencana Cakrada. All rights reserved.
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const icon = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const btn = document.getElementById('loginBtn');
            const btnText = document.getElementById('btnText');
            const spinner = document.getElementById('btnSpinner');

            // Show loading
            btn.disabled = true;
            btnText.style.display = 'none';
            spinner.style.display = 'block';

            const formData = new FormData(this);

            try {
                const response = await fetch('<?= base_url("admin/login/proses") ?>', {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                const data = await response.json();

                if (data.status === 'success') {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Login Berhasil!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false,
                        background: '#1a1a2e',
                        color: '#fff',
                        iconColor: '#C8A34D',
                    });
                    window.location.href = data.redirect;
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Gagal',
                        text: data.message,
                        background: '#1a1a2e',
                        color: '#fff',
                        confirmButtonColor: '#C8A34D',
                        confirmButtonText: 'Coba Lagi',
                    });
                }
            } catch (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Gagal terhubung ke server. Coba lagi.',
                    background: '#1a1a2e',
                    color: '#fff',
                    confirmButtonColor: '#C8A34D',
                });
            } finally {
                btn.disabled = false;
                btnText.style.display = 'block';
                spinner.style.display = 'none';
            }
        });

        // Auto focus
        document.querySelector('input[name="email"]').focus();
    </script>
</body>
</html>
