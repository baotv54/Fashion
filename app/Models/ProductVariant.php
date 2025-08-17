<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['product_id', 'price', 'stock', 'image', 'import_price', 'discount_price','quantity','delete_at'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function attributeValues()
    {
        return $this->belongsToMany(
            AttributeValue::class,
            'variant_attribute_values',
            'variant_id',
            'attribute_value_id'
        );
    }
    public function variants() {
        return $this->hasMany(ProductVariant::class);
    }
}
