<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageVector extends Model
{
    protected $fillable = ['product_id', 'image_path', 'image_type', 'vector'];
    protected $casts = [
        'vector' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
