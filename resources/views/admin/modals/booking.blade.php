@extends('admin.layouts.admin')

@section('title', 'Modals & Popups - Appointment Booking Modal')
@section('breadcrumbs')
  <a href="{{ route('admin.dashboard') }}">Admin</a> <span class="separator">/</span> <span>Modals & Popups</span> <span class="separator">/</span> <span>Appointment Booking Modal</span>
@endsection
@section('page_title', 'Appointment Booking Modal Settings')

@section('content')
<div class="page-desc-banner">
  <i class="fa-solid fa-calendar-check"></i>
  <p>Manage the headings, care options (In-Clinic, Home Visit, Telehealth), form field labels, input placeholders, submit button text, and reason choices for the appointment booking popup modal.</p>
</div>

<div class="card">
  <div class="card-header">
    <h3>Booking Modal Headings, Care Options & Field Labels</h3>
  </div>

  <form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Modal Heading Title</label>
        <input type="text" name="booking_modal_title" class="form-control" value="{{ $settings['booking_modal_title'] ?? $settings['booking_title'] ?? '📅 Schedule Appointment' }}">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Care Delivery Section Label</label>
        <input type="text" name="booking_care_label" class="form-control" value="{{ $settings['booking_care_label'] ?? '1. Select Care Delivery Model' }}">
      </div>

      <div class="form-group">
        <label class="form-label">In-Clinic Option Title</label>
        <input type="text" name="booking_model_in_clinic" class="form-control" value="{{ $settings['booking_model_in_clinic'] ?? 'In-Clinic Visit' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Home Visit Option Title</label>
        <input type="text" name="booking_model_home" class="form-control" value="{{ $settings['booking_model_home'] ?? 'Home Visit' }}">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Telehealth Option Title</label>
        <input type="text" name="booking_model_telehealth" class="form-control" value="{{ $settings['booking_model_telehealth'] ?? 'Telehealth Visit' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Field Label (Full Name)</label>
        <input type="text" name="booking_label_name" class="form-control" value="{{ $settings['booking_label_name'] ?? 'Full Name' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Field Label (Phone Number)</label>
        <input type="text" name="booking_label_phone" class="form-control" value="{{ $settings['booking_label_phone'] ?? 'Phone Number' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Field Label (Email Address)</label>
        <input type="text" name="booking_label_email" class="form-control" value="{{ $settings['booking_label_email'] ?? 'Email Address' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Field Label (Preferred Date)</label>
        <input type="text" name="booking_label_date" class="form-control" value="{{ $settings['booking_label_date'] ?? 'Preferred Date' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Field Label (Reason for Visit)</label>
        <input type="text" name="booking_label_reason" class="form-control" value="{{ $settings['booking_label_reason'] ?? 'Reason for Visit' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Placeholder (Name)</label>
        <input type="text" name="booking_placeholder_name" class="form-control" value="{{ $settings['booking_placeholder_name'] ?? 'Patient\'s Full Name' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Placeholder (Phone)</label>
        <input type="text" name="booking_placeholder_phone" class="form-control" value="{{ $settings['booking_placeholder_phone'] ?? '(508) 555-0199' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Placeholder (Email)</label>
        <input type="text" name="booking_placeholder_email" class="form-control" value="{{ $settings['booking_placeholder_email'] ?? 'patient@example.com' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Submit Button Label</label>
        <input type="text" name="booking_btn_text" class="form-control" value="{{ $settings['booking_btn_text'] ?? '✅ Confirm & Request Appointment' }}">
      </div>
    </div>
    <button type="submit" class="btn btn-primary">💾 Save Booking Modal Settings</button>
  </form>
</div>

<!-- Reason Choices Table -->
<div class="card">
  <div class="card-header">
    <h3>Reason for Visit Dropdown Choices</h3>
  </div>

  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th style="min-width: 90px; width: 90px; text-align: center;">Order</th>
          <th>Display Label</th>
          <th>Submitted Value</th>
          <th>Redirect Link (Optional)</th>
          <th style="min-width: 130px; width: 130px; text-align: center;">Status</th>
          <th style="width: 180px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($reasons as $r)
          <tr>
            <form action="{{ route('admin.booking.reasons.update', $r) }}" method="POST">
              @csrf
              @method('PUT')
              <td>
                <input type="number" name="order" class="form-control" value="{{ $r->order }}">
              </td>
              <td>
                <input type="text" name="label" class="form-control" value="{{ $r->label }}">
              </td>
              <td>
                <input type="text" name="value" class="form-control" value="{{ $r->value }}">
              </td>
              <td>
                <input type="text" name="redirect_url" class="form-control" value="{{ $r->redirect_url }}" placeholder="https://example.com or /philosophy">
              </td>
              <td>
                <select name="is_active" class="form-control">
                  <option value="1" {{ $r->is_active ? 'selected' : '' }}>Active</option>
                  <option value="0" {{ !$r->is_active ? 'selected' : '' }}>Disabled</option>
                </select>
              </td>
              <td>
                <div style="display: flex; gap: 0.5rem; align-items: center; white-space: nowrap;">
                  <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-floppy-disk"></i> Save</button>
            </form>
                  <form action="{{ route('admin.booking.reasons.destroy', $r) }}" method="POST" onsubmit="return confirm('Delete booking reason?')">
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

<div class="card">
  <div class="card-header">
    <h3>Add Reason Choice Option</h3>
  </div>

  <form action="{{ route('admin.booking.reasons.store') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Display Label (Shown in Dropdown)</label>
        <input type="text" name="label" class="form-control" placeholder="e.g. Travel Vaccination Consultation">
      </div>

      <div class="form-group">
        <label class="form-label">Submitted Value Key</label>
        <input type="text" name="value" class="form-control" placeholder="e.g. travel_vaccination">
      </div>

      <div class="form-group">
        <label class="form-label">Redirect Link (Optional)</label>
        <input type="text" name="redirect_url" class="form-control" placeholder="https://example.com or /philosophy">
        <small style="color: var(--text-muted); font-size: 0.78rem;">If set, selecting this option in the dropdown will redirect the user to this URL link in a new tab.</small>
      </div>

      <div class="form-group">
        <label class="form-label">Display Order</label>
        <input type="number" name="order" class="form-control" value="{{ count($reasons) + 1 }}">
      </div>

      <div class="form-group">
        <label class="form-label">Status</label>
        <select name="is_active" class="form-control">
          <option value="1">Active</option>
          <option value="0">Disabled</option>
        </select>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">➕ Add Reason Option</button>
  </form>
</div>
@endsection
