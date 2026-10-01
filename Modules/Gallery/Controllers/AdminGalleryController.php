<?php

namespace Modules\Gallery\Controllers;

use App\Controllers\BaseController;
use Modules\Gallery\Models\GalleryAlbumModel;
use Modules\Gallery\Models\GalleryMediaModel;

class AdminGalleryController extends BaseController
{
    protected GalleryAlbumModel $albumModel;
    protected GalleryMediaModel $mediaModel;

    protected string $uploadPath   = ROOTPATH . 'public/uploads/gallery/';
    protected string $uploadUrl    = 'uploads/gallery/';

    public function __construct()
    {
        $this->albumModel = new GalleryAlbumModel();
        $this->mediaModel = new GalleryMediaModel();
    }

    // ─── Album CRUD ────────────────────────────────────────────────────────────

    /**
     * List all gallery albums (alias index).
     */
    public function index()
    {
        return $this->albums();
    }

    /**
     * DataTables list of all albums.
     */
    public function albums()
    {
        $albums = $this->albumModel->withMediaCount()->get()->getResultArray();

        return view('Modules\Gallery\Views\admin\albums', [
            'title'       => 'Manajemen Galeri',
            'albums'      => $albums,
            'breadcrumbs' => [['title' => 'Galeri']],
        ]);
    }

    /**
     * Show create-album form.
     */
    public function createAlbum()
    {
        return view('Modules\Gallery\Views\admin\album_form', [
            'title'       => 'Tambah Album',
            'album'       => null,
            'breadcrumbs' => [
                ['title' => 'Galeri', 'url' => base_url('admin/galeri')],
                ['title' => 'Tambah Album'],
            ],
        ]);
    }

    /**
     * Store a new album.
     */
    public function storeAlbum()
    {
        $rules = [
            'name'       => 'required|min_length[3]|max_length[200]',
            'sort_order' => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $name  = $this->request->getPost('name');
        $slug  = $this->albumModel->generateSlug($name);
        $cover = $this->_uploadImage('cover_image', 'cover_');

        $this->albumModel->insert([
            'name'        => $name,
            'slug'        => $slug,
            'description' => $this->request->getPost('description'),
            'cover_image' => $cover,
            'is_active'   => $this->request->getPost('is_active') ? 1 : 0,
            'sort_order'  => (int) ($this->request->getPost('sort_order') ?: 0),
        ]);

        return redirect()->to('/admin/galeri')->with('success', 'Album berhasil ditambahkan.');
    }

    /**
     * Show edit-album form.
     */
    public function editAlbum(int $id)
    {
        $album = $this->albumModel->find($id);
        if (!$album) {
            return redirect()->to('/admin/galeri')->with('error', 'Album tidak ditemukan.');
        }

        return view('Modules\Gallery\Views\admin\album_form', [
            'title'       => 'Edit Album',
            'album'       => $album,
            'breadcrumbs' => [
                ['title' => 'Galeri', 'url' => base_url('admin/galeri')],
                ['title' => 'Edit Album'],
            ],
        ]);
    }

    /**
     * Update an album.
     */
    public function updateAlbum(int $id)
    {
        $album = $this->albumModel->find($id);
        if (!$album) {
            return redirect()->to('/admin/galeri')->with('error', 'Album tidak ditemukan.');
        }

        $rules = [
            'name'       => 'required|min_length[3]|max_length[200]',
            'sort_order' => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $name  = $this->request->getPost('name');
        $slug  = $this->albumModel->generateSlug($name, $id);
        $cover = $album['cover_image'] ?? $album['cover'] ?? null;

        $newCover = $this->_uploadImage('cover_image', 'cover_');
        if ($newCover) {
            // Delete old cover
            if ($cover && file_exists($this->uploadPath . $cover)) {
                @unlink($this->uploadPath . $cover);
            }
            $cover = $newCover;
        }

        $this->albumModel->update($id, [
            'name'        => $name,
            'slug'        => $slug,
            'description' => $this->request->getPost('description'),
            'cover_image' => $cover,
            'is_active'   => $this->request->getPost('is_active') ? 1 : 0,
            'sort_order'  => (int) ($this->request->getPost('sort_order') ?: 0),
        ]);

        return redirect()->to('/admin/galeri')->with('success', 'Album berhasil diperbarui.');
    }

    /**
     * Soft-delete an album — returns JSON.
     */
    public function deleteAlbum(int $id)
    {
        $album = $this->albumModel->find($id);
        if (!$album) {
            return $this->response->setJSON(['success' => false, 'message' => 'Album tidak ditemukan.']);
        }

        $this->albumModel->delete($id); // soft delete via BaseModel

        return $this->response->setJSON(['success' => true, 'message' => 'Album berhasil dihapus.']);
    }

    /**
     * AJAX: Toggle is_active for an album.
     */
    public function toggleAlbumActive()
    {
        $id       = (int) $this->request->getPost('id');
        $isActive = (int) $this->request->getPost('is_active');

        if (!$id) {
            return $this->response->setJSON(['success' => false, 'message' => 'ID tidak valid.']);
        }

        if (!$this->albumModel->find($id)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Album tidak ditemukan.']);
        }

        $this->albumModel->update($id, ['is_active' => $isActive]);

        return $this->response->setJSON(['success' => true]);
    }

    /**
     * AJAX: Update sort_order for an album.
     */
    public function sortAlbum()
    {
        $id        = (int) $this->request->getPost('id');
        $sortOrder = (int) $this->request->getPost('sort_order');

        if (!$id) {
            return $this->response->setJSON(['success' => false, 'message' => 'ID tidak valid.']);
        }

        if (!$this->albumModel->find($id)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Album tidak ditemukan.']);
        }

        $this->albumModel->update($id, ['sort_order' => $sortOrder]);

        return $this->response->setJSON(['success' => true]);
    }

    // ─── Media CRUD ────────────────────────────────────────────────────────────

    /**
     * Show media manager for a given album.
     */
    public function media(int $albumId)
    {
        $album = $this->albumModel->find($albumId);
        if (!$album) {
            return redirect()->to('/admin/galeri')->with('error', 'Album tidak ditemukan.');
        }

        $mediaItems = $this->mediaModel->getByAlbum($albumId);

        return view('Modules\Gallery\Views\admin\media', [
            'title'       => 'Media Album: ' . esc($album['name']),
            'album'       => $album,
            'media'       => $mediaItems,
            'breadcrumbs' => [
                ['title' => 'Galeri', 'url' => base_url('admin/galeri')],
                ['title' => esc($album['name']), 'url' => base_url('admin/galeri/album/' . $albumId . '/media')],
                ['title' => 'Media'],
            ],
        ]);
    }

    /**
     * AJAX: Upload a media file (image or video) to an album.
     * POST /admin/galeri/album/{albumId}/upload
     *
     * Returns JSON { success, message, media: { id, file_path, thumbnail_path, title } }
     */
    public function uploadMedia(int $albumId)
    {
        $album = $this->albumModel->find($albumId);
        if (!$album) {
            return $this->response->setJSON(['success' => false, 'message' => 'Album tidak ditemukan.']);
        }

        $file = $this->request->getFile('file');

        if (!$file || !$file->isValid()) {
            return $this->response->setJSON(['success' => false, 'message' => 'File tidak valid.']);
        }

        // Validate size (10 MB)
        if ($file->getSize() > 10 * 1024 * 1024) {
            return $this->response->setJSON(['success' => false, 'message' => 'Ukuran file maksimal 10 MB.']);
        }

        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'video/mp4'];
        $mime = $file->getMimeType();

        if (!in_array($mime, $allowedMimes)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Tipe file tidak diizinkan. Gunakan jpg, png, gif, webp, atau mp4.']);
        }

        $isVideo     = str_starts_with($mime, 'video/');
        $newName     = uniqid('media_', true) . '.' . $file->getExtension();
        $file->move($this->uploadPath, $newName);

        $filePath      = $newName;
        $thumbnailPath = null;

        // For videos, look for an optional thumbnail upload
        if ($isVideo) {
            $thumb = $this->request->getFile('thumbnail');
            if ($thumb && $thumb->isValid() && !$thumb->hasMoved()) {
                $thumbMime  = $thumb->getMimeType();
                $thumbAllowed = ['image/jpeg', 'image/png', 'image/webp'];
                if (in_array($thumbMime, $thumbAllowed)) {
                    $thumbName     = uniqid('thumb_', true) . '.' . $thumb->getExtension();
                    $thumb->move($this->uploadPath, $thumbName);
                    $thumbnailPath = $thumbName;
                }
            }
        }

        $title = $this->request->getPost('title') ?? '';

        $insertId = $this->mediaModel->insert([
            'album_id'       => $albumId,
            'type'           => $isVideo ? 'video' : 'image',
            'file_path'      => $filePath,
            'thumbnail_path' => $thumbnailPath,
            'thumbnail'      => $thumbnailPath,
            'title'          => $title,
            'description'    => $this->request->getPost('description') ?? '',
            'sort_order'     => 0,
        ]);

        return $this->response->setJSON([
            'success'   => true,
            'message'   => 'Media berhasil diunggah.',
            'csrf_hash' => csrf_hash(),
            'media'     => [
                'id'             => $insertId,
                'file_path'      => $filePath,
                'thumbnail_path' => $thumbnailPath,
                'title'          => $title,
            ],
        ]);
    }

    /**
     * AJAX: Soft-delete a media item.
     */
    public function deleteMedia(int $id)
    {
        $media = $this->mediaModel->find($id);
        if (!$media) {
            return $this->response->setJSON(['success' => false, 'message' => 'Media tidak ditemukan.']);
        }

        $this->mediaModel->delete($id);

        return $this->response->setJSON(['success' => true, 'message' => 'Media berhasil dihapus.']);
    }

    // ─── Helpers ───────────────────────────────────────────────────────────────

    /**
     * Upload an image field and return the stored filename, or null.
     */
    protected function _uploadImage(string $field, string $prefix = 'img_'): ?string
    {
        $file = $this->request->getFile($field);

        if (!$file || !$file->isValid() || $file->hasMoved()) {
            return null;
        }

        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            return null;
        }

        if ($file->getSize() > 10 * 1024 * 1024) {
            return null;
        }

        $newName = uniqid($prefix, true) . '.' . $file->getExtension();
        $file->move($this->uploadPath, $newName);

        return $newName;
    }
}
