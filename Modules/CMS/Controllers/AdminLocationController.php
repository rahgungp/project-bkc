<?php

namespace Modules\CMS\Controllers;

use App\Controllers\BaseController;
use Modules\CMS\Models\LocationModel;

class AdminLocationController extends BaseController
{
    protected LocationModel $model;

    public function __construct()
    {
        $this->model = new LocationModel();
    }

    /**
     * List all locations in a DataTables view.
     */
    public function index()
    {
        $locations = $this->model->where('deleted_at', null)->orderBy('name', 'ASC')->findAll();

        return view('Modules\CMS\Views\admin\locations', [
            'title'       => 'Manajemen Lokasi',
            'locations'   => $locations,
            'breadcrumbs' => [['title' => 'Lokasi']],
        ]);
    }

    /**
     * AJAX: Create a new location.
     */
    public function store()
    {
        $rules = [
            'name'    => 'required|min_length[3]|max_length[255]',
            'city'    => 'required|max_length[100]',
            'address' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors'  => $this->validator->getErrors(),
            ]);
        }

        $id = $this->model->insert([
            'name'            => $this->request->getPost('name'),
            'address'         => $this->request->getPost('address'),
            'city'            => $this->request->getPost('city'),
            'province'        => $this->request->getPost('province'),
            'google_maps'     => $this->request->getPost('google_maps_url'),
            'phone'           => $this->request->getPost('phone'),
            'description'     => $this->request->getPost('description'),
            'type'            => $this->request->getPost('type') ?: 'venue',
            'is_active'       => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Lokasi berhasil ditambahkan.',
            'id'      => $id,
        ]);
    }

    /**
     * AJAX: Update an existing location.
     */
    public function update(int $id)
    {
        $location = $this->model->find($id);
        if (!$location) {
            return $this->response->setJSON(['success' => false, 'message' => 'Lokasi tidak ditemukan.']);
        }

        $rules = [
            'name'    => 'required|min_length[3]|max_length[255]',
            'city'    => 'required|max_length[100]',
            'address' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors'  => $this->validator->getErrors(),
            ]);
        }

        $this->model->update($id, [
            'name'            => $this->request->getPost('name'),
            'address'         => $this->request->getPost('address'),
            'city'            => $this->request->getPost('city'),
            'province'        => $this->request->getPost('province'),
            'google_maps'     => $this->request->getPost('google_maps_url'),
            'phone'           => $this->request->getPost('phone'),
            'description'     => $this->request->getPost('description'),
            'type'            => $this->request->getPost('type') ?: 'venue',
            'is_active'       => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return $this->response->setJSON(['success' => true, 'message' => 'Lokasi berhasil diperbarui.']);
    }

    /**
     * AJAX: Soft-delete a location.
     */
    public function delete(int $id)
    {
        $location = $this->model->find($id);
        if (!$location) {
            return $this->response->setJSON(['success' => false, 'message' => 'Lokasi tidak ditemukan.']);
        }

        $this->model->delete($id);

        return $this->response->setJSON(['success' => true, 'message' => 'Lokasi berhasil dihapus.']);
    }
}
