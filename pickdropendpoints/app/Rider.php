<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Rider extends Model
{
    use Notifiable,HasApiTokens;

    public $table = 'riders';
    protected $fillable = [
        'user_id', 'name', 'country', 'state', 'region','latitude', 'longitude', 'picture', 'driver_licence', "vehicle_document", 'insurance_doc', 'vehicle_type', 'vehicle_brand', 'vehicle_number', 'approval', 'active', 'timezone', 'referral_id', 'guarantor_name', 'guarantor_email', 'guarantor_address', 'applied', 'govt_id', 'phone_verified', 'email_verified', 'bank_name', 'account_number', 'account_name',  'sort_code', 'paypal_id', 'email','online_status', 'wallet', 'onesignal_id' 
    ];
}