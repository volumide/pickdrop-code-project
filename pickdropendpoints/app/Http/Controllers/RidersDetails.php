<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Rider;
use Illuminate\Support\Facades\Validator;
use JD\Cloudder\Facades\Cloudder;

class RidersDetails extends Controller
{
    public function uploaddocument($data){
        if(Cloudder::upload($data, null)) {
            $upload_result = Cloudder::getResult();
            return $upload_result['url'];
        };
    }

    public function uploaddoc(Request $request, $upload){
        $id = $this->riderInfo()->id;
        $views = Rider::find($id);
        $data = $request->all();
        switch ($upload) {

            case 'licence':
                $licence = $this->uploaddocument($data['driver_licence']);
                $views->driver_licence = $licence;
                $views->save();
                break;

            case 'vehicle':
                $vehicle = $this->uploaddocument($data['vehicle_document']);
                $views->vehicle_document = $vehicle;
                $views->save();
                break;

            case 'insurance':
                $insurance = $this->uploaddocument($data['insurance_doc']);
                $views->vehicle_document = $insurance;
                $views->save();
                break;

            case 'governmentid':
                $governmentid = $this->uploaddocument($data['govt_id']);
                $views->govt_id = $governmentid;
                $views->save();
                break;

            case 'picture':
                $picture = $this->uploaddocument($data['picture']);
                $views->govt_id = $picture;
                $views->save();
                break;

            default:
                # code...
                break;
        }
       
        return response()->json([
            "data"=> [
                'status' => 'success',
                'picture_url'=> $views->driver_licence
            ]
        ]);
    }

    public function riderInfo(){
        $user = Auth::user();
        if($user['status'] == 'rider'){
            $uuid = $user['uuid'];
            $id = Rider::where('user_id', $uuid)->get();
            // dd($id);
            return $id[0];
        }else{
            return response()->json([
                "message" => "infromation cannot be retrived from a customer account"
            ]);
        }
    }

    public function getallriders(){
        $views = Rider::all();
        return response()->json([
            "data"=> [
                "allusers" => $views
                ]
            ], 201
        );
    }

    public function updateriderinfo(Request $request){
        $id = $this->riderInfo()->id;
        $input =  $request->all();
        Rider::where('id', $id)->update($input);
        return response()->json([
            "data" => Rider::where('id', $id)->first()
        ]);
    }

    public function updatestatus(Request $request){
        $id = $this->riderInfo()->id;
        $input =  $request->status;
        Rider::where('id', $id)->update(["online_status" => $input]);
        return response()->json([
            "data" => Rider::where('id', $id)->first()
        ]);
    }
}
