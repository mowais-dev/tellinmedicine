<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Specialist;

class SpecialistSeeder extends Seeder
{
    public function run(): void
    {
        Specialist::truncate();

        Specialist::create([
            'name' => 'Dr. Jasper I. Ngomba, MD',
            'title' => 'Lead Internal Medicine Specialist',
            'qualifications' => 'MD, FACP | Primary Care & Telemedicine',
            'image' => '/images/doctor.png',
            'description' => 'Board-Certified Internal Medicine Specialist with over 15 years of clinical experience in adult primary care, chronic disease management, and physician home visits.',
            'experience_years' => '15+ Years',
            'order' => 1,
            'is_active' => true,
        ]);

        Specialist::create([
            'name' => 'Dr. Elena Vance, MD',
            'title' => 'Telehealth & Virtual Care Specialist',
            'qualifications' => 'MD | Board-Certified Family Physician',
            'image' => '/images/specialist_female.png',
            'description' => 'Specialist in virtual care consultations, remote patient monitoring, acute care triage, and personalized preventative health strategies.',
            'experience_years' => '10+ Years',
            'order' => 2,
            'is_active' => true,
        ]);

        Specialist::create([
            'name' => 'Dr. Marcus Sterling, MD',
            'title' => 'Geriatric & Home Visit Specialist',
            'qualifications' => 'MD | Geriatric & Senior Care Medicine',
            'image' => '/images/specialist_male.png',
            'description' => 'Dedicated physician providing specialized home visit evaluations, senior wellness assessments, and comprehensive mobility healthcare.',
            'experience_years' => '12+ Years',
            'order' => 3,
            'is_active' => true,
        ]);
    }
}
