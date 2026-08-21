@extends('admin.layouts.admin')

@section('title', 'Doctor Bio & Timeline')
@section('page_title', 'Manage Doctor Profile & Career Timeline')

@section('content')

<div class="card">
  <div class="card-header">
    <h3>Doctor Biography & Practice Information</h3>
  </div>

  <form action="{{ route('admin.doctor.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="grid-2" style="align-items: start; margin-bottom: 1.5rem;">
      <div>
        <label class="form-label">Doctor Portrait Photo Preview</label>
        <div class="image-picker-box" style="padding: 1.5rem; text-align: center;">
          @if(!empty($doctor->photo_path) && file_exists(public_path($doctor->photo_path)))
            <img src="{{ asset($doctor->photo_path) }}" alt="Doctor Portrait" class="image-preview-img" id="doctorPreview" style="max-height: 180px; object-fit: contain;">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); margin-top: 0.5rem;">{{ $doctor->photo_path }}</div>
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
          <label class="form-label">Full Name & Credentials</label>
          <input type="text" name="name" class="form-control" value="{{ $doctor->name }}">
        </div>
        <div class="form-group">
          <label class="form-label">Medical Specialty</label>
          <input type="text" name="specialty" class="form-control" value="{{ $doctor->specialty }}">
        </div>
      </div>
    </div>

    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Years of Experience Badge Text</label>
        <input type="text" name="experience_years" class="form-control" value="{{ $doctor->experience_years }}">
      </div>

      <div class="form-group">
        <label class="form-label">Subtitle / Practice Motto</label>
        <input type="text" name="subtitle" class="form-control" value="{{ $doctor->subtitle }}">
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Full Biography Text</label>
      <textarea name="bio" class="form-control" style="min-height: 120px;">{{ $doctor->bio }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">💾 Save Doctor Profile</button>
  </form>
</div>

<div class="card">
  <div class="card-header">
    <h3>Doctor Career Timeline Milestones</h3>
  </div>

  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th style="width: 80px;">Order</th>
          <th style="width: 150px;">Year Range</th>
          <th style="width: 220px;">Title</th>
          <th>Description</th>
          <th style="width: 180px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($timelines as $t)
          <tr>
            <form action="{{ route('admin.doctor.timelines.update', $t) }}" method="POST">
              @csrf
              @method('PUT')
              <td>
                <input type="number" name="order" class="form-control" value="{{ $t->order }}">
              </td>
              <td>
                <input type="text" name="year_range" class="form-control" value="{{ $t->year_range }}">
              </td>
              <td>
                <input type="text" name="title" class="form-control" value="{{ $t->title }}">
              </td>
              <td>
                <textarea name="description" class="form-control">{{ $t->description }}</textarea>
              </td>
              <td>
                <div style="display: flex; gap: 0.5rem; align-items: center; white-space: nowrap;">
                  <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-floppy-disk"></i> Save</button>
            </form>
                  <form action="{{ route('admin.doctor.timelines.destroy', $t) }}" method="POST" onsubmit="return confirm('Delete timeline item?')">
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

<div class="card">
  <div class="card-header">
    <h3>Add Career Timeline Milestone</h3>
  </div>

  <form action="{{ route('admin.doctor.timelines.store') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Year Range (e.g. 2012 - Present)</label>
        <input type="text" name="year_range" class="form-control">
      </div>

      <div class="form-group">
        <label class="form-label">Milestone Title</label>
        <input type="text" name="title" class="form-control">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control"></textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Order</label>
        <input type="number" name="order" class="form-control" value="{{ count($timelines) + 1 }}">
      </div>
    </div>

    <button type="submit" class="btn btn-primary">➕ Add Timeline Milestone</button>
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
