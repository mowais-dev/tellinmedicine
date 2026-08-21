@extends('admin.layouts.admin')

@section('title', 'Home - Services')
@section('breadcrumbs')
  <a href="{{ route('admin.dashboard') }}">Admin</a> <span class="separator">/</span> <span>Home</span> <span class="separator">/</span> <span>Services</span>
@endsection
@section('page_title', 'Services Suite')

@section('content')
<div class="page-desc-banner">
  <i class="fa-solid fa-stethoscope"></i>
  <p>Manage the clinical services offerings, category filter tabs, bullet features, and section headings displayed in the Services section of the Home page.</p>
</div>

<!-- Headings Section -->
<div class="card">
  <div class="card-header">
    <h3>Services Section Headings</h3>
  </div>

  <form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Section Pill Badge</label>
        <input type="text" name="services_badge" class="form-control" value="{{ $settings['services_badge'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Section Heading</label>
        <input type="text" name="services_title" class="form-control" value="{{ $settings['services_title'] ?? '' }}">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Section Subtitle / Description</label>
        <textarea name="services_subtitle" class="form-control">{{ $settings['services_subtitle'] ?? '' }}</textarea>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">💾 Save Services Headings</button>
  </form>
</div>

<!-- Category Filter Tabs -->
<div class="card">
  <div class="card-header">
    <h3>Services Category Filter Tabs</h3>
  </div>

  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th style="width: 120px;">Tab Key</th>
          <th style="width: 80px;">Order</th>
          <th>Label Title</th>
          <th style="width: 110px;">Status</th>
          <th style="width: 180px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($categories as $cat)
          <tr>
            <form action="{{ route('admin.services.categories.update', $cat) }}" method="POST">
              @csrf
              @method('PUT')
              <td style="font-weight: 700;">
                {{ $cat->key }}
              </td>
              <td>
                <input type="number" name="order" class="form-control" value="{{ $cat->order }}">
              </td>
              <td>
                <input type="text" name="label" class="form-control" value="{{ $cat->label }}">
              </td>
              <td>
                <select name="is_active" class="form-control">
                  <option value="1" {{ $cat->is_active ? 'selected' : '' }}>Active</option>
                  <option value="0" {{ !$cat->is_active ? 'selected' : '' }}>Disabled</option>
                </select>
              </td>
              <td>
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-floppy-disk"></i> Save Tab</button>
            </form>
              </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<!-- Existing Service Offerings -->
<div class="card">
  <div class="card-header">
    <h3>Existing Medical Offerings</h3>
  </div>

  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th style="min-width: 90px; width: 90px; text-align: center;">Order</th>
          <th style="min-width: 130px; width: 130px;">Category</th>
          <th style="min-width: 85px; width: 85px; text-align: center;">Icon</th>
          <th style="min-width: 200px;">Title</th>
          <th style="min-width: 250px;">Description</th>
          <th style="min-width: 250px;">Bullet Features (One per line)</th>
          <th style="min-width: 130px;">Button Label</th>
          <th style="min-width: 160px;">Button Link (href)</th>
          <th style="min-width: 140px;">Care Option</th>
          <th style="min-width: 130px; width: 130px; text-align: center;">Status</th>
          <th style="min-width: 190px; width: 190px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($services as $srv)
          <tr>
            <form action="{{ route('admin.services.update', $srv) }}" method="POST">
              @csrf
              @method('PUT')
              <td>
                <input type="number" name="order" class="form-control" value="{{ $srv->order }}">
              </td>
              <td>
                <select name="category" class="form-control">
                  <option value="primary" {{ $srv->category === 'primary' ? 'selected' : '' }}>Primary Care</option>
                  <option value="home" {{ $srv->category === 'home' ? 'selected' : '' }}>Home Visits</option>
                  <option value="telehealth" {{ $srv->category === 'telehealth' ? 'selected' : '' }}>Telehealth</option>
                  <option value="certs" {{ $srv->category === 'certs' ? 'selected' : '' }}>Certs & Physicals</option>
                </select>
              </td>
              <td style="min-width: 85px; width: 85px; text-align: center;">
                <input type="text" name="icon" class="form-control" value="{{ $srv->icon }}">
              </td>
              <td>
                <input type="text" name="title" class="form-control" value="{{ $srv->title }}">
              </td>
              <td>
                <textarea name="description" class="form-control">{{ $srv->description }}</textarea>
              </td>
              <td>
                <textarea name="features_raw" class="form-control">{{ is_array($srv->features) ? implode("\n", $srv->features) : '' }}</textarea>
              </td>
              <td>
                <input type="text" name="button_text" class="form-control" value="{{ $srv->button_text }}">
              </td>
              <td>
                <input type="text" name="button_url" class="form-control" value="{{ $srv->button_url }}" placeholder="e.g. /contact or #booking">
              </td>
              <td>
                <input type="text" name="care_model" class="form-control" value="{{ $srv->care_model }}">
              </td>
              <td>
                <select name="is_active" class="form-control">
                  <option value="1" {{ $srv->is_active ? 'selected' : '' }}>Active</option>
                  <option value="0" {{ !$srv->is_active ? 'selected' : '' }}>Disabled</option>
                </select>
              </td>
              <td>
                <div style="display: flex; gap: 0.5rem; align-items: center; white-space: nowrap;">
                  <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-floppy-disk"></i> Save</button>
            </form>
                  <form action="{{ route('admin.services.destroy', $srv) }}" method="POST" onsubmit="return confirm('Delete service offering?')">
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

<!-- Add Service Offering -->
<div class="card">
  <div class="card-header">
    <h3>Add New Service Offering</h3>
  </div>

  <form action="{{ route('admin.services.store') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Category Tab</label>
        <select name="category" class="form-control">
          <option value="primary">Primary Care</option>
          <option value="home">Home Visits</option>
          <option value="telehealth">Telehealth</option>
          <option value="certs">Certs & Physicals</option>
        </select>
      </div>

      <div class="form-group">
        <label class="form-label">Service Title</label>
        <input type="text" name="title" class="form-control" placeholder="e.g. DOT Physical Exams">
      </div>

      <div class="form-group">
        <label class="form-label">Icon Emoji</label>
        <input type="text" name="icon" class="form-control" placeholder="🩺">
      </div>

      <div class="form-group">
        <label class="form-label">Care Option</label>
        <input type="text" name="care_model" class="form-control" placeholder="In-Clinic / Online">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control"></textarea>
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Bullet Features (One per line)</label>
        <textarea name="features_raw" class="form-control" placeholder="Feature 1&#10;Feature 2"></textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Button Label</label>
        <input type="text" name="button_text" class="form-control" value="Book Consult ➔">
      </div>

      <div class="form-group">
        <label class="form-label">Button Link / URL (href)</label>
        <input type="text" name="button_url" class="form-control" placeholder="e.g. /contact or https://...">
      </div>

      <div class="form-group">
        <label class="form-label">Display Order</label>
        <input type="number" name="order" class="form-control" value="{{ count($services) + 1 }}">
      </div>

      <div class="form-group">
        <label class="form-label">Status</label>
        <select name="is_active" class="form-control">
          <option value="1">Active</option>
          <option value="0">Disabled</option>
        </select>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">➕ Create Service Offering</button>
  </form>
</div>
@endsection
