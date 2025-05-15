<?php

namespace App\Http\Controllers;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class ContactController extends Controller
{
   public function send(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'subject' => 'required',
        'message' => 'required'
    ]);

    try {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message
        ];

        Mail::to('coderedem1500k@gmail.com')->send(new ContactFormMail($data));

        return response()->json([
            'success' => true,
            'message' => 'Thank you for your message. We will get back to you soon!'
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Contact form error: '.$e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Failed to send message. Please try again later.'
        ], 500);
    }
}
public function showForm()
{
    return view('contact'); // Make sure you have a contact.blade.php view
}
}

