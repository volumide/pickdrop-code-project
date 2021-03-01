<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'ratings';
    protected $fillable = [
        'customera_uuid', 'rider_uuid', 'request_uuid', 'review', 'rating'
    ];
}
