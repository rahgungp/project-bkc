<?php

namespace Modules\Training\Models;

use App\Models\BaseModel;

class TrainingGalleryModel extends BaseModel
{
    protected $table = 'training_gallery';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['training_id', 'image', 'caption', 'sort_order'];

    public function getByTraining(int $trainingId): array
    {
        return $this->where('training_id', $trainingId)->orderBy('sort_order', 'ASC')->findAll();
    }
}
