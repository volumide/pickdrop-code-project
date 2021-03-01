<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RiderBalance extends Model
{
    protected $table = 'riders_balance';
    protected $fillable = [
        'rider_uuid', 'amount'
    ];
}
