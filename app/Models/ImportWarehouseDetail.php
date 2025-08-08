<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ImportWarehouseDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'import_warehouse_id',
        'product_id',
        'variant_id',
        'quantity',
        'price',
    ];

    public function warehouse()
    {
        return $this->belongsTo(ImportWarehouseMain::class, 'import_warehouse_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}
