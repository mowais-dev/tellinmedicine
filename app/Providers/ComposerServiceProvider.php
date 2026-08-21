<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;
use App\Models\NavigationItem;
use App\Models\ServiceCategory;
use App\Models\Service;
use App\Models\ChatWidgetConfig;
use App\Models\ChatChip;
use App\Models\BookingReason;

class ComposerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $allSettings = Setting::all()->pluck('value', 'key')->toArray();

            $view->with('globalSettings', array_merge([
                'site_title' => 'TELLinMedicine, LLC | Dr. Jasper I. Ngomba, MD | Primary Care, Home Visits & Telehealth',
                'site_description' => 'TELLinMedicine, LLC - Adult Primary Care, Physician Home Visits, World TeleMedicine, and Travel Vaccines in North Attleboro, MA. Founded by Dr. Jasper Ngomba, MD. Access to Health is Access to Wealth.',
                'address' => '380 Elm Street Suite 1, North Attleboro, MA 02760',
                'phone_primary' => '(774) 643-6261',
                'phone_secondary' => '(617) 513-1446',
                'email' => 'tellinmedicinellc@gmail.com',
                'hours_summary' => 'In-Clinic: Mon-Sat 8 AM-12 PM | E-Appointments: Mon-Sat 12 PM-6 PM',
                'hours_clinic_text' => 'Mon - Sat: 8 AM - 12 PM (In-Clinic)',
                'hours_telehealth_text' => 'Mon - Sat: 12 PM - 6 PM (Telehealth)',
                'hours_sunday_text' => 'Sunday: Closed (E-Appointments Only)',
                'slogan' => '"Access to Health is Access to Wealth"',
                'affiliation' => 'Affiliated with Steward Health Systems',
                'logo_path' => 'images/logo.png',
                'brand_name' => 'TELLin<span class="brand-title-accent">Medicine</span>',
                'brand_sub' => 'LLC',
                'copyright_text' => '© 2026 TELLinMedicine, LLC. All rights reserved. Dr. Jasper I. Ngomba, MD. 380 Elm St, Suite 1, North Attleboro, MA 02760.',
                'portal_button_text' => '🔐 Patient Portal Login',
            ], $allSettings));

            $view->with('navItems', NavigationItem::where('is_active', true)->orderBy('order')->get());
            $view->with('serviceCategories', ServiceCategory::where('is_active', true)->orderBy('order')->get());
            $view->with('footerServices', Service::where('is_active', true)->orderBy('order')->take(6)->get());
            $view->with('chatConfig', ChatWidgetConfig::first() ?? new ChatWidgetConfig());
            $view->with('chatChips', ChatChip::where('is_active', true)->orderBy('order')->get());
            $view->with('bookingReasons', BookingReason::where('is_active', true)->orderBy('order')->get());
        });
    }
}
