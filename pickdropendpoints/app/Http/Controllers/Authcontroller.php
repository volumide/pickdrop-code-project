<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\User;
use App\Rider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;



class Authcontroller extends Controller
{

    public function signup(Request $request){
        $checkvalidation = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone' => 'required|unique:users'
        ]);
        // dd($checkvalidation);

        if($checkvalidation->fails()){
            return response()->json([
                "message"=> "user already exists"
            ], 403);
        }

        $input = $request->all();
        $rider = $request->user_id;
        $approval = $request->approval;
        $applied = $request->applied;

        $input['email']= filter_var($input['email'], FILTER_SANITIZE_EMAIL);

        if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                "message"=> "invalid email address"
            ]);
        }

        $input['uuid'] = (string) Str::uuid();
        $input['password'] = bcrypt($input['password']);

        // $status = $request->input('status');
        if (empty($input['status'])) {
            $input['status'] = 'customer';
        }else{
            $input['status'] = 'rider';
            $rider = $input['uuid'];
            $approval = 0;
            $applied = 0;
            Rider::create(['user_id'=> $rider]);
        }
        
        $user = User::create($input);
        $token = $user->createToken('app')->accessToken;


        return response()->json([
            "status" => "success",
            "data" => $user,
            "rider"=> $rider,
            "token"=>$token,
            "message" => "Registration successfull."
            ], 200
        );
    }

    public function signin(Request $request){
        $userdetails = [
            "email" => $request->email,
            "password"=> $request->password
        ];

        // $authenticate = Auth::attempt($userdetails);
        if( Auth::attempt($userdetails)){
            $user = $request->user();
            $token = $user->createToken('Personaltoken')->accessToken;
            return response()->json([
                "data" => [ 
                    'content'=> $user,
                    "token" => $token
                    ]
                ], 200
            );
        }else{
            return response()->json([
                "error" => [ 
                    "message" => "unathorised"
                    ]
                ], 401
            );
        }
    }

    public function viewall(){
        $views = User::all();
        return \response()->json([
            "data"=> [
                "allusers" => $views
                ]
            ], 201
        );
    }

    public function myProfile(){
        $user = Auth::user();
        $views = User::findOrfail($user['id']);
        return response()->json([
            "status" => "success",
            "data"=> $views,
            "message"=> "My profile retrieved"
            ], 201
        );
    }

    public function updateprofile(Request $request){
        $data = $request->all();
        $user = Auth::user();

        User::where('uuid', $user['uuid'])->update($data);
        return response()->json([
            "data"=> [
                "profile"=>  User::where('uuid', $user['uuid'])->first(),
                "message"=> "Profile updated successfully"
            ]
        ]);
    }  

    public function uploadpic(Request $request){
        $data = $request->all();
        $user = Auth::user();

        if(Cloudder::upload($data['picture'], null)) {
            $upload_result = Cloudder::getResult();
            $data = array(
              'picture' => $upload_result['url']
            );

           if(User::where('uuid', $user['uuid'])->update($data)) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'User picture updated successfully',
                    'data' => User::where('uuid', $user['uuid'])->first()
                ], 200);   
            }

            return response()->json([
                'status' => 'failed',
                'message' => 'Error occurred while updating profile picture.'
            ], 401);
        }

    }

    public function sendphoneverificationcode(Request $request){
        $account_sid = "ACfbe606d107f7d3340fbd4d071a0b4b78";
        $auth_token = "1ac41a9cb50595afc33f53c99ef0334b";
        $account_verify_sid = "VAb988e79198055204797495b909ecd2f1";

        $user = Auth::user();

        $phone = $request->phone;
        
        $client = new Client($account_sid, $auth_token);
        $verification = $client->verify->v2->
                    services($account_verify_sid)->verifications->create($phone, "sms");
        if ($verification) {
            User::where("uuid", $user['uuid'])->update(
                ["phone" => $phone, "phone_verify_status" => $verification->status]
            );
        }

        return \response()->json([
            "status" => "success",
            "data" =>  [$verification->status, $verification->url]

        ]);
    }

    public function verifyphonenumber(Request $request){
        $account_sid = "ACfbe606d107f7d3340fbd4d071a0b4b78";
        $auth_token = "1ac41a9cb50595afc33f53c99ef0334b";
        $account_verify_sid = "VAb988e79198055204797495b909ecd2f1";
        $client = new Client($account_sid, $auth_token);

        $code = $request->code;
        $user = Auth::user();

        $verification_check = $client->verify->v2->services($account_verify_sid)
                            ->verificationChecks
                            ->create($code, ["to" => $user['phone']]
                        );

        if ($verification_check) {
            User::where("uuid", $user['uuid'])->update(
                ["phone_verify_status" => $verification_check ->status]
            );
        }

        return \response()->json([
            "status" => "success",
            "data" =>  $verification_check->status

        ]);
    }

    public function updatePassword(Request $request){
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                "status" => "fail",
                "message" => "user not found"
            ], 404);
        }
        $validate = Validator::make($request->all(), [
            'new_password'  => 'required|min:6',
        ]);

        if($validate->fails()){
            return response()->json([
                "status"=> "fail",
                "message" =>   "password lenght less than 6 character"
            ],);
        }

        // dd($user['password']);
        $current_password = $request->current_password;
        $new_password = $request->new_password;
        $password = $user['password'];

        // dd(bcrypt($current_password), $user['password']);

        if (!(Hash::check($current_password, $user['password']))) {
            return \response()->json([
                "status" => "fail",
                "message" => "you current password did not match with the one in our database",
            ]);
        }

        User::where('uuid', $user['uuid'])->update([
            "password" => bcrypt($new_password)
        ]);
       
        return \response()->json([
            "status" => "successful",
            "message" => "password change successful",
            "data" => $user
        ]);
    }

    public function sendEmailVerificationCode(Request $request){
        $input = $request->email;
        $user = User::where('email', $input)->get();

        if(count($user) < 1) return response()->json([
            "status" => 'fail',
            "message" => "invalid email, not found"
        ]);
        

        $data['code'] = rand(0000, 9999);
        $data['email'] = $input;
        User::where('email', $input)->update(['email_verify_pin', $data['code']]);

        $mail = function ($message)use($data) {
            $message->to($data['email']);
            $message->subject('Email Verification code');
        };
        $sendMail = Mail::send('verify',$data, $mail);
        
        if(!$sendMail){
            return response()->json([
                "status" => "fail",
                "mesaage" => "Unsuccessful"
            ]);
        }

        return response()->json([
            "status" => "success",
            "mesaage" => "Check you mail for your confirmation code"
        ]);
    }

    public function resetPassword(Request $request){
        $input = $request->all();
        $input['new_password'] = bcrypt($input['new_password']);

        $getuser = User::where('email', $input['email'])->get();

        if (count($getuser) < 1) {
            return response()->json([
                "status" => "success",
                "message" => "No such user in our database"
            ]);
        }

        $getuser = User::where('email', $input['email'])->upddate([
            "password" => $input['new_password']
        ]);

        return response()->json([
            "status" => "success",
            "message" => "passsword reset successfully"
        ]);
    }

    public function verifyCodes(Request $request){
        $input = $request->code;
      
        $verify = User::where('email', $input['email'])->where('email_verification_code', $input['code'])->update([
            "email_verify_status" => true
        ]);

        return response()->json([
            "status" => "success",
            "message" => "verification successful",
        ]);
    }
}


