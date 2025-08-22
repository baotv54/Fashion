<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class ImportWarehouseMain extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'order_warehouses';
    protected $fillable = [
        'code',
        'supplier_id',
        'user_id',
        'note',
        'import_date',
        'total_price',
        'payment_status',
        'payment_method',
        'payment_amount',
        'payment_date',
        'payment_reference',
        'name_cost',        // mới thêm
        'additional_cost',  // mới thêm
        'discount',
        'deleted_at'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class)->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function details()
    {
        return $this->hasMany(ImportWarehouseDetail::class, 'import_warehouse_id');
    }
}
