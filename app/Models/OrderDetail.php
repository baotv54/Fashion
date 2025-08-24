<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'quantity',
        'price',
        'variant_id',
        'variant_details',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function product()
    {
        // lấy cả sản phẩm đã bị soft delete
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Quan hệ tới biến thể (nếu có)
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
    public function reviews()
    {
        return $this->hasMany(OrderReview::class);
    }
}
