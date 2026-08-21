@extends('admin.layouts.admin')

@section('title', 'Patient Education - Preventive Checklists')
@section('breadcrumbs')
  <a href="{{ route('admin.dashboard') }}">Admin</a> <span class="separator">/</span> <span>Patient Education</span> <span class="separator">/</span> <span>Preventive Checklists</span>
@endsection
@section('page_title', 'Age-Appropriate Preventive Checklists')

@section('content')
<div class="page-desc-banner">
  <i class="fa-solid fa-list-check"></i>
  <p>Manage age-appropriate preventive health checklists, age group titles, checklist items, and bottom call-to-action banner text on the Patient Education page.</p>
</div>

<!-- Headings & Callout Banner -->
<div class="card">
  <div class="card-header">
    <h3>Checklists Section Headings & Bottom Callout Banner</h3>
  </div>

  <form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Section Pill Badge</label>
        <input type="text" name="education_checklists_badge" class="form-control" value="{{ $settings['education_checklists_badge'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Section Heading</label>
        <input type="text" name="education_checklists_title" class="form-control" value="{{ $settings['education_checklists_title'] ?? '' }}">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Section Subtitle / Description</label>
        <textarea name="education_checklists_subtitle" class="form-control">{{ $settings['education_checklists_subtitle'] ?? '' }}</textarea>
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Bottom Appointment Callout Banner Text</label>
        <textarea name="education_callout_text" class="form-control">{{ $settings['education_callout_text'] ?? '' }}</textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Callout Button Label</label>
        <input type="text" name="education_callout_btn_text" class="form-control" value="{{ $settings['education_callout_btn_text'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Callout Button Link / URL (href)</label>
        <input type="text" name="education_callout_btn_url" class="form-control" value="{{ $settings['education_callout_btn_url'] ?? '' }}" placeholder="e.g. /contact or https://...">
        <small style="color: var(--text-muted); font-size: 0.78rem;">Leave blank to open booking modal, or enter custom URL.</small>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">💾 Save Headings & Callout Text</button>
  </form>
</div>

<!-- Existing Checklists Table -->
<div class="card">
  <div class="card-header">
    <h3>Existing Preventive Health Checklists</h3>
  </div>

  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th style="min-width: 90px; width: 90px; text-align: center;">Order</th>
          <th style="min-width: 220px;">Age Group Title</th>
          <th style="min-width: 120px; width: 120px;">Border Accent Color</th>
          <th style="min-width: 320px;">Checklist Items (One item per line)</th>
          <th style="min-width: 130px; width: 130px; text-align: center;">Status</th>
          <th style="min-width: 190px; width: 190px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($checklists as $chk)
          <tr>
            <form action="{{ route('admin.education.checklists.update', $chk) }}" method="POST">
              @csrf
              @method('PUT')
              <td>
                <input type="number" name="order" class="form-control" value="{{ $chk->order }}">
              </td>
              <td>
                <input type="text" name="title" class="form-control" value="{{ $chk->title }}">
              </td>
              <td>
                <input type="color" name="border_color" class="form-control" value="{{ $chk->border_color }}" style="height: 42px; padding: 0.2rem;">
              </td>
              <td>
                <textarea name="items_raw" class="form-control">{{ is_array($chk->items) ? implode("\n", $chk->items) : '' }}</textarea>
              </td>
              <td>
                <select name="is_active" class="form-control">
                  <option value="1" {{ $chk->is_active ? 'selected' : '' }}>Active</option>
                  <option value="0" {{ !$chk->is_active ? 'selected' : '' }}>Disabled</option>
                </select>
              </td>
              <td>
                <div style="display: flex; gap: 0.5rem; align-items: center; white-space: nowrap;">
                  <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-floppy-disk"></i> Save</button>
            </form>
                  <form action="{{ route('admin.education.checklists.destroy', $chk) }}" method="POST" onsubmit="return confirm('Delete checklist?')">
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

<!-- Add Checklist -->
<div class="card">
  <div class="card-header">
    <h3>Add Age-Appropriate Preventive Checklist</h3>
  </div>

  <form action="{{ route('admin.education.checklists.store') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Checklist Card Title</label>
        <input type="text" name="title" class="form-control" placeholder="e.g. Adults Aged 40 - 65">
      </div>

      <div class="form-group">
        <label class="form-label">Card Accent Border Color</label>
        <input type="color" name="border_color" class="form-control" value="#1A84C5" style="height: 42px; padding: 0.2rem; cursor: pointer;">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Checklist Bullet Items (One per line)</label>
        <textarea name="items_raw" class="form-control" placeholder="Annual Physical Exam&#10;Cholesterol Screening&#10;Blood Pressure Check"></textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Display Order</label>
        <input type="number" name="order" class="form-control" value="{{ count($checklists) + 1 }}">
      </div>

      <div class="form-group">
        <label class="form-label">Status</label>
        <select name="is_active" class="form-control">
          <option value="1">Active</option>
          <option value="0">Disabled</option>
        </select>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">➕ Create Preventive Checklist</button>
  </form>
</div>
@endsection
