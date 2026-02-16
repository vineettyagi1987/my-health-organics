<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gallery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->paginate(12);
        return view('admin.gallery.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $data['image'] = $request->file('image')->store('gallery', 'public');

        Gallery::create($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery image uploaded successfully.');
    }

    public function destroy(Gallery $gallery)
    {
        Storage::disk('public')->delete($gallery->image);
        $gallery->delete();

        return back()->with('success', 'Gallery image deleted successfully.');
    }
    public function edit(Gallery $gallery)
{
    return view('admin.gallery.edit', compact('gallery'));
}

public function update(Request $request, Gallery $gallery)
{
    $data = $request->validate([
        'title' => 'nullable',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
    ]);

    if ($request->hasFile('image')) {
        \Storage::disk('public')->delete($gallery->image);
        $data['image'] = $request->file('image')->store('gallery', 'public');
    }

    $gallery->update($data);

    return redirect()->route('admin.gallery.index')->with('success', 'Gallery image updated successfully.');
}
}

