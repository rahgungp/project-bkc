<?php

namespace Modules\Profile\Models;

use App\Models\BaseModel;

class PublicationModel extends BaseModel
{
    protected $table = 'publications';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['founder_id', 'title', 'type', 'journal', 'year', 'isbn', 'issn', 'doi', 'url', 'is_scopus', 'publisher', 'abstract', 'sort_order'];

    public function getByFounder(int $founderId): array
    {
        return $this->where('founder_id', $founderId)->orderBy('year', 'DESC')->orderBy('sort_order', 'ASC')->findAll();
    }
}
