<?php

namespace Modules\Admin\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Modules\Admin\Models\RoleModel;

class RoleController extends BaseController
{
    protected RoleModel $roleModel;
    protected UserModel $userModel;

    protected array $availablePermissions = [
        'dashboard'           => 'Dashboard',
        'training.view'       => 'Lihat Pelatihan',
        'training.create'     => 'Tambah Pelatihan',
        'training.edit'       => 'Edit Pelatihan',
        'training.delete'     => 'Hapus Pelatihan',
        'news.view'           => 'Lihat Berita',
        'news.create'         => 'Tambah Berita',
        'news.edit'           => 'Edit Berita',
        'news.delete'         => 'Hapus Berita',
        'registration.view'   => 'Lihat Pendaftaran',
        'registration.edit'   => 'Edit Pendaftaran',
        'gallery.manage'      => 'Kelola Galeri',
        'testimonial.manage'  => 'Kelola Testimoni',
        'faq.manage'          => 'Kelola FAQ',
        'profile.manage'      => 'Kelola Profil',
        'user.manage'         => 'Kelola Pengguna',
        'role.manage'         => 'Kelola Role',
        'settings.manage'     => 'Kelola Pengaturan',
        'log.view'            => 'Lihat Log Aktivitas',
    ];

    public function __construct()
    {
        $this->roleModel = new RoleModel();
        $this->userModel = new UserModel();
        helper(['url', 'form']);
    }

    // ─── Index ────────────────────────────────────────────────────────────────

    public function index()
    {
        $roles = $this->roleModel->withUserCount()->findAll();

        return view('Modules\Admin\Views\roles\index', [
            'title'      => 'Role Management',
            'breadcrumbs' => [
                ['title' => 'Sistem'],
                ['title' => 'Roles & Permission'],
            ],
            'roles'                => $roles,
            'availablePermissions' => $this->availablePermissions,
        ]);
    }

    // ─── Create ───────────────────────────────────────────────────────────────

    public function create()
    {
        return view('Modules\Admin\Views\roles\form', [
            'title'      => 'Tambah Role',
            'breadcrumbs' => [
                ['title' => 'Roles & Permission', 'url' => base_url('admin/roles')],
                ['title' => 'Tambah Role'],
            ],
            'availablePermissions' => $this->availablePermissions,
            'role'   => null,
            'isEdit' => false,
        ]);
    }

    // ─── Store ────────────────────────────────────────────────────────────────

    public function store()
    {
        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
            'slug' => 'required|min_length[2]|max_length[100]|is_unique[roles.slug]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $permissions = $this->request->getPost('permissions') ?? [];
        if (!is_array($permissions)) {
            $permissions = [];
        }

        $data = [
            'name'        => $this->request->getPost('name'),
            'slug'        => $this->request->getPost('slug'),
            'description' => $this->request->getPost('description'),
            'permissions' => json_encode(array_values($permissions)),
            'is_active'   => $this->request->getPost('is_active') ? 1 : 0,
        ];

        $roleId = $this->roleModel->insert($data);
        $this->roleModel->logAudit('created', $roleId, [], $data);

        return redirect()->to(base_url('admin/roles'))
                         ->with('success', 'Role berhasil ditambahkan.');
    }

    // ─── Edit ─────────────────────────────────────────────────────────────────

    public function edit(int $id)
    {
        $role = $this->roleModel->find($id);
        if (!$role) {
            return redirect()->to(base_url('admin/roles'))->with('error', 'Role tidak ditemukan.');
        }

        $role['permissions'] = $this->roleModel->getPermissionsArray($id);

        return view('Modules\Admin\Views\roles\form', [
            'title'      => 'Edit Role',
            'breadcrumbs' => [
                ['title' => 'Roles & Permission', 'url' => base_url('admin/roles')],
                ['title' => 'Edit Role'],
            ],
            'availablePermissions' => $this->availablePermissions,
            'role'   => $role,
            'isEdit' => true,
        ]);
    }

    // ─── Update ───────────────────────────────────────────────────────────────

    public function update(int $id)
    {
        $role = $this->roleModel->find($id);
        if (!$role) {
            return redirect()->to(base_url('admin/roles'))->with('error', 'Role tidak ditemukan.');
        }

        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
            'slug' => "required|min_length[2]|max_length[100]|is_unique[roles.slug,id,{$id}]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $permissions = $this->request->getPost('permissions') ?? [];
        if (!is_array($permissions)) {
            $permissions = [];
        }

        $data = [
            'name'        => $this->request->getPost('name'),
            'slug'        => $this->request->getPost('slug'),
            'description' => $this->request->getPost('description'),
            'permissions' => json_encode(array_values($permissions)),
            'is_active'   => $this->request->getPost('is_active') ? 1 : 0,
        ];

        $oldData = $role;
        $this->roleModel->update($id, $data);
        $this->roleModel->logAudit('updated', $id, $oldData, $data);

        return redirect()->to(base_url('admin/roles'))
                         ->with('success', 'Role berhasil diperbarui.');
    }

    // ─── Delete ───────────────────────────────────────────────────────────────

    public function delete(int $id)
    {
        $role = $this->roleModel->find($id);
        if (!$role) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Role tidak ditemukan.',
            ]);
        }

        // Prevent deletion if users are still assigned to this role
        $userCount = $this->userModel
            ->where('role_id', $id)
            ->where('deleted_at', null)
            ->countAllResults();

        if ($userCount > 0) {
            return $this->response->setJSON([
                'success' => false,
                'message' => "Role tidak dapat dihapus karena masih digunakan oleh {$userCount} user.",
            ]);
        }

        $this->roleModel->delete($id);
        $this->roleModel->logAudit('deleted', $id, $role, []);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Role berhasil dihapus.',
        ]);
    }
}
