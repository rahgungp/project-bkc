<?php

namespace Modules\Training\Models;

use App\Models\BaseModel;

class TrainingSpeakerModel extends BaseModel
{
    protected $table = 'training_speakers';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;
    protected $allowedFields = ['training_id', 'speaker_id', 'role', 'sort_order'];

    public function getByTraining(int $trainingId): array
    {
        return $this->select('training_speakers.*, speakers.name, speakers.title, speakers.speciality, speakers.photo, speakers.bio')
                    ->join('speakers', 'speakers.id = training_speakers.speaker_id')
                    ->where('training_speakers.training_id', $trainingId)
                    ->orderBy('training_speakers.sort_order', 'ASC')
                    ->findAll();
    }
}
