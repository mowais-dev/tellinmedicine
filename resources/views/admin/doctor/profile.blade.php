@extends('admin.layouts.admin')

@section('title', 'Meet Dr. Ngomba - Doctor Profile')
@section('breadcrumbs')
  <a href="{{ route('admin.dashboard') }}">Admin</a> <span class="separator">/</span> <span>Meet Dr. Ngomba</span> <span class="separator">/</span> <span>Doctor Profile</span>
@endsection
@section('page_title', 'Dr. Jasper I. Ngomba Profile')

@section('content')
<div class="page-desc-banner">
  <i class="fa-solid fa-id-card"></i>
  <p>Manage Dr. Ngomba's portrait photo, name title, badge pill, medical credentials, doctor's personal quote box, and full biography displayed on the Home page.</p>
</div>

<div class="card">
  <div class="card-header">
    <h3>Doctor Biography & Credentials Information</h3>
  </div>

  <form action="{{ route('admin.doctor.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="grid-2" style="align-items: start; margin-bottom: 1.5rem;">
      <div>
        <label class="form-label">Doctor Portrait Photo Preview</label>
        <div class="image-picker-box" style="padding: 1.5rem; text-align: center;">
          @if(!empty($doctor->photo_path) && file_exists(public_path($doctor->photo_path)))
            <img src="{{ asset($doctor->photo_path) }}" alt="Doctor Portrait" class="image-preview-img" id="doctorPreview" style="max-height: 180px; object-fit: contain;">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); margin-top: 0.5rem; word-break: break-all;">{{ $doctor->photo_path }}</div>
          @else
            <div style="color: var(--text-muted); font-size: 0.9rem;">No photo uploaded</div>
          @endif
        </div>
      </div>

      <div>
        <div class="form-group">
          <label class="form-label">Upload New Portrait Photo (PNG, JPG, WEBP)</label>
          <input type="file" name="photo_file" class="form-control" accept="image/*" onchange="previewImage(this, 'doctorPreview')">
        </div>
        <div class="form-group">
          <label class="form-label">Section Pill Badge</label>
          <input type="text" name="badge" class="form-control" value="{{ $doctor->badge ?? '' }}" placeholder="e.g. Founder & Medical Director">
        </div>
        <div class="form-group">
          <label class="form-label">Full Name & Medical Title</label>
          <input type="text" name="name" class="form-control" value="{{ $doctor->name ?? '' }}" placeholder="e.g. Meet Dr. Jasper I. Ngomba, MD">
        </div>
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Medical Credentials & Certifications</label>
      <input type="text" name="credentials" class="form-control" value="{{ $doctor->credentials ?? '' }}" placeholder="e.g. Board-Certified in Internal Medicine | Former Critical Care Nurse">
    </div>

    <div class="form-group">
      <label class="form-label">Doctor Personal Quote Box</label>
      <textarea name="quote" class="form-control" style="min-height: 90px;" placeholder="e.g. Prevention is the best medicine...">{{ strip_tags($doctor->quote ?? '') }}</textarea>
    </div>

    <div class="form-group">
      <label class="form-label">Full Medical Biography Essay</label>
      <textarea name="bio" class="form-control" style="min-height: 140px;">{{ strip_tags($doctor->bio ?? '') }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">💾 Save Doctor Profile</button>
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
</script>
@endsection
