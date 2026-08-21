@extends('admin.layouts.admin')

@section('title', 'Notification Email Recipients')

@section('breadcrumbs')
  <a href="{{ route('admin.dashboard') }}">Admin</a> <span class="separator">/</span> <span>Notifications</span> <span class="separator">/</span> <span>Email Recipients</span>
@endsection

@section('page_title', 'Appointment Notification Email Recipients')

@section('content')
<div class="page-desc-banner">
  <i class="fa-solid fa-envelope-open-text"></i>
  <p>Manage the email addresses that receive instant notification emails whenever a patient requests an appointment. You can add new recipient emails, toggle their active status, or remove old ones.</p>
</div>

<!-- Add New Notification Email Card -->
<div class="card" style="margin-bottom: 2rem;">
  <div class="card-header">
    <h3>➕ Add New Email Recipient</h3>
  </div>

  <form action="{{ route('admin.emails.store') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Email Address <span style="color: #ef4444;">*</span></label>
        <input type="email" name="email" class="form-control" placeholder="e.g. doctor@tellinmedicine.com" required>
      </div>

      <div class="form-group">
        <label class="form-label">Description / Label (Optional)</label>
        <input type="text" name="label" class="form-control" placeholder="e.g. Dr. Ngomba Main, Front Desk, Billing">
      </div>
    </div>
    <button type="submit" class="btn btn-primary">➕ Add Email Recipient</button>
  </form>
</div>

<!-- Existing Notification Email Recipients Table Card -->
<div class="card">
  <div class="card-header">
    <h3>📧 Configured Email Recipients</h3>
  </div>

  @if($recipients->isEmpty())
    <p style="color: var(--text-muted); padding: 1.5rem; text-align: center;">No email recipients configured yet. Add an email above to start receiving appointment notifications.</p>
  @else
    <div style="overflow-x: auto;">
      <table class="data-table">
        <thead>
          <tr>
            <th style="width: 35%;">EMAIL ADDRESS</th>
            <th style="width: 30%;">LABEL / RECIPIENT NAME</th>
            <th style="width: 15%;">STATUS</th>
            <th style="width: 20%;">ACTIONS</th>
          </tr>
        </thead>
        <tbody>
          @foreach($recipients as $item)
            <tr>
              <td>
                <form action="{{ route('admin.emails.update', $item) }}" method="POST" id="edit-form-{{ $item->id }}">
                  @csrf
                  @method('PUT')
                  <input type="email" name="email" class="form-control" value="{{ $item->email }}" required>
              </td>
              <td>
                  <input type="text" name="label" class="form-control" value="{{ $item->label }}" placeholder="e.g. Main Clinic Email">
              </td>
              <td>
                  <select name="is_active" class="form-control">
                    <option value="1" {{ $item->is_active ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$item->is_active ? 'selected' : '' }}>Disabled</option>
                  </select>
              </td>
              <td>
                  <div style="display: flex; gap: 0.5rem; align-items: center; white-space: nowrap;">
                    <button type="submit" class="btn btn-primary btn-sm">💾 Save</button>
                </form>
                    <form action="{{ route('admin.emails.destroy', $item) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this email recipient?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm">🗑️ Delete</button>
                    </form>
                  </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>
@endsection
