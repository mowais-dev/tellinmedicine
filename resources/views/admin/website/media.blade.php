@extends('admin.layouts.admin')

@section('title', 'Website - Media Library')
@section('breadcrumbs')
  <a href="{{ route('admin.dashboard') }}">Admin</a> <span class="separator">/</span> <span>Website</span> <span class="separator">/</span> <span>Media Library</span>
@endsection
@section('page_title', 'Media Library & Uploaded Assets')

@section('content')
<div class="page-desc-banner">
  <i class="fa-solid fa-images"></i>
  <p>Upload new image assets, preview existing practice photos, view file paths, and manage uploaded media used across the website.</p>
</div>

<div class="card">
  <div class="card-header">
    <h3>Upload New Media Asset</h3>
  </div>

  <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Select Image File (PNG, JPG, WEBP, SVG)</label>
        <input type="file" name="file" class="form-control" accept="image/*">
      </div>

      <div class="form-group">
        <label class="form-label">Alt Text / Image Description</label>
        <input type="text" name="alt_text" class="form-control" placeholder="e.g. Dr. Ngomba Portrait">
      </div>
    </div>

    <button type="submit" class="btn btn-primary">📤 Upload Image to Media Library</button>
  </form>
</div>

<div class="card">
  <div class="card-header">
    <h3>Uploaded Media Files</h3>
  </div>

  @if($media->isEmpty())
    <p style="color: var(--text-muted); font-size: 0.9rem;">No custom uploaded media yet. Baseline website images are listed below.</p>
  @else
    <div class="grid-3" style="margin-bottom: 1.5rem;">
      @foreach($media as $m)
        <div style="border: 1px solid var(--border-light); border-radius: 12px; padding: 1rem; text-align: center; background: #FFFFFF; box-shadow: 0 4px 12px rgba(31, 45, 61, 0.04);">
          <img src="{{ asset($m->path) }}" alt="{{ $m->alt_text }}" style="max-width: 100%; height: 130px; object-fit: contain; margin-bottom: 0.5rem;">
          <div style="font-size: 0.78rem; font-weight: 700; color: var(--text-dark); word-break: break-all;">{{ $m->path }}</div>
          <div style="font-size: 0.72rem; color: var(--text-muted); margin-top: 0.2rem;">Size: {{ round($m->size / 1024, 1) }} KB</div>
          <div style="margin-top: 0.75rem;">
            <form action="{{ route('admin.media.destroy', $m) }}" method="POST" onsubmit="return confirm('Delete this image?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i> Delete</button>
            </form>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</div>

<div class="card">
  <div class="card-header">
    <h3>Default Baseline Website Images (`public/images/`)</h3>
  </div>

  <div class="grid-3">
    @foreach($publicImages as $img)
      @php $relPath = 'images/' . $img->getFilename(); @endphp
      <div style="border: 1px solid var(--border-light); border-radius: 12px; padding: 1rem; text-align: center; background: #FFFFFF;">
        <img src="{{ asset($relPath) }}" alt="{{ $img->getFilename() }}" style="max-width: 100%; height: 120px; object-fit: contain; margin-bottom: 0.5rem;">
        <div style="font-size: 0.78rem; font-weight: 700; color: var(--text-dark); word-break: break-all;">{{ $relPath }}</div>
        <div style="font-size: 0.72rem; color: var(--text-muted); margin-top: 0.25rem;">Baseline Practice Asset</div>
      </div>
    @endforeach
  </div>
</div>
@endsection
