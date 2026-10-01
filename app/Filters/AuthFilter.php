<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null): RedirectResponse|null
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if ($arguments) {
            $permission      = $arguments[0];
            $userPermissions = session()->get('admin_permissions') ?? [];
            if (!in_array($permission, $userPermissions, true) && !in_array('*', $userPermissions, true)) {
                return redirect()->to('/admin')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null): void
    {
        // No post-processing required
    }
}
