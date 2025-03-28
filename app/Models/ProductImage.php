<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $table = 'product_images'; // Tên bảng trong database

    protected $fillable = [
        'id',
        'product_id',
        'image_path',
        'sort_order',
    ];

    /**
     * Mối quan hệ với bảng sản phẩm (Product)
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
