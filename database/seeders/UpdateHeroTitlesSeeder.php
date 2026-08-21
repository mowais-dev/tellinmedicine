<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HeroSection;
use App\Models\Setting;

class UpdateHeroTitlesSeeder extends Seeder
{
    public function run(): void
    {
        $home = HeroSection::where('page', 'home')->first();
        if ($home) {
            $home->update([
                'title' => 'Compassionate Healthcare',
                'title_highlight' => 'Without Borders',
            ]);
        }

        $edu = HeroSection::where('page', 'education')->first();
        if ($edu) {
            $edu->update([
                'title' => 'Patient Education &',
                'title_highlight' => 'Health Empowerment',
            ]);
        }

        $phil = HeroSection::where('page', 'philosophy')->first();
        if ($phil) {
            $phil->update([
                'title' => 'Our Medical',
                'title_highlight' => 'Philosophy',
            ]);
        }

        Setting::set('brand_name', 'TELLin');
        Setting::set('brand_accent', 'Medicine');
        Setting::set('brand_sub', 'Primary Care & Telehealth');
    }
}
