@extends('admin.layouts.admin')

@section('title', 'Media Library')
@section('page_title', 'Media Library & Uploads')

@section('content')
<div class="card">
  <div class="card-header">
    <h3>Upload New Image Asset</h3>
  </div>

  <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Select Image File</label>
        <input type="file" name="file" class="form-control" accept="image/*">
      </div>

      <div class="form-group">
        <label class="form-label">Alt Text / Description</label>
        <input type="text" name="alt_text" class="form-control" placeholder="e.g. Doctor Portrait">
      </div>
    </div>

    <button type="submit" class="btn btn-primary">📤 Upload Image</button>
  </form>
</div>

<div class="card">
  <div class="card-header">
    <h3>Uploaded Media Files</h3>
  </div>

  @if($media->isEmpty())
    <p style="color: var(--text-muted);">No custom uploaded media yet. All existing public images are listed below.</p>
  @else
    <div class="grid-3" style="margin-bottom: 2rem;">
      @foreach($media as $m)
        <div style="border: 1px solid var(--border); border-radius: 8px; padding: 1rem; text-align: center; background: #fff;">
          <img src="{{ asset($m->path) }}" alt="{{ $m->alt_text }}" style="max-width: 100%; height: 120px; object-fit: contain; margin-bottom: 0.5rem;">
          <div style="font-size: 0.8rem; font-weight: 700; word-break: break-all;">{{ $m->path }}</div>
          <div style="margin-top: 0.5rem;">
            <form action="{{ route('admin.media.destroy', $m) }}" method="POST" onsubmit="return confirm('Delete this image?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm">Delete</button>
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
      <div style="border: 1px solid var(--border); border-radius: 8px; padding: 1rem; text-align: center; background: #fff; max-width: 100%; box-sizing: border-box; overflow: hidden;">
        <img src="{{ asset($relPath) }}" alt="{{ $img->getFilename() }}" style="max-width: 100%; height: 120px; object-fit: contain; margin-bottom: 0.5rem;">
        <div style="font-size: 0.8rem; font-weight: 700; word-break: break-all;">{{ $relPath }}</div>
        <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.25rem;">Default Baseline Asset</div>
      </div>
    @endforeach
  </div>
</div>
@endsection
