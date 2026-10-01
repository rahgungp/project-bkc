<?php

namespace Modules\Gallery\Models;

use App\Models\BaseModel;
use CodeIgniter\Database\BaseBuilder;

class GalleryAlbumModel extends BaseModel
{
    protected $table = 'gallery_albums';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'slug', 'description', 'cover',
        'type', 'category', 'event_date', 'sort_order', 'is_active',
    ];

    public function getActive(): array
    {
        return $this->where('is_active', 1)
                    ->where('deleted_at', null)
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    public function withMediaCount(): BaseBuilder
    {
        return $this->db->table('gallery_albums')
            ->select('gallery_albums.*, COUNT(gallery_media.id) AS media_count')
            ->join('gallery_media', 'gallery_media.album_id = gallery_albums.id AND gallery_media.deleted_at IS NULL', 'left')
            ->where('gallery_albums.deleted_at', null)
            ->groupBy('gallery_albums.id')
            ->orderBy('gallery_albums.sort_order', 'ASC');
    }

    public function getBySlug(string $slug): ?array
    {
        return $this->where('slug', $slug)->where('deleted_at', null)->first();
    }
}
