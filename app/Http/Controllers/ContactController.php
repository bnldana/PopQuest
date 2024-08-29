<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        $email = 'hello@popcornquest.fun';

        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'userMessage' => $request->input('message'),
        ];

        Mail::send('contact.email', $data, function ($message) use ($email) {
            $message->to($email)
                    ->subject('Contact Form Submission');
        });

        return back()->with('success', 'Ton message a bien été envoyé !');
    }
}
