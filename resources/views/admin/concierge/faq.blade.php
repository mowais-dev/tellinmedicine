@extends('admin.layouts.admin')

@section('title', 'Concierge Medicine - FAQs & Facility')
@section('breadcrumbs')
  <a href="{{ route('admin.dashboard') }}">Admin</a> <span class="separator">/</span> <span>Concierge Medicine</span> <span class="separator">/</span> <span>FAQs & Facility</span>
@endsection
@section('page_title', 'Concierge FAQs & Facility Info Card')

@section('content')
<div class="page-desc-banner">
  <i class="fa-solid fa-circle-question"></i>
  <p>Manage the Concierge page FAQs, the 2-2-2 Rapid Response Plan parameters, and the primary care facility card sidebar.</p>
</div>

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
  @csrf

  <!-- Section Header -->
  <div class="card mb-4">
    <div class="card-header">
      <h3>Section Header & Titles</h3>
    </div>
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Badge Pill Label</label>
        <input type="text" name="concierge_faq_badge" class="form-control" value="{{ $settings['concierge_faq_badge'] ?? 'Patient Information & FAQs' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Main Section Heading</label>
        <input type="text" name="concierge_faq_title" class="form-control" value="{{ $settings['concierge_faq_title'] ?? 'Frequently Asked Questions about Concierge Medicine' }}">
      </div>
    </div>
    <div class="form-group">
      <label class="form-label">Subheading Description</label>
      <input type="text" name="concierge_faq_subtitle" class="form-control" value="{{ $settings['concierge_faq_subtitle'] ?? 'Everything you need to know about our concierge model, coverage, and rapid response standards.' }}">
    </div>
  </div>

  <!-- Primary Care Facility Sidebar Card -->
  <div class="card mb-4">
    <div class="card-header">
      <h3>Primary Care Facility Sidebar Card</h3>
    </div>
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Badge Label</label>
        <input type="text" name="concierge_facility_badge" class="form-control" value="{{ $settings['concierge_facility_badge'] ?? '📍 Primary Care Facility' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Facility Building Image</label>
        <input type="file" name="building_image_file" class="form-control" accept="image/*">
        @if(!empty($settings['building_image_path']))
          <div style="margin-top: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <img src="{{ asset($settings['building_image_path']) }}" alt="Building Photo" style="height: 45px; border-radius: 6px; border: 1px solid #cbd5e1;">
            <span style="font-size: 0.8rem; color: var(--text-muted);">Current Photo</span>
          </div>
        @endif
      </div>
      <div class="form-group">
        <label class="form-label">Clinic Name</label>
        <input type="text" name="concierge_facility_title" class="form-control" value="{{ $settings['concierge_facility_title'] ?? 'TELLinMedicine Clinic' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Clinic Address</label>
        <input type="text" name="concierge_facility_address" class="form-control" value="{{ $settings['concierge_facility_address'] ?? '380 Elm Street Suite 1, North Attleboro, MA 02760' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Lead Physician Name</label>
        <input type="text" name="concierge_facility_doctor" class="form-control" value="{{ $settings['concierge_facility_doctor'] ?? 'Dr. Jasper I. Ngomba, MD' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Physician Title / Credential</label>
        <input type="text" name="concierge_facility_doc_title" class="form-control" value="{{ $settings['concierge_facility_doc_title'] ?? 'Board Certified Internal Medicine' }}">
      </div>
      <div class="form-group">
        <label class="form-label">In-Clinic Hours Pill</label>
        <input type="text" name="concierge_facility_hours" class="form-control" value="{{ $settings['concierge_facility_hours'] ?? '🕒 Mon - Sat: 8 AM - 12 PM (In-Clinic)' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Office Phone Number</label>
        <input type="text" name="concierge_facility_phone" class="form-control" value="{{ $settings['concierge_facility_phone'] ?? '(774) 643-6261' }}">
      </div>
    </div>
  </div>

  <!-- FAQ Cards (3 Cards) -->
  <div class="grid-3 mb-4">
    <!-- FAQ 1 -->
    <div class="card">
      <div class="card-header">
        <h3>FAQ 1: Core Care Concept</h3>
      </div>
      <div class="form-group">
        <label class="form-label">Badge</label>
        <input type="text" name="concierge_faq1_badge" class="form-control" value="{{ $settings['concierge_faq1_badge'] ?? 'Core Care Concept' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Question</label>
        <input type="text" name="concierge_faq1_q" class="form-control" value="{{ $settings['concierge_faq1_q'] ?? '❓ What is Concierge Medicine?' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Answer Text</label>
        <textarea name="concierge_faq1_a" class="form-control" style="min-height: 110px;">{{ $settings['concierge_faq1_a'] ?? 'Concierge Medicine is defined as a relationship between a patient and a primary care physician where the patient pays an annual fee directly to your doctor, and in return they become your own personal physician, taking direct responsibility for your healthcare needs.' }}</textarea>
      </div>
      <div class="form-group">
        <label class="form-label">Highlight Box Text</label>
        <input type="text" name="concierge_faq1_highlight" class="form-control" value="{{ $settings['concierge_faq1_highlight'] ?? 'Concierge medicine is no longer a privilege for only the rich — it is now accessible and affordable for all patients seeking dedicated healthcare access.' }}">
      </div>
    </div>

    <!-- FAQ 2 -->
    <div class="card">
      <div class="card-header">
        <h3>FAQ 2: Coverage & 2-2-2 Plan</h3>
      </div>
      <div class="form-group">
        <label class="form-label">Badge</label>
        <input type="text" name="concierge_faq2_badge" class="form-control" value="{{ $settings['concierge_faq2_badge'] ?? 'Coverage & Response' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Question</label>
        <input type="text" name="concierge_faq2_q" class="form-control" value="{{ $settings['concierge_faq2_q'] ?? '📋 What is covered in the plan?' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Answer Text</label>
        <textarea name="concierge_faq2_a" class="form-control" style="min-height: 110px;">{{ $settings['concierge_faq2_a'] ?? 'The plan may cover a variety of medical services, screenings and in-office lab tests. Through the "New Age of Telemedicine", a patient may text a picture directly to the provider for review or video conference using our eTeleMedicine software.' }}</textarea>
      </div>
      <div class="form-group">
        <label class="form-label">2-Min Response Label</label>
        <input type="text" name="concierge_rapid_min_text" class="form-control" value="{{ $settings['concierge_rapid_min_text'] ?? 'Video Conference Response' }}">
      </div>
      <div class="form-group">
        <label class="form-label">2-Hour Callback Label</label>
        <input type="text" name="concierge_rapid_hours_text" class="form-control" value="{{ $settings['concierge_rapid_hours_text'] ?? 'Phone Call Callback' }}">
      </div>
      <div class="form-group">
        <label class="form-label">2-Day In-Office Visit Label</label>
        <input type="text" name="concierge_rapid_days_text" class="form-control" value="{{ $settings['concierge_rapid_days_text'] ?? 'Schedule In-Office Visit' }}">
      </div>
    </div>

    <!-- FAQ 3 -->
    <div class="card">
      <div class="card-header">
        <h3>FAQ 3: Insurance & Direct Pay</h3>
      </div>
      <div class="form-group">
        <label class="form-label">Badge</label>
        <input type="text" name="concierge_faq3_badge" class="form-control" value="{{ $settings['concierge_faq3_badge'] ?? 'Insurance & Direct Pay' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Question</label>
        <input type="text" name="concierge_faq3_q" class="form-control" value="{{ $settings['concierge_faq3_q'] ?? '🛡️ Does a Concierge Medicine Plan take the place of a health insurance plan?' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Answer Text</label>
        <textarea name="concierge_faq3_a" class="form-control" style="min-height: 160px;">{{ $settings['concierge_faq3_a'] ?? 'Concierge Medicine is not a substitute for health insurance. Concierge Medicine is an alternative medical model, which can offer unlimited office visits. It is a great model for "direct pay" patients, as well as patients with a high deductible insurance plan.' }}</textarea>
      </div>
    </div>
  </div>

  <button type="submit" class="btn btn-primary">💾 Save FAQ & Facility Settings</button>
</form>
@endsection
