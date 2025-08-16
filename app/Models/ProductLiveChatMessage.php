<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductLiveChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'thread_id',
        'user_id',
        'sender',
        'message',
    ];

    public function thread(): BelongsTo
    {
        return $this->belongsTo(ProductLiveChatThread::class, 'thread_id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(ProductLiveChatAttachment::class, 'message_id');
    }
}
