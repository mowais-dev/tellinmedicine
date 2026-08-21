<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\NavigationItem;
use App\Models\HeroSection;
use App\Models\Pillar;
use App\Models\DoctorProfile;
use App\Models\DoctorTimeline;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\EducationGuide;
use App\Models\PreventiveChecklist;
use App\Models\PhilosophyContent;
use App\Models\ChatWidgetConfig;
use App\Models\ChatChip;
use App\Models\BookingReason;
use App\Models\NotificationEmail;
use App\Models\Media;
use App\Models\Specialist;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'services_count' => Service::count(),
            'pillars_count' => Pillar::count(),
            'nav_count' => NavigationItem::count(),
            'guides_count' => EducationGuide::count(),
            'checklists_count' => PreventiveChecklist::count(),
        ];
        return view('admin.dashboard', compact('stats'));
    }

    // Helper for handling image uploads
    private function handleImageUpload(Request $request, $fileKey, $defaultPath = null)
    {
        if ($request->hasFile($fileKey)) {
            $request->validate([
                $fileKey => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            ]);
            $file = $request->file($fileKey);
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            $file->move(public_path('images'), $filename);
            $relPath = 'images/' . $filename;

            Media::create([
                'filename' => $filename,
                'path' => $relPath,
                'alt_text' => $filename,
                'mime_type' => $file->getClientMimeType(),
                'size' => filesize(public_path($relPath)),
            ]);

            return $relPath;
        }
        return $defaultPath;
    }

    // Site Settings
    public function settings()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $data = $request->except(['_token', 'logo_file', 'favicon_file', 'building_image_file']);
        
        if ($uploadedLogo = $this->handleImageUpload($request, 'logo_file')) {
            $data['logo_path'] = $uploadedLogo;
        }

        if ($uploadedFavicon = $this->handleImageUpload($request, 'favicon_file')) {
            $data['favicon_path'] = $uploadedFavicon;
        }

        if ($uploadedBuilding = $this->handleImageUpload($request, 'building_image_file')) {
            $data['building_image_path'] = $uploadedBuilding;
        }

        foreach ($data as $key => $val) {
            Setting::set($key, $val);
        }
        return back()->with('success', 'Site settings updated successfully.');
    }

    // Navigation Items
    public function navigation()
    {
        $items = NavigationItem::orderBy('order')->get();
        return view('admin.navigation', compact('items'));
    }

    public function storeNavigation(Request $request)
    {
        NavigationItem::create($request->validate([
            'label' => 'nullable|string',
            'url' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'is_cta' => 'nullable|boolean',
            'care_model' => 'nullable|string',
        ]));
        return back()->with('success', 'Navigation item created.');
    }

    public function updateNavigation(Request $request, NavigationItem $item)
    {
        $item->update($request->validate([
            'label' => 'nullable|string',
            'url' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'is_cta' => 'nullable|boolean',
            'care_model' => 'nullable|string',
        ]));
        return back()->with('success', 'Navigation item updated.');
    }

    public function destroyNavigation(NavigationItem $item)
    {
        $item->delete();
        return back()->with('success', 'Navigation item deleted.');
    }

    // Heroes
    public function heroes()
    {
        $heroes = HeroSection::all()->keyBy('page');
        return view('admin.heroes', compact('heroes'));
    }

    public function updateHero(Request $request, $page)
    {
        $hero = HeroSection::firstOrCreate(['page' => $page]);
        
        $request->validate([
            'image_rotation' => 'nullable|integer|between:-45,45',
        ]);

        $data = $request->except(['_token', 'image_file']);
        
        if (array_key_exists('image_rotation', $data)) {
            $data['image_rotation'] = (int) ($data['image_rotation'] ?? 0);
        }

        if ($uploadedImage = $this->handleImageUpload($request, 'image_file')) {
            $data['image_path'] = $uploadedImage;
        }

        $hero->update($data);
        return back()->with('success', ucfirst($page) . ' hero section updated.');
    }

    // Pillars
    public function pillars()
    {
        $homePillars = Pillar::where('page', 'home')->orderBy('order')->get();
        $philosophyPillars = Pillar::where('page', 'philosophy')->orderBy('order')->get();
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.pillars', compact('homePillars', 'philosophyPillars', 'settings'));
    }

    public function storePillar(Request $request)
    {
        $data = $request->all();
        if ($uploadedImage = $this->handleImageUpload($request, 'image_file')) {
            $data['image_path'] = $uploadedImage;
        }
        Pillar::create($data);
        return back()->with('success', 'Pillar created.');
    }

    public function updatePillar(Request $request, Pillar $pillar)
    {
        $data = $request->all();
        if ($uploadedImage = $this->handleImageUpload($request, 'image_file')) {
            $data['image_path'] = $uploadedImage;
        }
        $pillar->update($data);
        return back()->with('success', 'Pillar updated.');
    }

    public function destroyPillar(Pillar $pillar)
    {
        $pillar->delete();
        return back()->with('success', 'Pillar deleted.');
    }

    // Doctor
    public function doctor()
    {
        $doctor = DoctorProfile::first() ?? new DoctorProfile();
        $timelines = DoctorTimeline::orderBy('order')->get();
        return view('admin.doctor', compact('doctor', 'timelines'));
    }

    public function updateDoctor(Request $request)
    {
        $doctor = DoctorProfile::firstOrCreate(['id' => 1]);
        $data = $request->all();
        
        if ($uploadedPhoto = $this->handleImageUpload($request, 'photo_file')) {
            $data['photo_path'] = $uploadedPhoto;
        }

        $doctor->update($data);
        return back()->with('success', 'Doctor profile updated.');
    }

    public function storeTimeline(Request $request)
    {
        DoctorTimeline::create($request->validate([
            'year_range' => 'nullable|string',
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]));
        return back()->with('success', 'Timeline item added.');
    }

    public function updateTimeline(Request $request, DoctorTimeline $timeline)
    {
        $timeline->update($request->all());
        return back()->with('success', 'Timeline item updated.');
    }

    public function destroyTimeline(DoctorTimeline $timeline)
    {
        $timeline->delete();
        return back()->with('success', 'Timeline item deleted.');
    }

    // Services
    public function services()
    {
        $services = Service::orderBy('order')->get();
        $categories = ServiceCategory::orderBy('order')->get();
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.services', compact('services', 'categories', 'settings'));
    }

    public function storeService(Request $request)
    {
        $data = $request->all();
        if (isset($data['features_raw'])) {
            $data['features'] = array_filter(array_map('trim', explode("\n", $data['features_raw'])));
        }
        Service::create($data);
        return back()->with('success', 'Service created.');
    }

    public function updateService(Request $request, Service $service)
    {
        $data = $request->all();
        if (isset($data['features_raw'])) {
            $data['features'] = array_filter(array_map('trim', explode("\n", $data['features_raw'])));
        }
        $service->update($data);
        return back()->with('success', 'Service updated.');
    }

    public function destroyService(Service $service)
    {
        $service->delete();
        return back()->with('success', 'Service deleted.');
    }

    public function updateServiceCategory(Request $request, ServiceCategory $category)
    {
        $category->update($request->validate([
            'label' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]));
        return back()->with('success', 'Service category tab updated.');
    }

    // Education
    public function education()
    {
        $guides = EducationGuide::orderBy('order')->get();
        $checklists = PreventiveChecklist::orderBy('order')->get();
        $settings = Setting::all()->pluck('value', 'key');
        $hero = HeroSection::firstOrCreate(['page' => 'education']);
        return view('admin.education', compact('guides', 'checklists', 'settings', 'hero'));
    }

    public function storeEducationGuide(Request $request)
    {
        $data = $request->all();
        if (isset($data['features_raw'])) {
            $data['features'] = array_filter(array_map('trim', explode("\n", $data['features_raw'])));
        }
        EducationGuide::create($data);
        return back()->with('success', 'Education guide created.');
    }

    public function updateEducationGuide(Request $request, EducationGuide $guide)
    {
        $data = $request->all();
        if (isset($data['features_raw'])) {
            $data['features'] = array_filter(array_map('trim', explode("\n", $data['features_raw'])));
        }
        $guide->update($data);
        return back()->with('success', 'Education guide updated.');
    }

    public function destroyEducationGuide(EducationGuide $guide)
    {
        $guide->delete();
        return back()->with('success', 'Education guide deleted.');
    }

    public function storePreventiveChecklist(Request $request)
    {
        $data = $request->all();
        if (isset($data['items_raw'])) {
            $data['items'] = array_filter(array_map('trim', explode("\n", $data['items_raw'])));
        }
        PreventiveChecklist::create($data);
        return back()->with('success', 'Checklist created.');
    }

    public function updatePreventiveChecklist(Request $request, PreventiveChecklist $checklist)
    {
        $data = $request->all();
        if (isset($data['items_raw'])) {
            $data['items'] = array_filter(array_map('trim', explode("\n", $data['items_raw'])));
        }
        $checklist->update($data);
        return back()->with('success', 'Checklist updated.');
    }

    public function destroyPreventiveChecklist(PreventiveChecklist $checklist)
    {
        $checklist->delete();
        return back()->with('success', 'Checklist deleted.');
    }

    // Philosophy
    public function philosophy()
    {
        $philosophy = PhilosophyContent::first() ?? new PhilosophyContent();
        $settings = Setting::all()->pluck('value', 'key');
        $hero = HeroSection::firstOrCreate(['page' => 'philosophy']);
        $philosophyPillars = Pillar::where('page', 'philosophy')->orderBy('order')->get();
        return view('admin.philosophy', compact('philosophy', 'settings', 'hero', 'philosophyPillars'));
    }

    public function updatePhilosophy(Request $request)
    {
        $philosophy = PhilosophyContent::firstOrCreate(['id' => 1]);
        $philosophy->update($request->all());
        return back()->with('success', 'Philosophy content updated.');
    }

    // Booking
    public function booking()
    {
        $reasons = BookingReason::orderBy('order')->get();
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.booking', compact('reasons', 'settings'));
    }

    public function storeBookingReason(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'value' => 'nullable|string|max:255',
            'redirect_url' => 'nullable|string|max:500',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $label = trim($validated['label']);
        $value = !empty($validated['value']) ? trim($validated['value']) : \Illuminate\Support\Str::slug($label, '_');

        BookingReason::create([
            'label' => $label,
            'value' => $value,
            'redirect_url' => !empty($validated['redirect_url']) ? trim($validated['redirect_url']) : null,
            'order' => $validated['order'] ?? 0,
            'is_active' => $request->has('is_active') ? (bool)$request->is_active : true,
        ]);

        return back()->with('success', 'Booking reason created successfully.');
    }

    public function updateBookingReason(Request $request, BookingReason $reason)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'value' => 'nullable|string|max:255',
            'redirect_url' => 'nullable|string|max:500',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $label = trim($validated['label']);
        $value = !empty($validated['value']) ? trim($validated['value']) : \Illuminate\Support\Str::slug($label, '_');

        $reason->update([
            'label' => $label,
            'value' => $value,
            'redirect_url' => !empty($validated['redirect_url']) ? trim($validated['redirect_url']) : null,
            'order' => $validated['order'] ?? $reason->order,
            'is_active' => $request->has('is_active') ? (bool)$request->is_active : $reason->is_active,
        ]);

        return back()->with('success', 'Booking reason updated successfully.');
    }

    public function destroyBookingReason(BookingReason $reason)
    {
        $reason->delete();
        return back()->with('success', 'Booking reason deleted.');
    }

    // AI Chat
    public function chat()
    {
        $config = ChatWidgetConfig::first() ?? new ChatWidgetConfig();
        return view('admin.chat', compact('config'));
    }

    public function updateChatConfig(Request $request)
    {
        $config = ChatWidgetConfig::firstOrCreate(['id' => 1]);
        $config->update($request->all());
        return back()->with('success', 'AI Chat settings updated.');
    }

    public function storeChatChip(Request $request)
    {
        ChatChip::create($request->all());
        return back()->with('success', 'Chat chip added.');
    }

    public function updateChatChip(Request $request, ChatChip $chip)
    {
        $chip->update($request->all());
        return back()->with('success', 'Chat chip updated.');
    }

    public function destroyChatChip(ChatChip $chip)
    {
        $chip->delete();
        return back()->with('success', 'Chat chip deleted.');
    }

    // Home Subpage Views
    public function homeHero()
    {
        $hero = HeroSection::firstOrCreate(['page' => 'home']);
        return view('admin.home.hero', compact('hero'));
    }

    public function homePillars()
    {
        $pillars = Pillar::where('page', 'home')->orderBy('order')->get();
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.home.pillars', compact('pillars', 'settings'));
    }

    public function homeSchedule()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.home.schedule', compact('settings'));
    }

    public function homeServices()
    {
        $services = Service::orderBy('order')->get();
        $categories = ServiceCategory::orderBy('order')->get();
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.home.services', compact('services', 'categories', 'settings'));
    }

    public function homeContact()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.home.contact', compact('settings'));
    }

    // Patient Education Subpage Views
    public function educationHero()
    {
        $hero = HeroSection::firstOrCreate(['page' => 'education']);
        return view('admin.education.hero', compact('hero'));
    }

    public function educationBmi()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.education.bmi', compact('settings'));
    }

    public function educationGuides()
    {
        $guides = EducationGuide::orderBy('order')->get();
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.education.guides', compact('guides', 'settings'));
    }

    public function educationChecklists()
    {
        $checklists = PreventiveChecklist::orderBy('order')->get();
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.education.checklists', compact('checklists', 'settings'));
    }

    // Our Philosophy Subpage Views
    public function philosophyHero()
    {
        $hero = HeroSection::firstOrCreate(['page' => 'philosophy']);
        return view('admin.philosophy.hero', compact('hero'));
    }

    public function philosophyArticle()
    {
        $philosophy = PhilosophyContent::first() ?? new PhilosophyContent();
        return view('admin.philosophy.article', compact('philosophy'));
    }

    public function philosophyPillars()
    {
        $pillars = Pillar::where('page', 'philosophy')->orderBy('order')->get();
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.philosophy.pillars', compact('pillars', 'settings'));
    }

    // Meet Dr. Ngomba Subpage Views
    public function doctorProfile()
    {
        $doctor = DoctorProfile::first() ?? new DoctorProfile();
        return view('admin.doctor.profile', compact('doctor'));
    }

    public function doctorTimeline()
    {
        $timelines = DoctorTimeline::orderBy('order')->get();
        return view('admin.doctor.timeline', compact('timelines'));
    }

    // Website Subpage Views
    public function websiteMarquee()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.website.marquee', compact('settings'));
    }

    public function websiteNavigation()
    {
        $items = NavigationItem::orderBy('order')->get();
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.website.navigation', compact('items', 'settings'));
    }

    public function websiteFooter()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.website.footer', compact('settings'));
    }

    // Modals & Popups Subpage View
    public function modalsBooking()
    {
        $reasons = BookingReason::orderBy('order')->get();
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.modals.booking', compact('reasons', 'settings'));
    }

    // Notification Emails Management
    public function notificationEmails()
    {
        $recipients = NotificationEmail::orderBy('created_at', 'desc')->get();
        if ($recipients->isEmpty()) {
            $settingEmail = Setting::get('email', 'tellinmedicinellc@gmail.com');
            if ($settingEmail) {
                NotificationEmail::create([
                    'email' => $settingEmail,
                    'label' => 'Primary Clinic Contact',
                    'is_active' => true,
                ]);
                $recipients = NotificationEmail::orderBy('created_at', 'desc')->get();
            }
        }
        return view('admin.emails', compact('recipients'));
    }

    public function storeNotificationEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255|unique:notification_emails,email',
            'label' => 'nullable|string|max:255',
        ]);

        NotificationEmail::create([
            'email' => trim($validated['email']),
            'label' => $validated['label'] ?? null,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Notification email recipient added successfully!');
    }

    public function updateNotificationEmail(Request $request, NotificationEmail $emailRecipient)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255|unique:notification_emails,email,' . $emailRecipient->id,
            'label' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        $emailRecipient->update([
            'email' => trim($validated['email']),
            'label' => $validated['label'] ?? null,
            'is_active' => (bool)$validated['is_active'],
        ]);

        return redirect()->back()->with('success', 'Notification email recipient updated successfully!');
    }

    public function destroyNotificationEmail(NotificationEmail $emailRecipient)
    {
        $emailRecipient->delete();
        return redirect()->back()->with('success', 'Notification email recipient removed successfully!');
    }

    // Specialists
    public function homeSpecialists()
    {
        $specialists = Specialist::orderBy('order')->get();
        return view('admin.home.specialists', compact('specialists'));
    }

    public function storeSpecialist(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'qualifications' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'experience_years' => 'nullable|string|max:100',
            'order' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        if ($uploadedImage = $this->handleImageUpload($request, 'image_file')) {
            $data['image'] = $uploadedImage;
        }

        Specialist::create($data);
        return back()->with('success', 'Specialist added successfully.');
    }

    public function updateSpecialist(Request $request, Specialist $specialist)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'qualifications' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'experience_years' => 'nullable|string|max:100',
            'order' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        if ($uploadedImage = $this->handleImageUpload($request, 'image_file')) {
            $data['image'] = $uploadedImage;
        }

        $specialist->update($data);
        return back()->with('success', 'Specialist updated successfully.');
    }

    public function destroySpecialist(Specialist $specialist)
    {
        $specialist->delete();
        return back()->with('success', 'Specialist deleted successfully.');
    }
}
