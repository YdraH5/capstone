<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{

    public function session(Request $request){
        \Stripe\Stripe::setApiKey(config('stripe.sk'));

        $total_price = $request->get('total_price');
        $apartment_id = $request->get('apartment_id');
        $two0 = "00";
        $total="$total_price$two0";

        $session=\Stripe\Checkout\Session::create([
            'line_items' => [
                [
                    'price_data'=>[
                        'currency' => 'PHP',
                        'product_data'=>[
                            'name'=>$apartment_id,
                        ],
                        'unit_amount'=>$total,
                    ],   
                ],
            ],
            'mode'          => 'payment',
            'success_url'   => route('reserve.wait'),
            'cancel_url;'    => route('reserve.index'),
        ]);
        return redirect()->away($session->url);
    }
}
