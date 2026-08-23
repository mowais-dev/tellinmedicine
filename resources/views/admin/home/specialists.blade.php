@extends('admin.layouts.admin')

@section('title', 'Home - Our Specialists')
@section('breadcrumbs')
  <a href="{{ route('admin.dashboard') }}">Admin</a> <span class="separator">/</span> <span>Home</span> <span class="separator">/</span> <span>Our Specialists</span>
@endsection
@section('page_title', 'Our Specialists')

@section('content')
<div class="page-desc-banner">
  <i class="fa-solid fa-user-doctor"></i>
  <p>Manage physician specialist profiles, photo avatars, titles, qualifications, and descriptions displayed in the Specialists section on the Home page.</p>
</div>

<!-- Section Headings -->
<div class="card">
  <div class="card-header">
    <h3>Our Specialists Section Headings</h3>
  </div>

  <form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Section Pill Badge</label>
        <input type="text" name="specialists_badge" class="form-control" value="{{ $settings['specialists_badge'] ?? '🩺 Expert Care Team' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Section Heading</label>
        <input type="text" name="specialists_title" class="form-control" value="{{ $settings['specialists_title'] ?? 'Meet Our Specialists' }}">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Section Subtitle / Description</label>
        <textarea name="specialists_subtitle" class="form-control">{{ $settings['specialists_subtitle'] ?? 'Board-certified medical specialists dedicated to delivering compassionate primary care, virtual care, and in-home physician visits.' }}</textarea>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">💾 Save Section Headings</button>
  </form>
</div>

<!-- Specialists List Card -->
<div class="card">
  <div class="card-header">
    <h3>Current Specialists</h3>
  </div>

  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th style="width: 70px; text-align: center;">Photo</th>
          <th>Name & Title</th>
          <th>Qualifications & Experience</th>
          <th style="min-width: 80px; width: 80px; text-align: center;">Order</th>
          <th style="min-width: 110px; width: 110px; text-align: center;">Status</th>
          <th style="width: 180px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($specialists as $spec)
          <form id="form-spec-{{ $spec->id }}" action="{{ route('admin.specialists.update', $spec) }}" method="POST" enctype="multipart/form-data" style="display: none;">
            @csrf
            @method('PUT')
          </form>
          <tr>
            <td style="text-align: center;">
              <div style="width: 50px; height: 50px; border-radius: 50%; overflow: hidden; margin: 0 auto; border: 2px solid var(--border-color); background: #f0f9ff; display: flex; align-items: center; justify-content: center;">
                @if(!empty($spec->image))
                  <img id="spec-preview-{{ $spec->id }}" src="{{ asset($spec->image) }}" alt="{{ $spec->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                  <img id="spec-preview-{{ $spec->id }}" src="" alt="{{ $spec->name }}" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                  <span id="spec-icon-{{ $spec->id }}" style="font-size: 1.5rem; line-height: 50px;">🩺</span>
                @endif
              </div>
            </td>
            <td>
              <input type="text" name="name" form="form-spec-{{ $spec->id }}" class="form-control" value="{{ $spec->name }}" style="font-weight: 700; margin-bottom: 0.3rem;" required>
              <input type="text" name="title" form="form-spec-{{ $spec->id }}" class="form-control" value="{{ $spec->title }}" placeholder="Title / Specialty" required>
            </td>
            <td>
              <input type="text" name="qualifications" form="form-spec-{{ $spec->id }}" class="form-control" value="{{ $spec->qualifications }}" placeholder="Qualifications (e.g. MD, FACP)" style="margin-bottom: 0.3rem;">
              <input type="text" name="experience_years" form="form-spec-{{ $spec->id }}" class="form-control" value="{{ $spec->experience_years }}" placeholder="Experience (e.g. 15+ Years)">
            </td>
            <td>
              <input type="number" name="order" form="form-spec-{{ $spec->id }}" class="form-control" value="{{ $spec->order }}" style="text-align: center;" required>
            </td>
            <td>
              <select name="is_active" form="form-spec-{{ $spec->id }}" class="form-control">
                <option value="1" {{ $spec->is_active ? 'selected' : '' }}>Active</option>
                <option value="0" {{ !$spec->is_active ? 'selected' : '' }}>Disabled</option>
              </select>
            </td>
            <td>
              <div style="display: flex; gap: 0.5rem; align-items: center; white-space: nowrap;">
                <button type="submit" form="form-spec-{{ $spec->id }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                <form action="{{ route('admin.specialists.destroy', $spec) }}" method="POST" onsubmit="return confirm('Delete specialist profile?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i> Delete</button>
                </form>
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="6" style="padding-top: 0; padding-bottom: 1rem; border-bottom: 2px solid var(--border-color);">
              <div style="background: #f8fafc; padding: 0.75rem 1rem; border-radius: 8px; border: 1px dashed var(--border-color);">
                <label style="font-size: 0.78rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Bio Description & Update Photo:</label>
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem; align-items: center;">
                  <textarea name="description" form="form-spec-{{ $spec->id }}" class="form-control" style="min-height: 55px; font-size: 0.85rem;" placeholder="Specialist bio / description details...">{{ $spec->description }}</textarea>
                  <div>
                    <input type="file" name="image_file" form="form-spec-{{ $spec->id }}" class="form-control specialist-crop-input" data-preview-id="spec-preview-{{ $spec->id }}" data-icon-id="spec-icon-{{ $spec->id }}" style="font-size: 0.8rem;">
                    <small style="color: var(--text-muted); font-size: 0.75rem;">Leave blank to keep existing photo.</small>
                  </div>
                </div>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<!-- Add New Specialist Card -->
<div class="card">
  <div class="card-header">
    <h3>➕ Add New Specialist</h3>
  </div>

  <form action="{{ route('admin.specialists.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Full Name *</label>
        <input type="text" name="name" class="form-control" placeholder="e.g. Dr. Sarah Jenkins, MD" required>
      </div>

      <div class="form-group">
        <label class="form-label">Specialty Title *</label>
        <input type="text" name="title" class="form-control" placeholder="e.g. Primary Care & Wellness Specialist" required>
      </div>

      <div class="form-group">
        <label class="form-label">Qualifications / Credentials</label>
        <input type="text" name="qualifications" class="form-control" placeholder="e.g. MD, Board-Certified Primary Care">
      </div>

      <div class="form-group">
        <label class="form-label">Experience Tag</label>
        <input type="text" name="experience_years" class="form-control" placeholder="e.g. 10+ Years Experience">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Bio Details / Description</label>
        <textarea name="description" class="form-control" style="min-height: 80px;" placeholder="Brief details about the specialist's expertise, care approach, and patient services..."></textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Photo Image File</label>
        <input type="file" name="image_file" id="newSpecialistImageInput" class="form-control specialist-crop-input" data-preview-id="newSpecialistPreviewImg" data-wrapper-id="newSpecialistPreviewWrapper">
        <div id="newSpecialistPreviewWrapper" style="margin-top: 0.75rem; display: none; align-items: center; gap: 0.75rem;">
          <div style="width: 55px; height: 55px; border-radius: 50%; overflow: hidden; border: 2px solid var(--brand-blue); background: #f0f9ff; flex-shrink: 0;">
            <img id="newSpecialistPreviewImg" src="" alt="Cropped Preview" style="width: 100%; height: 100%; object-fit: cover;">
          </div>
          <span style="font-size: 0.8rem; color: #0369a1; font-weight: 600;">✓ Photo cropped & ready to upload</span>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Display Order</label>
        <input type="number" name="order" class="form-control" value="{{ count($specialists) + 1 }}">
      </div>

      <div class="form-group">
        <label class="form-label">Status</label>
        <select name="is_active" class="form-control">
          <option value="1">Active</option>
          <option value="0">Disabled</option>
        </select>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">➕ Add Specialist Profile</button>
  </form>
</div>

<!-- Specialist Image Cropper Modal -->
<div id="specialistCropModal" class="specialist-crop-modal-overlay" style="display: none;">
  <div class="specialist-crop-modal-card">
    <div class="specialist-crop-modal-header">
      <h4><i class="fa-solid fa-crop-simple"></i> Crop Specialist Photo</h4>
      <button type="button" class="specialist-crop-close-btn" id="cropCancelXBtn">&times;</button>
    </div>
    <div class="specialist-crop-modal-body">
      <div class="specialist-crop-viewport-container">
        <img id="specialistCropImage" src="" alt="Specialist Crop Target">
      </div>
      <div class="specialist-crop-toolbar">
        <button type="button" class="btn btn-secondary btn-sm" id="cropZoomInBtn" title="Zoom In"><i class="fa-solid fa-magnifying-glass-plus"></i> Zoom In</button>
        <button type="button" class="btn btn-secondary btn-sm" id="cropZoomOutBtn" title="Zoom Out"><i class="fa-solid fa-magnifying-glass-minus"></i> Zoom Out</button>
        <button type="button" class="btn btn-secondary btn-sm" id="cropRotateLeftBtn" title="Rotate Left"><i class="fa-solid fa-rotate-left"></i></button>
        <button type="button" class="btn btn-secondary btn-sm" id="cropRotateRightBtn" title="Rotate Right"><i class="fa-solid fa-rotate-right"></i></button>
        <button type="button" class="btn btn-secondary btn-sm" id="cropResetBtn" title="Reset"><i class="fa-solid fa-arrow-rotate-left"></i> Reset</button>
      </div>
    </div>
    <div class="specialist-crop-modal-footer">
      <button type="button" class="btn btn-secondary" id="cropCancelBtn">Cancel</button>
      <button type="button" class="btn btn-primary" id="cropApplyBtn">✂️ Apply Crop</button>
    </div>
  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" />
<style>
  .specialist-crop-modal-overlay {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(15, 23, 42, 0.75);
    backdrop-filter: blur(4px);
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
  }
  .specialist-crop-modal-card {
    background: #ffffff;
    border-radius: 16px;
    width: 100%;
    max-width: 540px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    max-height: 92vh;
  }
  .specialist-crop-modal-header {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #f8fafc;
  }
  .specialist-crop-modal-header h4 {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 700;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }
  .specialist-crop-close-btn {
    background: transparent;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: #64748b;
    line-height: 1;
    padding: 0 0.25rem;
  }
  .specialist-crop-close-btn:hover {
    color: #0f172a;
  }
  .specialist-crop-modal-body {
    padding: 1.25rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
    overflow-y: auto;
  }
  .specialist-crop-viewport-container {
    width: 100%;
    height: 340px;
    background: #090d16;
    border-radius: 12px;
    overflow: hidden;
    position: relative;
  }
  .specialist-crop-viewport-container .cropper-view-box,
  .specialist-crop-viewport-container .cropper-face {
    border-radius: 50%;
  }
  .specialist-crop-toolbar {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    justify-content: center;
  }
  .specialist-crop-toolbar .btn {
    padding: 0.35rem 0.75rem;
    font-size: 0.82rem;
    border-radius: 8px;
  }
  .specialist-crop-modal-footer {
    padding: 1rem 1.25rem;
    border-top: 1px solid #e2e8f0;
    background: #f8fafc;
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
  }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  let cropper = null;
  let activeInput = null;
  let activePreviewImg = null;
  let activeIconEl = null;
  let activePreviewWrapper = null;

  const modal = document.getElementById('specialistCropModal');
  const cropImage = document.getElementById('specialistCropImage');
  const cancelBtn = document.getElementById('cropCancelBtn');
  const cancelXBtn = document.getElementById('cropCancelXBtn');
  const applyBtn = document.getElementById('cropApplyBtn');

  const zoomInBtn = document.getElementById('cropZoomInBtn');
  const zoomOutBtn = document.getElementById('cropZoomOutBtn');
  const rotateLeftBtn = document.getElementById('cropRotateLeftBtn');
  const rotateRightBtn = document.getElementById('cropRotateRightBtn');
  const resetBtn = document.getElementById('cropResetBtn');

  document.querySelectorAll('.specialist-crop-input').forEach(function(input) {
    input.addEventListener('change', function(e) {
      const files = e.target.files;
      if (!files || !files.length) return;

      const file = files[0];
      if (!file.type.match(/^image\//)) {
        alert('Please select a valid image file (JPG, PNG, WEBP, etc.).');
        input.value = '';
        return;
      }

      activeInput = input;
      const previewId = input.dataset.previewId;
      activePreviewImg = document.getElementById(previewId);
      
      const iconId = input.dataset.iconId;
      if (iconId) {
        activeIconEl = document.getElementById(iconId);
      } else {
        activeIconEl = null;
      }

      const wrapperId = input.dataset.wrapperId;
      if (wrapperId) {
        activePreviewWrapper = document.getElementById(wrapperId);
      } else {
        activePreviewWrapper = null;
      }

      const reader = new FileReader();
      reader.onload = function(evt) {
        cropImage.src = evt.target.result;
        openCropModal();
      };
      reader.readAsDataURL(file);
    });
  });

  function openCropModal() {
    modal.style.display = 'flex';
    if (cropper) {
      cropper.destroy();
    }
    cropper = new Cropper(cropImage, {
      aspectRatio: 1,
      viewMode: 1,
      dragMode: 'move',
      autoCropArea: 0.95,
      restore: false,
      guides: true,
      center: true,
      highlight: false,
      cropBoxMovable: true,
      cropBoxResizable: true,
      toggleDragModeOnDblclick: false,
    });
  }

  function closeCropModal() {
    modal.style.display = 'none';
    if (cropper) {
      cropper.destroy();
      cropper = null;
    }
    cropImage.src = '';
  }

  function cancelCrop() {
    if (activeInput && (!activeInput.files || !activeInput.files.length || !activeInput.dataset.cropped)) {
      activeInput.value = '';
    }
    closeCropModal();
  }

  cancelBtn.addEventListener('click', cancelCrop);
  cancelXBtn.addEventListener('click', cancelCrop);

  zoomInBtn.addEventListener('click', function() { cropper && cropper.zoom(0.1); });
  zoomOutBtn.addEventListener('click', function() { cropper && cropper.zoom(-0.1); });
  rotateLeftBtn.addEventListener('click', function() { cropper && cropper.rotate(-90); });
  rotateRightBtn.addEventListener('click', function() { cropper && cropper.rotate(90); });
  resetBtn.addEventListener('click', function() { cropper && cropper.reset(); });

  applyBtn.addEventListener('click', function() {
    if (!cropper || !activeInput) return;

    const canvas = cropper.getCroppedCanvas({
      width: 800,
      height: 800,
      imageSmoothingEnabled: true,
      imageSmoothingQuality: 'high',
    });

    if (!canvas) {
      alert('Could not crop image. Please try again.');
      return;
    }

    canvas.toBlob(function(blob) {
      if (!blob) return;

      const filename = 'specialist_crop_' + Date.now() + '.jpg';
      const croppedFile = new File([blob], filename, { type: 'image/jpeg' });

      const dataTransfer = new DataTransfer();
      dataTransfer.items.add(croppedFile);
      activeInput.files = dataTransfer.files;
      activeInput.dataset.cropped = "true";

      const dataUrl = canvas.toDataURL('image/jpeg', 0.9);
      if (activePreviewImg) {
        activePreviewImg.src = dataUrl;
        activePreviewImg.style.display = 'block';
      }
      if (activeIconEl) {
        activeIconEl.style.display = 'none';
      }
      if (activePreviewWrapper) {
        activePreviewWrapper.style.display = 'flex';
      }

      closeCropModal();
    }, 'image/jpeg', 0.9);
  });
});
</script>
@endpush
