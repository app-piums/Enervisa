<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageReceivedMail;
use App\Mail\ContactMessageSubmittedMail;
use App\Models\ContactMessage;
use App\Models\Gallery;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::active()->get();
        $galleries = Gallery::active()->get();

        return view('home', compact('services', 'galleries'));
    }

    public function contact(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:120',
            'email'   => 'required|email|max:160',
            'phone'   => 'nullable|string|max:40',
            'subject' => 'nullable|string|max:160',
            'message' => 'required|string|max:3000',
        ]);

        $message = ContactMessage::create($data);

        $notificationEmail = Setting::get('contact_email', config('mail.from.address'));

        try {
            if (is_string($notificationEmail) && filter_var($notificationEmail, FILTER_VALIDATE_EMAIL)) {
                Mail::to($notificationEmail)->send(new ContactMessageSubmittedMail($message));
            }

            Mail::to($message->email)->send(new ContactMessageReceivedMail($message));
        } catch (\Throwable $e) {
            Log::warning('Contact form emails could not be delivered.', [
                'message_id' => $message->id,
                'error' => $e->getMessage(),
            ]);
        }

        return back()
            ->with('success', '¡Gracias por contactarnos! Te responderemos pronto.')
            ->withFragment('contacto');
    }
}
