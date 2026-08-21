@extends('admin.layouts.admin')

@section('title', 'Education & Checklists')
@section('page_title', 'Manage Patient Education Guides, BMI & Checklists')

@section('content')

<!-- Section 0: Education Hero Banner -->
<div class="card">
  <div class="card-header">
    <h3>Patient Education Hero Banner</h3>
  </div>

  <form action="{{ route('admin.heroes.update', 'education') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Hero Badge Pill</label>
        <input type="text" name="badge" class="form-control" value="{{ $hero->badge ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Hero Title</label>
        <input type="text" name="title" class="form-control" value="{{ strip_tags($hero->title ?? '') }}">
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Hero Subtitle</label>
      <textarea name="subtitle" class="form-control">{{ strip_tags($hero->subtitle ?? '') }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">💾 Save Education Hero</button>
  </form>
</div>

<!-- Section 1: BMI Section Content -->
<div class="card">
  <div class="card-header">
    <h3>Interactive BMI Calculator Section Content</h3>
  </div>

  <form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Section Badge</label>
        <input type="text" name="bmi_badge" class="form-control" value="{{ $settings['bmi_badge'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Section Title</label>
        <input type="text" name="bmi_title" class="form-control" value="{{ $settings['bmi_title'] ?? '' }}">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Section Subtitle</label>
        <textarea name="bmi_subtitle" class="form-control">{{ $settings['bmi_subtitle'] ?? '' }}</textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Calculator Card Title</label>
        <input type="text" name="bmi_card_title" class="form-control" value="{{ $settings['bmi_card_title'] ?? '' }}">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Calculator Card Description</label>
        <textarea name="bmi_card_desc" class="form-control">{{ $settings['bmi_card_desc'] ?? '' }}</textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Height Field Label</label>
        <input type="text" name="bmi_label_height" class="form-control" value="{{ $settings['bmi_label_height'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Weight Field Label</label>
        <input type="text" name="bmi_label_weight" class="form-control" value="{{ $settings['bmi_label_weight'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Age Field Label</label>
        <input type="text" name="bmi_label_age" class="form-control" value="{{ $settings['bmi_label_age'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Calculate Button Text</label>
        <input type="text" name="bmi_btn_text" class="form-control" value="{{ $settings['bmi_btn_text'] ?? '' }}">
      </div>
    </div>
    <button type="submit" class="btn btn-primary">💾 Save BMI Calculator Content</button>
  </form>
</div>

<!-- Section 2: Education Guides Section Headings & Cards -->
<div class="card">
  <div class="card-header">
    <h3>Chronic Disease Education Guides Section Headings</h3>
  </div>

  <form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Section Badge</label>
        <input type="text" name="education_guides_badge" class="form-control" value="{{ $settings['education_guides_badge'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Section Title</label>
        <input type="text" name="education_guides_title" class="form-control" value="{{ $settings['education_guides_title'] ?? '' }}">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Section Subtitle</label>
        <textarea name="education_guides_subtitle" class="form-control">{{ $settings['education_guides_subtitle'] ?? '' }}</textarea>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">💾 Save Guides Section Headings</button>
  </form>
</div>

<div class="card">
  <div class="card-header">
    <h3>Chronic Disease Prevention & Management Guides</h3>
  </div>

  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th style="min-width: 75px; width: 75px;">Order</th>
          <th style="min-width: 65px; width: 65px; text-align: center;">Icon</th>
          <th style="min-width: 200px;">Title</th>
          <th style="min-width: 280px;">Description</th>
          <th style="min-width: 320px;">Bullet Features (One per line)</th>
          <th style="min-width: 120px; width: 120px;">Status</th>
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
              <td style="width: 65px; text-align: center;">
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
                  <form action="{{ route('admin.education.guides.destroy', $g) }}" method="POST" onsubmit="return confirm('Delete guide?')">
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
    <h3>Add Chronic Disease Guide</h3>
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
        <input type="text" name="title" class="form-control">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control"></textarea>
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Bullet Features (One item per line)</label>
        <textarea name="features_raw" class="form-control"></textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Order</label>
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

<!-- Section 3: Preventive Checklists Section Headings & Cards -->
<div class="card">
  <div class="card-header">
    <h3>Preventive Checklists Section Headings & Callout Banner</h3>
  </div>

  <form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Section Badge</label>
        <input type="text" name="education_checklists_badge" class="form-control" value="{{ $settings['education_checklists_badge'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Section Title</label>
        <input type="text" name="education_checklists_title" class="form-control" value="{{ $settings['education_checklists_title'] ?? '' }}">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Section Subtitle</label>
        <textarea name="education_checklists_subtitle" class="form-control">{{ $settings['education_checklists_subtitle'] ?? '' }}</textarea>
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Bottom Appointment Callout Text</label>
        <textarea name="education_callout_text" class="form-control">{{ $settings['education_callout_text'] ?? '' }}</textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Callout Button Text</label>
        <input type="text" name="education_callout_btn_text" class="form-control" value="{{ $settings['education_callout_btn_text'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Callout Button Link / URL (href)</label>
        <input type="text" name="education_callout_btn_url" class="form-control" value="{{ $settings['education_callout_btn_url'] ?? '' }}" placeholder="e.g. /contact or https://...">
        <small style="color: var(--text-muted); font-size: 0.78rem;">Leave blank to open booking modal, or enter custom URL.</small>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">💾 Save Checklists Headings & Callout</button>
  </form>
</div>

<div class="card">
  <div class="card-header">
    <h3>Age-Appropriate Preventive Checklists</h3>
  </div>

  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th style="min-width: 75px; width: 75px;">Order</th>
          <th style="min-width: 220px;">Group Title</th>
          <th style="min-width: 120px; width: 120px;">Border Accent</th>
          <th style="min-width: 320px;">Checklist Items (One per line)</th>
          <th style="min-width: 120px; width: 120px;">Status</th>
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
@endsection
