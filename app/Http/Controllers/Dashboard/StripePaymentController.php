<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stripe\Exception\CardException;
use Stripe\StripeClient;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Mail;

class StripePaymentController extends Controller
{
    private $stripe;
    private $currency;
    private $amount;
    public function __construct()
    {
        $this->stripe = new StripeClient(config('stripe.api_keys.secret_key'));
        $this->currency = config('stripe.api_keys.currency');
        $this->amount = config('stripe.api_keys.amount');
    }

    public function paymentSuccess(Request $request)
    {
        return view('payments.thankyou');
    }

     public function paymentError(Request $request)
    {
        dd($request->all());
        return view('payments.error');
    }

     public function stripe(Request $request, $token)
    {
        $id = $request->session()->get('user_id');

        if(!$token)
        {
            return response()->redirectTo('')->with("error", "Payment token required");
        }

         $user = User::where('stripe_token', '=', $token)
                        ->first();

        if(!$user){
             return response()->redirectTo('')->with("error", "Invalid Token");
        }
        return view('payments.stripe', compact('user', 'token'));
    }

    public function stripePost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'stripe_token' => 'required',
            'cardNumber' => 'required',
            'month' => 'required',
            'year' => 'required',
            'cvc' => 'required'
        ]);

        if ($validator->fails()) {
            $request->session()->flash('error', $validator->errors()->first());
            return response()->redirectTo('/');
        }

        $date = date('Y-m-d h:m:s');

        $token = $request->stripe_token;

        $user = User::where('stripe_token', '=', $token)
                        ->first();

         if(!$user){
             return back()->with("error", "Invalid Token");
        }

        $token = $this->createToken($request);
        if (!empty($token['error'])) {
            $request->session()->flash('error', $token['error']);
            return response()->redirectTo('/payment-error');
        }
        if (empty($token['id'])) {
            $request->session()->flash('error', 'Payment failed.');
            return response()->redirectTo('payment-error');
        }

        $payment = $this->createPayment($token['id'], $request, $user );
        // dd($payment);
        if (!empty($payment) && $payment['status'] == 'succeeded') {

            $insert = array(
                    'user_id' => $user->id,
                    'order_hash' => $token['id'],
                    'payer_name' => $user->first_name ." ".$user->last_name,
                    'payer_email' => $user->email,
                    'payer_phone' => $user->phone,
                    'amount' => $payment['amount']/100,
                    'currency' => $payment['currency'],
                    'payment_type' => 'stripe',
                    'order_date' => date('Y-m-d'),
                    'order_status' => 'Completed',
                    'address' => $user->street,
                    'country' => $user->country,
                    'city' => $user->city,
                    'postal_code' => $user->postal_code,
                    'stripe_payment_intent_id' => $payment['id'],
                    'payment_status' => 'Paid',
                    'stripe_payment_status' => $payment['status'],
                    'stripe_payment_response' => json_encode($payment),
                    'created_at' => $date
                );

            $this->insertPaymentInfo($insert);

            // update payment status
            $user->payment_status = 1;
            $user->stripe_token = null;
            $user->save();

            // // send payment success email

            // $data = array('name'=>$user->first_name ." ". $user->last_name, 'link' => $link);

            // Mail::send('email.verify_email', $data, function($message) use($user) {
            //  $message->to($user->email, 'Tournament Players Team')->subject
            //     ('Verify Your Email Address');
            //  $message->from('tp@logicaldottech.com','Tournament Players Team');
            // });

            $request->session()->flash('success', 'Payment Completed.');

             return response()->redirectTo('payment-success');
        } else {
            $request->session()->flash('error', 'Payment failed.');

            return response()->redirectTo('payment-error');
        }
       
    }

    private function insertPaymentInfo($insert)
    {
        $payment = Payment::create($insert);

        return $payment;
    }

    private function createToken($cardData)
    {
        $token = null;
        try {
            $token = $this->stripe->tokens->create([
                'card' => [
                    'number' => $cardData['cardNumber'],
                    'exp_month' => $cardData['month'],
                    'exp_year' => $cardData['year'],
                    'cvc' => $cardData['cvc']
                ]
            ]);
        } catch (CardException $e) {
            $token['error'] = $e->getError()->message;
        } catch (Exception $e) {
            $token['error'] = $e->getMessage();
        }
        return $token;
    }

    private function createPayment($tokenId, $request, $user)
    {
        $user = User::where('stripe_token', '=', $request->stripe_token)
                        ->first();
        $customer = null;
        $method = $this->stripe->paymentMethods->create([
          'type' => 'card',
          'card' => [
            'number' => $request->cardNumber,
            'exp_month' => $request->month,
            'exp_year' => $request->year,
            'cvc' => $request->cvc,
          ],
        ]);
        $customer = $this->stripe->customers->create([
                        'name' => $user->first_name ." ".$user->last_name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                        'address' => [
                          'line1' => $user->street,
                          'postal_code' => $user->postal_code,
                          'city' => $user->city,
                          // 'state' => 'CA',
                          'country' => $user->getCountry->code,
                        ],
                        "source" => $tokenId,
                      ]);
        try {
            $payment = $this->stripe->paymentIntents->create([
                            "amount" => $this->amount * 100,
                            "currency" => $this->currency,
                            "description" => "Tournament Player Subscription" ,
                            'customer' => $customer->id,
                            'payment_method' => $method->id,
                            'payment_method_types' => ['card'],
                            'confirm' => true
                        ]);
            

           
        } catch (Exception $e) {
            $payment['error'] = $e->getMessage();
        }
        return $payment;
    }


     public function createSession(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('stripe.api_keys.secret_key'));

        $token = $request->stripe_token;

        if(!$token){
            return response()->redirectTo('')->with("error", "Payment token required");
        }

        $user = User::where('stripe_token', '=', $token)
                        ->first();

         if(!$user){
             return response()->json(false)->with('error', 'Invalid token.');
        }

       $session = \Stripe\Checkout\Session::create([
                              'customer_email' => $user->email,
                              'line_items' => [[
                                # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                                'price' => 'price_1MLPcjSHPKm4xZNwyQHR07hJ',
                                'quantity' => 1,
                              ]],
                              'mode' => 'payment',
                                'success_url' => url('payment-success'),
                                'cancel_url' => url('failed-payment')
                            ]);
        $result = [
            'sessionId' => $session['id'],
        ];
        // dd($session->url);

        return response()->redirectTo($session->url);
        // return response()->json($result)->with('success', 'Session created successfully.');
    }
    
    public function paymentSuccessHook()
    {
       \Stripe\Stripe::setApiKey(config('stripe.api_keys.secret_key'));

        // This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret = 'whsec_CceipSijKMS8wDD2644Yw7Cd0aDKpY1j';

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        $date = date('Y-m-d h:m:s');

        try {
          $event = \Stripe\Webhook::constructEvent(
            $payload, $sig_header, $endpoint_secret
          );
        } catch(\UnexpectedValueException $e) {
          // Invalid payload
            echo $e->getMessage();
          http_response_code(400);
          exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
          // Invalid signature
            echo $e->getMessage();
          http_response_code(400);
          exit();
        }

        // Handle the event
        switch ($event->type) {
          case 'checkout.session.completed':
            $session = $event->data->object;

            if ($session->payment_status == 'paid') {

                try{

                    $user = User::where('email', $session['customer_email'])->first();
                    // Fulfill the purchase
                      $insert = array(
                            'user_id' => $user->id,
                            'order_hash' => $session['id'],
                            'payer_name' => $user->first_name ." ".$user->last_name,
                            'payer_email' => $user->email,
                            'payer_phone' => $user->phone,
                            'amount' => $session['amount_subtotal']/100,
                            'currency' => $session['currency'],
                            'payment_type' => 'stripe',
                            'order_date' => date('Y-m-d'),
                            'order_status' => 'Completed',
                            'address' => $user->street,
                            'country' => $user->country,
                            'city' => $user->city,
                            'postal_code' => $user->postal_code,
                            'stripe_payment_intent_id' => $session['payment_intent'],
                            'payment_status' => 'Paid',
                            'stripe_payment_status' => $session['payment_status'],
                            'stripe_payment_response' => json_encode($session),
                            'created_at' => $date
                        );

                    $this->insertPaymentInfo($insert);

                    // update payment status
                    $user->payment_status = 1;
                    $user->status = 1;
                    $user->stripe_token = null;
                    $user->save();
                }
                catch(\UnexpectedValueException $e) {
                  // Invalid payload
                    echo $e->getMessage();
                  http_response_code(400);
                  exit();
                } 
            }
          // ... handle other event types
          default:
            echo 'Received unknown event type ' . $event->type;
        }

        http_response_code(200);
    }

    public function handleFailedPayment()
    {
        // 
    }
}
