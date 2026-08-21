@extends('admin.layouts.admin')

@section('title', 'Website - Footer')
@section('breadcrumbs')
  <a href="{{ route('admin.dashboard') }}">Admin</a> <span class="separator">/</span> <span>Website</span> <span class="separator">/</span> <span>Footer</span>
@endsection
@section('page_title', 'Footer Content & Copyright Settings')

@section('content')
<div class="page-desc-banner">
  <i class="fa-solid fa-shoe-prints"></i>
  <p>Manage all text, column headings, patient portal access callout, portal button label, slogan pill, copyright notice, and medical affiliation displayed across the website footer.</p>
</div>

<div class="card">
  <div class="card-header">
    <h3>Website Footer Content & Column Headings</h3>
  </div>

  <form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Footer Practice Description</label>
        <textarea name="footer_description" class="form-control" style="min-height: 100px;">{{ strip_tags($settings['footer_description'] ?? '') }}</textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Footer Motto Pill Badge</label>
        <input type="text" name="slogan" class="form-control" value="{{ strip_tags($settings['slogan'] ?? '') }}" placeholder="e.g. Access to Health is Access to Wealth">
      </div>

      <div class="form-group">
        <label class="form-label">Column 1 Heading (Quick Navigation)</label>
        <input type="text" name="footer_col1_header" class="form-control" value="{{ strip_tags($settings['footer_col1_header'] ?? '') }}">
      </div>

      <div class="form-group">
        <label class="form-label">Column 2 Heading (Practice Services)</label>
        <input type="text" name="footer_col2_header" class="form-control" value="{{ strip_tags($settings['footer_col2_header'] ?? '') }}">
      </div>

      <div class="form-group">
        <label class="form-label">Column 3 Heading (Patient Portal)</label>
        <input type="text" name="footer_col3_header" class="form-control" value="{{ strip_tags($settings['footer_col3_header'] ?? '') }}">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Patient Portal Access Note</label>
        <textarea name="footer_portal_text" class="form-control" style="min-height: 90px;">{{ strip_tags($settings['footer_portal_text'] ?? '') }}</textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Patient Portal Button Text</label>
        <input type="text" name="portal_button_text" class="form-control" value="{{ strip_tags($settings['portal_button_text'] ?? '') }}" placeholder="e.g. Request Appointment">
      </div>

      <div class="form-group">
        <label class="form-label">Patient Portal Button Link / URL (href)</label>
        <input type="text" name="portal_button_url" class="form-control" value="{{ strip_tags($settings['portal_button_url'] ?? '') }}" placeholder="e.g. /contact or https://...">
        <small style="color: var(--text-muted); font-size: 0.78rem;">Leave blank to open booking modal, or enter custom URL.</small>
      </div>

      <div class="form-group">
        <label class="form-label">Medical System Affiliation Text</label>
        <input type="text" name="affiliation" class="form-control" value="{{ strip_tags($settings['affiliation'] ?? '') }}" placeholder="e.g. Affiliated with Steward Health Systems">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Copyright Notice Text</label>
        <input type="text" name="copyright_text" class="form-control" value="{{ strip_tags($settings['copyright_text'] ?? '') }}">
      </div>
    </div>

    <button type="submit" class="btn btn-primary">💾 Save Footer Content Settings</button>
  </form>
</div>
@endsection
