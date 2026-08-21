@extends('admin.layouts.admin')

@section('title', 'Home - Practice Schedule')
@section('breadcrumbs')
  <a href="{{ route('admin.dashboard') }}">Admin</a> <span class="separator">/</span> <span>Home</span> <span class="separator">/</span> <span>Practice Schedule</span>
@endsection
@section('page_title', 'Practice Working Hours & Schedule')

@section('content')
<div class="page-desc-banner">
  <i class="fa-solid fa-calendar-days"></i>
  <p>Manage clinic working hours, telehealth schedule, and top bar announcements displayed on the Home page and header banner.</p>
</div>

<div class="card">
  <div class="card-header">
    <h3>Practice Schedule & Hours Settings</h3>
  </div>

  <form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Schedule Section Pill Badge</label>
        <input type="text" name="schedule_badge" class="form-control" value="{{ $settings['schedule_badge'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Schedule Section Heading</label>
        <input type="text" name="schedule_title" class="form-control" value="{{ $settings['schedule_title'] ?? '' }}">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Schedule Section Subtitle / Note</label>
        <textarea name="schedule_subtitle" class="form-control">{{ $settings['schedule_subtitle'] ?? '' }}</textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Top Bar Hours Summary Text</label>
        <input type="text" name="hours_summary" class="form-control" value="{{ $settings['hours_summary'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">In-Clinic Practice Hours</label>
        <input type="text" name="hours_clinic_text" class="form-control" value="{{ $settings['hours_clinic_text'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Telehealth Practice Hours</label>
        <input type="text" name="hours_telehealth_text" class="form-control" value="{{ $settings['hours_telehealth_text'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Sunday Hours / Emergency Note</label>
        <input type="text" name="hours_sunday_text" class="form-control" value="{{ $settings['hours_sunday_text'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Practice Slogan</label>
        <input type="text" name="slogan" class="form-control" value="{{ $settings['slogan'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Hospital / System Affiliation</label>
        <input type="text" name="affiliation" class="form-control" value="{{ $settings['affiliation'] ?? '' }}">
      </div>
    </div>

    <button type="submit" class="btn btn-primary">💾 Save Practice Schedule</button>
  </form>
</div>
@endsection
