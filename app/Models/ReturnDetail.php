<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnDetail extends Model
{
    use HasFactory;

    protected $table = 'return_details';

    protected $fillable = [
        'return_id',
        'product_id',
        'variant_id',
        'quantity',
        'price',
    ];

    // Quan hệ ngược lại: mỗi chi tiết thuộc về một phiếu trả hàng
    public function purchaseReturn()
    {
        return $this->belongsTo(PurchaseReturn::class, 'return_id');
    }

    // Quan hệ với sản phẩm
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Quan hệ với variant (nếu có)
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    // Nếu bạn muốn gọi $returnDetail->supplier trực tiếp:
    public function supplier()
    {
        return $this->hasOneThrough(
            Supplier::class,
            PurchaseReturn::class,
            'id',          // Khóa chính PurchaseReturn
            'id',          // Khóa chính Supplier
            'return_id',   // FK trong ReturnDetail -> PurchaseReturn
            'supplier_id'  // FK trong PurchaseReturn -> Supplier
        );
    }
    public function user()
    {
        return $this->hasOneThrough(
            User::class,
            PurchaseReturn::class,
            'id',        // PK trong PurchaseReturn
            'id',        // PK trong User
            'return_id', // FK ReturnDetail -> PurchaseReturn
            'user_id'    // FK PurchaseReturn -> User
        );
    }
}
