@extends('layouts.app')

@section('title', 'Concierge Medicine Plans | TELLinMedicine, LLC')
@section('meta_description', 'Choose the Gold, Platinum, or Diamond Concierge Medicine Plan right for your family. Direct access to Dr. Jasper I. Ngomba, MD, unlimited office visits, home visits & telemedicine.')

@section('content')
  <!-- Hero Section -->
  <section id="hero" class="hero-section">
    <div class="container hero-grid">
      <!-- Hero Text Column -->
      <div class="hero-text">
        <h1 class="hero-title">
          {{ $hero->title ?? "CHOOSE THE PLAN THAT'S" }}
          <span class="text-gradient-crimson">{{ $hero->title_highlight ?? 'RIGHT FOR YOU!' }}</span>
        </h1>
        <p class="hero-subtitle">
          {{ $hero->subtitle ?? "We offer the Gold, Platinum, & Diamond Concierge Medicine plans based on your family's anticipated healthcare needs. No matter the plan you choose, you will be offered quick access to medical care and have the peace of mind that your healthcare is always our #1 priority!" }}
        </p>

        <div class="hero-actions">
          <a href="#plans" class="clay-button clay-button-primary">
            {{ $hero->btn_primary_text ?? '💎 Explore Membership Plans' }}
          </a>
          <button class="clay-button clay-button-secondary js-open-booking" data-care-model="In-Clinic">
            {{ $hero->btn_secondary_text ?? '📅 Schedule Consultation' }}
          </button>
        </div>
      </div>

      <!-- Hero Visual Column -->
      <div class="hero-visual text-center">
        <img src="{{ asset($hero->image_path ?? 'images/concierge_clay_hero_transparent.png') }}" alt="VIP Medical Membership" class="concierge-hero-img-clean">
      </div>
    </div>
  </section>

  <!-- Out-of-Pocket Routine Rates Section -->
  <section class="concierge-rates-section">
    <div class="container">
      <div class="clay-card concierge-rates-card">
        <div class="rates-header text-center mb-4">
          <span class="badge-clay badge-clay-rates">{{ $globalSettings['concierge_rates_badge'] ?? '💡 Non-Membership Standard Rates' }}</span>
          <h2 class="rates-main-title mt-3">{{ $globalSettings['concierge_rates_title'] ?? 'Fee-For-Service Out-of-Pocket Pricing' }}</h2>
          <p class="rates-subtitle">{{ $globalSettings['concierge_rates_subtitle'] ?? 'Pay-per-visit pricing for non-concierge patients. Choosing a membership plan below provides significant savings.' }}</p>
        </div>

        <div class="rates-cards-grid">
          <!-- Rate Box 1 -->
          <div class="rate-box-clay">
            <div>
              <span class="rate-box-badge">{{ $globalSettings['concierge_rate1_badge'] ?? 'Standard Visit' }}</span>
              <div class="rate-box-icon">{{ $globalSettings['concierge_rate1_icon'] ?? '🏥' }}</div>
              <h3 class="rate-box-title">{{ $globalSettings['concierge_rate1_title'] ?? 'Routine Office Visit' }}</h3>
              <div class="rate-box-price">{{ $globalSettings['concierge_rate1_price'] ?? '$200' }} <span class="rate-box-unit">{{ $globalSettings['concierge_rate1_unit'] ?? '/ hour' }}</span></div>
            </div>
            <p class="rate-box-subtext">{{ $globalSettings['concierge_rate1_subtext'] ?? 'In-clinic physician evaluation & consultation' }}</p>
          </div>

          <!-- Rate Box 2 -->
          <div class="rate-box-clay rate-box-highlight">
            <div>
              <span class="rate-box-badge badge-teal">{{ $globalSettings['concierge_rate2_badge'] ?? 'Annual Exam' }}</span>
              <div class="rate-box-icon">{{ $globalSettings['concierge_rate2_icon'] ?? '🩺' }}</div>
              <h3 class="rate-box-title">{{ $globalSettings['concierge_rate2_title'] ?? 'Physical Exam' }}</h3>
              <div class="rate-box-price">{{ $globalSettings['concierge_rate2_price'] ?? '$250' }} <span class="rate-box-unit">{{ $globalSettings['concierge_rate2_unit'] ?? 'per exam' }}</span></div>
            </div>
            <p class="rate-box-subtext">{{ $globalSettings['concierge_rate2_subtext'] ?? 'Comprehensive annual preventive physical evaluation' }}</p>
          </div>

          <!-- Rate Box 3 -->
          <div class="rate-box-clay">
            <div>
              <span class="rate-box-badge badge-crimson">{{ $globalSettings['concierge_rate3_badge'] ?? 'At-Home Care' }}</span>
              <div class="rate-box-icon">{{ $globalSettings['concierge_rate3_icon'] ?? '🏠' }}</div>
              <h3 class="rate-box-title">{{ $globalSettings['concierge_rate3_title'] ?? 'Doctor Home Visits' }}</h3>
              <div class="rate-box-price">{{ $globalSettings['concierge_rate3_price'] ?? '$300 – $500' }} <span class="rate-box-unit">{{ $globalSettings['concierge_rate3_unit'] ?? 'per visit' }}</span></div>
            </div>
            <p class="rate-box-subtext">{{ $globalSettings['concierge_rate3_subtext'] ?? 'Physician house calls delivered directly at your doorstep' }}</p>
          </div>
        </div>

        <!-- Smart Value Banner -->
        <div class="rates-smart-banner mt-4">
          <span class="banner-icon">⚡</span>
          <span><strong>Smart Health Tip:</strong> {{ $globalSettings['concierge_tip_text'] ?? 'All Concierge Membership Plans below include your Yearly Physical Exam ($250 value) plus direct doctor access and multiple visits included for one fixed annual fee!' }}</span>
        </div>
      </div>
    </div>
  </section>

  <!-- Concierge Pricing Plans Section -->
  <section id="plans" class="concierge-plans-section py-5">
    <div class="container">
      <div class="section-header text-center mb-5">
        <span class="badge-clay badge-clay-crimson">{{ $globalSettings['concierge_plans_badge'] ?? 'Concierge Membership Tiers' }}</span>
        <h2 class="section-title mt-2">{{ $globalSettings['concierge_plans_title'] ?? 'Comprehensive Annual Healthcare Plans' }}</h2>
        <p class="section-subtitle">{{ $globalSettings['concierge_plans_subtitle'] ?? 'Select the membership tier tailored to your lifestyle and clinical needs.' }}</p>
      </div>

      <div class="plans-grid">
        <!-- Gold Plan Card -->
        <div class="clay-card plan-card gold-plan-card">
          <div class="plan-header">
            <span class="plan-badge gold-badge">{{ $globalSettings['concierge_gold_badge'] ?? 'Gold Tier' }}</span>
            <h3 class="plan-name">{{ $globalSettings['concierge_gold_name'] ?? 'Gold Plan' }}</h3>
            <div class="plan-price">{{ $globalSettings['concierge_gold_price'] ?? '$2,000' }} <span class="plan-period">{{ $globalSettings['concierge_gold_period'] ?? '/ year' }}</span></div>
            <p class="plan-includes">{{ $globalSettings['concierge_gold_includes'] ?? 'Includes Yearly Physical Exam' }}</p>
          </div>
          <div class="plan-body">
            <ul class="plan-features">
              @php
                $goldRaw = $globalSettings['concierge_gold_features'] ?? '';
                $goldLines = array_filter(array_map('trim', explode("\n", strip_tags($goldRaw, '<strong><em><b><i>'))));
              @endphp
              @if(count($goldLines) > 0)
                @foreach($goldLines as $featureLine)
                  @php
                    preg_match('/^([\x{1F300}-\x{1F9FF}]|[\x{2600}-\x{26FF}]|[\x{2700}-\x{27BF}]|[^a-zA-Z0-9\s<]+)/u', $featureLine, $iconMatches);
                    $icon = !empty($iconMatches[1]) ? trim($iconMatches[1]) : '🩺';
                    $text = !empty($iconMatches[1]) ? trim(mb_substr($featureLine, mb_strlen($iconMatches[1]))) : $featureLine;
                  @endphp
                  <li>
                    <span class="feature-icon">{{ $icon }}</span>
                    <span>{!! $text !!}</span>
                  </li>
                @endforeach
              @else
                <li>
                  <span class="feature-icon">🩺</span>
                  <span><strong>Covers Primary Care:</strong> 10 visits to office per year</span>
                </li>
                <li>
                  <span class="feature-icon">⚡</span>
                  <span><strong>Direct Access</strong> to MD/Provider</span>
                </li>
                <li>
                  <span class="feature-icon">📱</span>
                  <span><strong>5 eTeleMedicine</strong> Mobile/Desktop Video Consultations</span>
                </li>
                <li>
                  <span class="feature-icon">✈️</span>
                  <span><strong>Travel Medicine</strong> & Advisory</span>
                </li>
                <li>
                  <span class="feature-icon">🌍</span>
                  <span><strong>Global Network:</strong> Assist with referral to Provider when you travel</span>
                </li>
              @endif
            </ul>
          </div>
          <div class="plan-footer">
            <div class="spouse-discount">{{ $globalSettings['concierge_gold_spouse_discount'] ?? '*Spouses get 25% discount of individual cost in the same plan.' }}</div>
            <button class="clay-button clay-button-primary w-100 js-open-concierge-modal" data-plan-name="{{ $globalSettings['concierge_gold_name'] ?? 'Gold Plan' }}" data-plan-price="{{ ($globalSettings['concierge_gold_price'] ?? '$2,000') . ' ' . ($globalSettings['concierge_gold_period'] ?? '/ year') }}">
              {{ $globalSettings['concierge_gold_btn_text'] ?? 'Select Gold Plan' }}
            </button>
          </div>
        </div>

        <!-- Platinum Plan Card (Featured) -->
        <div class="clay-card plan-card platinum-plan-card popular-plan">
          <div class="popular-ribbon">{{ $globalSettings['concierge_platinum_ribbon'] ?? '🔥 MOST POPULAR' }}</div>
          <div class="plan-header">
            <span class="plan-badge platinum-badge">{{ $globalSettings['concierge_platinum_badge'] ?? 'Platinum Tier' }}</span>
            <h3 class="plan-name">{{ $globalSettings['concierge_platinum_name'] ?? 'Platinum Plan' }}</h3>
            <div class="plan-price">{{ $globalSettings['concierge_platinum_price'] ?? '$2,500' }} <span class="plan-period">{{ $globalSettings['concierge_platinum_period'] ?? '/ year' }}</span></div>
            <p class="plan-includes">{{ $globalSettings['concierge_platinum_includes'] ?? 'Includes Yearly Physical Exam' }}</p>
          </div>
          <div class="plan-body">
            <ul class="plan-features">
              @php
                $platRaw = $globalSettings['concierge_platinum_features'] ?? '';
                $platLines = array_filter(array_map('trim', explode("\n", strip_tags($platRaw, '<strong><em><b><i>'))));
              @endphp
              @if(count($platLines) > 0)
                @foreach($platLines as $featureLine)
                  @php
                    preg_match('/^([\x{1F300}-\x{1F9FF}]|[\x{2600}-\x{26FF}]|[\x{2700}-\x{27BF}]|[^a-zA-Z0-9\s<]+)/u', $featureLine, $iconMatches);
                    $icon = !empty($iconMatches[1]) ? trim($iconMatches[1]) : '🩺';
                    $text = !empty($iconMatches[1]) ? trim(mb_substr($featureLine, mb_strlen($iconMatches[1]))) : $featureLine;
                  @endphp
                  <li>
                    <span class="feature-icon">{{ $icon }}</span>
                    <span>{!! $text !!}</span>
                  </li>
                @endforeach
              @else
                <li>
                  <span class="feature-icon">🩺</span>
                  <span><strong>Covers Primary Care:</strong> 12 visits to office & request 1 <em>"Doctor in the house visit"</em> per year</span>
                </li>
                <li>
                  <span class="feature-icon">⚡</span>
                  <span><strong>Direct Access</strong> to MD/Provider</span>
                </li>
                <li>
                  <span class="feature-icon">📱</span>
                  <span><strong>10 eTeleMedicine</strong> Mobile/Desktop Video Consultations</span>
                </li>
                <li>
                  <span class="feature-icon">✈️</span>
                  <span><strong>Travel Medicine</strong> & Advisory</span>
                </li>
                <li>
                  <span class="feature-icon">🌍</span>
                  <span><strong>Global Network:</strong> Assist with referral to Provider when you travel</span>
                </li>
              @endif
            </ul>
          </div>
          <div class="plan-footer">
            <div class="spouse-discount">{{ $globalSettings['concierge_platinum_spouse_discount'] ?? '*Spouses get 25% discount of individual cost in the same plan.' }}</div>
            <button class="clay-button clay-button-secondary w-100 js-open-concierge-modal" data-plan-name="{{ $globalSettings['concierge_platinum_name'] ?? 'Platinum Plan' }}" data-plan-price="{{ ($globalSettings['concierge_platinum_price'] ?? '$2,500') . ' ' . ($globalSettings['concierge_platinum_period'] ?? '/ year') }}">
              {{ $globalSettings['concierge_platinum_btn_text'] ?? 'Select Platinum Plan' }}
            </button>
          </div>
        </div>

        <!-- Diamond Plan Card -->
        <div class="clay-card plan-card diamond-plan-card">
          <div class="plan-header">
            <span class="plan-badge diamond-badge">{{ $globalSettings['concierge_diamond_badge'] ?? 'Diamond VIP' }}</span>
            <h3 class="plan-name">{{ $globalSettings['concierge_diamond_name'] ?? 'Diamond Plan' }}</h3>
            <div class="plan-price">{{ $globalSettings['concierge_diamond_price'] ?? '$3,000' }} <span class="plan-period">{{ $globalSettings['concierge_diamond_period'] ?? '/ year' }}</span></div>
            <p class="plan-includes">{{ $globalSettings['concierge_diamond_includes'] ?? 'Includes Yearly Physical Exam' }}</p>
          </div>
          <div class="plan-body">
            <ul class="plan-features">
              @php
                $diamondRaw = $globalSettings['concierge_diamond_features'] ?? '';
                $diamondLines = array_filter(array_map('trim', explode("\n", strip_tags($diamondRaw, '<strong><em><b><i>'))));
              @endphp
              @if(count($diamondLines) > 0)
                @foreach($diamondLines as $featureLine)
                  @php
                    preg_match('/^([\x{1F300}-\x{1F9FF}]|[\x{2600}-\x{26FF}]|[\x{2700}-\x{27BF}]|[^a-zA-Z0-9\s<]+)/u', $featureLine, $iconMatches);
                    $icon = !empty($iconMatches[1]) ? trim($iconMatches[1]) : '🌟';
                    $text = !empty($iconMatches[1]) ? trim(mb_substr($featureLine, mb_strlen($iconMatches[1]))) : $featureLine;
                    $isHighlight = strtolower($icon) === '🥗' || str_contains(strtolower($text), 'weightloss');
                  @endphp
                  <li class="{{ $isHighlight ? 'highlight-feature' : '' }}">
                    <span class="feature-icon">{{ $icon }}</span>
                    <span>{!! $text !!}</span>
                  </li>
                @endforeach
              @else
                <li>
                  <span class="feature-icon">🌟</span>
                  <span><strong>Covers Primary Care:</strong> <strong>Unlimited</strong> office visits & 2 <em>"Doctor in the house visits"</em> per year</span>
                </li>
                <li>
                  <span class="feature-icon">⚡</span>
                  <span><strong>Direct Access</strong> to MD/Provider</span>
                </li>
                <li>
                  <span class="feature-icon">📱</span>
                  <span><strong>20 eTeleMedicine</strong> Mobile/Desktop Video Consultations</span>
                </li>
                <li>
                  <span class="feature-icon">✈️</span>
                  <span><strong>Travel Medicine</strong> & Advisory</span>
                </li>
                <li>
                  <span class="feature-icon">🌍</span>
                  <span><strong>Global Network:</strong> Assist with referral to Provider when you travel</span>
                </li>
                <li class="highlight-feature">
                  <span class="feature-icon">🥗</span>
                  <span><strong>Weightloss Plan for 21 days</strong> included</span>
                </li>
              @endif
            </ul>
          </div>
          <div class="plan-footer">
            <div class="spouse-discount">{{ $globalSettings['concierge_diamond_spouse_discount'] ?? '*Spouses get 25% discount of individual cost in the same plan.' }}</div>
            <button class="clay-button clay-button-primary w-100 js-open-concierge-modal" data-plan-name="{{ $globalSettings['concierge_diamond_name'] ?? 'Diamond Plan' }}" data-plan-price="{{ ($globalSettings['concierge_diamond_price'] ?? '$3,000') . ' ' . ($globalSettings['concierge_diamond_period'] ?? '/ year') }}">
              {{ $globalSettings['concierge_diamond_btn_text'] ?? 'Select Diamond Plan' }}
            </button>
          </div>
        </div>
      </div>

      <!-- Exclusions & Payment Terms Note -->
      <div class="clay-card concierge-terms-card mt-5 p-4">
        <div class="terms-grid">
          <div class="terms-item">
            <span class="terms-icon">⚠️</span>
            <p><strong>Exclusions Note:</strong> {{ $globalSettings['concierge_exclusions_note'] ?? 'Does not cover ER visit, Acute Hospital, Rehab, or Radiology or Lab Test.' }}</p>
          </div>
          <div class="terms-item">
            <span class="terms-icon">💳</span>
            <p><strong>Flexible Payments:</strong> {{ $globalSettings['concierge_payment_note'] ?? 'Major Credit cards and cash are accepted; Payment Plans are available!' }}</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ Section -->
  <section class="concierge-faq-section">
    <div class="container">
      <div class="section-header text-center mb-5">
        <span class="badge-clay badge-clay-crimson">{{ $globalSettings['concierge_faq_badge'] ?? 'Patient Information & FAQs' }}</span>
        <h2 class="section-title mt-2">{{ $globalSettings['concierge_faq_title'] ?? 'Frequently Asked Questions about Concierge Medicine' }}</h2>
        <p class="section-subtitle">{{ $globalSettings['concierge_faq_subtitle'] ?? 'Everything you need to know about our concierge model, coverage, and rapid response standards.' }}</p>
      </div>

      <div class="faq-grid">
        <!-- Clinic Info Card -->
        <div class="clay-card faq-image-card p-4 text-center">
          <div class="faq-card-header mb-3">
            <span class="badge-clay">{{ $globalSettings['concierge_facility_badge'] ?? '📍 Primary Care Facility' }}</span>
          </div>
          <div class="clinic-img-wrapper mb-3">
            <img src="{{ asset($globalSettings['building_image_path'] ?? 'images/1786960015_building.png') }}" alt="TELLinMedicine Clinic Facility" class="faq-clinic-img">
          </div>
          <div class="clinic-info-details">
            <h3 class="clinic-name">{{ $globalSettings['concierge_facility_title'] ?? 'TELLinMedicine Clinic' }}</h3>
            <p class="clinic-address">{{ $globalSettings['concierge_facility_address'] ?? '380 Elm Street Suite 1, North Attleboro, MA 02760' }}</p>
            <div class="clinic-physician mt-3">
              <strong>{{ $globalSettings['concierge_facility_doctor'] ?? 'Dr. Jasper I. Ngomba, MD' }}</strong>
              <div class="physician-title">{{ $globalSettings['concierge_facility_doc_title'] ?? 'Board Certified Internal Medicine' }}</div>
            </div>
            <div class="clinic-hours-pill mt-3">
              <span>{{ $globalSettings['concierge_facility_hours'] ?? '🕒 Mon - Sat: 8 AM - 12 PM (In-Clinic)' }}</span>
            </div>
            <a href="tel:{{ preg_replace('/[^0-9]/', '', $globalSettings['concierge_facility_phone'] ?? '7746436261') }}" class="clay-button clay-button-primary w-100 mt-4">
              {{ $globalSettings['concierge_facility_btn_text'] ?? ('📞 Call Office: ' . ($globalSettings['concierge_facility_phone'] ?? '(774) 643-6261')) }}
            </a>
          </div>
        </div>

        <!-- FAQ Cards Column -->
        <div class="faq-list">
          <!-- FAQ Card 1 -->
          <div class="clay-card faq-card p-4 mb-4">
            <div class="faq-card-top mb-2">
              <span class="faq-badge">{{ $globalSettings['concierge_faq1_badge'] ?? 'Core Care Concept' }}</span>
            </div>
            <h3 class="faq-question">{{ $globalSettings['concierge_faq1_q'] ?? '❓ What is Concierge Medicine?' }}</h3>
            <p class="faq-answer mt-2">
              {{ $globalSettings['concierge_faq1_a'] ?? 'Concierge Medicine is defined as a relationship between a patient and a primary care physician where the patient pays an annual fee directly to your doctor, and in return they become your own personal physician, taking direct responsibility for your healthcare needs.' }}
            </p>
            <div class="faq-highlight-box mt-3 p-3">
              <span><strong>Key Takeaway:</strong> {{ $globalSettings['concierge_faq1_highlight'] ?? 'Concierge medicine is no longer a privilege for only the rich — it is now accessible and affordable for all patients seeking dedicated healthcare access.' }}</span>
            </div>
          </div>

          <!-- FAQ Card 2 -->
          <div class="clay-card faq-card p-4 mb-4">
            <div class="faq-card-top mb-2">
              <span class="faq-badge badge-teal">{{ $globalSettings['concierge_faq2_badge'] ?? 'Coverage & Response' }}</span>
            </div>
            <h3 class="faq-question">{{ $globalSettings['concierge_faq2_q'] ?? '📋 What is covered in the plan?' }}</h3>
            <p class="faq-answer mt-2">
              {{ $globalSettings['concierge_faq2_a'] ?? 'The plan may cover a variety of medical services, screenings and in-office lab tests. Through the "New Age of Telemedicine", a patient may text a picture directly to the provider for review or video conference using our eTeleMedicine software.' }}
            </p>

            <div class="rapid-response-box mt-4 p-4">
              <div class="response-header d-flex align-items-center gap-2 mb-3">
                <h4 class="response-title mb-0">🚀 Our 2-2-2 Rapid Response Plan</h4>
              </div>
              <div class="response-items-grid">
                <div class="response-pill">
                  <span class="pill-badge">Within 2 Min</span>
                  <span class="pill-label">{{ $globalSettings['concierge_rapid_min_text'] ?? 'Video Conference Response' }}</span>
                </div>
                <div class="response-pill">
                  <span class="pill-badge pill-badge-teal">Within 2 Hours</span>
                  <span class="pill-label">{{ $globalSettings['concierge_rapid_hours_text'] ?? 'Phone Call Callback' }}</span>
                </div>
                <div class="response-pill">
                  <span class="pill-badge pill-badge-crimson">Within 2 Days</span>
                  <span class="pill-label">{{ $globalSettings['concierge_rapid_days_text'] ?? 'Schedule In-Office Visit' }}</span>
                </div>
              </div>
              <p class="response-footer-note mt-3 mb-0">{{ $globalSettings['concierge_rapid_footer'] ?? '💡 Designed to save you substantial time, stress, and unnecessary healthcare expenses!' }}</p>
            </div>
          </div>

          <!-- FAQ Card 3 -->
          <div class="clay-card faq-card p-4 mb-4">
            <div class="faq-card-top">
              <span class="faq-badge badge-amber">{{ $globalSettings['concierge_faq3_badge'] ?? 'Insurance & Direct Pay' }}</span>
            </div>
            <h3 class="faq-question">{{ $globalSettings['concierge_faq3_q'] ?? '🛡️ Does a Concierge Medicine Plan take the place of a health insurance plan?' }}</h3>
            <p class="faq-answer mt-2">
              {{ $globalSettings['concierge_faq3_a'] ?? 'Concierge Medicine is not a substitute for health insurance. Concierge Medicine is an alternative medical model, which can offer unlimited office visits. It is a great model for "direct pay" patients, as well as patients with a high deductible insurance plan.' }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Call to Action Banner -->
  <section class="concierge-cta-section">
    <div class="container">
      <div class="clay-card concierge-cta-card p-5 text-center">
        <h2 class="cta-title">{{ $globalSettings['concierge_cta_title'] ?? "Finding the plan that's right for you..." }}</h2>
        <p class="cta-subtitle">
          {{ $globalSettings['concierge_cta_subtitle'] ?? 'Have questions or ready to enroll? Contact Dr. Jasper I. Ngomba, MD directly or request an appointment today.' }}
        </p>
        <div class="cta-actions mt-4">
          <button class="clay-button clay-button-secondary js-open-booking" data-care-model="Concierge Inquiry">
            {{ $globalSettings['concierge_cta_btn1_text'] ?? '📅 Schedule Appointment Now' }}
          </button>
          <a href="{{ $globalSettings['concierge_cta_btn2_url'] ?? 'tel:7746436261' }}" class="clay-button clay-button-primary">
            {{ $globalSettings['concierge_cta_btn2_text'] ?? '📞 Call Office: (774) 643-6261' }}
          </a>
        </div>
      </div>
    </div>
  </section>
@endsection
