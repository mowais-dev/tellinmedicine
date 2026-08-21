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
          <tr>
            <form action="{{ route('admin.specialists.update', $spec) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <td style="text-align: center;">
                <div style="width: 50px; height: 50px; border-radius: 50%; overflow: hidden; margin: 0 auto; border: 2px solid var(--border-color); background: #f0f9ff;">
                  @if(!empty($spec->image))
                    <img src="{{ asset($spec->image) }}" alt="{{ $spec->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                  @else
                    <span style="font-size: 1.5rem; line-height: 50px;">🩺</span>
                  @endif
                </div>
              </td>
              <td>
                <input type="text" name="name" class="form-control" value="{{ $spec->name }}" style="font-weight: 700; margin-bottom: 0.3rem;">
                <input type="text" name="title" class="form-control" value="{{ $spec->title }}" placeholder="Title / Specialty">
              </td>
              <td>
                <input type="text" name="qualifications" class="form-control" value="{{ $spec->qualifications }}" placeholder="Qualifications (e.g. MD, FACP)" style="margin-bottom: 0.3rem;">
                <input type="text" name="experience_years" class="form-control" value="{{ $spec->experience_years }}" placeholder="Experience (e.g. 15+ Years)">
              </td>
              <td>
                <input type="number" name="order" class="form-control" value="{{ $spec->order }}" style="text-align: center;">
              </td>
              <td>
                <select name="is_active" class="form-control">
                  <option value="1" {{ $spec->is_active ? 'selected' : '' }}>Active</option>
                  <option value="0" {{ !$spec->is_active ? 'selected' : '' }}>Disabled</option>
                </select>
              </td>
              <td>
                <div style="display: flex; gap: 0.5rem; align-items: center; white-space: nowrap;">
                  <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-floppy-disk"></i> Save</button>
            </form>
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
                    <input type="file" name="image_file" class="form-control" style="font-size: 0.8rem;">
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
        <input type="file" name="image_file" class="form-control">
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
@endsection
