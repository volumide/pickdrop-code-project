<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Deliveryrequest;
use App\User;
use App\Rider;
use App\RiderEarning;
use App\RiderBalance;
use App\RiderWithdrawal;
use Illuminate\Support\Facades\Auth;
use JD\Cloudder\Facades\Cloudder;

class Sendrequest extends Controller
{
    public function makerequest(Request $requests){
        $currentUser = Auth::user();
        $input = $requests->all();
        $input['uuid'] = (string) Str::uuid();
        $input['status'] = 'pending';
        $input['request_code'] = 'pic'.rand(999999, 100000);

        if (count($input['drop_up_location']) > 4) {
            return response()->json([
                'message' => "Drop up location can not be more than 4"
            ], 403);
        }

        foreach ($input['drop_up_location'] as $location){
            $input['drop_up_location'] = $location;
            $makerequest = Deliveryrequest::create($input);
        }

        $cuurentRequest = Deliveryrequest::where('uuid', $input['uuid'])->get();

        return response()->json([
            "data" => $cuurentRequest
        ], 201);
    }

    public function userrequestlog(){
        $currentUser = Auth::user();
        $all = [];
        if ($currentUser['status'] === "customer") {
            $status = Deliveryrequest::where('user_uuid', $currentUser['uuid'])->get();

            foreach($status as $stat){
                $uuid = $stat['rider_uuid'];
                $rider = User::where('uuid', $uuid)->get();
                $rider_info = Rider::where('user_id', $uuid)->get();
                $merged =array_merge([$stat->toArray(), "rider_info" => $rider[0]->toArray()], ["rider_details" => $rider_info[0]->toArray]);
                array_push($all, $merged);
            }

            return response()->json([
                "data"=> $all,
            ]);
        }
    }

    public function riderlog(){
        $currentUser = Auth::user();
        $all = [];
        if ($currentUser['status'] === "rider") {
            $status = Deliveryrequest::where('rider_uuid', $currentUser['uuid'])->get();

            foreach($status as $stat){
                $uuid = $stat['user_uuid'];
                $user = User::where('uuid', $uuid)->get();
                $merged =array_merge($stat->toArray(), ["customer_info" => $user[0]->toArray()]);
                array_push($all, $merged);
            }

            $name['name'] = $user[0]['name'];
            return response()->json([
                "data"=> $all,
            ]);
        }
    }

    public function notification(Request $request){
        $userId = $request->user_id;
        $content = $request->content;
        $fields['include_player_ids'] = [$userId];
        $fields['contents'] = array(
            "en" => 'English Message',
            "es" => 'Spanish Message',
        );

        if (!$userId && !$content) {
            return \response()->json([
                "message" => "notificartion sent not successful"
            ]);
        }

        $result =  \OneSignal::sendPush($fields, $content);
        return \response()->json([
            "status" => "success",
            "data" => $result
        ]);
    }

    public function updateridestatus($id){
        $status;
        $views = Deliveryrequest::find($id);
        $input = $views['status'];
        // dd($views->status);
        switch ($views->status) {
            case 'pending':
                $views->status = 'accepted';
                $status = 'accepted';
                $views->save();
                break;
            case 'accepted':
                $views->status = 'picked';
                $status = 'picked';
                $views->save();
                break;
            case 'picked':
                $views->status = 'moving';
                $status = 'moving';
                $views->save();
                break;
            case 'moving':
                $views->status = 'completed';
                $status = 'completed';
                $views->save();
                break;
            default:
                $status = 'No obvious change noticed';
                break;
        }
        return response()->json([
            "data"=> [
                "status"=> $views->status,
                "message"=> $status
            ]
        ]);
    }

    public function uploadsignature(Request $request, $id){
        $data = $request->all();
        $views = Deliveryrequest::find($id);
        if(Cloudder::upload($data['signature'], null)) {
            $upload_result = Cloudder::getResult();
            $views->signature = $upload_result['url'];
            $message = 'upload successful';
            $views->save();

            return \response()->json([
                "data"=> [
                    'status' => $message,
                    'picture_url'=> $views->signature
                ]
            ]);
        };
    }

    public function uploadevidence(Request $request, $id){
        $data =$request->all();
        $views = Deliveryrequest::find($id);
        if(Cloudder::upload($data['evidence'], null)) {
            $upload_result = Cloudder::getResult();
            $views->evidence = $upload_result['url'];
            $message = 'upload successful';
            $views->save();

            return \response()->json([
                "data"=> [
                    'status' => $message,
                    'picture_url'=> $views->evidence
                ]
            ]);
        };
    }

    public function updatestarttime(Request $request, $id){
        $data['start_time'] = $request->start_time;
        Deliveryrequest::where('id', $id)->update($data);
        $views = Deliveryrequest::find($id);

        return \response()->json([
            "data" => $views,
            "status"=> "successful"

        ]);
    }

    public function rejectride($id){
        $views = Deliveryrequest::find($id);
        $input = $views['status'];
        switch ($views->status) {
            case 'pending':
                $views->status = 'reject';
                $status = 'accepted';
                $views->save();
                break;
            default:
                $status = 'No obvious change noticed';
                break;
        }
        return response()->json([
            "data"=> [
                "status"=> $views->status,
                "message"=> $status
            ]
        ]);
    }

    public function confirmpin($id, $code){
        $views = Deliveryrequest::find($id);
        
        $table_code = $views['request_code'];

        if($table_code === $code){
            return response()->json([
                'data' => 'Request code confirmed'
            ]);
        }
        return response()->json([
            'message' => 'Invalide code'
        ]);
    }

    public function riderearning(Request $request){
        $user = Auth::user();

        $input['cutomer_uuid'] == $user['uuid'];
        $input['rider_uuid'] == $request->rider_uuid;
        $input['price'] = $request->amount;
        $input['request_uuid'] = $request->request_uuid;
        $input['payment_type'] = 'card';

        $recipent = Deliveryrequest::where('uuid', $input['request_uuid'])->get();

        if (count($recipent) < 0) {
            return response()->json([
                "status" => "fail",
                "message" => "not found",
            ]);
        }

        $addEarning = RiderEarning::create($input);

        $balance = RiderBalance::where("rider_uuid", $input['rider_uuid'])->get();
        $price = $balance[0]['balance'];
        if (count($balance) < 1) {
            RiderBalance::create(["rider_uuid" => $input['rider_uuid'], "balance" => 0]);
            $price = 0;
        }

        $updatebalance = $price+ $input['price'];

        RiderBalance::where("rider_uuid", $input['rider_uuid'])-update([
            "balance" => $updatebalance
        ]);

        Rider::where('user_id', $input['rider_uuid'])->update([
            "wallet" => $updatebalance
        ]);

        return response()->json([
            "status" => "success",
            "data" => $rider,
            "rider_detail"=> Rider::where('user_id', $rider['rider_uuid'])->get()[0]
        ]);


    }

    public function debitRider(Request $request){
        $user = Auth::user();
        $input['rider_uuid'] = $user['uuid'];
        $amount = $request->amount;
        $balance = RiderBalance::where('rider_uuid', $input['rider_uuid'])->get();

        if (count($balance) < 1) {
            return \response()->json([
                "status" => "fail",
                "message" => "User not found"
            ]);
        }

        $balance = $balance[0]['balance'];

        if ($amount > $balance) {
            return \response()->json([
                "status" => "fail",
                "message" => "Insufficient fund"
            ]);
        }

        $updatebalance = $balance - $amount;
        $input['amount'] = $updatebalance;

        RiderBalance::where('rider_uuid', $input['rider_uuid'])->update([
            "balance" => $updatebalance
        ]);

        Rider::where('user_id', $input['rider_uuid'])->update([
            "wallet" => $updatebalance
        ]);
        $withdraw = RiderWithdrawal::create($input);

    }
}
