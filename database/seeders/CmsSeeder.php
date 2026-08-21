<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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

class CmsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Site Settings
        $settings = [
            'site_title' => 'TELLinMedicine, LLC | Dr. Jasper I. Ngomba, MD | Primary Care, Home Visits & Telehealth',
            'site_description' => 'TELLinMedicine, LLC - Adult Primary Care, Physician Home Visits, World TeleMedicine, and Travel Vaccines in North Attleboro, MA. Founded by Dr. Jasper Ngomba, MD. Access to Health is Access to Wealth.',
            'brand_name' => 'TELLin',
            'brand_accent' => 'Medicine',
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
            'copyright_text' => '© 2026 TELLinMedicine, LLC. All rights reserved. Dr. Jasper I. Ngomba, MD. 380 Elm St, Suite 1, North Attleboro, MA 02760.',
            'portal_button_text' => '🔐 Patient Portal Login',
            'brand_sub' => 'LLC',

            // Section Badges & Titles
            'pillars_badge' => 'Comprehensive Medicine',
            'pillars_title' => 'Four Pillars of Dedicated Patient Care',
            'pillars_subtitle' => 'From home-based doctor visits to global telehealth consultations, we bring quality medicine directly to where you need it most.',

            'schedule_badge' => 'Practice Schedule',
            'schedule_title' => 'Working Hours & Care Availability',
            'schedule_subtitle' => 'Visit Dr. Jasper Ngomba in-clinic during morning hours or schedule virtual E-Appointments in the afternoon and weekends.',

            'services_badge' => 'Our Services',
            'services_title' => 'Comprehensive Medical Offerings',
            'services_subtitle' => 'Accepting most commercial insurances and Medicare. Tailored internal medicine solutions for every stage of adult health.',

            'contact_badge' => 'Get in Touch',
            'contact_title' => 'Visit or Contact TELLinMedicine',
            'contact_subtitle' => 'Located in North Attleboro, MA. We welcome new patients and accept most major insurances.',
            'contact_card_title' => 'Contact Details',
            'contact_form_title' => 'Send Us a Message',
            'contact_form_label_name' => 'Your Full Name',
            'contact_form_label_contact' => 'Phone or Email',
            'contact_form_label_msg' => 'How can we help you?',
            'contact_form_btn_text' => '✉️ Send Message to Office',

            'bmi_badge' => 'Interactive Wellness Tool',
            'bmi_title' => 'Body Mass Index (BMI) & Wellness Assessment',
            'bmi_subtitle' => 'Calculate your Body Mass Index to evaluate baseline cardiovascular and metabolic health indicators.',
            'bmi_card_title' => 'Interactive Health Metric Calculator',
            'bmi_card_desc' => 'Calculate your Body Mass Index (BMI) and evaluate preventive screening recommendations.',
            'bmi_label_height' => 'Height (cm)',
            'bmi_label_weight' => 'Weight (kg)',
            'bmi_label_age' => 'Age (Years)',
            'bmi_btn_text' => '📊 Calculate My Health Metrics',

            'education_guides_badge' => 'Clinical Guidance',
            'education_guides_title' => 'Chronic Disease Prevention & Management',
            'education_guides_subtitle' => 'Key educational insights to help you understand and manage common chronic conditions under physician guidance.',

            'education_checklists_badge' => 'Preventive Screening',
            'education_checklists_title' => 'Age-Appropriate Health Checklists',
            'education_checklists_subtitle' => 'Preventive screenings detect potential health issues early when treatment is most effective.',
            'education_callout_text' => 'Have questions about your screening schedule? Consult directly with Dr. Jasper Ngomba.',
            'education_callout_btn_text' => 'Schedule Your Preventive Visit',

            'philosophy_pillars_badge' => 'Principles of Care',
            'philosophy_pillars_title' => 'The Three Pillars of Our Philosophy',

            'footer_description' => 'Empowering patients with physician home visits, adult primary care, and world telemedicine consultations led by Dr. Jasper I. Ngomba, MD.',
            'footer_col1_header' => 'Quick Links',
            'footer_col2_header' => 'Services',
            'footer_col3_header' => 'Patient Portal Access',
            'footer_portal_text' => 'Complete forms, request appointments, pay bills, and message Dr. Ngomba securely.',

            'booking_modal_title' => '📅 Schedule Appointment',
            'booking_care_label' => '1. Select Care Delivery Model',
            'booking_model_in_clinic' => 'In-Clinic Visit',
            'booking_model_home' => 'Home Visit',
            'booking_model_telehealth' => 'Telehealth Visit',
            'booking_label_name' => 'Full Name',
            'booking_label_phone' => 'Phone Number',
            'booking_label_email' => 'Email Address',
            'booking_label_date' => 'Preferred Date',
            'booking_label_reason' => 'Reason for Visit',
            'booking_placeholder_name' => 'Patient\'s Full Name',
            'booking_placeholder_phone' => '(508) 555-0199',
            'booking_placeholder_email' => 'patient@example.com',
            'booking_btn_text' => '✅ Confirm & Request Appointment',
        ];

        foreach ($settings as $key => $val) {
            Setting::set($key, $val);
        }

        // 2. Navigation Items
        NavigationItem::truncate();
        NavigationItem::create(['label' => 'Home', 'url' => '/#hero', 'order' => 1]);
        NavigationItem::create(['label' => 'Meet Dr. Jasper Ngomba', 'url' => '/#doctor', 'order' => 2]);
        NavigationItem::create(['label' => 'Our Philosophy', 'url' => '/philosophy', 'order' => 3]);
        NavigationItem::create(['label' => 'Patient Education', 'url' => '/education', 'order' => 4]);
        NavigationItem::create(['label' => 'Contact Us', 'url' => '/#contact', 'order' => 5]);
        NavigationItem::create(['label' => 'Schedule Appointment', 'url' => '#booking', 'is_cta' => true, 'care_model' => 'In-Clinic', 'order' => 6]);

        // Service Categories
        ServiceCategory::truncate();
        ServiceCategory::create(['key' => 'all', 'label' => 'All Services', 'order' => 1]);
        ServiceCategory::create(['key' => 'primary', 'label' => 'Primary Care', 'order' => 2]);
        ServiceCategory::create(['key' => 'home', 'label' => 'Home Visits', 'order' => 3]);
        ServiceCategory::create(['key' => 'telehealth', 'label' => 'Telehealth', 'order' => 4]);
        ServiceCategory::create(['key' => 'certs', 'label' => 'Certifications & Physicals', 'order' => 5]);

        // 3. Hero Sections
        HeroSection::truncate();
        HeroSection::create([
            'page' => 'home',
            'title' => 'Compassionate Healthcare',
            'title_highlight' => 'Without Borders',
            'subtitle' => 'Experience patient-centered internal medicine, physician home visits, and world telehealth consultations led by Dr. Jasper I. Ngomba, MD. Empowering you with preventive care in North Attleboro & beyond.',
            'image_path' => 'images/hero_syringe.png',
            'primary_button_text' => 'Schedule Appointment',
            'primary_button_model' => 'In-Clinic',
            'secondary_button_text' => 'Request Physician Home Visit',
            'secondary_button_model' => 'Home Visit',
            'badge1_title' => 'Board Certified',
            'badge1_sub' => 'Internal Medicine MD',
            'badge2_title' => 'World TeleMedicine',
            'badge2_sub' => 'Virtual Queue Active',
        ]);

        HeroSection::create([
            'page' => 'education',
            'badge' => 'Knowledge is Prevention',
            'title' => 'Patient Education &',
            'title_highlight' => 'Health Empowerment',
            'subtitle' => 'We believe that informed patients make the best health decisions. Explore evidence-based guidelines, interactive wellness tools, and preventive care resources carefully curated by Dr. Jasper I. Ngomba, MD.',
        ]);

        HeroSection::create([
            'page' => 'philosophy',
            'badge' => 'Core Practice Beliefs',
            'title' => 'Our Medical',
            'title_highlight' => 'Philosophy',
            'subtitle' => '“Access to Health is Access to Wealth.” Taking primary care and health education beyond policy and beyond borders.',
        ]);

        // 4. Pillars
        Pillar::truncate();
        Pillar::create([
            'page' => 'home',
            'image_path' => 'images/home.png',
            'title' => 'Home Visits',
            'description' => 'Quality doctor visits in the comfort and security of your own home. Designed specifically for elderly patients, those with mobility challenges, or busy individuals desiring private care.',
            'link_text' => 'Request Home Visit →',
            'link_url' => '#services',
            'care_model' => 'Home Visit',
            'order' => 1,
        ]);
        Pillar::create([
            'page' => 'home',
            'image_path' => 'images/globe.png',
            'title' => 'World TeleMedicine',
            'description' => 'Access Board-Certified internal medicine care beyond geographical boundaries. Virtual video e-appointments available Monday through Saturday from 12 PM to 6 PM.',
            'link_text' => 'Launch Virtual Visit →',
            'link_url' => '#services',
            'care_model' => 'Telehealth',
            'order' => 2,
        ]);
        Pillar::create([
            'page' => 'home',
            'image_path' => 'images/stethoscope.png',
            'title' => 'Adult Primary Care',
            'description' => 'Complete internal medicine care, hypertension management, diabetes prevention, and annual wellness exams affiliated with Steward Health Systems.',
            'link_text' => 'Explore Primary Care →',
            'link_url' => '#services',
            'care_model' => 'In-Clinic',
            'order' => 3,
        ]);
        Pillar::create([
            'page' => 'home',
            'image_path' => 'images/vaccine.png',
            'title' => 'Travel Medicine',
            'description' => 'Preparing for international travel? Receive pre-travel medical consultations, mandatory immunizations, and travel advice customized for your destination.',
            'link_text' => 'Schedule Immunization →',
            'link_url' => '#services',
            'care_model' => 'In-Clinic',
            'order' => 4,
        ]);

        Pillar::create([
            'page' => 'philosophy',
            'icon' => '🌐',
            'title' => 'Beyond Borders',
            'description' => "Care shouldn't end at a zip code or clinic wall. We provide physician home visits and international telehealth to meet you anywhere.",
            'order' => 1,
        ]);
        Pillar::create([
            'page' => 'philosophy',
            'icon' => '🛡️',
            'title' => 'Prevention First',
            'description' => 'Preventing an illness before it occurs is always better than treating it after. Early screening and proactive wellness safeguard longevity.',
            'order' => 2,
        ]);
        Pillar::create([
            'page' => 'philosophy',
            'icon' => '🌱',
            'title' => 'Patient Ownership',
            'description' => 'We empower you with lifestyle knowledge and medical understanding so you can take full ownership of your daily health decisions.',
            'order' => 3,
        ]);

        // 5. Doctor Profile & Timelines
        DoctorProfile::truncate();
        DoctorProfile::create([
            'badge' => 'Founder & Medical Director',
            'name' => 'Meet Dr. Jasper I. Ngomba, MD',
            'credentials' => 'Board-Certified in Internal Medicine | Former Critical Care Nurse',
            'quote' => '"Prevention is the best medicine. Being able to access a doctor regardless of your mobility or location means spending more time preventing illness rather than treating it after it occurs."',
            'bio' => "Dr. Ngomba’s healthcare journey uniquely combines decades of hands-on nursing compassion with rigorous medical doctor expertise. After serving as a critical care travel nurse in Massachusetts and Canada, he saw first-hand the urgent need for flexible, home-based primary care and telemedicine.",
            'photo_path' => 'images/doctor.png',
        ]);

        DoctorTimeline::truncate();
        DoctorTimeline::create([
            'year_range' => '1995 - 1997',
            'title' => 'Undergraduate Nursing & Pre-Med',
            'description' => 'Completed Nursing degree and Pre-Med studies at UMass Boston.',
            'order' => 1,
        ]);
        DoctorTimeline::create([
            'year_range' => '2005',
            'title' => 'Doctor of Medicine (MD)',
            'description' => 'Graduated from St. George’s University School of Medicine, West Indies.',
            'order' => 2,
        ]);
        DoctorTimeline::create([
            'year_range' => '2005 - 2010',
            'title' => 'Critical Care Nurse & Residency',
            'description' => 'Flight & travel nurse; completed Internal Medicine Residency at Berkshire Medical Center, MA.',
            'order' => 3,
        ]);
        DoctorTimeline::create([
            'year_range' => '2012 - Present',
            'title' => 'Founded TELLinMedicine, LLC',
            'description' => 'Pioneering doctor home visits & virtual primary care in North Attleboro, MA.',
            'order' => 4,
        ]);

        // 6. Services Suite
        Service::truncate();
        Service::create([
            'category' => 'primary',
            'icon' => '🩺',
            'title' => 'Adult Primary Care',
            'description' => 'Comprehensive health evaluations, routine wellness checkups, and long-term illness management for adults.',
            'features' => ['Chronic Disease Management', 'Blood Pressure & Cholesterol', 'Steward Health System Affiliated'],
            'button_text' => 'Book Primary Visit',
            'care_model' => 'In-Clinic',
            'order' => 1,
        ]);
        Service::create([
            'category' => 'home',
            'icon' => '🏠',
            'title' => 'Physician Home Visits',
            'description' => 'Complete internal medicine care delivered at your home or care facility for individuals with mobility challenges.',
            'features' => ['Home Health Appraisals', 'In-Home Lab & Vitals Checks', 'Personalized Family Care'],
            'button_text' => 'Book Home Visit',
            'care_model' => 'Home Visit',
            'order' => 2,
        ]);
        Service::create([
            'category' => 'telehealth',
            'icon' => '💻',
            'title' => 'World TeleMedicine',
            'description' => 'Virtual video appointments from anywhere in MA or RI. Fast prescription refills and remote advice.',
            'features' => ['Mon-Sat 12 PM - 6 PM', 'HD Secure Video Portal', 'Remote Consultations'],
            'button_text' => 'Start Virtual Visit',
            'care_model' => 'Telehealth',
            'order' => 3,
        ]);
        Service::create([
            'category' => 'primary',
            'icon' => '💉',
            'title' => 'Travel Medicine & Vaccines',
            'description' => 'Pre-travel advice, destination health risk assessment, and mandatory international immunizations.',
            'features' => ['Destination Immunizations', 'Malaria Prophylaxis', 'Pre-Trip Consultations'],
            'button_text' => 'Book Travel Vaccine',
            'care_model' => 'In-Clinic',
            'order' => 4,
        ]);
        Service::create([
            'category' => 'certs',
            'icon' => '🚛',
            'title' => 'DOT Physicals',
            'description' => 'Certified Department of Transportation physical exams for commercial drivers with rapid appointment turnaround.',
            'features' => ['Seen Within 48 Hours', 'Official DOT Certification', 'Fast Medical Forms'],
            'button_text' => 'Schedule DOT Physical',
            'care_model' => 'In-Clinic',
            'order' => 5,
        ]);
        Service::create([
            'category' => 'certs',
            'icon' => '📄',
            'title' => 'Disability & Medical Cards',
            'description' => 'Short & long-term disability evaluations and state medical evaluations for RI and MA patients per state law.',
            'features' => ['RI & MA State Compliant', 'Short/Long-Term Disability', 'Comprehensive Appraisals'],
            'button_text' => 'Request Evaluation',
            'care_model' => 'In-Clinic',
            'order' => 6,
        ]);

        // 7. Education Guides
        EducationGuide::truncate();
        EducationGuide::create([
            'icon' => '❤️',
            'icon_bg' => 'linear-gradient(135deg, #ED174F, #c40d3e)',
            'title' => 'Hypertension & Blood Pressure',
            'description' => 'High blood pressure is often asymptomatic ("the silent thief"). Consistent monitoring, sodium reduction, stress control, and targeted therapy prevent heart disease and stroke.',
            'features' => ['Target BP: Generally under 120/80 mmHg', 'DASH diet rich in potassium & magnesium', 'Routine home blood pressure logs'],
            'order' => 1,
        ]);
        EducationGuide::create([
            'icon' => '🩸',
            'title' => 'Type 2 Diabetes & HbA1c',
            'description' => 'Managing blood glucose safeguards kidney, neurological, and microvascular health. Early glycemic control through dietary balance and medicine preserves organ function.',
            'features' => ['Hemoglobin A1c monitoring every 3-6 months', 'Low glycemic index nutrition planning', 'Annual retinal and diabetic foot evaluations'],
            'order' => 2,
        ]);
        EducationGuide::create([
            'icon' => '🫁',
            'icon_bg' => 'linear-gradient(135deg, #ED174F, #c40d3e)',
            'title' => 'Asthma & COPD Respiratory Care',
            'description' => 'Optimizing lung health through proper inhaler technique, avoiding environmental triggers, annual influenza and pneumococcal vaccination, and emergency action plans.',
            'features' => ['Personalized Asthma Action Plans', 'Peak flow monitoring & trigger management', 'Smoking cessation & air quality awareness'],
            'order' => 3,
        ]);
        EducationGuide::create([
            'icon' => '🥗',
            'title' => 'Lipids & Metabolic Wellness',
            'description' => 'Understanding cholesterol numbers (LDL, HDL, Triglycerides). Managing metabolic syndrome through aerobic activity, plant-focused diets, and lipid-lowering therapies when indicated.',
            'features' => ['Annual fasting lipid panels', 'Heart-healthy Mediterranean diet guidance', 'Cardiovascular risk score calculations'],
            'order' => 4,
        ]);

        // 8. Preventive Checklists
        PreventiveChecklist::truncate();
        PreventiveChecklist::create([
            'title' => 'Adults (Ages 18 - 39)',
            'border_color' => '#1A84C5',
            'items' => [
                'Annual primary care physical wellness exam',
                'Blood pressure evaluation (annual)',
                'Baseline lipid & blood glucose screening',
                'Tdap immunization & booster tracking',
                'Mental health & stress screening',
            ],
            'order' => 1,
        ]);
        PreventiveChecklist::create([
            'title' => 'Adults (Ages 40 - 64)',
            'border_color' => '#ED174F',
            'items' => [
                'Comprehensive annual internal medicine physical',
                'Colorectal cancer screening starting at age 45',
                'Annual HbA1c & fasting lipid evaluation',
                'Mammogram / Prostate screening discussion',
                'Annual Shingles (Shingrix) vaccine at 50+',
            ],
            'order' => 2,
        ]);
        PreventiveChecklist::create([
            'title' => 'Seniors (Ages 65+)',
            'border_color' => '#1A84C5',
            'items' => [
                'Medicare Wellness Exam & medication reconciliation',
                'Pneumococcal & high-dose annual flu vaccines',
                'Bone density (DEXA) osteoporosis screening',
                'Mobility & fall prevention assessment',
                'Home Visit physical evaluation options',
            ],
            'order' => 3,
        ]);

        // 9. Philosophy Content
        PhilosophyContent::truncate();
        PhilosophyContent::create([
            'icon' => '🩺',
            'title' => 'Access Beyond Policy & Beyond Borders',
            'highlight_quote' => '“At TELLinMedicine, LLC, we believe that ‘Access to Health is Access to Wealth.’ Our goal is to take access to health care and health education beyond policy and beyond borders.”',
            'paragraph1' => 'That’s why we offer physician home visits and world telemedicine. Being able to have a relationship with a primary care physician and access to preventive medicine regardless of your mobility or geographic location, means you can spend more time preventing illness rather than treating an illness after it occurs. After all, <strong>prevention is the best medicine</strong>.',
            'paragraph2' => 'We want patients to take ownership of their health, which is why we aim to empower patients with education and knowledge about lifestyle changes that can make a real difference in their health, well-being and longevity.',
            'cta_title' => 'Ready for Person-Centered Care?',
            'cta_text' => 'For compassionate, personalized service and treatment from a doctor who truly cares about you, call Dr. Jasper Ngomba in North Attleboro, Massachusetts at <strong>(617) 513-1446</strong> or use our online appointment request form.',
            'cta_phone_text' => '📞 Call (617) 513-1446',
            'cta_phone_url' => 'tel:6175131446',
            'cta_form_text' => 'Online Appointment Form',
        ]);

        // 10. AI Chat Config & Chips
        ChatWidgetConfig::truncate();
        ChatWidgetConfig::create([
            'assistant_name' => 'MedAssist AI',
            'status_text' => '🟢 Online | TELLinMedicine Assistant',
            'welcome_message' => 'Hello! I am Dr. Ngomba\'s Medical AI Assistant at TELLinMedicine, LLC. How can I help you today?',
            'input_placeholder' => 'Ask about doctor visits, hours, or services...',
        ]);

        ChatChip::truncate();
        ChatChip::create(['label' => '⏰ Clinic Hours', 'prompt' => 'What are your practice working hours?', 'order' => 1]);
        ChatChip::create(['label' => '🏥 Home Visits', 'prompt' => 'Do you offer physician home visits?', 'order' => 2]);
        ChatChip::create(['label' => '✈️ Travel Vaccines', 'prompt' => 'What travel vaccines do you provide?', 'order' => 3]);
        ChatChip::create(['label' => '💻 E-Appointments', 'prompt' => 'How do I book an E-Appointment?', 'order' => 4]);

        // 11. Booking Reasons
        BookingReason::truncate();
        BookingReason::create(['label' => 'Primary Care Checkup', 'value' => 'Primary Care Checkup', 'order' => 1]);
        BookingReason::create(['label' => 'Home Physician Consultation', 'value' => 'Home Physician Consultation', 'order' => 2]);
        BookingReason::create(['label' => 'Telehealth Consultation', 'value' => 'Telehealth Consultation', 'order' => 3]);
        BookingReason::create(['label' => 'Travel Vaccines', 'value' => 'Travel Vaccines', 'order' => 4]);
        BookingReason::create(['label' => 'DOT Physical', 'value' => 'DOT Physical', 'order' => 5]);
        BookingReason::create(['label' => 'Disability / Medical Card Evaluation', 'value' => 'Disability / Medical Card', 'order' => 6]);
    }
}
