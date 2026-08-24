@extends('admin.layouts.admin')

@section('title', 'Concierge Medicine - Hero & Homepage Banner')
@section('breadcrumbs')
  <a href="{{ route('admin.dashboard') }}">Admin</a> <span class="separator">/</span> <span>Concierge Medicine</span> <span class="separator">/</span> <span>Hero & Homepage Banner</span>
@endsection
@section('page_title', 'Concierge Hero & Homepage Teaser Banner')

@section('content')
<div class="page-desc-banner">
  <i class="fa-solid fa-wand-magic-sparkles"></i>
  <p>Manage the hero banner heading, buttons, description, visual image for the Concierge page (/concierge), and the homepage teaser banner.</p>
</div>

<!-- Concierge Hero Section Form -->
<div class="card mb-4">
  <div class="card-header">
    <h3>Concierge Page Hero Banner & Action Buttons</h3>
  </div>

  <form action="{{ route('admin.heroes.update', 'concierge') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Hero Main Title (Normal Text)</label>
        <input type="text" name="title" class="form-control" value="{{ $hero->title ?? "CHOOSE THE PLAN THAT'S" }}" placeholder="e.g. CHOOSE THE PLAN THAT'S">
      </div>

      <div class="form-group">
        <label class="form-label">Hero Highlight Text (Crimson Accent)</label>
        <input type="text" name="title_highlight" class="form-control" value="{{ $hero->title_highlight ?? 'RIGHT FOR YOU!' }}" placeholder="e.g. RIGHT FOR YOU!">
        <small style="color: var(--text-muted); font-size: 0.78rem;">Appears in crimson gradient styling on the frontend.</small>
      </div>

      <div class="form-group">
        <label class="form-label">Hero Primary Button Label</label>
        <input type="text" name="btn_primary_text" class="form-control" value="{{ $hero->btn_primary_text ?? '💎 Explore Membership Plans' }}" placeholder="e.g. 💎 Explore Membership Plans">
      </div>

      <div class="form-group">
        <label class="form-label">Hero Secondary Button Label</label>
        <input type="text" name="btn_secondary_text" class="form-control" value="{{ $hero->btn_secondary_text ?? '📅 Schedule Consultation' }}" placeholder="e.g. 📅 Schedule Consultation">
      </div>

      <div class="form-group">
        <label class="form-label">Hero Image File (Transparent Clay Visual)</label>
        <input type="file" name="image_file" class="form-control" accept="image/*">
        @if(!empty($hero->image_path))
          <div style="margin-top: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <img src="{{ asset($hero->image_path) }}" alt="Current Hero Image" style="height: 45px; border-radius: 6px; border: 1px solid #cbd5e1;">
            <span style="font-size: 0.8rem; color: var(--text-muted);">Current Image</span>
          </div>
        @endif
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Hero Subtitle / Description</label>
      <textarea name="subtitle" class="form-control" style="min-height: 110px;">{{ strip_tags($hero->subtitle ?? "We offer the Gold, Platinum, & Diamond Concierge Medicine plans based on your family's anticipated healthcare needs. No matter the plan you choose, you will be offered quick access to medical care and have the peace of mind that your healthcare is always our #1 priority!") }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">💾 Save Concierge Hero Settings</button>
  </form>
</div>

<!-- Homepage Teaser Banner Form -->
<div class="card">
  <div class="card-header">
    <h3>Homepage Concierge Teaser Banner (index.blade.php)</h3>
  </div>

  <form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Homepage Banner Icon Emoji</label>
        <input type="text" name="home_concierge_icon" class="form-control" value="{{ $settings['home_concierge_icon'] ?? '💎' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Homepage Banner Badge Label</label>
        <input type="text" name="home_concierge_badge" class="form-control" value="{{ $settings['home_concierge_badge'] ?? 'VIP CARE MEMBERSHIP' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Homepage Banner Title</label>
        <input type="text" name="home_concierge_title" class="form-control" value="{{ $settings['home_concierge_title'] ?? 'Concierge Medicine & Direct Primary Care' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Homepage Banner Button Label</label>
        <input type="text" name="home_concierge_btn_text" class="form-control" value="{{ $settings['home_concierge_btn_text'] ?? 'Explore Concierge Plans' }}">
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Homepage Banner Subtitle / Description</label>
      <textarea name="home_concierge_subtitle" class="form-control" style="min-height: 80px;">{{ $settings['home_concierge_subtitle'] ?? 'Unlimited office visits, 24/7 direct physician access, zero wait times & annual wellness packages.' }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">💾 Save Homepage Teaser Banner Settings</button>
  </form>
</div>
@endsection
