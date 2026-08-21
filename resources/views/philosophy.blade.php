@extends('layouts.app')

@section('title', 'Our Philosophy | TELLinMedicine LLC - Dr. Jasper I. Ngomba, MD')
@section('meta_description', 'Discover the medical philosophy of TELLinMedicine LLC and Dr. Jasper I. Ngomba, MD. We believe Access to Health is Access to Wealth, bringing preventive care beyond borders.')

@section('content')
  <main>
    <!-- Philosophy Banner Hero Section -->
    <section class="hero-section" style="padding: 4rem 0 5rem;">
      <div class="container">
        <div style="max-width: 820px; margin: 0 auto; text-align: center;">
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

    <!-- Main Philosophy Content Section -->
    <section class="services-section" style="padding: 5rem 0; background: #ffffff;">
      <div class="container">
        <div class="clay-card" style="max-width: 920px; margin: 0 auto; padding: 3.5rem 3rem;">

          <div style="margin-bottom: 2.5rem; text-align: center;">
            <div
              style="width: 72px; height: 72px; border-radius: 50%; background: linear-gradient(135deg, #7EA7D1, #1A84C5); color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 1.5rem; box-shadow: 0 8px 20px rgba(26, 132, 197, 0.35);">
              {{ $philosophy->icon ?? '' }}
            </div>
            <h2 class="section-title" style="font-size: 2.2rem; color: #1e293b;">
              {{ $philosophy->title ?? '' }}
            </h2>
          </div>

          <div class="philosophy-body-text" style="font-size: 1.15rem; line-height: 1.85; color: #334155;">

            <!-- Highlight Quote Card -->
            <div class="clay-card"
              style="background: linear-gradient(135deg, #f8fafc, #edf5fa); border-left: 5px solid #1A84C5; padding: 2rem; margin-bottom: 2.5rem; border-radius: 18px;">
              <p
                style="font-size: 1.3rem; font-weight: 800; color: #1A84C5; font-family: 'Outfit', sans-serif; line-height: 1.5; margin: 0;">
                {{ $philosophy->highlight_quote }}
              </p>
            </div>

            <p style="margin-bottom: 1.75rem;">
              {{ $philosophy->paragraph1 }}
            </p>

            <p style="margin-bottom: 2rem;">
              {{ $philosophy->paragraph2 }}
            </p>

            <!-- Call to Action Banner -->
            <div class="clay-card"
              style="background: linear-gradient(135deg, #1A84C5, #126396); color: #ffffff; padding: 2.5rem; border-radius: 24px; text-align: center; margin-top: 3rem;">
              <h3 style="font-size: 1.6rem; font-weight: 800; margin-bottom: 1rem; color: #ffffff;">
                {{ $philosophy->cta_title }}
              </h3>
              <p
                style="font-size: 1.1rem; max-width: 680px; margin: 0 auto 1.75rem; color: rgba(255, 255, 255, 0.95); line-height: 1.6;">
                {{ $philosophy->cta_text }}
              </p>
              <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="{{ $philosophy->cta_phone_url }}" class="clay-button clay-button-secondary"
                  style="background: #ffffff; color: #1A84C5; font-weight: 800; text-decoration: none;">
                  {{ $philosophy->cta_phone_text }}
                </a>
                @if(!empty($philosophy->cta_form_url))
                  <a href="{{ $philosophy->cta_form_url }}" target="_blank" rel="noopener noreferrer" class="clay-button clay-button-primary"
                    style="background: linear-gradient(135deg, #ED174F, #c40d3e); text-decoration: none; text-align: center;">
                    {{ $philosophy->cta_form_text }}
                  </a>
                @else
                  <button class="clay-button clay-button-primary js-open-booking" data-care-model="In-Clinic"
                    style="background: linear-gradient(135deg, #ED174F, #c40d3e);">
                    {{ $philosophy->cta_form_text }}
                  </button>
                @endif
              </div>
            </div>

          </div>

        </div>
      </div>
    </section>

    <!-- Three Pillars Summary Grid -->
    <section class="section-padding" style="background: #f8fafc;">
      <div class="container">
        <div class="section-header text-center">
          <span class="badge-clay">{{ $globalSettings['philosophy_pillars_badge'] }}</span>
          <h2 class="section-title">{{ $globalSettings['philosophy_pillars_title'] }}</h2>
        </div>

        <div class="pillars-grid">
          @foreach($pillars as $idx => $pillar)
            <div class="clay-card pillar-card">
              <div class="pillar-img-box"
                style="{{ $idx % 2 === 1 ? 'background: linear-gradient(135deg, #ED174F, #c40d3e);' : 'background: linear-gradient(135deg, #7EA7D1, #1A84C5);' }} color: #ffffff; font-size: 2.2rem; display: flex; align-items: center; justify-content: center;">
                {{ $pillar->icon }}
              </div>
              <h3 class="pillar-title">{{ $pillar->title }}</h3>
              <p class="pillar-desc">
                {{ $pillar->description }}
              </p>
            </div>
          @endforeach
        </div>
      </div>
    </section>

  </main>
@endsection
