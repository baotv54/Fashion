<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts'; // tên bảng trong DB

    protected $fillable = [
        'title',
        'content',
        'image',
        'created_at',
        'author',
        'is_visible',
    ];

    public $timestamps = false; // vì bảng chỉ có created_at, không có updated_at
}
