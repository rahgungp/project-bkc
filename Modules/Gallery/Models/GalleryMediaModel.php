<?php

namespace Modules\Gallery\Models;

use App\Models\BaseModel;
use CodeIgniter\Database\BaseBuilder;

class GalleryMediaModel extends BaseModel
{
    protected $table = 'gallery_media';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'album_id', 'type', 'file_path', 'thumbnail',
        'title', 'description', 'file_size', 'mime_type', 'sort_order',
    ];

    public function getByAlbum(int $albumId): array
    {
        return $this->where('album_id', $albumId)
                    ->where('deleted_at', null)
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    public function withAlbum(): BaseBuilder
    {
        return $this->db->table('gallery_media')
            ->select('gallery_media.*, gallery_albums.name AS album_name, gallery_albums.slug AS album_slug')
            ->join('gallery_albums', 'gallery_albums.id = gallery_media.album_id', 'left')
            ->where('gallery_media.deleted_at', null);
    }
}
