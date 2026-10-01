<?php

namespace Modules\Website\Controllers;

use App\Controllers\BaseController;
use Modules\Website\Models\ContactMessageModel;

class ContactController extends BaseController
{
    public function index()
    {
        return view('Modules\Website\Views\contact', [
            'meta_title' => 'Kontak Kami - CV. Bagus Kencana Cakrada',
            'meta_description' => 'Hubungi CV. Bagus Kencana Cakrada untuk informasi pelatihan dan konsultasi SDM.',
            'title' => 'Kontak Kami',
        ]);
    }

    public function send()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[200]',
            'email' => 'required|valid_email',
            'subject' => 'required|min_length[5]',
            'message' => 'required|min_length[20]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => implode(' ', $this->validator->getErrors()),
            ]);
        }

        $model = new ContactMessageModel();
        $model->insert([
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'institution' => $this->request->getPost('institution'),
            'subject' => $this->request->getPost('subject'),
            'message' => $this->request->getPost('message'),
            'ip_address' => $this->request->getIPAddress(),
        ]);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Pesan Anda berhasil dikirim. Tim kami akan menghubungi Anda segera.',
        ]);
    }
}
