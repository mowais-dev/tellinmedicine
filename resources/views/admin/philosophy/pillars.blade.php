@extends('admin.layouts.admin')

@section('title', 'Our Philosophy - Philosophy Pillars')
@section('breadcrumbs')
  <a href="{{ route('admin.dashboard') }}">Admin</a> <span class="separator">/</span> <span>Our Philosophy</span> <span class="separator">/</span> <span>Philosophy Pillars</span>
@endsection
@section('page_title', 'Principles & Pillars of Care')

@section('content')
<div class="page-desc-banner">
  <i class="fa-solid fa-layer-group"></i>
  <p>Manage the three core Principles & Pillars of Care cards displayed on Our Philosophy page, including icons, titles, and descriptions.</p>
</div>

<!-- Section Headings -->
<div class="card">
  <div class="card-header">
    <h3>Philosophy Pillars Section Headings</h3>
  </div>

  <form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Section Pill Badge</label>
        <input type="text" name="philosophy_pillars_badge" class="form-control" value="{{ $settings['philosophy_pillars_badge'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Section Heading</label>
        <input type="text" name="philosophy_pillars_title" class="form-control" value="{{ $settings['philosophy_pillars_title'] ?? '' }}">
      </div>
    </div>
    <button type="submit" class="btn btn-primary">💾 Save Section Headings</button>
  </form>
</div>

<!-- Philosophy Pillars Cards Table -->
<div class="card">
  <div class="card-header">
    <h3>Three Core Principles of Medical Care</h3>
  </div>

  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th style="min-width: 90px; width: 90px; text-align: center;">Order</th>
          <th style="min-width: 85px; width: 85px; text-align: center;">Icon</th>
          <th style="min-width: 220px;">Principle Title</th>
          <th style="min-width: 280px;">Description</th>
          <th style="min-width: 130px; width: 130px; text-align: center;">Status</th>
          <th style="min-width: 190px; width: 190px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($pillars as $pillar)
          <tr>
            <form action="{{ route('admin.pillars.update', $pillar) }}" method="POST">
              @csrf
              @method('PUT')
              <td>
                <input type="number" name="order" class="form-control" value="{{ $pillar->order }}">
              </td>
              <td style="min-width: 85px; width: 85px; text-align: center;">
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
                  <form action="{{ route('admin.pillars.destroy', $pillar) }}" method="POST" onsubmit="return confirm('Delete principle pillar?')">
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

<!-- Add Pillar -->
<div class="card">
  <div class="card-header">
    <h3>Add Philosophy Principle Card</h3>
  </div>

  <form action="{{ route('admin.pillars.store') }}" method="POST">
    @csrf
    <input type="hidden" name="page" value="philosophy">
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Icon Emoji</label>
        <input type="text" name="icon" class="form-control" placeholder="🌐">
      </div>

      <div class="form-group">
        <label class="form-label">Principle Title</label>
        <input type="text" name="title" class="form-control" placeholder="e.g. World TeleMedicine Beyond Borders">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control"></textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Display Order</label>
        <input type="number" name="order" class="form-control" value="{{ count($pillars) + 1 }}">
      </div>

      <div class="form-group">
        <label class="form-label">Status</label>
        <select name="is_active" class="form-control">
          <option value="1">Active</option>
          <option value="0">Disabled</option>
        </select>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">➕ Create Philosophy Principle Card</button>
  </form>
</div>
@endsection
