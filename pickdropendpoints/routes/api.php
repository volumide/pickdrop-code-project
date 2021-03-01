<?php

use Illuminate\Http\Requests;
use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\Ridercontroller;
use App\Http\Controllers\Sendrequest;
use App\Http\Controllers\Riderauthcontroller;
use App\Http\Controllers\RidersDetails;
use App\Http\Controllers\Paymentcontoller;
use App\Http\Controllers\Vehiclecontroller;

// use App\Http\Controllers\Regrider;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Auth::routes(['verify' => true]);

Route::group(['prefix' => 'v1'], function (){
	Route::post('signup', 'Authcontroller@signup');
	Route::post('signin', 'Authcontroller@signin');


	Route::post('verify/email', 'Authcontroller@sendEmailVerificationCode');
	Route::post('confirm/email/code', 'Authcontroller@verifyCodes');

	Route::post('create/vehicle', 'Vehiclecontroller@createvehicletype');
	Route::get('get/all/vehicle', 'Vehiclecontroller@getllvehicle');
	Route::post('reset/password', 'Authcontroller@resetPassword');

	
	Route::middleware('auth:api')->group(function () {
		
		//in app
		Route::put('upload', 'Authcontroller@uploadpic');
		Route::get('allusers', 'Authcontroller@viewall');
		Route::get('my-profile', 'Authcontroller@myProfile');
		Route::put('userupdate', 'Authcontroller@updateprofile');
		Route::put('update/location', 'Authcontroller@updateprofile');

		//twilio
		Route::post('send/verification/code', 'Authcontroller@sendphoneverificationcode');
		Route::post('verify/phone/code', 'Authcontroller@verifyphonenumber');
		Route::post('update/password', 'Authcontroller@updatePassword');

		Route::post('findrider', 'Requests@requestdelivery');

		Route::post('rate/rider/delivery', 'Requests@makereview');
		Route::post('report/rider', 'Requests@report');

		Route::post('makerequest', 'Sendrequest@makerequest');
		Route::get('riderlogs', 'Sendrequest@riderlog');

		Route::put('updatedeliverystatus/{id}', 'Sendrequest@updateridestatus');
		Route::put('reject/ride/{id}', 'Sendrequest@rejectride');
		Route::get('confirm/pin/{id}/{code}', 'Sendrequest@confirmpin');

		Route::get('user/request/log', 'Sendrequest@userrequestlog');
		Route::put('update/start/time/{id}', 'Sendrequest@updatestarttime');

		Route::put('upload/evidence/{id}', 'Sendrequest@uploadevidence');
		Route::get('get/cordinate/{address}/{latlong}', 'Ridercontroller@calccoordinate');
		Route::put('upload/signature/{id}', 'Sendrequest@uploadsignature');
		Route::post('send/notification', 'Sendrequest@notification');

		Route::post('credit/rider', 'Sendrequest@riderearning');
		Route::post('rider/withdraw', 'Sendrequest@debitRider');
		
		Route::put('update/rider/infomation', 'RidersDetails@updateriderinfo');
		Route::get('currentrider', 'RidersDetails@riderInfo');
		Route::put('doc/{documents}', 'RidersDetails@uploaddoc');
		Route::put('status', 'RidersDetails@updatestatus');
		
		Route::post('create/stripe/user', 'Paymentcontoller@createstripepayment');
		Route::post('create/user/card', 'Paymentcontoller@createstripepaymentcard');
		Route::post('charge/user/card', 'Paymentcontoller@chargecustomer');
		
		Route::post('add/new/card', 'CardController@createCard');
		Route::put('set/default/card', 'CardController@setDefaultCard');
		Route::get('get/all/card', 'CardController@getAllCards');
		Route::delete('remove/card', 'CardController@removeCardByNumber');
	});
});


