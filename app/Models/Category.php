<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'parent_id', 'status'];

    // Lấy danh mục con của một danh mục
    // Category.php
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('children');
    }

    // Lấy danh mục cha của một danh mục
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
