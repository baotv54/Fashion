<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderReviewMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_review_id',
        'file_path',
        'type', // image hoặc video
        'file_size',
        'mime_type',
        'original_name',
    ];

    public function review()
    {
        return $this->belongsTo(OrderReview::class, 'order_review_id');
    }
}
