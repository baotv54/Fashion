<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Popup extends Model
{
    protected $fillable = ['title', 'description', 'media_type', 'media_path', 'status'];
}
