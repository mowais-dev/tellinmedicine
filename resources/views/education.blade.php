@extends('layouts.app')

@section('title', 'Patient Education & Health Hub | TELLinMedicine LLC')
@section('meta_description', 'Empower your health with Patient Education resources from TELLinMedicine LLC and Dr. Jasper I. Ngomba, MD. Interactive health calculators, chronic disease management, and preventive guidelines.')

@section('content')
  <main>
    <!-- Education Hero Banner -->
    <section class="hero-section" style="padding: 4rem 0 5rem;">
      <div class="container">
        <div style="max-width: 860px; margin: 0 auto; text-align: center;">
          <span class="badge-clay" style="margin-bottom: 1.5rem;">{{ $hero->badge ?? '' }}</span>
          <h1 class="hero-title" style="font-size: 3.2rem; margin-bottom: 1.5rem;">
            {{ $hero->title ?? '' }}
            @if(!empty($hero->title_highlight))
              <span class="text-gradient-crimson">{{ $hero->title_highlight }}</span>
            @endif
          </h1>
          <p class="hero-subtitle" style="margin: 0 auto 2rem; font-size: 1.25rem; line-height: 1.6;">
            {{ $hero->subtitle ?? '' }}
          </p>
        </div>
      </div>
    </section>

    <!-- Section 1: Interactive Health Calculator -->
    <section class="section-padding" style="background: #ffffff; padding: 6rem 0;">
      <div class="container">
        <div class="section-header text-center">
          <span class="badge-clay">{{ $globalSettings['bmi_badge'] }}</span>
          <h2 class="section-title">{{ $globalSettings['bmi_title'] }}</h2>
          <p class="section-subtitle">
            {{ $globalSettings['bmi_subtitle'] }}
          </p>
        </div>

        <div class="calculator-card" style="max-width: 900px; margin: 0 auto;">
          <div class="calculator-grid">

            <div>
              <h3 style="font-size: 1.6rem; margin-bottom: 0.75rem;">{{ $globalSettings['bmi_card_title'] }}</h3>
              <p style="color: var(--text-medium); margin-bottom: 1.5rem; font-size: 0.95rem;">
                {{ $globalSettings['bmi_card_desc'] }}
              </p>

              <form id="bmiCalcForm">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                  <div class="form-group">
                    <label class="form-label" for="calcHeight">{{ $globalSettings['bmi_label_height'] }}</label>
                    <input type="number" id="calcHeight" class="clay-input" placeholder="e.g. 175" required min="50"
                      max="250" value="175">
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="calcWeight">{{ $globalSettings['bmi_label_weight'] }}</label>
                    <input type="number" id="calcWeight" class="clay-input" placeholder="e.g. 70" required min="20"
                      max="300" value="70">
                  </div>
                </div>

                <div class="form-group">
                  <label class="form-label" for="calcAge">{{ $globalSettings['bmi_label_age'] }}</label>
                  <input type="number" id="calcAge" class="clay-input" placeholder="e.g. 42" required min="18" max="110"
                    value="42">
                </div>

                <button type="submit" class="clay-button clay-button-primary" style="width: 100%; margin-top: 0.5rem;">
                  {{ $globalSettings['bmi_btn_text'] }}
                </button>
              </form>
            </div>

            <!-- Result Box -->
            <div class="calc-result-box">
              <span class="badge-clay badge-clay-crimson">Your BMI Score</span>
              <div class="calc-num" id="bmiScore">22.9</div>
              <h4 id="bmiCategory" style="font-size: 1.3rem; margin-bottom: 0.75rem; color: var(--primary-teal-dark);">
                Normal Weight</h4>
              <p id="riskAssessment" style="font-size: 0.95rem; color: var(--text-medium); line-height: 1.6;">
                Your BMI falls within a healthy range. Maintaining balanced nutrition and regular physical activity
                supports long-term cardiovascular health.
              </p>
            </div>

          </div>
        </div>
      </div>
    </section>

    <!-- Section 2: Chronic Disease Management & Education Guides -->
    <section class="services-section" style="padding: 6rem 0;">
      <div class="container">
        <div class="section-header text-center">
          <span class="badge-clay" style="background: rgba(255,255,255,0.2); color: #ffffff;">{{ $globalSettings['education_guides_badge'] }}</span>
          <h2 class="section-title" style="color: #ffffff;">{{ $globalSettings['education_guides_title'] }}</h2>
          <p class="section-subtitle" style="color: rgba(255, 255, 255, 0.9);">
            {{ $globalSettings['education_guides_subtitle'] }}
          </p>
        </div>

        <div class="services-grid">
          @foreach($guides as $guide)
            <div class="clay-card service-card">
              <div class="service-header">
                <div class="service-icon" style="{{ $guide->icon_bg ? 'background: ' . $guide->icon_bg . ';' : '' }}">
                  {{ $guide->icon }}
                </div>
                <h3 class="service-title">{{ $guide->title }}</h3>
              </div>
              <div class="service-body">
                <p>{{ $guide->description }}</p>
                @if(!empty($guide->features))
                  <ul style="margin-top: 1rem; padding-left: 1.25rem; font-size: 0.92rem; color: #475569;">
                    @foreach($guide->features as $item)
                      <li>{{ $item }}</li>
                    @endforeach
                  </ul>
                @endif
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>

    <!-- Section 3: Preventive Health Milestones by Age -->
    <section class="section-padding" style="background: #ffffff; padding: 6rem 0;">
      <div class="container">
        <div class="section-header text-center">
          <span class="badge-clay">{{ $globalSettings['education_checklists_badge'] }}</span>
          <h2 class="section-title">{{ $globalSettings['education_checklists_title'] }}</h2>
          <p class="section-subtitle">
            {{ $globalSettings['education_checklists_subtitle'] }}
          </p>
        </div>

        <div
          style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; max-width: 1000px; margin: 0 auto;">

          @foreach($checklists as $chk)
            <div class="clay-card" style="padding: 2.25rem; border-top: 4px solid {{ $chk->border_color }};">
              <h3 style="font-size: 1.3rem; font-weight: 800; color: {{ $chk->border_color }}; margin-bottom: 1rem;">
                {{ $chk->title }}
              </h3>
              @if(!empty($chk->items))
                <ul style="list-style-type: none; padding: 0; font-size: 0.95rem; color: #334155; line-height: 1.8;">
                  @foreach($chk->items as $it)
                    <li>✓ {{ $it }}</li>
                  @endforeach
                </ul>
              @endif
            </div>
          @endforeach

        </div>

        <!-- Appointment Callout -->
        <div style="text-align: center; margin-top: 3.5rem;">
          <p style="font-size: 1.15rem; color: #475569; margin-bottom: 1.5rem;">
            {{ $globalSettings['education_callout_text'] }}
          </p>
          @if(!empty($globalSettings['education_callout_btn_url']))
            <a href="{{ $globalSettings['education_callout_btn_url'] }}" target="_blank" rel="noopener noreferrer" class="clay-button clay-button-primary"
              style="padding: 0.85rem 2.2rem; font-size: 1.05rem; text-decoration: none; display: inline-block;">
              {{ $globalSettings['education_callout_btn_text'] }}
            </a>
          @else
            <button class="clay-button clay-button-primary js-open-booking" data-care-model="Preventive"
              style="padding: 0.85rem 2.2rem; font-size: 1.05rem;">
              {{ $globalSettings['education_callout_btn_text'] }}
            </button>
          @endif
        </div>

      </div>
    </section>

  </main>
@endsection
