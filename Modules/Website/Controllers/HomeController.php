<?php

namespace Modules\Website\Controllers;

use App\Controllers\BaseController;
use App\Libraries\VisitTracker;
use Modules\Training\Models\TrainingModel;
use Modules\Training\Models\TrainingCategoryModel;
use Modules\News\Models\NewsModel;
use Modules\Testimonial\Models\TestimonialModel;
use Modules\FAQ\Models\FaqModel;
use Modules\Gallery\Models\GalleryAlbumModel;
use Modules\Profile\Models\CompanyProfileModel;
use Modules\Profile\Models\FounderProfileModel;
use Modules\CMS\Models\BannerModel;

class HomeController extends BaseController
{
    public function index()
    {
        $trainingModel = new TrainingModel();
        $categoryModel = new TrainingCategoryModel();
        $newsModel = new NewsModel();
        $testimonialModel = new TestimonialModel();
        $faqModel = new FaqModel();
        $profileModel = new CompanyProfileModel();
        $founderModel = new FounderProfileModel();
        $bannerModel = new BannerModel();

        $tracker = new VisitTracker();
        $tracker->track('/');
        $totalVisitors = $tracker->totalUnique();
        $todayVisitors = $tracker->todayUnique();

        $featuredTrainings = $trainingModel->getFeatured(6);
        $upcomingTrainings = $trainingModel->getUpcoming(1);
        $categories = $categoryModel->getActive();
        $latestNews = $newsModel->getLatest(3);
        $testimonials = $testimonialModel->getFeatured(6);
        $faqs = $faqModel->getActive();
        $founder = $founderModel->getMain();
        $profile = $profileModel->getAll();

        $meta = [
            'meta_title' => $profile['meta_title'] ?? 'CV. Bagus Kencana Cakrada - Building Knowledge & Capacity',
            'meta_description' => $profile['meta_description'] ?? 'EMBA.',
            'navbar_dark' => true,
        ];

        return view('Modules\Website\Views\home', array_merge($meta, [
            'featuredTrainings' => $featuredTrainings,
            'upcomingTrainings' => $upcomingTrainings,
            'categories' => $categories,
            'latestNews' => $latestNews,
            'testimonials' => $testimonials,
            'faqs' => $faqs,
            'founder'        => $founder,
            'profile'        => $profile,
            'totalVisitors'  => $totalVisitors,
            'todayVisitors'  => $todayVisitors,
        ]));
    }
}
