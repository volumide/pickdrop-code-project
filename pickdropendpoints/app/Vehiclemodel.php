<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehiclemodel extends Model
{
    public $table = 'vehicle';
    protected $fillable = [
        'uuid', 'vehicle_type'
    ];
}
