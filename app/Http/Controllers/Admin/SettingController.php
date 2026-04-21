<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index()
    {
        $grouped = Setting::orderBy('id')->get()->groupBy('group');
        return view('admin.settings.index', compact('grouped'));
    }

    public function update(Request $request)
    {
        $data = $request->input('settings', []);
        foreach ($data as $key => $value) {
            Setting::where('key', $key)->update(['value' => $value]);
        }
        Cache::forget('settings.all');
        Cache::forget('home.services');
        Cache::forget('home.galleries');

        return back()->with('success', 'Configuración actualizada correctamente.');
    }
}
