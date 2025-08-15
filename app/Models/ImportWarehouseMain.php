<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ImportWarehouseMain extends Model
{
    use HasFactory;
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
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
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
