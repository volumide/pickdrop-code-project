<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Card;
use App\User;
class CardController extends Controller
{

    
    public function createCard(Request $request){

        $validate = Validator::make($request->all(), [
            'card_number'     => 'required|unique:cards',
        ]);

        if($validate->fails()){
            return response()->json([
                "status" => "fail",
                "message"=> "card already exist",
            ], 403);
        }
        $user = Auth::user();
        $input = $request->all();
        $input['user_uuid'] = $user['uuid'];
        $result = Card::create($input);

        if (!$result) {
            return \response()->json([
                "status" => "fail",
                "message" => "Uncable to add card"
            ]);
        }

        return \response()->json([
            "status" => "success",
            "message" => "card created successfully"
        ]);
    }

    public function getAllCards(){
        $user = Auth::user();
        $result = Card::where('user_uuid', $user['uuid'])->get();

        return \response()->json([
            "status" => "success",
            "message" => "card retirved successfully",
            "data" => $result
        ]);
    }

    public function setDefaultCard(Request $request){
        $user = Auth::user();
        $input = $request->card_number;
        $allcard = Card::where('user_uuid', $user['uuid'])->get();

        foreach($allcard as $card){
            if ($card->card_number !== $input) {
                Card::where('card_number', $card->card_number)->update([
                    "default" => false
                ]);
            }
        }

        $check = Card::where('card_number', $input)->get();
        if (count($check) < 1) {
            return \response()->json([
                "status" => "fail",
                "message" => "card not found"
            ], 404);
        }
        $result = Card::where('card_number', $input)->update([
            "default" => true
        ]);

        return \response()->json([
            "status" => "success",
            "message" => "card set to default successfully",
            "data" => Card::where('card_number', $input)->get()
        ]);
    }

    public function getCardByNumber(){
        $user = Auth::user();
        $input = $request->card_number;
        $card = Card::where('user_uuid', $user['uuid'])>where('card_number' , $input)->get();

        if (!$card) {
            return \response()->json([
                "status" => "fail",
                "message" => "card not found"
            ], 404);
        }

        return \response()->json([
            "status" => "success",
            "message" => "card set to default successfully",
            "data" => $card
        ]);
        
    }

    public function removeCardByNumber(Request $request){
        $user = Auth::user();
        $input = $request->card_number;
        $card = Card::where('card_number', $input)->delete();

        return response()->json([
            "status" => "success",
            "message" => "Card deleted successfully"
        ]); 
    }
}
