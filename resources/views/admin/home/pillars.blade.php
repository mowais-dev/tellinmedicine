@extends('admin.layouts.admin')

@section('title', 'Home - Pillars of Care')
@section('breadcrumbs')
  <a href="{{ route('admin.dashboard') }}">Admin</a> <span class="separator">/</span> <span>Home</span> <span class="separator">/</span> <span>Pillars of Care</span>
@endsection
@section('page_title', 'Homepage Pillars of Care')

@section('content')
<div class="page-desc-banner">
  <i class="fa-solid fa-layer-group"></i>
  <p>Manage the four main Pillars of Care displayed on the Home page, including titles, descriptions, 3D images, button links, and section headings.</p>
</div>

<!-- Section Headings -->
<div class="card">
  <div class="card-header">
    <h3>Homepage Pillars Section Headings</h3>
  </div>

  <form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Section Pill Badge</label>
        <input type="text" name="pillars_badge" class="form-control" value="{{ $settings['pillars_badge'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Section Heading</label>
        <input type="text" name="pillars_title" class="form-control" value="{{ $settings['pillars_title'] ?? '' }}">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Section Subtitle / Description</label>
        <textarea name="pillars_subtitle" class="form-control">{{ $settings['pillars_subtitle'] ?? '' }}</textarea>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">💾 Save Section Headings</button>
  </form>
</div>

<!-- Homepage Pillars Cards Table -->
<div class="card">
  <div class="card-header">
    <h3>Existing Homepage Pillar Cards</h3>
  </div>

  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th style="min-width: 90px; width: 90px; text-align: center;">Order</th>
          <th style="width: 140px;">3D Image</th>
          <th style="width: 180px;">Title</th>
          <th>Description</th>
          <th style="width: 140px;">Link Label</th>
          <th style="width: 160px;">Link URL (href)</th>
          <th style="width: 140px;">Care Option</th>
          <th style="min-width: 130px; width: 130px; text-align: center;">Status</th>
          <th style="width: 180px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($pillars as $pillar)
          <tr>
            <form action="{{ route('admin.pillars.update', $pillar) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <td>
                <input type="number" name="order" class="form-control" value="{{ $pillar->order }}">
              </td>
              <td>
                @if(!empty($pillar->image_path) && file_exists(public_path($pillar->image_path)))
                  <img src="{{ asset($pillar->image_path) }}" alt="Preview" style="height: 40px; object-fit: contain; display: block; margin-bottom: 0.3rem;" id="pillarPreview{{ $pillar->id }}">
                @endif
                <input type="file" name="image_file" class="form-control" accept="image/*" style="font-size: 0.7rem; padding: 0.2rem;" onchange="previewImage(this, 'pillarPreview{{ $pillar->id }}')">
              </td>
              <td>
                <input type="text" name="title" class="form-control" value="{{ $pillar->title }}">
              </td>
              <td>
                <textarea name="description" class="form-control">{{ $pillar->description }}</textarea>
              </td>
              <td>
                <input type="text" name="link_text" class="form-control" value="{{ $pillar->link_text }}">
              </td>
              <td>
                <input type="text" name="link_url" class="form-control" value="{{ $pillar->link_url }}" placeholder="e.g. /education or #services">
              </td>
              <td>
                <input type="text" name="care_model" class="form-control" value="{{ $pillar->care_model }}">
              </td>
              <td>
                <select name="is_active" class="form-control">
                  <option value="1" {{ $pillar->is_active ? 'selected' : '' }}>Active</option>
                  <option value="0" {{ !$pillar->is_active ? 'selected' : '' }}>Disabled</option>
                </select>
              </td>
              <td>
                <div style="display: flex; gap: 0.5rem; align-items: center; white-space: nowrap;">
                  <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-floppy-disk"></i> Save</button>
            </form>
                  <form action="{{ route('admin.pillars.destroy', $pillar) }}" method="POST" onsubmit="return confirm('Delete pillar?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i> Delete</button>
                  </form>
                </div>
              </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<!-- Add Pillar -->
<div class="card">
  <div class="card-header">
    <h3>Add New Homepage Pillar Card</h3>
  </div>

  <form action="{{ route('admin.pillars.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="page" value="home">
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Pillar Title</label>
        <input type="text" name="title" class="form-control" placeholder="e.g. Adult Primary Care">
      </div>

      <div class="form-group">
        <label class="form-label">Upload 3D Image</label>
        <input type="file" name="image_file" class="form-control" accept="image/*">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control"></textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Button Link Label</label>
        <input type="text" name="link_text" class="form-control" placeholder="Book Primary Care ➔">
      </div>

      <div class="form-group">
        <label class="form-label">Button Link URL / href</label>
        <input type="text" name="link_url" class="form-control" placeholder="e.g. /education or https://...">
      </div>

      <div class="form-group">
        <label class="form-label">Care Delivery Option</label>
        <input type="text" name="care_model" class="form-control" placeholder="In-Clinic Standard">
      </div>

      <div class="form-group">
        <label class="form-label">Display Order</label>
        <input type="number" name="order" class="form-control" value="{{ count($pillars) + 1 }}">
      </div>

      <div class="form-group">
        <label class="form-label">Status</label>
        <select name="is_active" class="form-control">
          <option value="1">Active</option>
          <option value="0">Disabled</option>
        </select>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">➕ Create Homepage Pillar</button>
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
