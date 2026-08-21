@extends('admin.layouts.admin')

@section('title', 'Medical Philosophy')
@section('page_title', 'Manage Philosophy Hero, Article Content & Pillars')

@section('content')

<!-- Section 1: Philosophy Page Hero Banner -->
<div class="card">
  <div class="card-header">
    <h3>Medical Philosophy Hero Banner</h3>
  </div>

  <form action="{{ route('admin.heroes.update', 'philosophy') }}" method="POST">
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

    <button type="submit" class="btn btn-primary">💾 Save Philosophy Hero</button>
  </form>
</div>

<!-- Section 2: Main Philosophy Article Content -->
<div class="card">
  <div class="card-header">
    <h3>Main Philosophy Article Content & Call to Action</h3>
  </div>

  <form action="{{ route('admin.philosophy.update') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Header Icon Emoji</label>
        <input type="text" name="icon" class="form-control" value="{{ $philosophy->icon }}">
      </div>

      <div class="form-group">
        <label class="form-label">Article Title</label>
        <input type="text" name="title" class="form-control" value="{{ $philosophy->title }}">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Highlight Quote Box Text</label>
        <textarea name="highlight_quote" class="form-control">{{ strip_tags($philosophy->highlight_quote ?? '') }}</textarea>
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Paragraph 1</label>
        <textarea name="paragraph1" class="form-control" style="min-height: 100px;">{{ strip_tags($philosophy->paragraph1 ?? '') }}</textarea>
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Paragraph 2</label>
        <textarea name="paragraph2" class="form-control" style="min-height: 100px;">{{ strip_tags($philosophy->paragraph2 ?? '') }}</textarea>
      </div>
    </div>

    <hr style="margin: 1.5rem 0; border: none; border-top: 1px solid var(--border-light);">

    <h4 style="margin-bottom: 1rem; color: var(--text-dark); font-weight: 800;">Call to Action Banner</h4>

    <div class="grid-2">
      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">CTA Banner Title</label>
        <input type="text" name="cta_title" class="form-control" value="{{ $philosophy->cta_title }}">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">CTA Banner Description</label>
        <textarea name="cta_text" class="form-control">{{ $philosophy->cta_text }}</textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Phone Button Text</label>
        <input type="text" name="cta_phone_text" class="form-control" value="{{ $philosophy->cta_phone_text }}">
      </div>

      <div class="form-group">
        <label class="form-label">Phone Button URL Target</label>
        <input type="text" name="cta_phone_url" class="form-control" value="{{ $philosophy->cta_phone_url }}">
      </div>

      <div class="form-group">
        <label class="form-label">Online Form Button Text</label>
        <input type="text" name="cta_form_text" class="form-control" value="{{ $philosophy->cta_form_text }}">
      </div>

      <div class="form-group">
        <label class="form-label">Online Form Button Link / URL (href)</label>
        <input type="text" name="cta_form_url" class="form-control" value="{{ $philosophy->cta_form_url }}" placeholder="e.g. /contact or https://...">
        <small style="color: var(--text-muted); font-size: 0.78rem;">Leave blank to open booking modal, or enter custom URL.</small>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">💾 Save Philosophy Article</button>
  </form>
</div>

<!-- Section 3: Philosophy Page Pillars of Care -->
<div class="card">
  <div class="card-header">
    <h3>Medical Philosophy Page Pillars of Care</h3>
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

@endsection
