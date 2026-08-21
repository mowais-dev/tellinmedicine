@extends('admin.layouts.admin')

@section('title', 'Home - Contact & Location')
@section('breadcrumbs')
  <a href="{{ route('admin.dashboard') }}">Admin</a> <span class="separator">/</span> <span>Home</span> <span class="separator">/</span> <span>Contact & Location</span>
@endsection
@section('page_title', 'Contact & Practice Location')

@section('content')
<div class="page-desc-banner">
  <i class="fa-solid fa-location-dot"></i>
  <p>Manage practice address, phone numbers, contact email, map information, and quick inquiry form field labels on the Home page.</p>
</div>

<div class="card">
  <div class="card-header">
    <h3>Practice Contact Information</h3>
  </div>

  <form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Clinic Address</label>
        <input type="text" name="address" class="form-control" value="{{ $settings['address'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Primary Phone Number</label>
        <input type="text" name="phone_primary" class="form-control" value="{{ $settings['phone_primary'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Secondary / Mobile Phone Number</label>
        <input type="text" name="phone_secondary" class="form-control" value="{{ $settings['phone_secondary'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Contact Email Address</label>
        <input type="email" name="email" class="form-control" value="{{ $settings['email'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">In-Clinic Working Hours</label>
        <input type="text" name="hours_clinic_text" class="form-control" value="{{ $settings['hours_clinic_text'] ?? '' }}" placeholder="e.g. Mon - Sat: 8 AM - 12 PM (In-Clinic)">
      </div>

      <div class="form-group">
        <label class="form-label">Telehealth Working Hours</label>
        <input type="text" name="hours_telehealth_text" class="form-control" value="{{ $settings['hours_telehealth_text'] ?? '' }}" placeholder="e.g. Mon - Sat: 12 PM - 6 PM (Telehealth)">
      </div>

      <div class="form-group">
        <label class="form-label">Sunday Working Hours / Note</label>
        <input type="text" name="hours_sunday_text" class="form-control" value="{{ $settings['hours_sunday_text'] ?? '' }}" placeholder="e.g. Sunday: Closed (E-Appointments Only)">
      </div>
    </div>
    <button type="submit" class="btn btn-primary">💾 Save Contact & Hours Information</button>
  </form>
</div>

<div class="card">
  <div class="card-header">
    <h3>Home Page Contact Section & Quick Form Content</h3>
  </div>

  <form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Contact Section Pill Badge</label>
        <input type="text" name="contact_badge" class="form-control" value="{{ $settings['contact_badge'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Contact Section Heading</label>
        <input type="text" name="contact_title" class="form-control" value="{{ $settings['contact_title'] ?? '' }}">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Contact Section Subtitle / Note</label>
        <textarea name="contact_subtitle" class="form-control">{{ $settings['contact_subtitle'] ?? '' }}</textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Contact Details Card Heading</label>
        <input type="text" name="contact_card_title" class="form-control" value="{{ $settings['contact_card_title'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Quick Inquiry Form Heading</label>
        <input type="text" name="contact_form_title" class="form-control" value="{{ $settings['contact_form_title'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Form Field Label (Full Name)</label>
        <input type="text" name="contact_form_label_name" class="form-control" value="{{ $settings['contact_form_label_name'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Form Field Label (Phone / Email)</label>
        <input type="text" name="contact_form_label_contact" class="form-control" value="{{ $settings['contact_form_label_contact'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Form Field Label (Message Note)</label>
        <input type="text" name="contact_form_label_msg" class="form-control" value="{{ $settings['contact_form_label_msg'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Form Submit Button Text</label>
        <input type="text" name="contact_form_btn_text" class="form-control" value="{{ $settings['contact_form_btn_text'] ?? '' }}">
      </div>
    </div>

    <button type="submit" class="btn btn-primary">💾 Save Contact Section & Form Content</button>
  </form>
</div>

<!-- Location Map & Building Photo Card -->
<div class="card">
  <div class="card-header">
    <h3>📍 Location & Practice Building Settings</h3>
  </div>

  <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Building Photo Image File</label>
        <input type="file" name="building_image_file" class="form-control">
        @if(!empty($settings['building_image_path']))
          <small style="color: var(--text-muted); font-size: 0.78rem; display: block; margin-top: 0.25rem;">
            Current photo: {{ $settings['building_image_path'] }}
          </small>
        @endif
      </div>

      <div class="form-group">
        <label class="form-label">Google Maps Custom Embed URL (Optional)</label>
        <input type="text" name="google_map_embed_url" class="form-control" value="{{ $settings['google_map_embed_url'] ?? '' }}" placeholder="Leave blank to automatically embed mapped clinic address">
        <small style="color: var(--text-muted); font-size: 0.78rem;">If left empty, Google Maps will automatically pin the Clinic Address set above.</small>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">💾 Save Building Photo & Location Map Settings</button>
  </form>
</div>
@endsection
