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
        'view_count',
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

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'product_id');
    }
    // Tính đánh giá trung bình
    public function getAverageRatingAttribute()
    {
        return $this->reviews()
            ->where('is_approved', true)
            ->avg('rating') ?: 0;
    }

    // Đếm số lượng đánh giá
    public function getReviewsCountAttribute()
    {
        return $this->reviews()
            ->where('is_approved', true)
            ->count();
    }

    // Tính phần trăm giảm giá dựa trên price và discount_price
    public function getDiscountPercentageAttribute()
    {
        if (!$this->price || !$this->discount_price || $this->price <= 0) {
            return 0;
        }

        $discount = (($this->price - $this->discount_price) / $this->price) * 100;
        return max(0, round($discount));
    }

    // Lấy giá hiển thị (ưu tiên discount_price nếu có)
    public function getDisplayPriceAttribute()
    {
        return $this->discount_price ?: $this->price;
    }

    // Kiểm tra có giảm giá không
    public function getHasDiscountAttribute()
    {
        return $this->discount_price && $this->discount_price < $this->price;
    }
}
