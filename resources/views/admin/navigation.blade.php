@extends('admin.layouts.admin')

@section('title', 'Navigation Items')
@section('page_title', 'Manage Header & Navigation Links')

@section('content')
<div class="card">
  <div class="card-header">
    <h3>Existing Navigation Items</h3>
  </div>

  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th style="width: 80px;">Order</th>
          <th style="width: 180px;">Label</th>
          <th style="width: 180px;">Target URL</th>
          <th style="width: 120px;">CTA Button</th>
          <th style="width: 150px;">Care Model</th>
          <th style="width: 110px;">Status</th>
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
                <input type="text" name="url" class="form-control" value="{{ $item->url }}">
              </td>
              <td>
                <select name="is_cta" class="form-control">
                  <option value="0" {{ !$item->is_cta ? 'selected' : '' }}>No</option>
                  <option value="1" {{ $item->is_cta ? 'selected' : '' }}>Yes (Button)</option>
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
        <label class="form-label">Target URL / Hash Anchor</label>
        <input type="text" name="url" class="form-control" placeholder="e.g. #services or /education">
      </div>

      <div class="form-group">
        <label class="form-label">Display as Styled CTA Button?</label>
        <select name="is_cta" class="form-control">
          <option value="0">No (Standard Link)</option>
          <option value="1">Yes (Primary CTA Button)</option>
        </select>
      </div>

      <div class="form-group">
        <label class="form-label">Care Model Badge (Optional)</label>
        <input type="text" name="care_model" class="form-control" placeholder="e.g. In-Clinic">
      </div>

      <div class="form-group">
        <label class="form-label">Display Order</label>
        <input type="number" name="order" class="form-control" value="1">
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
@endsection
