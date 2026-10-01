<?php

namespace Modules\Auth\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\LoginHistoryModel;

class AuthController extends BaseController
{
    protected UserModel $userModel;
    protected LoginHistoryModel $loginHistoryModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->loginHistoryModel = new LoginHistoryModel();
    }

    public function login()
    {
        if (session()->get('admin_logged_in')) {
            return redirect()->to('/admin');
        }
        return view('Modules\Auth\Views\login', [
            'title' => 'Login Admin - CV. Bagus Kencana Cakrada',
        ]);
    }

    public function processLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember');

        // Rate limiting check
        $rateLimitKey = 'login_' . $this->request->getIPAddress();
        $cache = \Config\Services::cache();
        $attempts = $cache->get($rateLimitKey) ?? 0;

        if ($attempts >= 10) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terlalu banyak percobaan login. Coba lagi dalam 15 menit.'
            ]);
        }

        $user = $this->userModel->findByEmail($email);

        if (!$user) {
            $cache->save($rateLimitKey, $attempts + 1, 900);
            return $this->response->setJSON(['status' => 'error', 'message' => 'Email atau password salah.']);
        }

        if (!$user['is_active']) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Akun Anda tidak aktif. Hubungi administrator.']);
        }

        if ($this->userModel->isLocked($user['id'])) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Akun terkunci. Coba lagi dalam 30 menit.']);
        }

        if (!password_verify($password, $user['password'])) {
            $this->userModel->incrementFailedLogin($user['id']);
            $this->loginHistoryModel->log($user['id'], 'failed');
            $cache->save($rateLimitKey, $attempts + 1, 900);
            return $this->response->setJSON(['status' => 'error', 'message' => 'Email atau password salah.']);
        }

        // Success
        $this->userModel->resetLoginAttempts($user['id']);
        $this->loginHistoryModel->log($user['id'], 'success');
        $cache->delete($rateLimitKey);

        $permissions = json_decode($user['permissions'] ?? '[]', true);

        session()->set([
            'admin_logged_in' => true,
            'admin_id' => $user['id'],
            'admin_uuid' => $user['uuid'],
            'admin_name' => $user['name'],
            'admin_email' => $user['email'],
            'admin_role' => $user['role_slug'],
            'admin_role_name' => $user['role_name'],
            'admin_permissions' => $permissions,
            'admin_avatar' => $user['avatar'],
        ]);

        return $this->response->setJSON([
            'status'   => 'success',
            'message'  => 'Login berhasil! Selamat datang, ' . esc($user['name']),
            'redirect' => base_url('admin/dashboard'),
        ]);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin/login')->with('success', 'Berhasil logout.');
    }

    public function twoFactor()
    {
        return view('Modules\Auth\Views\two_factor');
    }

    public function verifyTwoFactor()
    {
        // 2FA is not yet implemented — block access until it is.
        return $this->response->setStatusCode(503)->setJSON([
            'status'  => 'error',
            'message' => '2FA belum diimplementasikan.',
        ]);
    }
}
