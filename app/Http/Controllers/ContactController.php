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
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'user_message' => $request->input('message'),
        ];
        
        Mail::send('contact', $data, function ($message) {
            $message->to('hello@popcornquest.fun')
                    ->subject('Nouveau message');
        });
        

        return redirect()->back()->with('success', 'Thank you for your message, we will get back to you soon!');
    }
}
