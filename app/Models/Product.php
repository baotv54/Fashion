<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'products'; // Tên bảng trong database

    protected $fillable = [
        'name',
        'slug',
        'import_price',
        'discount_price',
        'price',
        'quantity',
        'description',
        'brand_id',
        'category_id',
        'image', // Ảnh chính (nếu có)
        'status',
        'delete_at',
    ];

    /**
     * Mối quan hệ với bảng danh mục (Category)
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Mối quan hệ với bảng thương hiệu (Brand)
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }


    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    public function attributeValues()
    {
        return $this->hasManyThrough(
            AttributeValue::class,
            VariantAttributeValue::class,
            'variant_id', // foreign key in variant_attribute_values
            'id',         // foreign key in attribute_values
            'id',         // local key in products
            'attribute_value_id' // local key in variant_attribute_values
        );
    }
    public function reviews()
    {
        return $this->hasMany(\App\Models\ProductReview::class);
    }

    public function favoritedByUsers()
    {
        return $this->hasMany(Favorite::class);
    }

}
