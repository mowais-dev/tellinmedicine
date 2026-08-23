@extends('layouts.app')

@section('title', $globalSettings['site_title'])
@section('meta_description', $globalSettings['site_description'])

@section('content')
  <!-- Hero Section with Floating 3D Clay Medical Visuals -->
  <section id="hero" class="hero-section">
    <div class="container hero-grid">

      <!-- Hero Left Column Text -->
      <div class="hero-text">
        <h1 class="hero-title">
          {{ $hero->title ?? '' }}
          @if(!empty($hero->title_highlight))
            <span class="text-gradient-crimson">{{ $hero->title_highlight }}</span>
          @endif
        </h1>
        <p class="hero-subtitle">
          {{ $hero->subtitle ?? '' }}
        </p>

        <div class="hero-actions">
          @if(!empty($hero->primary_button_url))
            <a href="{{ $hero->primary_button_url }}" target="_blank" rel="noopener noreferrer" class="clay-button clay-button-primary" style="text-decoration: none; text-align: center;">
              {{ $hero->primary_button_text ?? '' }}
            </a>
          @else
            <button class="clay-button clay-button-primary js-open-booking" data-care-model="{{ $hero->primary_button_model ?? 'In-Clinic' }}">
              {{ $hero->primary_button_text ?? '' }}
            </button>
          @endif

          @if(!empty($hero->secondary_button_url))
            <a href="{{ $hero->secondary_button_url }}" target="_blank" rel="noopener noreferrer" class="clay-button clay-button-secondary" style="text-decoration: none; text-align: center;">
              {{ $hero->secondary_button_text ?? '' }}
            </a>
          @else
            <button class="clay-button clay-button-secondary js-open-booking" data-care-model="{{ $hero->secondary_button_model ?? 'Home Visit' }}">
              {{ $hero->secondary_button_text ?? '' }}
            </button>
          @endif
        </div>
      </div>

      <!-- Hero Right Column Visual Stage (3D Clay Syringe + Floating Elements) -->
      <div class="hero-visual-stage">

        <!-- Hero Main Floating 3D Syringe Frame (Replacing Doctor Photo) -->
        <div class="hero-syringe-frame">
          <div class="hero-rotation-wrapper" style="transform: rotate({{ $hero->image_rotation ?? 0 }}deg); display: inline-flex; align-items: center; justify-content: center; width: 100%; height: 100%; transition: transform 0.3s ease;">
            <img src="{{ asset($hero->image_path ?? 'images/hero_syringe.png') }}" alt="3D Floating Medical Injection Syringe" class="hero-syringe-img">
          </div>
        </div>

      </div>

    </div>
  </section>

  <!-- 4 Core Pillars of Care Section -->
  <section id="pillars" class="pillars-section">
    <div class="container">

      <div class="section-header">
        <span class="badge-clay">{{ $globalSettings['pillars_badge'] }}</span>
        <h2 class="section-title">{{ $globalSettings['pillars_title'] }}</h2>
        <p class="section-subtitle">
          {{ $globalSettings['pillars_subtitle'] }}
        </p>
      </div>

      <div class="pillars-grid">
        @foreach($pillars as $pillar)
          <div class="clay-card pillar-card">
            <div class="pillar-img-box">
              <img src="{{ asset($pillar->image_path) }}" alt="{{ $pillar->title }} 3D Clay Illustration" class="pillar-3d-img">
            </div>
            <h3 class="pillar-title">{{ $pillar->title }}</h3>
            <p class="pillar-desc">{{ $pillar->description }}</p>
            @if(!empty($pillar->link_url))
              <a href="{{ $pillar->link_url }}" target="_blank" rel="noopener noreferrer" class="pillar-link">
                {{ $pillar->link_text }}
              </a>
            @else
              <a href="javascript:void(0)" class="pillar-link js-open-booking" data-care-model="{{ $pillar->care_model }}">
                {{ $pillar->link_text }}
              </a>
            @endif
          </div>
        @endforeach
      </div>

    </div>
  </section>

  <!-- Practice Working Hours & Availability Schedule Section -->
  <section id="hours" class="hours-section">
    <div class="container">

      <div class="section-header">
        <span class="badge-clay">{{ $globalSettings['schedule_badge'] }}</span>
        <h2 class="section-title">{{ $globalSettings['schedule_title'] }}</h2>
        <p class="section-subtitle">
          {{ $globalSettings['schedule_subtitle'] }}
        </p>
      </div>

      <div class="calendar-clay-wrapper">
        <div class="calendar-layout-grid">

          <!-- Left Column: 3D Interactive Clay Calendar -->
          <div class="calendar-widget-card">
            <div class="calendar-header-nav">
              <button class="cal-nav-btn" id="prevMonthBtn" aria-label="Previous Month">‹</button>
              <h3 class="cal-month-title" id="calMonthTitle">August 2026</h3>
              <button class="cal-nav-btn" id="nextMonthBtn" aria-label="Next Month">›</button>
            </div>

            <div class="calendar-weekdays">
              <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
            </div>

            <div class="calendar-days-grid" id="calendarDaysGrid">
              <!-- Dynamically rendered by JS -->
            </div>
          </div>

          <!-- Right Column: Direct Interactive Booking Inspector -->
          <div class="day-inspector-card" id="dayInspectorCard" style="justify-content: flex-start;">
            <div class="inspector-header">
              <div class="inspector-date-box">
                <span class="badge-day-type" id="inspectorDayType">In-Clinic & Virtual</span>
                <h3 class="inspector-date-title" id="inspectorDateTitle">Select a Date</h3>
              </div>
              <div class="inspector-status-indicator" id="inspectorStatusIndicator">
                🟢 Open for Bookings
              </div>
            </div>

            <form id="inlineScheduleForm" style="margin-top: 0.5rem;">
              @csrf
              <input type="hidden" id="inlineSelectedDate" name="appointment_date">
              <input type="hidden" id="inlineSelectedCareModel" name="care_model" value="In-Clinic">

              <label class="form-label" style="margin-bottom: 0.4rem; font-size: 0.82rem; font-weight: 700;">{{ $globalSettings['booking_care_label'] ?? '' }}</label>
              <div class="care-option-grid inline-care-grid" style="margin-bottom: 0.85rem; gap: 0.6rem;">
                <div class="care-option-card inline-care-card selected" data-value="{{ $globalSettings['booking_model_in_clinic'] ?? 'In-Clinic' }}" style="padding: 0.6rem 0.4rem;">
                  <div class="care-option-icon" style="font-size: 1.1rem; margin-bottom: 0.2rem;">🏥</div>
                  <div class="care-option-title" style="font-size: 0.78rem;">{{ $globalSettings['booking_model_in_clinic'] ?? 'In-Clinic' }}</div>
                </div>
                <div class="care-option-card inline-care-card" data-value="{{ $globalSettings['booking_model_home'] ?? 'Home Visit' }}" style="padding: 0.6rem 0.4rem;">
                  <div class="care-option-icon" style="font-size: 1.1rem; margin-bottom: 0.2rem;">🏠</div>
                  <div class="care-option-title" style="font-size: 0.78rem;">{{ $globalSettings['booking_model_home'] ?? 'Home Visit' }}</div>
                </div>
                <div class="care-option-card inline-care-card" data-value="{{ $globalSettings['booking_model_telehealth'] ?? 'E-Appointments' }}" style="padding: 0.6rem 0.4rem;">
                  <div class="care-option-icon" style="font-size: 1.1rem; margin-bottom: 0.2rem;">💻</div>
                  <div class="care-option-title" style="font-size: 0.78rem;">{{ $globalSettings['booking_model_telehealth'] ?? 'E-Appointments' }}</div>
                </div>
              </div>

              <!-- Home Visit Eligibility Section (shown when Home Visit is selected) -->
              <div class="home-visit-eligibility-wrapper" style="display: none; margin-bottom: 0.85rem;">
                <div class="home-visit-notice-box" style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 8px; padding: 0.65rem 0.8rem; font-size: 0.78rem; color: #0369a1; margin-bottom: 0.75rem; line-height: 1.4;">
                  🏠 <strong>Home Visit Criteria:</strong> Physician Home Visits are exclusively available for seniors <strong>(Age 65+)</strong> or <strong>individuals with disabilities</strong>.
                </div>

                <div class="form-group" style="margin-bottom: 0.75rem;">
                  <label style="font-size: 0.8rem; cursor: pointer; display: flex; align-items: center; gap: 0.4rem; color: var(--text-dark); font-weight: 600;">
                    <input type="checkbox" name="is_disabled" value="1" class="home-visit-disabled-check" style="width: 16px; height: 16px; cursor: pointer; accent-color: var(--brand-blue);">
                    Patient has a disability or mobility limitation
                  </label>
                </div>

                <div class="home-visit-ineligible-msg" style="display: none; background: #fff1f2; border: 1px solid #fecdd3; border-radius: 8px; padding: 0.65rem 0.8rem; font-size: 0.78rem; color: #be123c; line-height: 1.4;">
                  ⚠️ <strong>Notice:</strong> Physician Home Visits are exclusively provided for patients aged 65 or older, or individuals with disabilities. If you do not meet these criteria, please select <strong>In-Clinic Visit</strong> or <strong>E-Appointments</strong>.
                </div>
              </div>

              <div class="standard-booking-fields">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 0.75rem;">
                  <div class="form-group" style="margin: 0;">
                    <label class="form-label" style="font-size: 0.8rem;">{{ $globalSettings['booking_label_name'] ?? '' }}</label>
                    <input type="text" name="patient_name" class="clay-input" placeholder="{{ $globalSettings['booking_placeholder_name'] ?? '' }}" required style="padding: 0.55rem 0.85rem; font-size: 0.88rem;">
                  </div>
                  <div class="form-group" style="margin: 0;">
                    <label class="form-label" style="font-size: 0.8rem;">{{ $globalSettings['booking_label_phone'] ?? '' }}</label>
                    <input type="tel" name="patient_phone" class="clay-input" placeholder="{{ $globalSettings['booking_placeholder_phone'] ?? '' }}" required style="padding: 0.55rem 0.85rem; font-size: 0.88rem;">
                  </div>
                </div>

                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 0.75rem; margin-bottom: 0.75rem;">
                  <div class="form-group" style="margin: 0;">
                    <label class="form-label" style="font-size: 0.8rem;">{{ $globalSettings['booking_label_email'] ?? '' }}</label>
                    <input type="email" name="patient_email" class="clay-input" placeholder="{{ $globalSettings['booking_placeholder_email'] ?? '' }}" required style="padding: 0.55rem 0.85rem; font-size: 0.88rem;">
                  </div>
                  <div class="form-group" style="margin: 0;">
                    <label class="form-label" style="font-size: 0.8rem;">Patient Age *</label>
                    <input type="number" name="patient_age" class="clay-input home-visit-age-input" placeholder="e.g. 45" min="1" max="120" required style="padding: 0.55rem 0.85rem; font-size: 0.85rem;">
                  </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 1rem;">
                  <div class="form-group" style="margin: 0;">
                    <label class="form-label" style="font-size: 0.8rem;">Preferred Time Slot</label>
                    <select id="inlineTimeSlotSelect" name="time_slot" class="clay-input" required style="padding: 0.55rem 0.85rem; font-size: 0.85rem; cursor: pointer;">
                      <!-- Dynamically filled by JS -->
                    </select>
                  </div>
                  <div class="form-group" style="margin: 0;">
                    <label class="form-label" style="font-size: 0.8rem;">{{ $globalSettings['booking_label_reason'] ?? '' }}</label>
                    <select name="reason" class="clay-input redirect-option-select reason-select-box" style="padding: 0.55rem 0.85rem; font-size: 0.85rem; cursor: pointer;">
                      <option value="">-- Select Reason for Visit --</option>
                      @foreach($bookingReasons as $reason)
                        <option value="{{ $reason->label }}" data-redirect-url="{{ $reason->redirect_url }}">{{ $reason->label }}</option>
                      @endforeach
                      @if(!$bookingReasons->contains(function($r){ return strtolower($r->value) === 'other' || str_contains(strtolower($r->label), 'other'); }))
                        <option value="other">Other (Please specify)</option>
                      @endif
                    </select>
                  </div>

                  <div class="other-reason-wrapper" style="display: none; grid-column: 1 / -1; margin-top: 0.6rem; width: 100%;">
                    <label class="form-label" style="font-size: 0.78rem; color: var(--brand-blue-hover);">Please specify your reason:</label>
                    <input type="text" name="other_reason" class="clay-input other-reason-input" placeholder="Type your specific reason for visit here..." style="padding: 0.55rem 0.85rem; font-size: 0.85rem; width: 100%;">
                  </div>
                </div>

                <button type="submit" id="inlineSubmitBtn" class="clay-button clay-button-primary" style="width: 100%; padding: 0.75rem; font-size: 0.95rem;">
                  {{ $globalSettings['booking_btn_text'] ?? '' }} (<span id="inlineBtnDateText">Selected Date</span>)
                </button>
              </div>
            </form>

          </div>

        </div>
      </div>

    </div>
  </section>

  <!-- Meet Dr. Jasper Ngomba Section -->
  <section id="doctor" class="doctor-section">
    <div class="container">
      <div class="doctor-grid">

        <!-- Left: Doctor Card with doctor.png -->
        <div class="doctor-portrait-box">
          <div class="clay-card doctor-main-card">
            <img src="{{ asset($doctor->photo_path ?? 'images/doctor.png') }}" alt="{{ $doctor->name ?? '' }}" class="doctor-portrait-img">
          </div>
        </div>

        <!-- Right: Bio & Timeline -->
        <div class="doctor-bio-content">
          <span class="badge-clay badge-clay-crimson">{{ $doctor->badge ?? '' }}</span>
          <h2>{{ $doctor->name ?? '' }}</h2>
          <div class="doctor-credentials">
            {{ $doctor->credentials ?? '' }}
          </div>

          <div class="doctor-quote-box">
            {{ $doctor->quote }}
          </div>

          <p style="color: var(--text-medium); margin-bottom: 1.5rem;">
            {{ $doctor->bio }}
          </p>

          <!-- Career Timeline -->
          <div class="timeline-container">
            @foreach($timelines as $item)
              <div class="timeline-item">
                <span class="timeline-year">{{ $item->year_range }}</span>
                <div class="timeline-text">
                  <h4>{{ $item->title }}</h4>
                  <p>{{ $item->description }}</p>
                </div>
              </div>
            @endforeach
          </div>

        </div>

      </div>
    </div>
  </section>

  <!-- Full Services Suite Section -->
  <section id="services" class="services-section">
    <div class="container">

      <div class="section-header">
        <span class="badge-clay">{{ $globalSettings['services_badge'] }}</span>
        <h2 class="section-title">{{ $globalSettings['services_title'] }}</h2>
        <p class="section-subtitle">
          {{ $globalSettings['services_subtitle'] }}
        </p>
      </div>

      <!-- Category Filter Tabs -->
      <div class="service-tabs">
        @foreach($serviceCategories as $idx => $cat)
          <button class="tab-btn {{ $idx === 0 ? 'active' : '' }}" data-filter="{{ $cat->key }}">{{ $cat->label }}</button>
        @endforeach
      </div>

      <!-- Services Grid -->
      <div class="services-grid">

        @foreach($services as $service)
          <div class="clay-card service-card" data-category="{{ $service->category }}">
            <div class="service-header">
              <div class="service-icon">{{ $service->icon }}</div>
              <h3 class="service-title">{{ $service->title }}</h3>
            </div>
            <p class="service-body">
              {{ $service->description }}
            </p>
            @if(!empty($service->features))
              <ul class="service-features">
                @foreach($service->features as $feat)
                  <li>✓ {{ $feat }}</li>
                @endforeach
              </ul>
            @endif
            @if(!empty($service->button_url))
              <a href="{{ $service->button_url }}" target="_blank" rel="noopener noreferrer" class="clay-button clay-button-secondary" style="text-decoration: none; text-align: center;">
                {{ $service->button_text }}
              </a>
            @else
              <button class="clay-button clay-button-secondary js-open-booking" data-care-model="{{ $service->care_model }}">
                {{ $service->button_text }}
              </button>
            @endif
          </div>
        @endforeach

      </div>

    </div>
  </section>

  <!-- Our Specialists Section -->
  <section id="specialists" style="padding: 6rem 0; background: #e6eff5;">
    <div class="container">

      <div class="section-header text-center" style="text-align: center; max-width: 720px; margin: 0 auto 3.5rem;">
        @if(!empty($globalSettings['specialists_badge']))
          <span class="badge-clay">{{ $globalSettings['specialists_badge'] }}</span>
        @endif
        <h2 class="section-title" style="color: #0f172a; font-size: 2.5rem; font-weight: 800; margin-top: 0.75rem; margin-bottom: 1rem;">{{ $globalSettings['specialists_title'] ?? 'Meet Our Specialists' }}</h2>
        @if(!empty($globalSettings['specialists_subtitle']))
          <p class="section-subtitle" style="color: #475569; font-size: 1.05rem; line-height: 1.6;">
            {{ $globalSettings['specialists_subtitle'] }}
          </p>
        @endif
      </div>

      @if(!empty($specialists) && count($specialists) > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(310px, 1fr)); gap: 2rem; margin-top: 3.5rem;">
          @foreach($specialists as $spec)
            <div class="clay-card specialist-card" style="padding: 2rem; display: flex; flex-direction: column; align-items: center; text-align: center; height: 100%; transition: transform 0.3s ease, box-shadow 0.3s ease;">
              
              <!-- Specialist Avatar Container -->
              <div style="width: 130px; height: 130px; border-radius: 50%; overflow: hidden; margin-bottom: 1.25rem; border: 4px solid #ffffff; box-shadow: 0 10px 25px rgba(26, 132, 197, 0.18); background: #f0f9ff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                @if(!empty($spec->image))
                  <img src="{{ asset($spec->image) }}" alt="{{ $spec->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                  <span style="font-size: 3rem;">🩺</span>
                @endif
              </div>

              <!-- Qualifications Badge -->
              @if(!empty($spec->qualifications))
                <span class="badge-clay" style="font-size: 0.75rem; padding: 0.25rem 0.75rem; margin-bottom: 0.75rem; background: #e0f2fe; color: #0369a1; border-color: #bae6fd;">
                  {{ $spec->qualifications }}
                </span>
              @endif

              <!-- Name & Title -->
              <h3 style="font-size: 1.35rem; font-weight: 800; color: #0B5382; margin-bottom: 0.35rem;">
                {{ $spec->name }}
              </h3>

              <div style="font-size: 0.92rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem;">
                {{ $spec->title }}
              </div>

              <!-- Description / Details -->
              @if(!empty($spec->description))
                <p style="font-size: 0.88rem; color: #475569; line-height: 1.6; margin-bottom: 0;">
                  {{ $spec->description }}
                </p>
              @endif
            </div>
          @endforeach
        </div>
      @endif

    </div>
  </section>

  <!-- Concierge Medicine Teaser Banner Section (Full Width, Increase Height, Gold Hover) -->
  <section id="concierge-banner" class="concierge-teaser-section">
    <a href="{{ url('/concierge') }}" class="concierge-teaser-card">
      <div class="teaser-content-wrapper">
        
        <!-- Left Column: Icon + Text -->
        <div class="teaser-left">
          <div class="teaser-icon-box">
            💎
          </div>
          <div class="teaser-text-box">
            <span class="teaser-badge">
              VIP CARE MEMBERSHIP
            </span>
            <h3 class="teaser-title">
              Concierge Medicine & Direct Primary Care
            </h3>
            <p class="teaser-subtitle">
              Unlimited office visits, 24/7 direct physician access, zero wait times & annual wellness packages.
            </p>
          </div>
        </div>

        <!-- Right Column: Button -->
        <div class="teaser-right">
          <span class="clay-button clay-button-secondary teaser-btn">
            <span>Explore Concierge Plans</span> ➔
          </span>
        </div>

      </div>
    </a>
  </section>

  <!-- Contact & Location Section -->
  <section id="contact" style="padding: 6rem 0; background: var(--clay-card-bg);">
    <div class="container">

      <div class="section-header text-center" style="text-align: center; max-width: 720px; margin: 0 auto 3.5rem;">
        <span class="badge-clay" >{{ $globalSettings['contact_badge'] }}</span>
        <h2 class="section-title" style="color: #0f172a; font-size: 2.5rem; font-weight: 800; margin-top: 0.75rem; margin-bottom: 1rem;">{{ $globalSettings['contact_title'] }}</h2>
        <p class="section-subtitle" style="color: #475569; font-size: 1.05rem; line-height: 1.6;">
          {{ $globalSettings['contact_subtitle'] }}
        </p>
      </div>

      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2.5rem; margin-top: 3rem;">

        <!-- Contact Information Cards -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
          <div class="clay-card" style="padding: 2rem;">
            <h3 style="font-size: 1.4rem; font-weight: 800; color: #0f172a; margin-bottom: 1.25rem;">{{ $globalSettings['contact_card_title'] }}</h3>

            <div class="contact-detail-item" style="margin-bottom: 1rem;">
              <div class="service-icon">📍</div>
              <div class="contact-detail-text">
                <h4>Practice Address</h4>
                <p>{{ $globalSettings['address'] }}</p>
              </div>
            </div>

            <div class="contact-detail-item" style="margin-bottom: 1rem;">
              <div class="service-icon">📞</div>
              <div class="contact-detail-text">
                <h4>Phone Numbers</h4>
                <p>{{ $globalSettings['phone_primary'] }} &nbsp;|&nbsp; {{ $globalSettings['phone_secondary'] }}</p>
              </div>
            </div>

            <div class="contact-detail-item" style="margin-bottom: 1rem;">
              <div class="service-icon">✉️</div>
              <div class="contact-detail-text">
                <h4>Email Address</h4>
                <p>{{ $globalSettings['email'] }}</p>
              </div>
            </div>

            <div class="contact-detail-item">
              <div class="service-icon">⏰</div>
              <div class="contact-detail-text">
                <h4>Working Hours</h4>
                <p>{{ $globalSettings['hours_clinic_text'] }}</p>
                <p>{{ $globalSettings['hours_telehealth_text'] }}</p>
                <p>{{ $globalSettings['hours_sunday_text'] }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Quick Message Form -->
        <div class="clay-card" style="padding: 2.5rem;">
          <h3 style="font-size: 1.6rem; margin-bottom: 1.5rem;">{{ $globalSettings['contact_form_title'] }}</h3>

          <form id="contactMsgForm"
            onsubmit="event.preventDefault(); alert('Thank you! Your message has been sent to Dr. Ngomba\'s office.'); this.reset();">
            @csrf
            <div class="form-group">
              <label class="form-label">{{ $globalSettings['contact_form_label_name'] }}</label>
              <input type="text" class="clay-input" placeholder="e.g. Sarah Jenkins" required>
            </div>
            <div class="form-group">
              <label class="form-label">{{ $globalSettings['contact_form_label_contact'] }}</label>
              <input type="text" class="clay-input" placeholder="e.g. sarah@example.com or (508) 555-0199" required>
            </div>

            <div class="form-group">
              <label class="form-label">{{ $globalSettings['contact_form_label_msg'] }}</label>
              <textarea class="clay-input" rows="4"
                placeholder="Briefly describe your health query or appointment request..." required
                style="resize: vertical;"></textarea>
            </div>

            <button type="submit" class="clay-button clay-button-primary" style="width: 100%;">
              {{ $globalSettings['contact_form_btn_text'] }}
            </button>
          </form>
        </div>

      </div>
    </div>
  </section>

  <!-- Practice Address & Interactive Location Map Section (Seamless Edge-to-Edge 50/50 Split) -->
  <section id="location-map" style="padding: 0; margin: 0; background: #f8fafc; overflow: hidden; border-top: 1px solid #e2e8f0;">
    <div style="padding: 0; margin: 0; width: 100%; max-width: 100%;">
      
      <!-- 50 / 50 Seamless Split Grid Layout: Google Map Left | Building Image Right -->
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 0; width: 100%; margin: 0; padding: 0; align-items: stretch;">

        <!-- Left Half: Full Google Map (Decreased Height to 380px) -->
        <div style="width: 100%; height: 380px; margin: 0; padding: 0; overflow: hidden; position: relative;">
          @php
            $mapUrl = !empty($globalSettings['google_map_embed_url']) 
              ? $globalSettings['google_map_embed_url'] 
              : 'https://maps.google.com/maps?q=' . urlencode($globalSettings['address'] ?? 'Framingham, MA') . '&t=&z=15&ie=UTF8&iwloc=&output=embed';
          @endphp
          <iframe 
            src="{{ $mapUrl }}" 
            width="100%" 
            height="100%" 
            style="border:0; margin:0; padding:0; width: 100%; height: 100%; display: block;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </div>

        <!-- Right Half: Full Building Image with Top Glassmorphic Facility Badge & Bottom Address Overlay -->
        <div style="width: 100%; height: 380px; margin: 0; padding: 0; overflow: hidden; position: relative; background: #e0f2fe;">
          <img 
            src="{{ asset($globalSettings['building_image_path'] ?? 'images/home.png') }}" 
            alt="Clinic Facility Building" 
            style="width: 100%; height: 100%; object-fit: cover; display: block; margin: 0; padding: 0;">

          <!-- Container Layer -->
          <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0, 0, 0, 0.65) 0%, rgba(0, 0, 0, 0) 55%); display: flex; flex-direction: column; justify-content: space-between; padding: 1.5rem;">
            
            <!-- Top Glassmorphic Facility Badge with Backdrop Filter Blur -->
            @if(!empty($globalSettings['contact_facility_badge']))
              <div style="align-self: flex-start; background: rgba(255, 255, 255, 0.25); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); border: 1.5px solid rgba(255, 255, 255, 0.6); color: #ffffff; padding: 0.4rem 0.95rem; border-radius: 20px; font-size: 0.82rem; font-weight: 800; text-shadow: 0 1px 3px rgba(0,0,0,0.5); display: flex; align-items: center; gap: 0.4rem;">
                {{ $globalSettings['contact_facility_badge'] }}
              </div>
            @endif

            <!-- Bottom Content: Clinic Title & Address -->
            <div style="color: #ffffff;">
              <h3 style="font-size: 1.35rem; font-weight: 800; color: #ffffff; margin-bottom: 0.3rem; text-shadow: 0 2px 6px rgba(0,0,0,0.9);">
                {{ $globalSettings['contact_building_title'] ?? (($globalSettings['brand_name'] ?? 'TELLin') . ' Clinic') }}
              </h3>

              <p style="font-size: 0.92rem; color: #ffffff; font-weight: 600; line-height: 1.4; margin: 0; text-shadow: 0 2px 5px rgba(0,0,0,0.9);">
                {{ $globalSettings['address'] ?? 'Framingham, MA' }}
              </p>
            </div>

          </div>
        </div>

      </div>

    </div>
  </section>
@endsection
