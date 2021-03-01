<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';
    protected $fillable = [
        'customera_uuid', 'rider_uuid', 'request_uuid', 'report'
    ];
}
