<?php

namespace Modules\Admin\Controllers;

use App\Controllers\BaseController;
use Modules\Training\Models\TrainingModel;
use Modules\News\Models\NewsModel;
use Modules\Registration\Models\RegistrationModel;
use Modules\Testimonial\Models\TestimonialModel;
use App\Models\AuditLogModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $trainingModel = new TrainingModel();
        $newsModel = new NewsModel();
        $registrationModel = new RegistrationModel();
        $testimonialModel = new TestimonialModel();
        $auditLogModel = new AuditLogModel();

        // Stats
        $stats = [
            'total_trainings' => $trainingModel->where('deleted_at', null)->countAllResults(),
            'published_trainings' => $trainingModel->where('status', 'published')->where('deleted_at', null)->countAllResults(),
            'upcoming_trainings' => $trainingModel->where('status', 'published')->where('start_date >=', date('Y-m-d'))->where('deleted_at', null)->countAllResults(),
            'total_news' => $newsModel->where('deleted_at', null)->countAllResults(),
            'total_registrations' => $registrationModel->where('deleted_at', null)->countAllResults(),
            'pending_registrations' => $registrationModel->where('status', 'pending')->where('deleted_at', null)->countAllResults(),
            'paid_registrations' => $registrationModel->where('status', 'paid')->where('deleted_at', null)->countAllResults(),
            'total_testimonials' => $testimonialModel->where('deleted_at', null)->countAllResults(),
            'pending_testimonials' => $testimonialModel->where('is_approved', 0)->where('deleted_at', null)->countAllResults(),
        ];

        // Recent registrations
        $recentRegistrations = $registrationModel->withDetails()
            ->where('registrations.deleted_at', null)
            ->orderBy('registrations.created_at', 'DESC')
            ->findAll(10);

        // Recent activity log
        $recentActivity = $auditLogModel->withUser()
            ->orderBy('audit_logs.created_at', 'DESC')
            ->findAll(15);

        // Chart data - registrations last 7 days
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $chartLabels[] = date('d/m', strtotime($date));
            $count = $registrationModel->where('DATE(created_at)', $date)->where('deleted_at', null)->countAllResults();
            $chartData[] = $count;
        }

        // Upcoming trainings
        $upcomingTrainings = $trainingModel->getUpcoming(5);

        return view('Modules\Admin\Views\dashboard', [
            'title' => 'Dashboard',
            'stats' => $stats,
            'recentRegistrations' => $recentRegistrations,
            'recentActivity' => $recentActivity,
            'chartLabels' => json_encode($chartLabels),
            'chartData' => json_encode($chartData),
            'upcomingTrainings' => $upcomingTrainings,
        ]);
    }

    public function profile()
    {
        return view('Modules\Admin\Views\profile', ['title' => 'Profil Saya']);
    }

    public function updateProfile()
    {
        // Update profile logic
        return redirect()->to('/admin/profil')->with('success', 'Profil berhasil diperbarui.');
    }
}
