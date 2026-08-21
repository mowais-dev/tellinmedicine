@extends('admin.layouts.admin')

@section('title', 'Our Philosophy - Hero Section')
@section('breadcrumbs')
  <a href="{{ route('admin.dashboard') }}">Admin</a> <span class="separator">/</span> <span>Our Philosophy</span> <span class="separator">/</span> <span>Hero Section</span>
@endsection
@section('page_title', 'Medical Philosophy Hero Banner')

@section('content')
<div class="page-desc-banner">
  <i class="fa-solid fa-wand-magic-sparkles"></i>
  <p>Manage the hero banner heading, badge pill, and subtitle displayed at the top of Our Philosophy page (/philosophy).</p>
</div>

<div class="card">
  <div class="card-header">
    <h3>Medical Philosophy Hero Banner</h3>
  </div>

  <form action="{{ route('admin.heroes.update', 'philosophy') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Hero Badge Pill</label>
        <input type="text" name="badge" class="form-control" value="{{ $hero->badge ?? '' }}" placeholder="e.g. Access to Health is Access to Wealth">
      </div>

      <div class="form-group">
        <label class="form-label">Hero Main Title (Normal Text)</label>
        <input type="text" name="title" class="form-control" value="{{ $hero->title ?? '' }}" placeholder="e.g. Our Medical">
      </div>

      <div class="form-group">
        <label class="form-label">Hero Highlight Text (Crimson Accent)</label>
        <input type="text" name="title_highlight" class="form-control" value="{{ $hero->title_highlight ?? '' }}" placeholder="e.g. Philosophy">
        <small style="color: var(--text-muted); font-size: 0.78rem;">Text entered here will appear in the crimson gradient accent color on the website.</small>
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Hero Subtitle / Description</label>
      <textarea name="subtitle" class="form-control" style="min-height: 110px;">{{ strip_tags($hero->subtitle ?? '') }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">💾 Save Philosophy Hero</button>
  </form>
</div>
@endsection
