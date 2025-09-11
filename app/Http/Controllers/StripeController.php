<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    //
     public function index()
    {
        return view('stripe');
    }

    public function store(Request $request)
    {
      $stripe = new \Stripe\StripeClient(env("STRIPE_SECRET"));
     $stripe->charges->create([
        'amount' => $request->price * 100,
        'currency' => 'usd',
        'source' => $request->stripeToken,
        'description' => 'Test payment from laravel app',
        ]);
        
        return back()->with('success', 'Thank you! Your payment has been accepted.');
    }
}
