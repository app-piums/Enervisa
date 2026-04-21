<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('sort_order')->orderByDesc('id')->paginate(15);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        Service::create($data);
        Cache::forget('home.services');
        return redirect()->route('admin.services.index')->with('success', 'Servicio creado.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $service->update($this->validateData($request));
        Cache::forget('home.services');
        return redirect()->route('admin.services.index')->with('success', 'Servicio actualizado.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        Cache::forget('home.services');
        return back()->with('success', 'Servicio eliminado.');
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'title'       => 'required|string|max:160',
            'description' => 'required|string|max:2000',
            'icon'        => 'required|string|max:40',
            'sort_order'  => 'integer|min:0',
            'active'      => 'nullable|boolean',
        ]) + ['active' => $request->boolean('active')];
    }
}
