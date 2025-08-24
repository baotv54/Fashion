<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'event',
        'type',
        'value',
        'min_cart_value',
        'start_date',
        'end_date',
        'usage_limit',
        'used',
        'image',
        'description',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}
