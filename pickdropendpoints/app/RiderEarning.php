<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RiderEarning extends Model
{
    protected $table = 'riders_earning';
    protected $fillable = [
        'rider_uuid', 'request_uuid', 'price', 'paymeny_type'
    ];
}
