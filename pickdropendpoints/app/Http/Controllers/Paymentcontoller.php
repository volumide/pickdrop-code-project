<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\RiderBalance;
use App\Deliveryrequest;

class Paymentcontoller extends Controller
{
    public function createstripepayment(Request $request){
        \Stripe\Stripe::setApiKey('sk_test_KA8xWXIS1ek1xFVYacJ6v65a00Ss1sHqg6');

        $user = Auth::user();
        $input = $request->card_number;
        $card_number = Card::where('user_uuid', $user['uuid'])->where('card_number', $input)->get[0]->card_number;

        if (!card_number) {
            return \response()->json([
                "status"=>"fail",
                "message" => "card not found"
            ]);
        }
        $card_id = \Stripe\Customer::create([
            'description' => 'First ever stripe api consumed',
        ]);
        Card::where('card_number', $card_number)->update(["stripe_id"=> $card_id->id]);

        return \response()->json([
            "status"=>"success",
            "stripe_responds" => $card_id,
            "data" => $user
        ]);
    }

    public function createstripepaymentcard(Request $request){
        \Stripe\Stripe::setApiKey('sk_test_KA8xWXIS1ek1xFVYacJ6v65a00Ss1sHqg6');

        $user = Auth::user();
        $id = $user['stripe_id'];
        $token = $request->token;
        $customer =\Stripe\Customer::createSource(
            $id,
            ['source' => $token]
        );

        User::where('uuid', $user['uuid'])->update(["pay_card_token" => $token]);

        return \response()->json([
            "status"=>"success",
            "stripe_responds" => $customer,
            "user" => $user
        ]);
    }

    public function chargecustomer(Request $request){
        \Stripe\Stripe::setApiKey('sk_test_KA8xWXIS1ek1xFVYacJ6v65a00Ss1sHqg6');

        $user = Auth::user();
        $amount = $request->amount;
        $customers = Card::where('user_uuid', $user['id'])->get();
        $id = [] ;
        foreach ($customers as $cutomer) {
            if ($customer['default'] == true){
                 array_push($customer['stripe_id']);
            }
        }

        $charge = \Stripe\Charge::create([
            'amount' => $amount,
            'currency' => 'usd',
            'customer' => $id[0]
        ]);

        return $charge;
    }
}
