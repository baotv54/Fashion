<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductLiveChatAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'path',
        'type',
        'mime',
        'size',
    ];

    public function message(): BelongsTo
    {
        return $this->belongsTo(ProductLiveChatMessage::class, 'message_id');
    }
}
