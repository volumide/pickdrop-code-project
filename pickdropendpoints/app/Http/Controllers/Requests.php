<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Ridercontroller;
use App\Report;
use App\Rating;

class Requests extends Controller
{
    public function requestdelivery(Request $requests){
        $requestrider = new Ridercontroller;
        $input = $requests->all();
        $allresult = array();
        $totalcharge;
        if(empty($input['pick_up_location']) or empty($input['drop_up_location'])){
            return response()->json([
                "message" => 'pickup and dropoff location are compulsory'
            ]);
        }

        if (count($input['drop_up_location']) > 4 ) {
            return response()->json([
                "message" => "drop off location cannot be more than 4"
            ]);
        }

        $pickuplocation = $input['pick_up_location'];
        
        for ($i=0; $i < count($input['drop_up_location']); $i++) { 
            $vehicle_type = $input['vehicle_type'];
            $dropuplocation = $input['drop_up_location'][$i];
            $result = $requestrider->locationfinder($pickuplocation, $dropuplocation , $vehicle_type);
            array_push($allresult, $result->original);
            $pickuplocation = $input['drop_up_location'][$i];
        }

        $car = 0;
        $truck = 0;

        foreach($allresult as $cost){
            $car += $cost["car"]['total_cost'];
            $truck += $cost["truck"]['total_cost'];
        }

        $totalcharge['car_cost'] = $car;
        $totalcharge['truck_cost'] = $truck;

        $count = count($allresult);
        return response()->json([
                "status" => "successful",
                "data"=> $allresult,
                "charges" => $totalcharge
            ]
        );
    }

    public function makereview(Request $request){
        $user = Auth::user();
        $input = $request->all();
        $input['customer_uuid'] = $user['uuid'];
        $input['uuid'] = (string) Str::uuid();

        $result = Rating::create($input);

        return response()->json([
            "status" => "successful",
            "data" => $result,
        ]);
    }

    public function report(Request $request){
        $user = Auth::user();
        $input = $request->all();
        $input['customer_uuid'] = $user['uuid'];
        $result = Report::create($input);
        return response()->json([
            "status" => "success",
            "message" => "report submmited"
        ]);
    }
}
