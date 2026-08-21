@extends('admin.layouts.admin')

@section('title', 'Home - Hero Section')
@section('breadcrumbs')
  <a href="{{ route('admin.dashboard') }}">Admin</a> <span class="separator">/</span> <span>Home</span> <span class="separator">/</span> <span>Hero Section</span>
@endsection
@section('page_title', 'Home Page Hero Section')

@section('content')
<div class="page-desc-banner">
  <i class="fa-solid fa-wand-magic-sparkles"></i>
  <p>Manage the main hero banner displayed at the top of the Home page, including headlines, call-to-action buttons, 3D visual preview, and image rotation angle.</p>
</div>

<div class="card">
  <div class="card-header">
    <h3>Homepage Hero Banner Content</h3>
  </div>

  <form action="{{ route('admin.heroes.update', 'home') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Hero Main Title (Normal Text)</label>
        <input type="text" name="title" class="form-control" value="{{ $hero->title ?? '' }}" placeholder="e.g. Compassionate Healthcare">
      </div>
      <div class="form-group">
        <label class="form-label">Hero Highlight Text (Crimson Accent)</label>
        <input type="text" name="title_highlight" class="form-control" value="{{ $hero->title_highlight ?? '' }}" placeholder="e.g. Without Borders">
        <small style="color: var(--text-muted); font-size: 0.78rem;">Text entered here will appear in the crimson gradient accent color on the website.</small>
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Hero Subtitle / Practice Description</label>
      <textarea name="subtitle" class="form-control" style="min-height: 110px;">{{ strip_tags($hero->subtitle ?? '') }}</textarea>
    </div>

    <div class="grid-2" style="align-items: start; margin-bottom: 1.5rem;">
      <div>
        <label class="form-label">Current Hero 3D Image Preview</label>
        <div class="image-picker-box" style="padding: 1.25rem; text-align: center;">
          @if(!empty($hero->image_path) && file_exists(public_path($hero->image_path)))
            <div style="display: inline-block; overflow: hidden; max-width: 100%;">
              <img src="{{ asset($hero->image_path) }}" alt="Hero Preview" class="image-preview-img" id="heroPreview" style="transform: rotate({{ $hero->image_rotation ?? 0 }}deg); transition: transform 0.25s ease; max-height: 180px; max-width: 100%; object-fit: contain;">
            </div>
            <div style="font-size: 0.78rem; font-weight: 700; color: var(--text-muted); margin-top: 0.5rem; word-break: break-all;">{{ $hero->image_path }}</div>
          @else
            <div style="color: var(--text-muted); font-size: 0.9rem;">No hero image uploaded yet</div>
          @endif
        </div>
      </div>

      <div>
        <div class="form-group">
          <label class="form-label">Upload New Hero Image (PNG, WEBP, SVG, JPG)</label>
          <input type="file" name="image_file" class="form-control" accept="image/*" onchange="previewImage(this, 'heroPreview')">
        </div>

        <!-- Visual Hero Image Rotation Control -->
        <div class="form-group" style="background: rgba(40, 137, 198, 0.06); padding: 1.1rem; border-radius: 12px; border: 1px solid rgba(40, 137, 198, 0.2); margin-top: 1rem;">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.6rem; flex-wrap: wrap; gap: 0.5rem;">
            <label class="form-label" style="margin-bottom: 0; font-size: 0.85rem; color: var(--text-dark);">
              <i class="fa-solid fa-rotate" style="color: var(--brand-blue); margin-right: 0.35rem;"></i> Image Rotation Angle
            </label>
            <div style="font-size: 0.88rem; font-weight: 800; color: var(--text-dark);">
              Current Rotation: <span id="rotationDegreeDisplay" style="color: var(--brand-blue);">{{ $hero->image_rotation ?? 0 }}°</span>
            </div>
          </div>

          <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.85rem;">
            <span style="font-size: 0.78rem; font-weight: 800; color: var(--text-muted);">-45°</span>
            <input type="range" name="image_rotation" id="rotationSlider" min="-45" max="45" value="{{ $hero->image_rotation ?? 0 }}" class="form-control" style="padding: 0; cursor: pointer; flex: 1; min-width: 0; accent-color: #2889C6;" oninput="updateRotationPreview(this.value)">
            <span style="font-size: 0.78rem; font-weight: 800; color: var(--text-muted);">+45°</span>
          </div>

          <div style="display: flex; gap: 0.4rem; justify-content: space-between; align-items: center; flex-wrap: wrap;">
            <div style="display: flex; gap: 0.3rem; flex-wrap: wrap;">
              <button type="button" class="btn btn-secondary btn-sm" onclick="setRotation(-15)">-15°</button>
              <button type="button" class="btn btn-secondary btn-sm" onclick="setRotation(0)">0°</button>
              <button type="button" class="btn btn-secondary btn-sm" onclick="setRotation(15)">+15°</button>
            </div>
            <button type="button" class="btn btn-danger btn-sm" onclick="setRotation(0)"><i class="fa-solid fa-rotate-left"></i> Reset to 0°</button>
          </div>
        </div>
      </div>
    </div>

    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Primary Call-to-Action Button Label</label>
        <input type="text" name="primary_button_text" class="form-control" value="{{ $hero->primary_button_text }}">
      </div>

      <div class="form-group">
        <label class="form-label">Primary Button Link / URL (href)</label>
        <input type="text" name="primary_button_url" class="form-control" value="{{ $hero->primary_button_url }}" placeholder="e.g. #services or /education or https://...">
        <small style="color: var(--text-muted); font-size: 0.78rem;">Leave blank to default to appointment booking modal, or enter a URL/anchor link.</small>
      </div>

      <div class="form-group">
        <label class="form-label">Secondary Button Label</label>
        <input type="text" name="secondary_button_text" class="form-control" value="{{ $hero->secondary_button_text }}">
      </div>

      <div class="form-group">
        <label class="form-label">Secondary Button Link / URL (href)</label>
        <input type="text" name="secondary_button_url" class="form-control" value="{{ $hero->secondary_button_url }}" placeholder="e.g. #contact or /philosophy or https://...">
        <small style="color: var(--text-muted); font-size: 0.78rem;">Leave blank to default to appointment booking modal, or enter a URL/anchor link.</small>
      </div>
    </div>

    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Badge 1 Heading (e.g. Board Certified)</label>
        <input type="text" name="badge1_title" class="form-control" value="{{ $hero->badge1_title }}">
      </div>
      <div class="form-group">
        <label class="form-label">Badge 1 Subheading (e.g. Internal Medicine MD)</label>
        <input type="text" name="badge1_sub" class="form-control" value="{{ $hero->badge1_sub }}">
      </div>
      <div class="form-group">
        <label class="form-label">Badge 2 Heading (e.g. World TeleMedicine)</label>
        <input type="text" name="badge2_title" class="form-control" value="{{ $hero->badge2_title }}">
      </div>
      <div class="form-group">
        <label class="form-label">Badge 2 Subheading (e.g. Virtual Queue Active)</label>
        <input type="text" name="badge2_sub" class="form-control" value="{{ $hero->badge2_sub }}">
      </div>
    </div>

    <button type="submit" class="btn btn-primary">💾 Save Homepage Hero Section</button>
  </form>
</div>

<script>
  function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById(previewId).src = e.target.result;
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  function updateRotationPreview(val) {
    var degree = parseInt(val) || 0;
    document.getElementById('rotationDegreeDisplay').innerText = degree + '°';
    var img = document.getElementById('heroPreview');
    if (img) {
      img.style.transform = 'rotate(' + degree + 'deg)';
    }
  }

  function setRotation(val) {
    var slider = document.getElementById('rotationSlider');
    if (slider) {
      slider.value = val;
      updateRotationPreview(val);
    }
  }
</script>
@endsection
