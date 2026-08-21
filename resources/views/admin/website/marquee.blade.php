@extends('admin.layouts.admin')

@section('title', 'Website - Marquee / Top Bar')
@section('breadcrumbs')
  <a href="{{ route('admin.dashboard') }}">Admin</a> <span class="separator">/</span> <span>Website</span> <span class="separator">/</span> <span>Marquee / Top Bar</span>
@endsection
@section('page_title', 'Top Bar & Announcement Marquee')

@section('content')
<div class="page-desc-banner">
  <i class="fa-solid fa-bullhorn"></i>
  <p>Manage all items scrolling in the top marquee bar across the entire website: clinic address, primary and secondary phone numbers, email address, health system affiliation, working hours summary, and practice motto.</p>
</div>

<div class="card">
  <div class="card-header">
    <h3>Top Bar Announcement & Marquee Items</h3>
  </div>

  <form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Top Marquee Working Hours Summary</label>
        <textarea name="hours_summary" class="form-control" style="min-height: 90px;" placeholder="e.g. In-Clinic: Mon-Sat 8 AM-12 PM | E-Appointments: Mon-Sat 12 PM-6 PM">{{ $settings['hours_summary'] ?? '' }}</textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Clinic Street Address</label>
        <input type="text" name="address" class="form-control" value="{{ $settings['address'] ?? '' }}" placeholder="e.g. 380 Elm Street Suite 1, North Attleboro, MA 02760">
      </div>

      <div class="form-group">
        <label class="form-label">Health System Affiliation</label>
        <input type="text" name="affiliation" class="form-control" value="{{ $settings['affiliation'] ?? '' }}" placeholder="e.g. Affiliated with Steward Health Systems">
      </div>

      <div class="form-group">
        <label class="form-label">Primary Office Phone</label>
        <input type="text" name="phone_primary" class="form-control" value="{{ $settings['phone_primary'] ?? '' }}" placeholder="e.g. (508) 555-0199">
      </div>

      <div class="form-group">
        <label class="form-label">Secondary / Mobile Phone</label>
        <input type="text" name="phone_secondary" class="form-control" value="{{ $settings['phone_secondary'] ?? '' }}" placeholder="e.g. (617) 513-1446">
      </div>

      <div class="form-group">
        <label class="form-label">Contact Email Address</label>
        <input type="email" name="email" class="form-control" value="{{ $settings['email'] ?? '' }}" placeholder="e.g. tellinmedicinellc@gmail.com">
      </div>

      <div class="form-group">
        <label class="form-label">Practice Motto / Slogan</label>
        <input type="text" name="slogan" class="form-control" value="{{ $settings['slogan'] ?? '' }}" placeholder="e.g. Access to Health is Access to Wealth">
      </div>
    </div>

    <button type="submit" class="btn btn-primary">💾 Save Top Marquee Bar Settings</button>
  </form>
</div>
@endsection
