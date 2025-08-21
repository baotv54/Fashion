<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImportWarehouse extends Model
{
   use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'import_warehouse'; // Tên bảng

    protected $fillable = [
        'product_id',
        'variant_id',
        'quantity',
        'name_cost',        // mới thêm
        'additional_cost',  // mới thêm
        'discount',         // mới thêm
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
