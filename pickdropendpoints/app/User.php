<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
// use GoldSpecDigital\LaravelEloquentUUID\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'status', 'phone', 'uuid', 'country', 'region','phone_verify_status', 'phone_verify_date_created', 'email_verify_pin', 'email_verify_status', 'email_verify_date_creates', 'user_current_lat', 'user_current_lng', 'user_deleted', 'user_time_zone', 'vehicle_type, vehicle_name', 'vehicle_number', 'vehicle_doc_one','vehicle_doc_two', 'vehicle_doc_three', 'vehicle_doc_four','profile_pic','pay_card_token','referer_id','phone_pin','email_pin','suspended','state','city','longitude','latitude','phone_verified', 'stripe_id', 'onesignal_id'
    ];
    // 'name', 'country', 'state', 'region', 'latitude', 'longitude', 'picture', 'driver_licence', "vehicle_document", 'insurance_doc', 'vehicle_type', 'vehicle_brand', 'vehicle_number', 'approval', 'active', 'timezone', 'referral_id', 'guarantor_name', 'guarantor_email', 'guarantor_address', 'applied', 'govt_id', 'phone_verified', 'email_verified', 'bank_name', 'account_number', 'account_name',  'sort_code', 'paypal_id', 'email'

    // 
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}

// vehicle_name": null,
//         "vehicle_number": null,
//         "vehicle_doc_one": null,
//         "vehicle_doc_two": null,
//         "vehicle_doc_three": null,
//         "vehicle_doc_four