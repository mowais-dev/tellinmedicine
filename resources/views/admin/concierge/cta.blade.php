@extends('admin.layouts.admin')

@section('title', 'Concierge Medicine - Bottom Callout')
@section('breadcrumbs')
  <a href="{{ route('admin.dashboard') }}">Admin</a> <span class="separator">/</span> <span>Concierge Medicine</span> <span class="separator">/</span> <span>Bottom Callout</span>
@endsection
@section('page_title', 'Bottom Callout Banner (CTA)')

@section('content')
<div class="page-desc-banner">
  <i class="fa-solid fa-bullseye"></i>
  <p>Manage the headline, subtitle, and action buttons for the callout banner at the bottom of the Concierge Medicine page.</p>
</div>

<div class="card">
  <div class="card-header">
    <h3>Bottom Callout Banner Settings</h3>
  </div>

  <form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Banner Headline</label>
        <input type="text" name="concierge_cta_title" class="form-control" value="{{ $settings['concierge_cta_title'] ?? "Finding the plan that's right for you..." }}">
      </div>

      <div class="form-group">
        <label class="form-label">Primary Button Label</label>
        <input type="text" name="concierge_cta_btn1_text" class="form-control" value="{{ $settings['concierge_cta_btn1_text'] ?? '📅 Schedule Appointment Now' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Secondary Button Label</label>
        <input type="text" name="concierge_cta_btn2_text" class="form-control" value="{{ $settings['concierge_cta_btn2_text'] ?? '📞 Call Office: (774) 643-6261' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Secondary Button URL / Phone Link</label>
        <input type="text" name="concierge_cta_btn2_url" class="form-control" value="{{ $settings['concierge_cta_btn2_url'] ?? 'tel:7746436261' }}">
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Banner Subtitle / Description</label>
      <textarea name="concierge_cta_subtitle" class="form-control" style="min-height: 90px;">{{ $settings['concierge_cta_subtitle'] ?? 'Have questions or ready to enroll? Contact Dr. Jasper I. Ngomba, MD directly or request an appointment today.' }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">💾 Save Bottom Callout Settings</button>
  </form>
</div>
@endsection
