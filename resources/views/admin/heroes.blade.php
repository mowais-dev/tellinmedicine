@extends('admin.layouts.admin')

@section('title', 'Page Heroes')
@section('page_title', 'Manage Page Heroes & Visual Assets')

@section('content')

<!-- Home Hero -->
@php $homeHero = $heroes['home'] ?? new \App\Models\HeroSection(); @endphp
<div class="card">
  <div class="card-header">
    <h3>Homepage Hero Banner</h3>
  </div>

  <form action="{{ route('admin.heroes.update', 'home') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label class="form-label">Hero Title</label>
      <input type="text" name="title" class="form-control" value="{{ strip_tags($homeHero->title ?? '') }}">
    </div>

    <div class="form-group">
      <label class="form-label">Hero Subtitle / Description</label>
      <textarea name="subtitle" class="form-control">{{ strip_tags($homeHero->subtitle ?? '') }}</textarea>
    </div>

    <div class="grid-2" style="align-items: start; margin-bottom: 1.5rem;">
      <div>
        <label class="form-label">Homepage Hero 3D Visual Live Preview</label>
        <div class="image-picker-box" style="padding: 1rem; text-align: center; max-width: 100%; box-sizing: border-box; overflow: hidden;">
          @if(!empty($homeHero->image_path) && file_exists(public_path($homeHero->image_path)))
            <div style="display: inline-block; overflow: hidden; max-width: 100%;">
              <img src="{{ asset($homeHero->image_path) }}" alt="Hero Preview" class="image-preview-img" id="heroPreview" style="transform: rotate({{ $homeHero->image_rotation ?? 0 }}deg); transition: transform 0.25s ease; max-height: 180px; max-width: 100%; object-fit: contain;">
            </div>
            <div style="font-size: 0.78rem; font-weight: 700; color: var(--text-muted); margin-top: 0.5rem; word-break: break-all;">{{ $homeHero->image_path }}</div>
          @else
            <div style="color: var(--text-muted); font-size: 0.9rem;">No hero image uploaded</div>
          @endif
        </div>
      </div>

      <div>
        <div class="form-group">
          <label class="form-label">Upload New Hero Image (PNG, WEBP, SVG, JPG)</label>
          <input type="file" name="image_file" class="form-control" accept="image/*" onchange="previewImage(this, 'heroPreview')">
        </div>

        <!-- User-Friendly Image Rotation Control -->
        <div class="form-group" style="background: rgba(40, 137, 198, 0.06); padding: 1.1rem; border-radius: 12px; border: 1px solid rgba(40, 137, 198, 0.2); margin-top: 1rem; max-width: 100%; box-sizing: border-box; overflow: hidden;">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.6rem; flex-wrap: wrap; gap: 0.5rem;">
            <label class="form-label" style="margin-bottom: 0; font-size: 0.85rem; color: var(--text-dark);">
              <i class="fa-solid fa-rotate" style="color: var(--brand-blue); margin-right: 0.35rem;"></i> Image Rotation Angle
            </label>
            <div style="font-size: 0.88rem; font-weight: 800; color: var(--text-dark);">
              Current: <span id="rotationDegreeDisplay" style="color: var(--brand-blue);">{{ $homeHero->image_rotation ?? 0 }}°</span>
            </div>
          </div>

          <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.85rem; max-width: 100%;">
            <span style="font-size: 0.78rem; font-weight: 800; color: var(--text-muted);">-45°</span>
            <input type="range" name="image_rotation" id="rotationSlider" min="-45" max="45" value="{{ $homeHero->image_rotation ?? 0 }}" class="form-control" style="padding: 0; cursor: pointer; flex: 1; min-width: 0; accent-color: #2889C6;" oninput="updateRotationPreview(this.value)">
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
        <label class="form-label">Primary Button Text</label>
        <input type="text" name="primary_button_text" class="form-control" value="{{ $homeHero->primary_button_text }}">
      </div>

      <div class="form-group">
        <label class="form-label">Primary Button Link / URL (href)</label>
        <input type="text" name="primary_button_url" class="form-control" value="{{ $homeHero->primary_button_url }}" placeholder="e.g. #services or /education or https://...">
        <small style="color: var(--text-muted); font-size: 0.78rem;">Leave blank to default to booking modal, or enter a URL/anchor link.</small>
      </div>

      <div class="form-group">
        <label class="form-label">Secondary Button Text</label>
        <input type="text" name="secondary_button_text" class="form-control" value="{{ $homeHero->secondary_button_text }}">
      </div>

      <div class="form-group">
        <label class="form-label">Secondary Button Link / URL (href)</label>
        <input type="text" name="secondary_button_url" class="form-control" value="{{ $homeHero->secondary_button_url }}" placeholder="e.g. #contact or /philosophy or https://...">
        <small style="color: var(--text-muted); font-size: 0.78rem;">Leave blank to default to booking modal, or enter a URL/anchor link.</small>
      </div>
    </div>

    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Badge 1 Title (e.g. Board Certified)</label>
        <input type="text" name="badge1_title" class="form-control" value="{{ $homeHero->badge1_title }}">
      </div>
      <div class="form-group">
        <label class="form-label">Badge 1 Subtitle (e.g. Internal Medicine MD)</label>
        <input type="text" name="badge1_sub" class="form-control" value="{{ $homeHero->badge1_sub }}">
      </div>
      <div class="form-group">
        <label class="form-label">Badge 2 Title (e.g. World TeleMedicine)</label>
        <input type="text" name="badge2_title" class="form-control" value="{{ $homeHero->badge2_title }}">
      </div>
      <div class="form-group">
        <label class="form-label">Badge 2 Subtitle (e.g. Virtual Queue Active)</label>
        <input type="text" name="badge2_sub" class="form-control" value="{{ $homeHero->badge2_sub }}">
      </div>
    </div>

    <button type="submit" class="btn btn-primary">💾 Save Homepage Hero</button>
  </form>
</div>

<!-- Education Hero -->
@php $eduHero = $heroes['education'] ?? new \App\Models\HeroSection(); @endphp
<div class="card">
  <div class="card-header">
    <h3>Patient Education Hero Banner</h3>
  </div>

  <form action="{{ route('admin.heroes.update', 'education') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Hero Badge Pill</label>
        <input type="text" name="badge" class="form-control" value="{{ $eduHero->badge }}">
      </div>

      <div class="form-group">
        <label class="form-label">Hero Title</label>
        <input type="text" name="title" class="form-control" value="{{ strip_tags($eduHero->title ?? '') }}">
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Hero Subtitle</label>
      <textarea name="subtitle" class="form-control">{{ strip_tags($eduHero->subtitle ?? '') }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">💾 Save Education Hero</button>
  </form>
</div>

<!-- Philosophy Hero -->
@php $philHero = $heroes['philosophy'] ?? new \App\Models\HeroSection(); @endphp
<div class="card">
  <div class="card-header">
    <h3>Medical Philosophy Hero Banner</h3>
  </div>

  <form action="{{ route('admin.heroes.update', 'philosophy') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Hero Badge Pill</label>
        <input type="text" name="badge" class="form-control" value="{{ $philHero->badge }}">
      </div>

      <div class="form-group">
        <label class="form-label">Hero Title</label>
        <input type="text" name="title" class="form-control" value="{{ strip_tags($philHero->title ?? '') }}">
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Hero Subtitle</label>
      <textarea name="subtitle" class="form-control">{{ strip_tags($philHero->subtitle ?? '') }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">💾 Save Philosophy Hero</button>
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
