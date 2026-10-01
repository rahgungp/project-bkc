<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ===== WEBSITE FRONTEND ROUTES =====
$routes->get('/', '\Modules\Website\Controllers\HomeController::index');
$routes->get('tentang', '\Modules\Profile\Controllers\ProfileController::about');

// Training
$routes->get('pelatihan', '\Modules\Training\Controllers\TrainingController::index');
$routes->get('pelatihan/(:segment)/brosur', '\Modules\Training\Controllers\TrainingController::downloadBrochure/$1');
$routes->get('pelatihan/(:segment)/sertifikat-preview', '\Modules\Training\Controllers\TrainingController::certificatePreview/$1');
$routes->get('pelatihan/(:segment)', '\Modules\Training\Controllers\TrainingController::detail/$1');
$routes->get('jadwal-pelatihan', '\Modules\Training\Controllers\TrainingController::calendar');
$routes->get('request-inhouse', '\Modules\Training\Controllers\TrainingController::inhouse');
$routes->post('request-inhouse/kirim', '\Modules\Training\Controllers\TrainingController::sendInhouse');

// Registration
$routes->get('daftar', '\Modules\Registration\Controllers\RegistrationController::form');
$routes->get('daftar/(:num)', '\Modules\Registration\Controllers\RegistrationController::form/$1');
$routes->post('daftar', '\Modules\Registration\Controllers\RegistrationController::store');

// News
$routes->get('berita', '\Modules\News\Controllers\NewsController::index');
$routes->get('berita/(:segment)', '\Modules\News\Controllers\NewsController::detail/$1');

// Gallery
$routes->get('galeri', '\Modules\Gallery\Controllers\GalleryController::index');
$routes->get('galeri/(:segment)', '\Modules\Gallery\Controllers\GalleryController::album/$1');

// Other pages
$routes->get('testimoni', '\Modules\Testimonial\Controllers\TestimonialController::index');
$routes->get('faq', '\Modules\FAQ\Controllers\FaqController::index');
$routes->get('kontak', '\Modules\Website\Controllers\ContactController::index');
$routes->post('kontak/kirim', '\Modules\Website\Controllers\ContactController::send');
$routes->get('profil-pendiri', '\Modules\Profile\Controllers\ProfileController::founder');
$routes->get('publikasi', '\Modules\Profile\Controllers\ProfileController::publications');
$routes->get('sitemap.xml', '\Modules\Website\Controllers\SeoController::sitemap');
$routes->get('robots.txt', '\Modules\Website\Controllers\SeoController::robots');

// Public certificate download (no auth)
$routes->get('sertifikat/(:segment)', '\Modules\Registration\Controllers\AdminCertificateController::downloadPublic/$1');

// Live Search & API
$routes->get('api/search', '\Modules\Website\Controllers\SearchController::index');
$routes->get('api/pelatihan', '\Modules\Training\Controllers\TrainingController::apiList');

// ===== AUTH ROUTES =====
$routes->get('admin/login', '\Modules\Auth\Controllers\AuthController::login');
$routes->post('admin/login/proses', '\Modules\Auth\Controllers\AuthController::processLogin');
$routes->get('admin/logout', '\Modules\Auth\Controllers\AuthController::logout');

// ===== ADMIN ROUTES (Protected) =====
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    // Dashboard
    $routes->get('/', '\Modules\Admin\Controllers\DashboardController::index');
    $routes->get('dashboard', '\Modules\Admin\Controllers\DashboardController::index');
    $routes->get('profil', '\Modules\Admin\Controllers\DashboardController::profile');
    $routes->post('profil/update', '\Modules\Admin\Controllers\DashboardController::updateProfile');

    // Training Module
    $routes->get('pelatihan', '\Modules\Training\Controllers\AdminTrainingController::index');
    $routes->get('pelatihan/tambah', '\Modules\Training\Controllers\AdminTrainingController::create');
    $routes->post('pelatihan/simpan', '\Modules\Training\Controllers\AdminTrainingController::store');
    $routes->get('pelatihan/edit/(:num)', '\Modules\Training\Controllers\AdminTrainingController::edit/$1');
    $routes->post('pelatihan/update/(:num)', '\Modules\Training\Controllers\AdminTrainingController::update/$1');
    $routes->delete('pelatihan/hapus/(:num)', '\Modules\Training\Controllers\AdminTrainingController::delete/$1');
    $routes->get('pelatihan/detail/(:num)', '\Modules\Training\Controllers\AdminTrainingController::detail/$1');

    // Kategori Pelatihan
    $routes->get('kategori-pelatihan', '\Modules\Training\Controllers\AdminCategoryController::index');
    $routes->post('kategori-pelatihan/simpan', '\Modules\Training\Controllers\AdminCategoryController::store');
    $routes->post('kategori-pelatihan/update/(:num)', '\Modules\Training\Controllers\AdminCategoryController::update/$1');
    $routes->delete('kategori-pelatihan/hapus/(:num)', '\Modules\Training\Controllers\AdminCategoryController::delete/$1');

    // News Module
    $routes->get('berita', '\Modules\News\Controllers\AdminNewsController::index');
    $routes->get('berita/tambah', '\Modules\News\Controllers\AdminNewsController::create');
    $routes->post('berita/simpan', '\Modules\News\Controllers\AdminNewsController::store');
    $routes->get('berita/edit/(:num)', '\Modules\News\Controllers\AdminNewsController::edit/$1');
    $routes->post('berita/update/(:num)', '\Modules\News\Controllers\AdminNewsController::update/$1');
    $routes->delete('berita/hapus/(:num)', '\Modules\News\Controllers\AdminNewsController::delete/$1');

    // Gallery Module
    $routes->get('galeri', '\Modules\Gallery\Controllers\AdminGalleryController::albums');
    $routes->get('galeri/tambah', '\Modules\Gallery\Controllers\AdminGalleryController::createAlbum');
    $routes->post('galeri/album/simpan', '\Modules\Gallery\Controllers\AdminGalleryController::storeAlbum');
    $routes->get('galeri/album/edit/(:num)', '\Modules\Gallery\Controllers\AdminGalleryController::editAlbum/$1');
    $routes->post('galeri/album/update/(:num)', '\Modules\Gallery\Controllers\AdminGalleryController::updateAlbum/$1');
    $routes->delete('galeri/album/hapus/(:num)', '\Modules\Gallery\Controllers\AdminGalleryController::deleteAlbum/$1');
    $routes->post('galeri/album/toggle', '\Modules\Gallery\Controllers\AdminGalleryController::toggleAlbumActive');
    $routes->post('galeri/album/sort', '\Modules\Gallery\Controllers\AdminGalleryController::sortAlbum');
    $routes->get('galeri/album/(:num)/media', '\Modules\Gallery\Controllers\AdminGalleryController::media/$1');
    $routes->post('galeri/album/(:num)/upload', '\Modules\Gallery\Controllers\AdminGalleryController::uploadMedia/$1');
    $routes->delete('galeri/media/hapus/(:num)', '\Modules\Gallery\Controllers\AdminGalleryController::deleteMedia/$1');

    // Testimonial
    $routes->get('testimoni', '\Modules\Testimonial\Controllers\AdminTestimonialController::index');
    $routes->post('testimoni/simpan', '\Modules\Testimonial\Controllers\AdminTestimonialController::store');
    $routes->post('testimoni/approve/(:num)', '\Modules\Testimonial\Controllers\AdminTestimonialController::approve/$1');
    $routes->post('testimoni/featured/(:num)', '\Modules\Testimonial\Controllers\AdminTestimonialController::toggleFeatured/$1');
    $routes->post('testimoni/update/(:num)', '\Modules\Testimonial\Controllers\AdminTestimonialController::update/$1');
    $routes->delete('testimoni/hapus/(:num)', '\Modules\Testimonial\Controllers\AdminTestimonialController::delete/$1');

    // FAQ
    $routes->get('faq', '\Modules\FAQ\Controllers\AdminFaqController::index');
    $routes->post('faq', '\Modules\FAQ\Controllers\AdminFaqController::store');
    $routes->post('faq/reorder', '\Modules\FAQ\Controllers\AdminFaqController::reorder');
    $routes->post('faq/(:num)', '\Modules\FAQ\Controllers\AdminFaqController::update/$1');
    $routes->delete('faq/(:num)', '\Modules\FAQ\Controllers\AdminFaqController::delete/$1');
    $routes->delete('faq/hapus/(:num)', '\Modules\FAQ\Controllers\AdminFaqController::delete/$1');

    // Registration Management
    $routes->get('pendaftaran', '\Modules\Registration\Controllers\AdminRegistrationController::index');
    $routes->get('pendaftaran/detail/(:num)', '\Modules\Registration\Controllers\AdminRegistrationController::detail/$1');
    $routes->post('pendaftaran/status/(:num)', '\Modules\Registration\Controllers\AdminRegistrationController::updateStatus/$1');
    $routes->post('pendaftaran/peserta/(:num)', '\Modules\Registration\Controllers\AdminRegistrationController::updateParticipant/$1');
    $routes->get('pendaftaran/riwayat', '\Modules\Registration\Controllers\AdminRegistrationController::participantHistory');
    $routes->delete('pendaftaran/hapus/(:num)', '\Modules\Registration\Controllers\AdminRegistrationController::deleteRegistration/$1');
    $routes->get('pendaftaran/export-excel', '\Modules\Registration\Controllers\AdminRegistrationController::exportExcel');
    $routes->get('pendaftaran/export-pdf', '\Modules\Registration\Controllers\AdminRegistrationController::exportPdf');
    $routes->get('pendaftaran/export', '\Modules\Registration\Controllers\AdminRegistrationController::exportExcel');

    // Participants
    $routes->get('peserta', '\Modules\Admin\Controllers\ParticipantController::index');
    $routes->get('peserta/detail/(:num)', '\Modules\Admin\Controllers\ParticipantController::detail/$1');
    $routes->get('peserta/edit/(:num)', '\Modules\Admin\Controllers\ParticipantController::edit/$1');
    $routes->post('peserta/update/(:num)', '\Modules\Admin\Controllers\ParticipantController::update/$1');
    $routes->delete('peserta/hapus/(:num)', '\Modules\Admin\Controllers\ParticipantController::delete/$1');
    $routes->get('peserta/export', '\Modules\Admin\Controllers\ParticipantController::export');

    // Company Profile CMS
    $routes->get('profil-perusahaan', '\Modules\Profile\Controllers\AdminProfileController::company');
    $routes->post('profil-perusahaan/update', '\Modules\Profile\Controllers\AdminProfileController::updateCompany');
    $routes->get('profil-pendiri', '\Modules\Profile\Controllers\AdminProfileController::founder');
    $routes->post('profil-pendiri/update', '\Modules\Profile\Controllers\AdminProfileController::updateFounder');
    $routes->get('profil-pendiri/publikasi', '\Modules\Profile\Controllers\AdminProfileController::publications');
    $routes->post('profil-pendiri/publikasi/simpan', '\Modules\Profile\Controllers\AdminProfileController::storePublication');
    $routes->post('profil-pendiri/publikasi/update/(:num)', '\Modules\Profile\Controllers\AdminProfileController::updatePublication/$1');
    $routes->delete('profil-pendiri/publikasi/hapus/(:num)', '\Modules\Profile\Controllers\AdminProfileController::deletePublication/$1');

    // Banner
    $routes->get('banner', '\Modules\CMS\Controllers\AdminBannerController::index');
    $routes->post('banner/simpan', '\Modules\CMS\Controllers\AdminBannerController::store');
    $routes->post('banner/update/(:num)', '\Modules\CMS\Controllers\AdminBannerController::update/$1');
    $routes->post('banner/toggle/(:num)', '\Modules\CMS\Controllers\AdminBannerController::toggleActive/$1');
    $routes->delete('banner/hapus/(:num)', '\Modules\CMS\Controllers\AdminBannerController::delete/$1');
    $routes->post('banner/reorder', '\Modules\CMS\Controllers\AdminBannerController::reorder');

    // Master Data - Location
    $routes->get('lokasi', '\Modules\CMS\Controllers\AdminLocationController::index');
    $routes->post('lokasi/simpan', '\Modules\CMS\Controllers\AdminLocationController::store');
    $routes->post('lokasi/update/(:num)', '\Modules\CMS\Controllers\AdminLocationController::update/$1');
    $routes->delete('lokasi/hapus/(:num)', '\Modules\CMS\Controllers\AdminLocationController::delete/$1');

    // Master Data - Speaker/Narasumber
    $routes->get('narasumber', '\Modules\CMS\Controllers\AdminSpeakerController::index');
    $routes->post('narasumber/simpan', '\Modules\CMS\Controllers\AdminSpeakerController::store');
    $routes->post('narasumber/update/(:num)', '\Modules\CMS\Controllers\AdminSpeakerController::update/$1');
    $routes->delete('narasumber/hapus/(:num)', '\Modules\CMS\Controllers\AdminSpeakerController::delete/$1');

    // User Management
    $routes->get('users', '\Modules\Admin\Controllers\UserController::index');
    $routes->get('users/tambah', '\Modules\Admin\Controllers\UserController::create');
    $routes->post('users/simpan', '\Modules\Admin\Controllers\UserController::store');
    $routes->get('users/edit/(:num)', '\Modules\Admin\Controllers\UserController::edit/$1');
    $routes->post('users/update/(:num)', '\Modules\Admin\Controllers\UserController::update/$1');
    $routes->delete('users/hapus/(:num)', '\Modules\Admin\Controllers\UserController::delete/$1');
    $routes->post('users/reset-password/(:num)', '\Modules\Admin\Controllers\UserController::resetPassword/$1');
    $routes->post('users/toggle-active/(:num)', '\Modules\Admin\Controllers\UserController::toggleActive/$1');

    // Roles & Permissions
    $routes->get('roles', '\Modules\Admin\Controllers\RoleController::index');
    $routes->get('roles/tambah', '\Modules\Admin\Controllers\RoleController::create');
    $routes->post('roles/simpan', '\Modules\Admin\Controllers\RoleController::store');
    $routes->get('roles/edit/(:num)', '\Modules\Admin\Controllers\RoleController::edit/$1');
    $routes->post('roles/update/(:num)', '\Modules\Admin\Controllers\RoleController::update/$1');
    $routes->delete('roles/hapus/(:num)', '\Modules\Admin\Controllers\RoleController::delete/$1');

    // Media Manager
    $routes->get('media', '\Modules\CMS\Controllers\MediaController::index');
    $routes->post('media/upload', '\Modules\CMS\Controllers\MediaController::upload');
    $routes->delete('media/hapus/(:num)', '\Modules\CMS\Controllers\MediaController::delete/$1');

    // Activity Log
    $routes->get('activity-log', '\Modules\Admin\Controllers\ActivityLogController::index');
    $routes->post('activity-log/clear', '\Modules\Admin\Controllers\ActivityLogController::clear');
    $routes->get('activity-log/export', '\Modules\Admin\Controllers\ActivityLogController::export');

    // Settings
    $routes->get('pengaturan', '\Modules\Admin\Controllers\SettingsController::index');
    $routes->post('pengaturan/update', '\Modules\Admin\Controllers\SettingsController::update');
    $routes->post('pengaturan/seo', '\Modules\Admin\Controllers\SettingsController::updateSeo');
    $routes->post('pengaturan/clear-cache', '\Modules\Admin\Controllers\SettingsController::clearCache');
    $routes->get('visibilitas', '\Modules\Admin\Controllers\SettingsController::visibility');
    $routes->post('visibilitas/update', '\Modules\Admin\Controllers\SettingsController::updateVisibility');

    // Certificates
    $routes->get('sertifikat', '\Modules\Registration\Controllers\AdminCertificateController::index');
    $routes->get('sertifikat/preview/(:num)', '\Modules\Registration\Controllers\AdminCertificateController::preview/$1');
    $routes->get('sertifikat/download/(:num)', '\Modules\Registration\Controllers\AdminCertificateController::download/$1');
});
