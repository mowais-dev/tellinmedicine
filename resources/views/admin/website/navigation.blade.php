@extends('admin.layouts.admin')

@section('title', 'Website - Header & Navigation')
@section('breadcrumbs')
  <a href="{{ route('admin.dashboard') }}">Admin</a> <span class="separator">/</span> <span>Website</span> <span class="separator">/</span> <span>Header & Navigation</span>
@endsection
@section('page_title', 'Header Logo & Navigation Links')

@section('content')
<div class="page-desc-banner">
  <i class="fa-solid fa-bars"></i>
  <p>Manage main header navigation links, logo image, brand text, and call-to-action buttons displayed in the website navigation bar.</p>
</div>

<!-- Header Logo & Branding -->
<div class="card">
  <div class="card-header">
    <h3>Header Logo & Brand Title Settings</h3>
  </div>

  <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="grid-2" style="align-items: center;">
      <div>
        <label class="form-label">Current Logo Image Preview</label>
        <div class="image-picker-box">
          @if(!empty($settings['logo_path']) && file_exists(public_path($settings['logo_path'])))
            <img src="{{ asset($settings['logo_path']) }}" alt="Logo Preview" class="image-preview-img" id="logoPreview">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted);">{{ $settings['logo_path'] }}</div>
          @else
            <div style="color: var(--text-muted); font-size: 0.9rem;">No logo uploaded yet</div>
          @endif
        </div>
      </div>

      <div>
        <div class="form-group">
          <label class="form-label">Upload New Header Logo (PNG, SVG, WEBP)</label>
          <input type="file" name="logo_file" class="form-control" accept="image/*" onchange="previewImage(this, 'logoPreview')">
        </div>
        <div class="form-group">
          <label class="form-label">Upload Custom Favicon (Browser Tab Icon)</label>
          <input type="file" name="favicon_file" class="form-control" accept="image/*">
          <small style="color: var(--text-muted); font-size: 0.78rem;">Optional. If left blank, your Header Logo will automatically be used as the browser tab favicon.</small>
        </div>
        <div class="form-group">
          <label class="form-label">Brand Main Name (Normal Text)</label>
          <input type="text" name="brand_name" class="form-control" value="{{ $settings['brand_name'] ?? 'TELLin' }}" placeholder="e.g. TELLin">
        </div>
        <div class="form-group">
          <label class="form-label">Brand Accent Name (Crimson Accent)</label>
          <input type="text" name="brand_accent" class="form-control" value="{{ $settings['brand_accent'] ?? 'Medicine' }}" placeholder="e.g. Medicine">
          <small style="color: var(--text-muted); font-size: 0.78rem;">Text entered here will appear in the crimson accent color in the brand title.</small>
        </div>
        <div class="form-group">
          <label class="form-label">Brand Legal Tag (e.g. LLC)</label>
          <input type="text" name="brand_sub" class="form-control" value="{{ $settings['brand_sub'] ?? 'LLC' }}">
        </div>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">💾 Save Logo & Brand Title</button>
  </form>
</div>

<!-- Header Navigation Links -->
<div class="card">
  <div class="card-header">
    <h3>Existing Navigation Items</h3>
  </div>

  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th style="min-width: 90px; width: 90px; text-align: center;">Order</th>
          <th style="width: 180px;">Link Label</th>
          <th style="width: 180px;">Target Link URL (href)</th>
          <th style="width: 130px;">CTA Button</th>
          <th style="width: 150px;">Care Option</th>
          <th style="min-width: 130px; width: 130px; text-align: center;">Status</th>
          <th style="width: 180px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($items as $item)
          <tr>
            <form action="{{ route('admin.navigation.update', $item) }}" method="POST">
              @csrf
              @method('PUT')
              <td>
                <input type="number" name="order" class="form-control" value="{{ $item->order }}">
              </td>
              <td>
                <input type="text" name="label" class="form-control" value="{{ $item->label }}">
              </td>
              <td>
                <input type="text" name="url" class="form-control" value="{{ $item->url }}" placeholder="e.g. #services or /education">
              </td>
              <td>
                <select name="is_cta" class="form-control">
                  <option value="0" {{ !$item->is_cta ? 'selected' : '' }}>Standard Link</option>
                  <option value="1" {{ $item->is_cta ? 'selected' : '' }}>Styled CTA Button</option>
                </select>
              </td>
              <td>
                <input type="text" name="care_model" class="form-control" value="{{ $item->care_model }}" placeholder="e.g. In-Clinic">
              </td>
              <td>
                <select name="is_active" class="form-control">
                  <option value="1" {{ $item->is_active ? 'selected' : '' }}>Active</option>
                  <option value="0" {{ !$item->is_active ? 'selected' : '' }}>Disabled</option>
                </select>
              </td>
              <td>
                <div style="display: flex; gap: 0.5rem; align-items: center; white-space: nowrap;">
                  <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-floppy-disk"></i> Save</button>
            </form>
                  <form action="{{ route('admin.navigation.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this navigation link?')">
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
    <h3>Add New Navigation Link</h3>
  </div>

  <form action="{{ route('admin.navigation.store') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Link Label</label>
        <input type="text" name="label" class="form-control" placeholder="e.g. Services">
      </div>

      <div class="form-group">
        <label class="form-label">Target URL / Hash Anchor (href)</label>
        <input type="text" name="url" class="form-control" placeholder="e.g. #services or /education or https://...">
      </div>

      <div class="form-group">
        <label class="form-label">Display Style</label>
        <select name="is_cta" class="form-control">
          <option value="0">Standard Header Link</option>
          <option value="1">Primary CTA Button</option>
        </select>
      </div>

      <div class="form-group">
        <label class="form-label">Care Option Badge (Optional)</label>
        <input type="text" name="care_model" class="form-control" placeholder="e.g. In-Clinic">
      </div>

      <div class="form-group">
        <label class="form-label">Display Order</label>
        <input type="number" name="order" class="form-control" value="{{ count($items) + 1 }}">
      </div>

      <div class="form-group">
        <label class="form-label">Status</label>
        <select name="is_active" class="form-control">
          <option value="1">Active</option>
          <option value="0">Disabled</option>
        </select>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">➕ Create Navigation Link</button>
  </form>
</div>

<script>
  function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById(previewId).src = e.target.result;
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
@endsection
