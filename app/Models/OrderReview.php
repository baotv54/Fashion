<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'order_detail_id',
        'user_id',
        'rating',
        'comment',
        'is_approved',
        'approved_at',
        'rejected_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'is_approved' => 'boolean',
    ];

    // Review thuộc về một đơn hàng
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function orderDetail()
    {
        return $this->belongsTo(OrderDetail::class);
    }
    // Review thuộc về một người dùng
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Review có thể có nhiều media
    public function media()
    {
        return $this->hasMany(OrderReviewMedia::class);
    }

    // Scope cho các review đã được duyệt
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    // Scope cho các review đang chờ duyệt
    public function scopePending($query)
    {
        return $query->where('is_approved', false)->whereNull('rejected_at');
    }

    // Scope cho các review bị từ chối
    public function scopeRejected($query)
    {
        return $query->whereNotNull('rejected_at');
    }
}
