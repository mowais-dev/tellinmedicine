@extends('admin.layouts.admin')

@section('title', 'Patient Education - Education Guides')
@section('breadcrumbs')
  <a href="{{ route('admin.dashboard') }}">Admin</a> <span class="separator">/</span> <span>Patient Education</span> <span class="separator">/</span> <span>Education Guides</span>
@endsection
@section('page_title', 'Chronic Disease Education Guides')

@section('content')
<div class="page-desc-banner">
  <i class="fa-solid fa-book-open"></i>
  <p>Manage chronic disease prevention & management guides, icons, bullet points, and section headings on the Patient Education page.</p>
</div>

<!-- Section Headings -->
<div class="card">
  <div class="card-header">
    <h3>Education Guides Section Headings</h3>
  </div>

  <form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Section Pill Badge</label>
        <input type="text" name="education_guides_badge" class="form-control" value="{{ $settings['education_guides_badge'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Section Heading</label>
        <input type="text" name="education_guides_title" class="form-control" value="{{ $settings['education_guides_title'] ?? '' }}">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Section Subtitle / Description</label>
        <textarea name="education_guides_subtitle" class="form-control">{{ $settings['education_guides_subtitle'] ?? '' }}</textarea>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">💾 Save Guides Section Headings</button>
  </form>
</div>

<!-- Existing Guides Table -->
<div class="card">
  <div class="card-header">
    <h3>Existing Chronic Disease Education Guides</h3>
  </div>

  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th style="min-width: 90px; width: 90px; text-align: center;">Order</th>
          <th style="min-width: 85px; width: 85px; text-align: center;">Icon</th>
          <th style="min-width: 200px;">Guide Title</th>
          <th style="min-width: 280px;">Description</th>
          <th style="min-width: 320px;">Bullet Features (One item per line)</th>
          <th style="min-width: 130px; width: 130px; text-align: center;">Status</th>
          <th style="min-width: 190px; width: 190px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($guides as $g)
          <tr>
            <form action="{{ route('admin.education.guides.update', $g) }}" method="POST">
              @csrf
              @method('PUT')
              <td>
                <input type="number" name="order" class="form-control" value="{{ $g->order }}">
              </td>
              <td style="min-width: 85px; width: 85px; text-align: center;">
                <input type="text" name="icon" class="form-control" value="{{ $g->icon }}">
              </td>
              <td>
                <input type="text" name="title" class="form-control" value="{{ $g->title }}">
              </td>
              <td>
                <textarea name="description" class="form-control">{{ $g->description }}</textarea>
              </td>
              <td>
                <textarea name="features_raw" class="form-control">{{ is_array($g->features) ? implode("\n", $g->features) : '' }}</textarea>
              </td>
              <td>
                <select name="is_active" class="form-control">
                  <option value="1" {{ $g->is_active ? 'selected' : '' }}>Active</option>
                  <option value="0" {{ !$g->is_active ? 'selected' : '' }}>Disabled</option>
                </select>
              </td>
              <td>
                <div style="display: flex; gap: 0.5rem; align-items: center; white-space: nowrap;">
                  <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-floppy-disk"></i> Save</button>
            </form>
                  <form action="{{ route('admin.education.guides.destroy', $g) }}" method="POST" onsubmit="return confirm('Delete education guide?')">
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

<!-- Add Guide -->
<div class="card">
  <div class="card-header">
    <h3>Add New Chronic Disease Guide</h3>
  </div>

  <form action="{{ route('admin.education.guides.store') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Icon Emoji</label>
        <input type="text" name="icon" class="form-control" placeholder="❤️">
      </div>

      <div class="form-group">
        <label class="form-label">Guide Title</label>
        <input type="text" name="title" class="form-control" placeholder="e.g. Hypertension & Heart Health">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control"></textarea>
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Bullet Features (One item per line)</label>
        <textarea name="features_raw" class="form-control" placeholder="Key feature 1&#10;Key feature 2"></textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Display Order</label>
        <input type="number" name="order" class="form-control" value="{{ count($guides) + 1 }}">
      </div>

      <div class="form-group">
        <label class="form-label">Status</label>
        <select name="is_active" class="form-control">
          <option value="1">Active</option>
          <option value="0">Disabled</option>
        </select>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">➕ Create Education Guide</button>
  </form>
</div>
@endsection
