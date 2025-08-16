<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductLiveChatThread extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'session_token',
        'status',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(ProductLiveChatMessage::class, 'thread_id');
    }
}
