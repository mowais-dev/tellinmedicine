@extends('admin.layouts.admin')

@section('title', 'Pillars of Care')
@section('page_title', 'Manage Homepage & Philosophy Pillars of Care')

@section('content')

<!-- Homepage Pillars Headings & Cards -->
<div class="card">
  <div class="card-header">
    <h3>Homepage 4 Pillars Section Headings</h3>
  </div>

  <form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Section Badge</label>
        <input type="text" name="home_pillars_badge" class="form-control" value="{{ $settings['home_pillars_badge'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Section Title</label>
        <input type="text" name="home_pillars_title" class="form-control" value="{{ $settings['home_pillars_title'] ?? '' }}">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Section Subtitle</label>
        <textarea name="home_pillars_subtitle" class="form-control">{{ $settings['home_pillars_subtitle'] ?? '' }}</textarea>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">💾 Save Homepage Pillars Headings</button>
  </form>
</div>

<div class="card">
  <div class="card-header">
    <h3>Homepage 4 Practice Pillars</h3>
  </div>

  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th style="width: 80px;">Order</th>
          <th style="width: 140px;">3D Image</th>
          <th style="width: 180px;">Title</th>
          <th>Description</th>
          <th style="width: 140px;">Link Text</th>
          <th style="width: 160px;">Link URL (href)</th>
          <th style="width: 140px;">Care Model</th>
          <th style="width: 110px;">Status</th>
          <th style="width: 180px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($homePillars as $pillar)
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

<!-- Philosophy Pillars Headings & Cards -->
<div class="card">
  <div class="card-header">
    <h3>Philosophy Page Pillars Headings</h3>
  </div>

  <form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Section Badge</label>
        <input type="text" name="philosophy_pillars_badge" class="form-control" value="{{ $settings['philosophy_pillars_badge'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Section Title</label>
        <input type="text" name="philosophy_pillars_title" class="form-control" value="{{ $settings['philosophy_pillars_title'] ?? '' }}">
      </div>
    </div>
    <button type="submit" class="btn btn-primary">💾 Save Philosophy Pillars Headings</button>
  </form>
</div>

<div class="card">
  <div class="card-header">
    <h3>Philosophy 3 Principles of Care</h3>
  </div>

  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th style="min-width: 75px; width: 75px;">Order</th>
          <th style="min-width: 65px; width: 65px; text-align: center;">Icon</th>
          <th style="min-width: 220px;">Title</th>
          <th style="min-width: 280px;">Description</th>
          <th style="min-width: 120px; width: 120px;">Status</th>
          <th style="min-width: 190px; width: 190px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($philosophyPillars as $pillar)
          <tr>
            <form action="{{ route('admin.pillars.update', $pillar) }}" method="POST">
              @csrf
              @method('PUT')
              <td>
                <input type="number" name="order" class="form-control" value="{{ $pillar->order }}">
              </td>
              <td style="width: 65px; text-align: center;">
                <input type="text" name="icon" class="form-control" value="{{ $pillar->icon }}">
              </td>
              <td>
                <input type="text" name="title" class="form-control" value="{{ $pillar->title }}">
              </td>
              <td>
                <textarea name="description" class="form-control">{{ $pillar->description }}</textarea>
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
    <h3>Add New Pillar Card</h3>
  </div>

  <form action="{{ route('admin.pillars.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Target Page</label>
        <select name="page" class="form-control">
          <option value="home">Homepage (Four Pillars)</option>
          <option value="philosophy">Philosophy Page (Three Pillars)</option>
        </select>
      </div>

      <div class="form-group">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control">
      </div>

      <div class="form-group">
        <label class="form-label">Upload 3D Image (For Homepage Pillars)</label>
        <input type="file" name="image_file" class="form-control" accept="image/*">
      </div>

      <div class="form-group">
        <label class="form-label">Icon Emoji (For Philosophy Pillars)</label>
        <input type="text" name="icon" class="form-control" placeholder="🌐">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control"></textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Link Text (For Homepage Pillars)</label>
        <input type="text" name="link_text" class="form-control" placeholder="Learn More ➔">
      </div>

      <div class="form-group">
        <label class="form-label">Link URL / href (For Homepage Pillars)</label>
        <input type="text" name="link_url" class="form-control" placeholder="e.g. /education or https://...">
      </div>

      <div class="form-group">
        <label class="form-label">Care Model (For Homepage Pillars)</label>
        <input type="text" name="care_model" class="form-control" placeholder="TeleMedicine Standard">
      </div>

      <div class="form-group">
        <label class="form-label">Display Order</label>
        <input type="number" name="order" class="form-control" value="1">
      </div>

      <div class="form-group">
        <label class="form-label">Status</label>
        <select name="is_active" class="form-control">
          <option value="1">Active</option>
          <option value="0">Disabled</option>
        </select>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">➕ Create Pillar Card</button>
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
