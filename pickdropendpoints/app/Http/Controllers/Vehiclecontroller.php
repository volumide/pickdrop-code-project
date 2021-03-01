<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Vehiclemodel;


class Vehiclecontroller extends Controller
{
    public function createvehicletype(Request $request){
        $checkvalidation = Validator::make($request->all(), [
            'vehicle_type' => 'required|unique:vehicle',
        ]);

        if($checkvalidation->fails()){
            return response()->json([
                "message"=> "Vehicle type already exist"
            ], 403);
        }

        $input = $request->all();
        $input['uuid'] = (string) Str::uuid();
        $create_vehicle = Vehiclemodel::create($input);

        return \response()->json([
            "status" => "successfuly created",
            "data" => $create_vehicle
        ]);
    }

    public function getllvehicle(){
        $allvehicle = Vehiclemodel::all();
        return response()->json([
            "status" => "success",
            "data" => $allvehicle
        ]);
    }

}
