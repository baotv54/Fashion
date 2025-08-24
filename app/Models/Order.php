<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_code',
        'email',
        'name',
        'phone',
        'address',
        'province',
        'district',
        'ward',
        'note',
        'subtotal',
        'discount',
        'total',
        'payment_method',
        'status',
        'partner_code',
        'shipping_fee',
        'payment_status',

    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
    public function reviews()
    {
        return $this->hasMany(OrderReview::class);
    }

    /**
     * Get the approved reviews for this order
     */
    public function approvedReviews()
    {
        return $this->reviews()->where('is_approved', true);
    }

    /**
     * Check if user can review this order
     */
    public function canBeReviewedBy($userId)
    {
        return $this->user_id == $userId
            && $this->status === 'delivered'
            && !$this->reviews()->where('user_id', $userId)->exists();
    }

    /**
     * Get user's review for this order
     */
    public function getUserReview($userId)
    {
        return $this->reviews()->where('user_id', $userId)->first();
    }

    /**
     * Get average rating for this order
     */
    public function averageRating()
    {
        return $this->approvedReviews()->avg('rating') ?? 0;
    }

    /**
     * Get total review count for this order
     */
    public function reviewCount()
    {
        return $this->approvedReviews()->count();
    }
}
