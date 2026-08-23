<?php

namespace App\Http\Controllers;

use App\Models\HeroSection;
use App\Models\Pillar;
use App\Models\DoctorProfile;
use App\Models\DoctorTimeline;
use App\Models\Service;
use App\Models\EducationGuide;
use App\Models\PreventiveChecklist;
use App\Models\PhilosophyContent;
use App\Models\Specialist;

class PageController extends Controller
{
    public function home()
    {
        $hero = HeroSection::where('page', 'home')->first();
        $pillars = Pillar::where('page', 'home')->where('is_active', true)->orderBy('order')->get();
        $doctor = DoctorProfile::first();
        $timelines = DoctorTimeline::orderBy('order')->get();
        $services = Service::where('is_active', true)->orderBy('order')->get();
        $specialists = Specialist::where('is_active', true)->orderBy('order')->get();

        return view('index', compact('hero', 'pillars', 'doctor', 'timelines', 'services', 'specialists'));
    }

    public function education()
    {
        $hero = HeroSection::where('page', 'education')->first();
        $guides = EducationGuide::where('is_active', true)->orderBy('order')->get();
        $checklists = PreventiveChecklist::where('is_active', true)->orderBy('order')->get();

        return view('education', compact('hero', 'guides', 'checklists'));
    }

    public function philosophy()
    {
        $hero = HeroSection::where('page', 'philosophy')->first();
        $philosophy = PhilosophyContent::first();
        $pillars = Pillar::where('page', 'philosophy')->where('is_active', true)->orderBy('order')->get();

        return view('philosophy', compact('hero', 'philosophy', 'pillars'));
    }

    public function concierge()
    {
        $hero = HeroSection::where('page', 'concierge')->first();

        return view('concierge', compact('hero'));
    }
}
