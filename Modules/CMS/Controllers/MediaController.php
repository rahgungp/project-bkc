<?php

namespace Modules\CMS\Controllers;

use App\Controllers\BaseController;
use Modules\CMS\Models\MediaModel;

class MediaController extends BaseController
{
    protected MediaModel $mediaModel;

    public function __construct()
    {
        $this->mediaModel = new MediaModel();
        helper(['url', 'form', 'filesystem']);
    }

    public function index(): string
    {
        $folder = $this->request->getGet('folder') ?? 'general';
        $mediaFiles = $this->mediaModel->getByFolder($folder);

        $folders = ['general', 'training', 'news', 'gallery', 'profile', 'other'];

        return view('Modules\CMS\Views\admin\media', [
            'title'      => 'Media Manager',
            'mediaFiles' => $mediaFiles,
            'folder'     => $folder,
            'folders'    => $folders,
        ]);
    }

    public function upload()
    {
        $validFolders = ['general', 'training', 'news', 'gallery', 'profile', 'other'];
        $folder = $this->request->getPost('folder') ?? 'general';
        if (!in_array($folder, $validFolders, true)) {
            $folder = 'general';
        }
        $file = $this->request->getFile('file');

        if (!$file || !$file->isValid()) {
            return $this->response->setJSON(['success' => false, 'message' => 'File tidak valid.']);
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'application/pdf'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Tipe file tidak diizinkan.']);
        }

        if ($file->getSize() > 10 * 1024 * 1024) {
            return $this->response->setJSON(['success' => false, 'message' => 'Ukuran file maksimal 10MB.']);
        }

        $uploadPath = FCPATH . 'uploads/media/' . $folder . '/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $newName = $file->getRandomName();
        $file->move($uploadPath, $newName);

        $filePath = 'uploads/media/' . $folder . '/' . $newName;
        $fileUrl  = base_url($filePath);

        $width  = null;
        $height = null;
        if (strpos($file->getMimeType(), 'image/') === 0) {
            [$width, $height] = getimagesize(FCPATH . $filePath);
        }

        $id = $this->mediaModel->insert([
            'folder'        => $folder,
            'filename'      => $newName,
            'original_name' => strip_tags(basename($file->getClientName())),
            'file_path'     => $filePath,
            'file_url'      => $fileUrl,
            'mime_type'     => $file->getMimeType(),
            'file_size'     => $file->getSize(),
            'width'         => $width,
            'height'        => $height,
            'uploaded_by'   => session()->get('admin_id'),
        ]);

        return $this->response->setJSON([
            'success'  => true,
            'message'  => 'File berhasil diupload.',
            'media'    => [
                'id'       => $id,
                'url'      => $fileUrl,
                'filename' => $newName,
                'type'     => $file->getMimeType(),
            ],
        ]);
    }

    public function delete(int $id)
    {
        $media = $this->mediaModel->find($id);
        if (!$media) {
            return $this->response->setJSON(['success' => false, 'message' => 'File tidak ditemukan.']);
        }

        $fullPath = FCPATH . $media['file_path'];
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        $this->mediaModel->delete($id);

        return $this->response->setJSON(['success' => true, 'message' => 'File berhasil dihapus.']);
    }
}
