<?php

namespace Modules\Admin\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Modules\Admin\Models\RoleModel;

class UserController extends BaseController
{
    protected UserModel $userModel;
    protected RoleModel $roleModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
        helper(['url', 'form', 'filesystem']);
    }

    // ─── Index ────────────────────────────────────────────────────────────────

    public function index()
    {
        $users = $this->userModel
            ->select('users.*, roles.name as role_name, roles.slug as role_slug')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->where('users.deleted_at', null)
            ->orderBy('users.created_at', 'DESC')
            ->paginate(20, 'default');

        return view('Modules\Admin\Views\users\index', [
            'title'      => 'User Management',
            'breadcrumbs' => [
                ['title' => 'Sistem'],
                ['title' => 'User Management'],
            ],
            'users'   => $users,
            'pager'   => $this->userModel->pager,
        ]);
    }

    // ─── Create ───────────────────────────────────────────────────────────────

    public function create()
    {
        return view('Modules\Admin\Views\users\form', [
            'title'      => 'Tambah User',
            'breadcrumbs' => [
                ['title' => 'User Management', 'url' => base_url('admin/users')],
                ['title' => 'Tambah User'],
            ],
            'roles'  => $this->roleModel->getActive(),
            'user'   => null,
            'isEdit' => false,
        ]);
    }

    // ─── Store ────────────────────────────────────────────────────────────────

    public function store()
    {
        $rules = [
            'name'             => 'required|min_length[2]|max_length[100]',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'password'         => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]',
            'role_id'          => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'      => $this->request->getPost('name'),
            'email'     => $this->request->getPost('email'),
            'password'  => password_hash($this->request->getPost('password'), PASSWORD_ARGON2ID),
            'role_id'   => (int) $this->request->getPost('role_id'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        ];

        // Photo upload
        $photo = $this->request->getFile('photo');
        $allowedPhotoMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        if ($photo && $photo->isValid() && !$photo->hasMoved() && in_array($photo->getMimeType(), $allowedPhotoMimes, true)) {
            $newName = $photo->getRandomName();
            $uploadPath = FCPATH . 'uploads/users/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $photo->move($uploadPath, $newName);
            $data['avatar'] = 'users/' . $newName;
        }

        $userId = $this->userModel->insert($data);
        $this->userModel->logAudit('created', $userId, [], $data);

        return redirect()->to(base_url('admin/users'))
                         ->with('success', 'User berhasil ditambahkan.');
    }

    // ─── Edit ─────────────────────────────────────────────────────────────────

    public function edit(int $id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to(base_url('admin/users'))->with('error', 'User tidak ditemukan.');
        }

        return view('Modules\Admin\Views\users\form', [
            'title'      => 'Edit User',
            'breadcrumbs' => [
                ['title' => 'User Management', 'url' => base_url('admin/users')],
                ['title' => 'Edit User'],
            ],
            'roles'  => $this->roleModel->getActive(),
            'user'   => $user,
            'isEdit' => true,
        ]);
    }

    // ─── Update ───────────────────────────────────────────────────────────────

    public function update(int $id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to(base_url('admin/users'))->with('error', 'User tidak ditemukan.');
        }

        $rules = [
            'name'    => 'required|min_length[2]|max_length[100]',
            'role_id' => 'required|integer',
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $rules['password']         = 'min_length[8]';
            $rules['password_confirm'] = 'matches[password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'      => $this->request->getPost('name'),
            'role_id'   => (int) $this->request->getPost('role_id'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        ];

        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_ARGON2ID);
        }

        // Photo upload
        $photo = $this->request->getFile('photo');
        if ($photo && $photo->isValid() && !$photo->hasMoved() && in_array($photo->getMimeType(), ['image/jpeg', 'image/png', 'image/webp', 'image/gif'], true)) {
            // Remove old photo
            if (!empty($user['avatar']) && file_exists(FCPATH . 'uploads/' . $user['avatar'])) {
                unlink(FCPATH . 'uploads/' . $user['avatar']);
            }
            $newName = $photo->getRandomName();
            $uploadPath = FCPATH . 'uploads/users/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $photo->move($uploadPath, $newName);
            $data['avatar'] = 'users/' . $newName;
        }

        $oldData = $user;
        $this->userModel->update($id, $data);
        $this->userModel->logAudit('updated', $id, $oldData, $data);

        return redirect()->to(base_url('admin/users'))
                         ->with('success', 'User berhasil diperbarui.');
    }

    // ─── Delete ───────────────────────────────────────────────────────────────

    public function delete(int $id)
    {
        if ((int) session()->get('admin_id') === $id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Anda tidak dapat menghapus akun Anda sendiri.',
            ]);
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User tidak ditemukan.',
            ]);
        }

        $this->userModel->delete($id);
        $this->userModel->logAudit('deleted', $id, $user, []);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'User berhasil dihapus.',
        ]);
    }

    // ─── Reset Password ───────────────────────────────────────────────────────

    public function resetPassword(int $id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User tidak ditemukan.',
            ]);
        }

        // Generate temporary password
        $chars    = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789!@#$';
        $tempPass = '';
        for ($i = 0; $i < 12; $i++) {
            $tempPass .= $chars[random_int(0, strlen($chars) - 1)];
        }

        $this->userModel->update($id, [
            'password'       => password_hash($tempPass, PASSWORD_ARGON2ID),
            'login_attempts' => 0,
            'locked_until'   => null,
        ]);

        $this->userModel->logAudit('reset_password', $id, [], ['user_id' => $id]);

        return $this->response->setJSON([
            'success'  => true,
            'message'  => 'Password berhasil direset.',
            'password' => $tempPass,
        ]);
    }

    // ─── Toggle Active ────────────────────────────────────────────────────────

    public function toggleActive(int $id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User tidak ditemukan.',
            ]);
        }

        $newStatus = $user['is_active'] ? 0 : 1;
        $this->userModel->update($id, ['is_active' => $newStatus]);
        $this->userModel->logAudit('toggle_active', $id, ['is_active' => $user['is_active']], ['is_active' => $newStatus]);

        return $this->response->setJSON([
            'success'   => true,
            'is_active' => $newStatus,
            'message'   => $newStatus ? 'User diaktifkan.' : 'User dinonaktifkan.',
        ]);
    }
}
