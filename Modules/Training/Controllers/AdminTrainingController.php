<?php

namespace Modules\Training\Controllers;

use App\Controllers\BaseController;
use Modules\Training\Models\TrainingModel;
use Modules\Training\Models\TrainingCategoryModel;
use Modules\Training\Models\TrainingGalleryModel;
use Modules\Training\Models\TrainingSpeakerModel;
use Modules\Training\Models\TrainingScheduleModel;
use Modules\CMS\Models\LocationModel;
use Modules\CMS\Models\SpeakerModel;

class AdminTrainingController extends BaseController
{
    protected TrainingModel $model;

    public function __construct()
    {
        $this->model = new TrainingModel();
    }

    public function index()
    {
        $trainings = $this->model->withAll()
            ->where('trainings.deleted_at', null)
            ->orderBy('trainings.created_at', 'DESC')
            ->findAll();

        return view('Modules\Training\Views\admin\index', [
            'title' => 'Manajemen Pelatihan',
            'trainings' => $trainings,
            'breadcrumbs' => [['title' => 'Pelatihan']],
        ]);
    }

    public function create()
    {
        $categoryModel = new TrainingCategoryModel();
        $locationModel = new LocationModel();
        $speakerModel = new SpeakerModel();

        return view('Modules\Training\Views\admin\form', [
            'title' => 'Tambah Pelatihan',
            'breadcrumbs' => [['title' => 'Pelatihan', 'url' => base_url('admin/pelatihan')], ['title' => 'Tambah']],
            'categories' => $categoryModel->getActive(),
            'locations' => $locationModel->getActive(),
            'speakers' => $speakerModel->getActive(),
            'training' => null,
        ]);
    }

    public function store()
    {
        $rules = [
            'title' => 'required|min_length[5]|max_length[300]',
            'category_id' => 'required|integer',
            'status' => 'required|in_list[draft,published,upcoming,ongoing,completed,cancelled]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }

        $slug = $this->model->generateSlug($this->request->getPost('title'));
        $uuid = $this->model->generateUuid();

        // Handle cover image
        $cover = null;
        $coverFile = $this->request->getFile('cover');
        if ($coverFile && $coverFile->isValid() && !$coverFile->hasMoved()) {
            $newName = $coverFile->getRandomName();
            $coverFile->move(ROOTPATH . 'public/assets/uploads/training/', $newName);
            $cover = $newName;
        }

        // Handle brochure
        $brochure = null;
        $brochureFile = $this->request->getFile('brochure');
        if ($brochureFile && $brochureFile->isValid() && !$brochureFile->hasMoved()) {
            $newName = $brochureFile->getRandomName();
            $brochureFile->move(WRITEPATH . 'uploads/brochures/', $newName);
            $brochure = $newName;
        }

        $benefits = $this->request->getPost('benefits');
        $materials = $this->request->getPost('materials');

        $id = $this->model->insert([
            'uuid' => $uuid,
            'title' => $this->request->getPost('title'),
            'slug' => $slug,
            'category_id' => $this->request->getPost('category_id'),
            'location_id' => $this->request->getPost('location_id') ?: null,
            'cover' => $cover,
            'brochure' => $brochure,
            'short_description' => $this->request->getPost('short_description'),
            'description' => $this->request->getPost('description'),
            'benefits' => is_array($benefits) ? json_encode($benefits) : $benefits,
            'materials' => is_array($materials) ? json_encode($materials) : $materials,
            'target_segment' => $this->request->getPost('target_segment'),
            'duration_days' => (int) ($this->request->getPost('duration_days') ?: 1),
            'duration_hours' => (int) ($this->request->getPost('duration_hours') ?: 8),
            'price' => (float) ($this->request->getPost('price') ?: 0),
            'price_info' => $this->request->getPost('price_info'),
            'max_participants' => (int) ($this->request->getPost('max_participants') ?: 30),
            'start_date' => $this->request->getPost('start_date') ?: null,
            'end_date' => $this->request->getPost('end_date') ?: null,
            'registration_deadline' => $this->request->getPost('registration_deadline') ?: null,
            'status' => $this->request->getPost('status'),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'is_online' => $this->request->getPost('is_online') ? 1 : 0,
            'online_link' => $this->request->getPost('online_link'),
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
            'meta_keywords' => $this->request->getPost('meta_keywords'),
            'sort_order' => (int) ($this->request->getPost('sort_order') ?: 0),
            'created_by' => session()->get('admin_id'),
        ]);

        // Handle speakers
        $speakerIds = $this->request->getPost('speaker_ids') ?? [];
        if (!empty($speakerIds)) {
            $speakerModel = new TrainingSpeakerModel();
            foreach ($speakerIds as $idx => $speakerId) {
                $speakerModel->insert(['training_id' => $id, 'speaker_id' => $speakerId, 'sort_order' => $idx]);
            }
        }

        return redirect()->to('/admin/pelatihan')->with('success', 'Pelatihan berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $training = $this->model->find($id);
        if (!$training) {
            return redirect()->to('/admin/pelatihan')->with('error', 'Pelatihan tidak ditemukan.');
        }

        $categoryModel = new TrainingCategoryModel();
        $locationModel = new LocationModel();
        $speakerModel = new SpeakerModel();
        $trainingSpeakerModel = new TrainingSpeakerModel();

        return view('Modules\Training\Views\admin\form', [
            'title' => 'Edit Pelatihan',
            'breadcrumbs' => [['title' => 'Pelatihan', 'url' => base_url('admin/pelatihan')], ['title' => 'Edit']],
            'categories' => $categoryModel->getActive(),
            'locations' => $locationModel->getActive(),
            'speakers' => $speakerModel->getActive(),
            'assignedSpeakers' => array_column($trainingSpeakerModel->getByTraining($id), 'speaker_id'),
            'training' => $training,
        ]);
    }

    public function update(int $id)
    {
        $training = $this->model->find($id);
        if (!$training) {
            return redirect()->to('/admin/pelatihan')->with('error', 'Pelatihan tidak ditemukan.');
        }

        $title = $this->request->getPost('title');
        $slug = $title !== $training['title'] ? $this->model->generateSlug($title, $id) : $training['slug'];

        $data = [
            'title' => $title,
            'slug' => $slug,
            'category_id' => $this->request->getPost('category_id'),
            'location_id' => $this->request->getPost('location_id') ?: null,
            'short_description' => $this->request->getPost('short_description'),
            'description' => $this->request->getPost('description'),
            'benefits' => $this->request->getPost('benefits'),
            'materials' => $this->request->getPost('materials'),
            'target_segment' => $this->request->getPost('target_segment'),
            'duration_days' => (int) ($this->request->getPost('duration_days') ?: 1),
            'duration_hours' => (int) ($this->request->getPost('duration_hours') ?: 8),
            'price' => (float) ($this->request->getPost('price') ?: 0),
            'price_info' => $this->request->getPost('price_info'),
            'max_participants' => (int) ($this->request->getPost('max_participants') ?: 30),
            'start_date' => $this->request->getPost('start_date') ?: null,
            'end_date' => $this->request->getPost('end_date') ?: null,
            'registration_deadline' => $this->request->getPost('registration_deadline') ?: null,
            'status' => $this->request->getPost('status'),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'is_online' => $this->request->getPost('is_online') ? 1 : 0,
            'online_link' => $this->request->getPost('online_link'),
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
            'meta_keywords' => $this->request->getPost('meta_keywords'),
            'sort_order' => (int) ($this->request->getPost('sort_order') ?: 0),
            'updated_by' => session()->get('admin_id'),
        ];

        // Handle cover image
        $coverFile = $this->request->getFile('cover');
        if ($coverFile && $coverFile->isValid() && !$coverFile->hasMoved()) {
            if ($training['cover'] && file_exists(ROOTPATH . 'public/assets/uploads/training/' . $training['cover'])) {
                unlink(ROOTPATH . 'public/assets/uploads/training/' . $training['cover']);
            }
            $newName = $coverFile->getRandomName();
            $coverFile->move(ROOTPATH . 'public/assets/uploads/training/', $newName);
            $data['cover'] = $newName;
        }

        $this->model->update($id, $data);

        // Sync speakers: delete existing then re-insert submitted ones
        $trainingSpeakerModel = new TrainingSpeakerModel();
        $trainingSpeakerModel->where('training_id', $id)->delete();
        $speakerIds = $this->request->getPost('speaker_ids') ?? [];
        foreach ($speakerIds as $idx => $speakerId) {
            if ((int) $speakerId > 0) {
                $trainingSpeakerModel->insert([
                    'training_id' => $id,
                    'speaker_id'  => (int) $speakerId,
                    'sort_order'  => $idx,
                ]);
            }
        }

        return redirect()->to('/admin/pelatihan')->with('success', 'Pelatihan berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $training = $this->model->find($id);
        if (!$training) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan.']);
        }

        $this->model->delete($id);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Pelatihan berhasil dihapus.']);
    }

    public function detail(int $id)
    {
        $training = $this->model->withAll()->where('trainings.id', $id)->first();
        if (!$training) {
            return redirect()->to('/admin/pelatihan')->with('error', 'Pelatihan tidak ditemukan.');
        }

        $trainingSpeakerModel = new TrainingSpeakerModel();
        $speakers = $trainingSpeakerModel->getByTraining($id);

        return view('Modules\Training\Views\admin\detail', [
            'title'       => 'Detail Pelatihan',
            'training'    => $training,
            'speakers'    => $speakers,
            'breadcrumbs' => [
                ['title' => 'Pelatihan', 'url' => base_url('admin/pelatihan')],
                ['title' => esc($training['title'])],
            ],
        ]);
    }
}
