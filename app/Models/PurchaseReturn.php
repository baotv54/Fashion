<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model
{
    use HasFactory;

    protected $table = 'purchase_returns';

    protected $fillable = [
        'return_code',
        'return_status',
        'refund_status',
        'supplier_id',
        'user_id',
        'total_quantity',
        'total_amount',
    ];

    // Quan hệ 1 - nhiều: Một phiếu trả hàng có nhiều chi tiết
    public function details()
    {
        return $this->hasMany(ReturnDetail::class, 'return_id');
    }

    // Quan hệ với supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    // Quan hệ với user (người tạo)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
