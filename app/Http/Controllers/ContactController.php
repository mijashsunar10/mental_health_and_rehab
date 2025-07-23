<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function contact()
    {
        return view('frontend.contact.contact');
    }

    public function submitContactForm(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        try {
            // Store in database
            Contact::create($validatedData);
            
            // Send email
            Mail::to('sandeshpahari05@gmail.com')
                ->send(new ContactFormMail($validatedData));
                
            return response()->json(['message' => 'Your message has been sent successfully!'], 200);
            
        } catch (\Exception $e) {
            Log::error('Contact form error: '.$e->getMessage());
            return response()->json(['message' => 'Failed to send message. Please try again later.'], 500);
        }
    }
}