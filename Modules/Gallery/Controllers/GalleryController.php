<?php

namespace Modules\Gallery\Controllers;

use App\Controllers\BaseController;
use Modules\Gallery\Models\GalleryAlbumModel;
use Modules\Gallery\Models\GalleryMediaModel;

class GalleryController extends BaseController
{
    protected GalleryAlbumModel $albumModel;
    protected GalleryMediaModel $mediaModel;

    public function __construct()
    {
        $this->albumModel = new GalleryAlbumModel();
        $this->mediaModel = new GalleryMediaModel();
    }

    /**
     * Frontend gallery index — shows all active albums with media count.
     */
    public function index()
    {
        $albums = $this->albumModel->withMediaCount()->get()->getResultArray();

        return view('Modules\Gallery\Views\index', [
            'meta_title'       => 'Galeri | CV. Bagus Kencana Cakrada',
            'meta_description' => 'Kumpulan foto dan video kegiatan pelatihan CV. Bagus Kencana Cakrada.',
            'albums'           => $albums,
        ]);
    }

    /**
     * Frontend album detail — shows a single album and all its media.
     */
    public function album(string $slug)
    {
        $album = $this->albumModel->getBySlug($slug);

        if (!$album) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $media = $this->mediaModel->getByAlbum((int) $album['id']);

        return view('Modules\Gallery\Views\album', [
            'meta_title'       => esc($album['name']) . ' | Galeri BKC',
            'meta_description' => esc($album['description'] ?? 'Album galeri kegiatan BKC.'),
            'album'            => $album,
            'media'            => $media,
        ]);
    }
}
