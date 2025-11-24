<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ContactController extends Controller
{
    // show contact form
    public function index()
    {
        return view('frontend.contact.index');
    }

    // handle form submit
    public function send(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:191',
            'email'   => 'required|email|max:191',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        // send mail to site admin (use MAIL_FROM_ADDRESS or specific admin address)
        $recipient = config('mail.from.address') ?? env('ADMIN_EMAIL', null);

        if (! $recipient) {
            return back()->withInput()->with('error', 'Mail recipient is not configured. Set MAIL_FROM_ADDRESS or ADMIN_EMAIL in .env');
        }

        // send synchronously (simple). For production, queue the mail.
        Mail::to($recipient)->send(new ContactMail($data));

        // optionally send a copy to sender
        // Mail::to($data['email'])->send(new ContactMail($data, true));

        return redirect()->route('contact')->with('success', 'Your message has been sent. We will contact you soon.');
    }
}
