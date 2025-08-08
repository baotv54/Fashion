<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $fillable = [
        'size', 'height_range', 'weight_range', 'chest_range', 'hip_range',
    ];
}
