<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Payments;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        try {
            // Set your Stripe secret key
            Stripe::setApiKey(config('services.stripe.secret'));

            // Get the amount from the request (assuming it's sent from the frontend)
            $amount = $request->input('amount');

            // Create a payment intent with the amount
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'usd',
            ]);

            return response()->json(['clientSecret' => $paymentIntent->client_secret], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating a payment intent.'], 500);
        }
    }
   
    public function saveBookingPaymentInformation(Request $request)
    {
        try {
            $payments = new Payments;
            $payments->booking_id = $request->data["bookingDetails"]["id"];
            $payments->client_secret = $request->data["clientSecret"];
            $payments->amount = $request->data["bookingDetails"]["amount"];
            $payments->details = json_encode($request->data["paymentIntent"]);

            if($request->data["paymentIntent"]["status"] == "succeeded"){
                $payments->status = config('constants.BOOKING_PAYMENT_SUCCESS');
            }
            else {
                $payments->status = config('constants.BOOKING_PAYMENT_FAILED');
            }

            $payments->save();
            
            return response()->json(['status' => "success" , 'message' => "Payment Detils saved successfully"], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while saving payment details.'], 500);
        }

    }
    public function updatePaymentStatusByStripWebhook(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook'); // Replace with your actual Stripe webhook signing secret 

        try {
            \Stripe\Webhook::constructEvent($payload, $signature, $endpointSecret);
        } catch (\Exception $e) {
             response()->json(['error' => 'Webhook signature verification failed.'], 403);
        }

        $event = json_decode($payload, true);
   
        if ($event['type'] === 'payment_intent.succeeded') {
            $paymentIntent = $event['data']['object'];

            if(isset( $paymentIntent['metadata']['bookingDetails'])){
                $bookingDetails = $paymentIntent['metadata']['bookingDetails'];
                $payments = Payments::where('booking_id', $bookingDetails["id"])->first();
                $payments->status = config('constants.BOOKING_PAYMENT_SUCCESS');
                $payments->update();
            }
        
            return response()->json(['message' => 'Webhook handled successfully.'], 200);
        }

        return response()->json(['message' => 'Event not handled.'], 200);

    }
}
