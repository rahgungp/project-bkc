<?php

namespace Modules\Training\Models;

use App\Models\BaseModel;

class TrainingScheduleModel extends BaseModel
{
    protected $table = 'training_schedules';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['training_id', 'day_number', 'date', 'start_time', 'end_time', 'topic', 'speaker_id', 'description', 'sort_order'];

    public function getByTraining(int $trainingId): array
    {
        return $this->select('training_schedules.*, speakers.name as speaker_name')
                    ->join('speakers', 'speakers.id = training_schedules.speaker_id', 'left')
                    ->where('training_schedules.training_id', $trainingId)
                    ->orderBy('training_schedules.day_number', 'ASC')
                    ->orderBy('training_schedules.start_time', 'ASC')
                    ->findAll();
    }
}
