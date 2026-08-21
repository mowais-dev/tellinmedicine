@extends('admin.layouts.admin')

@section('title', 'Main - Dashboard')
@section('breadcrumbs')
  <span>Admin</span> <span class="separator">/</span> <span>Main</span> <span class="separator">/</span> <span>Dashboard</span>
@endsection
@section('page_title', 'TELLinMedicine Practice Management Dashboard')

@section('content')
<div class="page-desc-banner">
  <i class="fa-solid fa-gauge-high"></i>
  <p>Welcome to the TELLinMedicine Website Content Manager. Select any section below to manage your website pages, clinical services, patient education guides, doctor profile, or appointment booking options.</p>
</div>

<div class="grid-3" style="margin-bottom: 2rem;">
  <!-- Card 1: Clinical Services -->
  <div class="card" style="margin-bottom: 0; display: flex; align-items: center; justify-content: space-between; border-top: 3px solid #2889C6;">
    <div>
      <h4 style="color: var(--text-muted); font-size: 0.78rem; text-transform: uppercase; font-weight: 800; letter-spacing: 0.08em;">Clinical Services</h4>
      <div style="font-size: 2.4rem; font-weight: 800; color: #1F2D3D; margin-top: 0.3rem; letter-spacing: -0.02em;">{{ $stats['services_count'] }}</div>
      <div style="font-size: 0.75rem; font-weight: 700; color: #2889C6; margin-top: 0.2rem;">Active Offerings</div>
    </div>
    <div style="width: 56px; height: 56px; border-radius: 16px; background: linear-gradient(135deg, #2889C6 0%, #4AA6D8 100%); color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; box-shadow: 0 6px 18px rgba(40, 137, 198, 0.35);">
      <i class="fa-solid fa-stethoscope"></i>
    </div>
  </div>

  <!-- Card 2: Care Pillars -->
  <div class="card" style="margin-bottom: 0; display: flex; align-items: center; justify-content: space-between; border-top: 3px solid #CB0E41;">
    <div>
      <h4 style="color: var(--text-muted); font-size: 0.78rem; text-transform: uppercase; font-weight: 800; letter-spacing: 0.08em;">Care Pillars</h4>
      <div style="font-size: 2.4rem; font-weight: 800; color: #1F2D3D; margin-top: 0.3rem; letter-spacing: -0.02em;">{{ $stats['pillars_count'] }}</div>
      <div style="font-size: 0.75rem; font-weight: 700; color: #CB0E41; margin-top: 0.2rem;">Core Practice Foundations</div>
    </div>
    <div style="width: 56px; height: 56px; border-radius: 16px; background: linear-gradient(135deg, #CB0E41 0%, #E11D48 100%); color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; box-shadow: 0 6px 18px rgba(203, 14, 65, 0.35);">
      <i class="fa-solid fa-layer-group"></i>
    </div>
  </div>

  <!-- Card 3: Education & Checklists -->
  <div class="card" style="margin-bottom: 0; display: flex; align-items: center; justify-content: space-between; border-top: 3px solid #2889C6;">
    <div>
      <h4 style="color: var(--text-muted); font-size: 0.78rem; text-transform: uppercase; font-weight: 800; letter-spacing: 0.08em;">Education & Checklists</h4>
      <div style="font-size: 2.4rem; font-weight: 800; color: #1F2D3D; margin-top: 0.3rem; letter-spacing: -0.02em;">{{ $stats['guides_count'] + $stats['checklists_count'] }}</div>
      <div style="font-size: 0.75rem; font-weight: 700; color: #2889C6; margin-top: 0.2rem;">Patient Health Resources</div>
    </div>
    <div style="width: 56px; height: 56px; border-radius: 16px; background: linear-gradient(135deg, #2889C6 0%, #CB0E41 100%); color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; box-shadow: 0 6px 18px rgba(40, 137, 198, 0.35);">
      <i class="fa-solid fa-book-medical"></i>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <h3>Page-Based Quick Shortcuts</h3>
  </div>

  <div class="grid-3" style="margin-top: 1rem;">
    <a href="{{ route('admin.home.hero') }}" class="btn btn-secondary" style="justify-content: flex-start; padding: 1rem 1.2rem; text-align: left;">
      <i class="fa-solid fa-house" style="color: var(--brand-blue); font-size: 1.2rem;"></i>
      <div>
        <div style="font-weight: 800; font-size: 0.92rem;">Manage Home Page</div>
        <div style="font-size: 0.76rem; font-weight: 500; color: var(--text-muted);">Hero, Services, Pillars, Schedule</div>
      </div>
    </a>

    <a href="{{ route('admin.doctor.profile') }}" class="btn btn-secondary" style="justify-content: flex-start; padding: 1rem 1.2rem; text-align: left;">
      <i class="fa-solid fa-user-doctor" style="color: var(--brand-blue); font-size: 1.2rem;"></i>
      <div>
        <div style="font-weight: 800; font-size: 0.92rem;">Manage Dr. Ngomba</div>
        <div style="font-size: 0.76rem; font-weight: 500; color: var(--text-muted);">Bio Essay & Timeline</div>
      </div>
    </a>

    <a href="{{ route('admin.philosophy.article') }}" class="btn btn-secondary" style="justify-content: flex-start; padding: 1rem 1.2rem; text-align: left;">
      <i class="fa-solid fa-lightbulb" style="color: var(--brand-blue); font-size: 1.2rem;"></i>
      <div>
        <div style="font-weight: 800; font-size: 0.92rem;">Manage Our Philosophy</div>
        <div style="font-size: 0.76rem; font-weight: 500; color: var(--text-muted);">Article Essay & Principles</div>
      </div>
    </a>

    <a href="{{ route('admin.education.hero') }}" class="btn btn-secondary" style="justify-content: flex-start; padding: 1rem 1.2rem; text-align: left;">
      <i class="fa-solid fa-book-medical" style="color: var(--brand-blue); font-size: 1.2rem;"></i>
      <div>
        <div style="font-weight: 800; font-size: 0.92rem;">Manage Patient Education</div>
        <div style="font-size: 0.76rem; font-weight: 500; color: var(--text-muted);">BMI, Guides & Checklists</div>
      </div>
    </a>

    <a href="{{ route('admin.website.footer') }}" class="btn btn-secondary" style="justify-content: flex-start; padding: 1rem 1.2rem; text-align: left;">
      <i class="fa-solid fa-globe" style="color: var(--brand-blue); font-size: 1.2rem;"></i>
      <div>
        <div style="font-weight: 800; font-size: 0.92rem;">Manage Website</div>
        <div style="font-size: 0.76rem; font-weight: 500; color: var(--text-muted);">Marquee, Header, Footer, Media</div>
      </div>
    </a>

    <a href="{{ route('admin.modals.booking') }}" class="btn btn-secondary" style="justify-content: flex-start; padding: 1rem 1.2rem; text-align: left;">
      <i class="fa-solid fa-calendar-check" style="color: var(--brand-blue); font-size: 1.2rem;"></i>
      <div>
        <div style="font-weight: 800; font-size: 0.92rem;">Manage Booking Modal</div>
        <div style="font-size: 0.76rem; font-weight: 500; color: var(--text-muted);">Popup Options & Reasons</div>
      </div>
    </a>

    <a href="{{ route('admin.chat') }}" class="btn btn-secondary" style="justify-content: flex-start; padding: 1rem 1.2rem; text-align: left;">
      <i class="fa-solid fa-robot" style="color: var(--brand-blue); font-size: 1.2rem;"></i>
      <div>
        <div style="font-weight: 800; font-size: 0.92rem;">Manage AI Chat Assistant</div>
        <div style="font-size: 0.76rem; font-weight: 500; color: var(--text-muted);">Greetings & Prompt Chips</div>
      </div>
    </a>
  </div>
</div>
@endsection
