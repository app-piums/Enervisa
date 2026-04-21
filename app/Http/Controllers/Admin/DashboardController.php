<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Gallery;
use App\Models\Service;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'services' => Service::count(),
            'photos'   => Gallery::count(),
            'messages' => ContactMessage::count(),
            'unread'   => ContactMessage::where('read', false)->count(),
        ];
        $recentMessages = ContactMessage::latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentMessages'));
    }
}
