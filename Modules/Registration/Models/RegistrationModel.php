<?php

namespace Modules\Registration\Models;

use App\Models\BaseModel;

class RegistrationModel extends BaseModel
{
    protected $table = 'registrations';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'uuid', 'registration_code', 'training_id', 'participant_id', 'status',
        'payment_method', 'payment_proof', 'payment_date', 'amount',
        'special_request', 'certificate_path', 'certificate_issued',
        'notes', 'confirmed_by', 'confirmed_at'
    ];

    public function withDetails(): static
    {
        return $this->select('registrations.*, participants.name as participant_name, participants.email as participant_email, participants.phone as participant_phone, participants.institution as participant_institution, trainings.title as training_title, trainings.start_date, trainings.end_date, training_categories.name as category_name')
                    ->join('participants', 'participants.id = registrations.participant_id', 'left')
                    ->join('trainings', 'trainings.id = registrations.training_id', 'left')
                    ->join('training_categories', 'training_categories.id = trainings.category_id', 'left');
    }

    public function getByTraining(int $trainingId): array
    {
        return $this->withDetails()->where('registrations.training_id', $trainingId)->where('registrations.deleted_at', null)->findAll();
    }

    public function generateCode(): string
    {
        $prefix = 'BKC';
        $year = date('Y');
        $month = date('m');
        $random = strtoupper(substr(md5(uniqid()), 0, 6));
        return "{$prefix}-{$year}{$month}-{$random}";
    }

    public function getStats(): array
    {
        $rows = $this->db->table('registrations')
            ->select('status, COUNT(*) AS cnt')
            ->where('deleted_at', null)
            ->groupBy('status')
            ->get()->getResultArray();

        $map = array_column($rows, 'cnt', 'status');
        return [
            'total'     => (int) array_sum(array_column($rows, 'cnt')),
            'pending'   => (int) ($map['pending']   ?? 0),
            'confirmed' => (int) ($map['confirmed'] ?? 0),
            'paid'      => (int) ($map['paid']      ?? 0),
        ];
    }
}
