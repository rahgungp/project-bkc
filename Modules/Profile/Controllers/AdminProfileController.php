<?php

namespace Modules\Profile\Controllers;

use App\Controllers\BaseController;
use Modules\Profile\Models\CompanyProfileModel;
use Modules\Profile\Models\FounderProfileModel;
use Modules\Profile\Models\PublicationModel;

class AdminProfileController extends BaseController
{
    public function company()
    {
        $model = new CompanyProfileModel();
        $settings = $model->getAll();

        return view('Modules\Profile\Views\admin\company', [
            'title' => 'Profil Perusahaan',
            'settings' => $settings,
            'breadcrumbs' => [['title' => 'Profil Perusahaan']],
        ]);
    }

    public function updateCompany()
    {
        $model = new CompanyProfileModel();
        $data = $this->request->getPost();
        unset($data[csrf_token()]);

        // Handle logo upload
        $logoFile = $this->request->getFile('logo');
        if ($logoFile && $logoFile->isValid() && !$logoFile->hasMoved()) {
            $newName = $logoFile->getRandomName();
            $logoFile->move(ROOTPATH . 'public/assets/images/logo/', $newName);
            $data['company_logo'] = $newName;
        }

        $model->updateSettings($data);
        return redirect()->to('/admin/profil-perusahaan')->with('success', 'Profil perusahaan berhasil diperbarui.');
    }

    public function founder()
    {
        $founderModel = new FounderProfileModel();
        $founder = $founderModel->getMain();

        return view('Modules\Profile\Views\admin\founder', [
            'title' => 'Profil Pendiri',
            'founder' => $founder,
            'breadcrumbs' => [['title' => 'Profil Pendiri']],
        ]);
    }

    public function updateFounder()
    {
        $model = new FounderProfileModel();
        $founder = $model->first();

        $data = [
            'name'          => $this->request->getPost('name'),
            'title'         => $this->request->getPost('title'),
            'bio'           => $this->request->getPost('bio'),
            'achievements'  => $this->request->getPost('achievements') ?? '',
            'email'         => $this->request->getPost('email'),
            'linkedin'      => $this->request->getPost('linkedin'),
            'scopus_id'     => $this->request->getPost('scopus_id'),
            'google_scholar' => $this->request->getPost('google_scholar'),
        ];

        // Education — submitted as JSON from the view's JS serializer
        $eduJson = $this->request->getPost('education_json') ?? '';
        $education = json_decode($eduJson, true);
        $data['education'] = json_encode(is_array($education) ? $education : []);

        // Experience — submitted as JSON from the view's JS serializer
        $expJson = $this->request->getPost('experience_json') ?? '';
        $experience = json_decode($expJson, true);
        $data['experience'] = json_encode(is_array($experience) ? $experience : []);

        // Photo
        $photoFile = $this->request->getFile('photo');
        if ($photoFile && $photoFile->isValid() && !$photoFile->hasMoved()) {
            $newName = $photoFile->getRandomName();
            $photoFile->move(ROOTPATH . 'public/assets/uploads/', $newName);
            $data['photo'] = $newName;
        }

        if ($founder) {
            $model->update($founder['id'], $data);
        } else {
            $model->insert($data);
        }

        return redirect()->to('/admin/profil-pendiri')->with('success', 'Profil pendiri berhasil diperbarui.');
    }

    public function publications()
    {
        $founderModel = new FounderProfileModel();
        $publicationModel = new PublicationModel();

        $founder = $founderModel->first();
        $publications = $founder ? $publicationModel->getByFounder($founder['id']) : [];

        return view('Modules\Profile\Views\admin\publications', [
            'title' => 'Publikasi Pendiri',
            'founder' => $founder,
            'publications' => $publications,
            'breadcrumbs' => [['title' => 'Profil Pendiri', 'url' => base_url('admin/profil-pendiri')], ['title' => 'Publikasi']],
        ]);
    }

    public function storePublication()
    {
        $founderModel = new FounderProfileModel();
        $founder = $founderModel->first();

        if (!$founder) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Profil pendiri belum diisi.']);
        }

        $model = new PublicationModel();
        $model->insert([
            'founder_id' => $founder['id'],
            'title' => $this->request->getPost('title'),
            'type' => $this->request->getPost('type') ?: 'journal',
            'journal' => $this->request->getPost('journal'),
            'year' => $this->request->getPost('year'),
            'isbn' => $this->request->getPost('isbn'),
            'issn' => $this->request->getPost('issn'),
            'doi' => $this->request->getPost('doi'),
            'url' => $this->request->getPost('url'),
            'is_scopus' => $this->request->getPost('is_scopus') ? 1 : 0,
            'publisher' => $this->request->getPost('publisher'),
            'abstract' => $this->request->getPost('abstract'),
            'sort_order' => (int)($this->request->getPost('sort_order') ?: 0),
        ]);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Publikasi berhasil ditambahkan.']);
    }

    public function updatePublication(int $id)
    {
        $model = new PublicationModel();
        $model->update($id, [
            'title' => $this->request->getPost('title'),
            'type' => $this->request->getPost('type'),
            'journal' => $this->request->getPost('journal'),
            'year' => $this->request->getPost('year'),
            'isbn' => $this->request->getPost('isbn'),
            'issn' => $this->request->getPost('issn'),
            'doi' => $this->request->getPost('doi'),
            'url' => $this->request->getPost('url'),
            'is_scopus' => $this->request->getPost('is_scopus') ? 1 : 0,
        ]);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Publikasi berhasil diperbarui.']);
    }

    public function deletePublication(int $id)
    {
        $model = new PublicationModel();
        $model->delete($id);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Publikasi berhasil dihapus.']);
    }
}
