<?php

namespace Modules\Training\Controllers;

use App\Controllers\BaseController;
use Modules\Training\Models\TrainingModel;
use Modules\Training\Models\TrainingCategoryModel;
use Modules\Training\Models\TrainingGalleryModel;
use Modules\Training\Models\TrainingSpeakerModel;
use Modules\Training\Models\TrainingScheduleModel;
use Modules\Training\Models\InhouseRequestModel;
use Modules\Testimonial\Models\TestimonialModel;
use Modules\FAQ\Models\FaqModel;
use Modules\Profile\Models\CompanyProfileModel;

class TrainingController extends BaseController
{
    protected TrainingModel $trainingModel;
    protected TrainingCategoryModel $categoryModel;

    public function __construct()
    {
        $this->trainingModel = new TrainingModel();
        $this->categoryModel = new TrainingCategoryModel();
    }

    public function index()
    {
        $page = max(1, (int) ($this->request->getGet('page') ?? 1));
        $perPage = 9;
        $offset = ($page - 1) * $perPage;

        $filters = [
            'category' => $this->request->getGet('category') ?? '',
            'search' => $this->request->getGet('search') ?? '',
            'segment' => $this->request->getGet('segment') ?? '',
        ];

        $trainings = $this->trainingModel->getPublished($perPage, $offset, $filters);
        $totalRows = $this->trainingModel->withAll()
            ->where('trainings.status', 'published')
            ->where('trainings.deleted_at', null);

        if (!empty($filters['category'])) {
            $totalRows->where('training_categories.slug', $filters['category']);
        }
        if (!empty($filters['search'])) {
            $totalRows->groupStart()->like('trainings.title', $filters['search'])->orLike('trainings.short_description', $filters['search'])->groupEnd();
        }

        $total = $totalRows->countAllResults();
        $totalPages = ceil($total / $perPage);

        $categories = $this->categoryModel->getActive();

        return view('Modules\Training\Views\index', [
            'meta_title' => 'Program Pelatihan - CV. Bagus Kencana Cakrada',
            'meta_description' => 'Temukan program pelatihan EMBA terbaik dari CV. Bagus Kencana Cakrada untuk ASN, BUMN, dan instansi swasta.',
            'title' => 'Program Pelatihan',
            'trainings' => $trainings,
            'categories' => $categories,
            'filters' => $filters,
            'total' => $total,
            'page' => $page,
            'totalPages' => $totalPages,
            'perPage' => $perPage,
        ]);
    }

    public function detail(string $slug)
    {
        $training = $this->trainingModel->getBySlug($slug);
        if (!$training) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Pelatihan tidak ditemukan.');
        }

        // Increment views
        $this->trainingModel->incrementViews($training['id']);

        // Get related data
        $galleryModel = new TrainingGalleryModel();
        $speakerModel = new TrainingSpeakerModel();
        $scheduleModel = new TrainingScheduleModel();
        $testimonialModel = new TestimonialModel();
        $faqModel = new FaqModel();

        $gallery = $galleryModel->getByTraining($training['id']);
        $speakers = $speakerModel->getByTraining($training['id']);
        $schedules = $scheduleModel->getByTraining($training['id']);
        $testimonials = $testimonialModel->where('training_id', $training['id'])->where('is_approved', 1)->findAll();
        $faqs = $faqModel->getActive();

        // Related trainings
        $related = $this->trainingModel->withAll()
            ->where('trainings.category_id', $training['category_id'])
            ->where('trainings.id !=', $training['id'])
            ->where('trainings.status', 'published')
            ->where('trainings.deleted_at', null)
            ->findAll(3);

        // Benefits & Materials parse
        $benefits = $training['benefits'] ? (json_decode($training['benefits'], true) ?? explode("\n", $training['benefits'])) : [];
        $materials = $training['materials'] ? (json_decode($training['materials'], true) ?? explode("\n", $training['materials'])) : [];

        return view('Modules\Training\Views\detail', [
            'meta_title' => $training['meta_title'] ?: $training['title'] . ' - CV. Bagus Kencana Cakrada',
            'meta_description' => $training['meta_description'] ?: $training['short_description'],
            'training' => $training,
            'gallery' => $gallery,
            'speakers' => $speakers,
            'schedules' => $schedules,
            'testimonials' => $testimonials,
            'faqs' => $faqs,
            'related' => $related,
            'benefits' => $benefits,
            'materials' => $materials,
        ]);
    }

    public function calendar()
    {
        $profileModel = new CompanyProfileModel();
        $trainings = $this->trainingModel->getForCalendar();

        $events = array_map(function ($t) {
            return [
                'id'              => $t['id'],
                'title'           => $t['title'],
                'start'           => $t['start_date'],
                'end'             => $t['end_date'],
                'url'             => base_url('pelatihan/' . $t['slug']),
                'backgroundColor' => $t['category_color'] ?? '#C8A34D',
                'borderColor'     => $t['category_color'] ?? '#C8A34D',
                'textColor'       => '#fff',
                'extendedProps'   => [
                    'slug'     => $t['slug'],
                    'location' => $t['location_name'] ?? '',
                    'price'    => $t['price'] ?? 0,
                    'quota'    => $t['quota'] ?? 0,
                ],
            ];
        }, $trainings);

        return view('Modules\Training\Views\calendar', [
            'meta_title'        => 'Jadwal Pelatihan - ' . ($profileModel->getSetting('company_name') ?? 'BKC'),
            'title'             => 'Kalender Jadwal Pelatihan',
            'events'            => json_encode($events),
            'upcomingTrainings' => $this->trainingModel->getUpcoming(5),
            'profile'           => $profileModel->getAll(),
        ]);
    }

    public function inhouse()
    {
        return view('Modules\Training\Views\inhouse', [
            'meta_title' => 'Request In-House Training - CV. Bagus Kencana Cakrada',
            'title' => 'Request In-House Training',
        ]);
    }

    public function sendInhouse()
    {
        $rules = [
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'phone' => 'required',
            'institution' => 'required',
            'topic' => 'required|min_length[5]',
            'participants_count' => 'required|integer|greater_than[0]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => implode(' ', $this->validator->getErrors()),
            ]);
        }

        $model = new InhouseRequestModel();
        $model->insert([
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'institution' => $this->request->getPost('institution'),
            'position' => $this->request->getPost('position'),
            'topic' => $this->request->getPost('topic'),
            'preferred_date' => $this->request->getPost('preferred_date') ?: null,
            'participants_count' => (int) $this->request->getPost('participants_count'),
            'location_pref' => $this->request->getPost('location_pref'),
            'budget' => $this->request->getPost('budget'),
            'message' => $this->request->getPost('message'),
        ]);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Permintaan In-House Training Anda berhasil dikirim. Tim kami akan menghubungi Anda dalam 1x24 jam.',
        ]);
    }

    public function downloadBrochure(string $slug)
    {
        $training = $this->trainingModel->where('slug', $slug)->where('deleted_at', null)->first();
        if (!$training || !$training['brochure']) {
            return redirect()->to('/pelatihan/' . $slug)->with('error', 'Brosur tidak tersedia.');
        }

        $path = WRITEPATH . 'uploads/brochures/' . basename($training['brochure']);
        if (!file_exists($path)) {
            return redirect()->to('/pelatihan/' . $slug)->with('error', 'File brosur tidak ditemukan.');
        }

        return $this->response->download($path, null);
    }

    public function certificatePreview(string $slug)
    {
        return view('Modules\Training\Views\certificate_preview', ['slug' => $slug]);
    }

    public function apiList()
    {
        $trainings = $this->trainingModel->getPublished(20);
        return $this->response->setJSON(['data' => $trainings]);
    }
}
