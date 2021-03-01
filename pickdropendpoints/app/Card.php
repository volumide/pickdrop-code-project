<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    public $table = 'cards';
    protected $fillable = [
        'user_uuid', 'payment_token', 'card_number', 'cvc', 'exp_date', 'default'
    ];
}
