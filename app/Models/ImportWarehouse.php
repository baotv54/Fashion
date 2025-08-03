<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportWarehouse extends Model
{
    use HasFactory;

    protected $table = 'import_warehouse'; // Tên bảng

    protected $fillable = [
        'product_id',
        'variant_id',
        'quantity',
    ];

    // Quan hệ tới sản phẩm
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
    
}
