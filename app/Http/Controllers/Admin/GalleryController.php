<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Services\ImageProcessor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function __construct(protected ImageProcessor $processor) {}

    public function index()
    {
        $items = Gallery::orderBy('sort_order')->orderByDesc('id')->paginate(24);
        return view('admin.gallery.index', compact('items'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'images.*'    => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
            'title'       => 'nullable|string|max:160',
            'description' => 'nullable|string|max:2000',
        ]);

        $count = 0;
        foreach ((array) $request->file('images', []) as $file) {
            [$imagePath, $thumbPath] = $this->processor->storeUpload($file);
            Gallery::create([
                'title'          => $request->input('title'),
                'description'    => $request->input('description'),
                'image_path'     => $imagePath,
                'thumbnail_path' => $thumbPath,
                'sort_order'     => (Gallery::max('sort_order') ?? 0) + 1,
                'active'         => true,
            ]);
            $count++;
        }

        Cache::forget('home.galleries');
        return redirect()->route('admin.gallery.index')->with('success', "{$count} imagen(es) subida(s) correctamente.");
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $data = $request->validate([
            'title'       => 'nullable|string|max:160',
            'description' => 'nullable|string|max:2000',
            'sort_order'  => 'integer|min:0',
            'active'      => 'nullable|boolean',
        ]) + ['active' => $request->boolean('active')];

        $gallery->update($data);
        Cache::forget('home.galleries');
        return redirect()->route('admin.gallery.index')->with('success', 'Imagen actualizada.');
    }

    public function destroy(Gallery $gallery)
    {
        Storage::disk('public')->delete([$gallery->image_path, $gallery->thumbnail_path]);
        $gallery->delete();
        Cache::forget('home.galleries');
        return back()->with('success', 'Imagen eliminada.');
    }
}
