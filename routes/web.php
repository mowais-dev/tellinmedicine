<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Admin\AdminLoginController;

// Public Website Routes
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/index.html', [PageController::class, 'home']);

Route::get('/education', [PageController::class, 'education'])->name('education');
Route::get('/education.html', [PageController::class, 'education']);

Route::get('/philosophy', [PageController::class, 'philosophy'])->name('philosophy');
Route::get('/philosophy.html', [PageController::class, 'philosophy']);

// Appointment Booking Endpoint
Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');

// AI Chat Messaging Endpoint
Route::post('/chat/message', [ChatController::class, 'sendMessage'])->name('chat.message');

// Direct access alias for admin login
Route::get('/adminlogin', function () {
    return redirect()->route('admin.login');
});

// Admin Authentication & Portal Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest Auth Routes
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.store');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    // Authenticated Admin Routes
    Route::middleware('auth')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

        // Home Submenus
        Route::get('/home/hero', [AdminController::class, 'homeHero'])->name('home.hero');
        Route::get('/home/pillars', [AdminController::class, 'homePillars'])->name('home.pillars');
        Route::get('/home/schedule', [AdminController::class, 'homeSchedule'])->name('home.schedule');
        Route::get('/home/services', [AdminController::class, 'homeServices'])->name('home.services');
        Route::get('/home/specialists', [AdminController::class, 'homeSpecialists'])->name('home.specialists');
        Route::get('/home/contact', [AdminController::class, 'homeContact'])->name('home.contact');

        // Specialists CRUD
        Route::post('/specialists', [AdminController::class, 'storeSpecialist'])->name('specialists.store');
        Route::put('/specialists/{specialist}', [AdminController::class, 'updateSpecialist'])->name('specialists.update');
        Route::delete('/specialists/{specialist}', [AdminController::class, 'destroySpecialist'])->name('specialists.destroy');

        // Patient Education Submenus
        Route::get('/education/hero', [AdminController::class, 'educationHero'])->name('education.hero');
        Route::get('/education/bmi', [AdminController::class, 'educationBmi'])->name('education.bmi');
        Route::get('/education/guides', [AdminController::class, 'educationGuides'])->name('education.guides');
        Route::get('/education/checklists', [AdminController::class, 'educationChecklists'])->name('education.checklists');

        // Our Philosophy Submenus
        Route::get('/philosophy/hero', [AdminController::class, 'philosophyHero'])->name('philosophy.hero');
        Route::get('/philosophy/article', [AdminController::class, 'philosophyArticle'])->name('philosophy.article');
        Route::get('/philosophy/pillars', [AdminController::class, 'philosophyPillars'])->name('philosophy.pillars');

        // Meet Dr. Ngomba Submenus
        Route::get('/doctor/profile', [AdminController::class, 'doctorProfile'])->name('doctor.profile');
        Route::get('/doctor/timeline', [AdminController::class, 'doctorTimeline'])->name('doctor.timeline');

        // Website Submenus
        Route::get('/website/marquee', [AdminController::class, 'websiteMarquee'])->name('website.marquee');
        Route::get('/website/navigation', [AdminController::class, 'websiteNavigation'])->name('website.navigation');
        Route::get('/website/footer', [AdminController::class, 'websiteFooter'])->name('website.footer');
        Route::get('/website/media', [MediaController::class, 'index'])->name('website.media');

        // Modals & Popups
        Route::get('/modals/booking', [AdminController::class, 'modalsBooking'])->name('modals.booking');

        // Notification Emails Management
        Route::get('/emails', [AdminController::class, 'notificationEmails'])->name('emails');
        Route::post('/emails', [AdminController::class, 'storeNotificationEmail'])->name('emails.store');
        Route::put('/emails/{emailRecipient}', [AdminController::class, 'updateNotificationEmail'])->name('emails.update');
        Route::delete('/emails/{emailRecipient}', [AdminController::class, 'destroyNotificationEmail'])->name('emails.destroy');

        // Site Settings
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');

        // Navigation
        Route::get('/navigation', [AdminController::class, 'navigation'])->name('navigation');
        Route::post('/navigation', [AdminController::class, 'storeNavigation'])->name('navigation.store');
        Route::put('/navigation/{item}', [AdminController::class, 'updateNavigation'])->name('navigation.update');
        Route::delete('/navigation/{item}', [AdminController::class, 'destroyNavigation'])->name('navigation.destroy');

        // Heroes
        Route::get('/heroes', [AdminController::class, 'heroes'])->name('heroes');
        Route::post('/heroes/{page}', [AdminController::class, 'updateHero'])->name('heroes.update');

        // Pillars
        Route::get('/pillars', [AdminController::class, 'pillars'])->name('pillars');
        Route::post('/pillars', [AdminController::class, 'storePillar'])->name('pillars.store');
        Route::put('/pillars/{pillar}', [AdminController::class, 'updatePillar'])->name('pillars.update');
        Route::delete('/pillars/{pillar}', [AdminController::class, 'destroyPillar'])->name('pillars.destroy');

        // Doctor Profile & Timelines
        Route::get('/doctor', [AdminController::class, 'doctor'])->name('doctor');
        Route::post('/doctor', [AdminController::class, 'updateDoctor'])->name('doctor.update');
        Route::post('/doctor/timelines', [AdminController::class, 'storeTimeline'])->name('doctor.timelines.store');
        Route::put('/doctor/timelines/{timeline}', [AdminController::class, 'updateTimeline'])->name('doctor.timelines.update');
        Route::delete('/doctor/timelines/{timeline}', [AdminController::class, 'destroyTimeline'])->name('doctor.timelines.destroy');

        // Services
        Route::get('/services', [AdminController::class, 'services'])->name('services');
        Route::post('/services', [AdminController::class, 'storeService'])->name('services.store');
        Route::put('/services/{service}', [AdminController::class, 'updateService'])->name('services.update');
        Route::delete('/services/{service}', [AdminController::class, 'destroyService'])->name('services.destroy');
        Route::put('/services/categories/{category}', [AdminController::class, 'updateServiceCategory'])->name('services.categories.update');

        // Education
        Route::get('/education', [AdminController::class, 'education'])->name('education');
        Route::post('/education/guides', [AdminController::class, 'storeEducationGuide'])->name('education.guides.store');
        Route::put('/education/guides/{guide}', [AdminController::class, 'updateEducationGuide'])->name('education.guides.update');
        Route::delete('/education/guides/{guide}', [AdminController::class, 'destroyEducationGuide'])->name('education.guides.destroy');
        Route::post('/education/checklists', [AdminController::class, 'storePreventiveChecklist'])->name('education.checklists.store');
        Route::put('/education/checklists/{checklist}', [AdminController::class, 'updatePreventiveChecklist'])->name('education.checklists.update');
        Route::delete('/education/checklists/{checklist}', [AdminController::class, 'destroyPreventiveChecklist'])->name('education.checklists.destroy');

        // Philosophy
        Route::get('/philosophy', [AdminController::class, 'philosophy'])->name('philosophy');
        Route::post('/philosophy', [AdminController::class, 'updatePhilosophy'])->name('philosophy.update');

        // Booking
        Route::get('/booking', [AdminController::class, 'booking'])->name('booking');
        Route::post('/booking/reasons', [AdminController::class, 'storeBookingReason'])->name('booking.reasons.store');
        Route::put('/booking/reasons/{reason}', [AdminController::class, 'updateBookingReason'])->name('booking.reasons.update');
        Route::delete('/booking/reasons/{reason}', [AdminController::class, 'destroyBookingReason'])->name('booking.reasons.destroy');

        // Chat
        Route::get('/chat', [AdminController::class, 'chat'])->name('chat');
        Route::post('/chat/config', [AdminController::class, 'updateChatConfig'])->name('chat.config.update');
        Route::post('/chat/chips', [AdminController::class, 'storeChatChip'])->name('chat.chips.store');
        Route::put('/chat/chips/{chip}', [AdminController::class, 'updateChatChip'])->name('chat.chips.update');
        Route::delete('/chat/chips/{chip}', [AdminController::class, 'destroyChatChip'])->name('chat.chips.destroy');

        // Media
        Route::get('/media', [MediaController::class, 'index'])->name('media');
        Route::post('/media', [MediaController::class, 'store'])->name('media.store');
        Route::delete('/media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');
    });
});
