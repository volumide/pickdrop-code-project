<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RiderWithdrawal extends Model
{
    protected $table = 'riders_withdrawer';
    protected $fillable = [
        'rider_uuid', 'balance'
    ];
}
