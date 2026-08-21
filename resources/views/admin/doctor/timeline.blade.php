@extends('admin.layouts.admin')

@section('title', 'Meet Dr. Ngomba - Career Timeline')
@section('breadcrumbs')
  <a href="{{ route('admin.dashboard') }}">Admin</a> <span class="separator">/</span> <span>Meet Dr. Ngomba</span> <span class="separator">/</span> <span>Career Timeline</span>
@endsection
@section('page_title', 'Doctor Career Timeline Milestones')

@section('content')
<div class="page-desc-banner">
  <i class="fa-solid fa-timeline"></i>
  <p>Manage Dr. Ngomba's medical career milestones, residency years, certifications, hospital appointments, and timeline achievements displayed on the Home page.</p>
</div>

<div class="card">
  <div class="card-header">
    <h3>Doctor Career Timeline Milestones</h3>
  </div>

  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th style="min-width: 90px; width: 90px; text-align: center;">Order</th>
          <th style="width: 160px;">Year Range</th>
          <th style="width: 220px;">Milestone Title</th>
          <th>Description</th>
          <th style="width: 180px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($timelines as $t)
          <tr>
            <form action="{{ route('admin.doctor.timelines.update', $t) }}" method="POST">
              @csrf
              @method('PUT')
              <td>
                <input type="number" name="order" class="form-control" value="{{ $t->order }}">
              </td>
              <td>
                <input type="text" name="year_range" class="form-control" value="{{ $t->year_range }}">
              </td>
              <td>
                <input type="text" name="title" class="form-control" value="{{ $t->title }}">
              </td>
              <td>
                <textarea name="description" class="form-control">{{ $t->description }}</textarea>
              </td>
              <td>
                <div style="display: flex; gap: 0.5rem; align-items: center; white-space: nowrap;">
                  <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-floppy-disk"></i> Save</button>
            </form>
                  <form action="{{ route('admin.doctor.timelines.destroy', $t) }}" method="POST" onsubmit="return confirm('Delete timeline item?')">
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
    <h3>Add Career Timeline Milestone</h3>
  </div>

  <form action="{{ route('admin.doctor.timelines.store') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Year Range (e.g. 2018 - Present)</label>
        <input type="text" name="year_range" class="form-control" placeholder="e.g. 2018 - Present">
      </div>

      <div class="form-group">
        <label class="form-label">Milestone Title</label>
        <input type="text" name="title" class="form-control" placeholder="e.g. Founder & Chief Medical Officer">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control"></textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Display Order</label>
        <input type="number" name="order" class="form-control" value="{{ count($timelines) + 1 }}">
      </div>
    </div>

    <button type="submit" class="btn btn-primary">➕ Add Timeline Milestone</button>
  </form>
</div>
@endsection
