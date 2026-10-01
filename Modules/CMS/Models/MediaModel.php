<?php

namespace Modules\CMS\Models;

use App\Models\BaseModel;

class MediaModel extends BaseModel
{
    protected $table = 'media_library';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['folder', 'filename', 'original_name', 'file_path', 'file_url', 'mime_type', 'file_size', 'width', 'height', 'alt', 'uploaded_by'];

    public function getByFolder(string $folder = 'general'): array
    {
        return $this->where('folder', $folder)->orderBy('created_at', 'DESC')->findAll();
    }
}
