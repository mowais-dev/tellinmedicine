@extends('admin.layouts.admin')

@section('title', 'Our Philosophy - Philosophy Article')
@section('breadcrumbs')
  <a href="{{ route('admin.dashboard') }}">Admin</a> <span class="separator">/</span> <span>Our Philosophy</span> <span class="separator">/</span> <span>Philosophy Article</span>
@endsection
@section('page_title', 'Philosophy Article & Call to Action')

@section('content')
<div class="page-desc-banner">
  <i class="fa-solid fa-newspaper"></i>
  <p>Manage the main philosophy article essay, highlighted quote box, lead paragraphs, and bottom call-to-action banner on Our Philosophy page.</p>
</div>

<div class="card">
  <div class="card-header">
    <h3>Main Philosophy Article Content</h3>
  </div>

  <form action="{{ route('admin.philosophy.update') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Header Icon Emoji</label>
        <input type="text" name="icon" class="form-control" value="{{ $philosophy->icon }}">
      </div>

      <div class="form-group">
        <label class="form-label">Article Heading</label>
        <input type="text" name="title" class="form-control" value="{{ $philosophy->title }}">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Highlight Quote Box Text</label>
        <textarea name="highlight_quote" class="form-control" style="min-height: 90px;">{{ strip_tags($philosophy->highlight_quote ?? '') }}</textarea>
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">First Article Paragraph</label>
        <textarea name="paragraph1" class="form-control" style="min-height: 110px;">{{ strip_tags($philosophy->paragraph1 ?? '') }}</textarea>
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Second Article Paragraph</label>
        <textarea name="paragraph2" class="form-control" style="min-height: 110px;">{{ strip_tags($philosophy->paragraph2 ?? '') }}</textarea>
      </div>
    </div>

    <hr style="margin: 1.5rem 0; border: none; border-top: 1px solid var(--border-light);">

    <h4 style="margin-bottom: 1rem; color: var(--text-dark); font-weight: 800;">Bottom Call-to-Action Banner</h4>

    <div class="grid-2">
      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">CTA Banner Heading</label>
        <input type="text" name="cta_title" class="form-control" value="{{ $philosophy->cta_title }}">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">CTA Banner Description</label>
        <textarea name="cta_text" class="form-control">{{ $philosophy->cta_text }}</textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Phone Button Label</label>
        <input type="text" name="cta_phone_text" class="form-control" value="{{ $philosophy->cta_phone_text }}">
      </div>

      <div class="form-group">
        <label class="form-label">Phone Link Target (tel: URI)</label>
        <input type="text" name="cta_phone_url" class="form-control" value="{{ $philosophy->cta_phone_url }}">
      </div>

      <div class="form-group">
        <label class="form-label">Online Booking Button Label</label>
        <input type="text" name="cta_form_text" class="form-control" value="{{ $philosophy->cta_form_text }}">
      </div>

      <div class="form-group">
        <label class="form-label">Online Booking Button Link / URL (href)</label>
        <input type="text" name="cta_form_url" class="form-control" value="{{ $philosophy->cta_form_url }}" placeholder="e.g. /contact or https://...">
        <small style="color: var(--text-muted); font-size: 0.78rem;">Leave blank to open booking modal, or enter custom URL.</small>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">💾 Save Philosophy Article & Banner</button>
  </form>
</div>
@endsection
