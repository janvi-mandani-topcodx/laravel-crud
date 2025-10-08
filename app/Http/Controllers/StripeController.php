<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripeController extends Controller
{
    public  function stripeForm()
    {
        return view('stripe');
    }
    public  function stripePayment(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.stripe_secret_key'));
        $paymentIntent = PaymentIntent::create([
            'amount' => $request->total * 100,
            'currency' => 'usd',
            'payment_method_types' => ['card'],
        ]);
        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
        ]);

    }
}
