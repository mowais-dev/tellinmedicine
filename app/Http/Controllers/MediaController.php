<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use Illuminate\Support\Facades\File;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::latest()->get();
        // Also list existing public/images/
        $publicImages = File::files(public_path('images'));
        return view('admin.media', compact('media', 'publicImages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'alt_text' => 'nullable|string',
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
        $file->move(public_path('images'), $filename);

        $media = Media::create([
            'filename' => $filename,
            'path' => 'images/' . $filename,
            'alt_text' => $request->alt_text,
            'mime_type' => $file->getClientMimeType(),
            'size' => filesize(public_path('images/' . $filename)),
        ]);

        return back()->with('success', 'Media file uploaded successfully as images/' . $filename);
    }

    public function destroy(Media $media)
    {
        if (File::exists(public_path($media->path))) {
            File::delete(public_path($media->path));
        }
        $media->delete();
        return back()->with('success', 'Media file deleted.');
    }
}
