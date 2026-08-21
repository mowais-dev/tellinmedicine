@extends('admin.layouts.admin')

@section('title', 'Main Logo & Brand Title Settings')
@section('breadcrumbs')
  <a href="{{ route('admin.dashboard') }}">Admin</a> <span class="separator">/</span> <span>Settings</span> <span class="separator">/</span> <span>Main Logo & Title</span>
@endsection
@section('page_title', 'Main Website Logo & Brand Title Settings')

@section('content')
<div class="page-desc-banner">
  <i class="fa-solid fa-sliders"></i>
  <p>Manage the main TELLinMedicine brand logo image, brand main name, and legal subtitle displayed in the website top header bar.</p>
</div>

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
  @csrf

  <div class="card">
    <div class="card-header">
      <h3>Website Main Logo & Brand Title</h3>
    </div>

    <div class="grid-2" style="align-items: center; margin-bottom: 1.5rem;">
      <div>
        <label class="form-label">Current Logo Image Preview</label>
        <div class="image-picker-box">
          @if(!empty($settings['logo_path']) && file_exists(public_path($settings['logo_path'])))
            <img src="{{ asset($settings['logo_path']) }}" alt="Logo Preview" class="image-preview-img" id="logoPreview">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); margin-top: 0.5rem; word-break: break-all;">{{ $settings['logo_path'] }}</div>
          @else
            <div style="color: var(--text-muted); font-size: 0.9rem;">No logo uploaded yet</div>
          @endif
        </div>
      </div>

      <div>
        <div class="form-group">
          <label class="form-label">Upload New Logo Image (PNG, SVG, WEBP, JPG)</label>
          <input type="file" name="logo_file" class="form-control" accept="image/*" onchange="previewImage(this, 'logoPreview')">
        </div>
        <div class="form-group">
          <label class="form-label">Brand Main Name</label>
          <input type="text" name="brand_name" class="form-control" value="{{ strip_tags($settings['brand_name'] ?? 'TELLinMedicine') }}" placeholder="e.g. TELLinMedicine">
        </div>
        <div class="form-group">
          <label class="form-label">Brand Legal Subtitle (e.g. LLC)</label>
          <input type="text" name="brand_sub" class="form-control" value="{{ $settings['brand_sub'] ?? 'LLC' }}">
        </div>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">💾 Save Main Logo & Brand Settings</button>
  </div>
</form>

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
</script>
@endsection
