<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deliveryrequest extends Model
{
    public $table = 'request_rider';
    public $fillable = ['pick_up_location', 'drop_up_location', 'pick_up_date','pick_up_time', 'pick_up_instruction', 'uuid', 'vehicle', 'length', 'width', 'height', 'weight', 'user_uuid', 'rider_uuid','status', 'price', 'request_code', 'start_time', 'evidence', 'signature'];
}
