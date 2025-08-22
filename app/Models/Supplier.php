<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model

{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'supplier_code',
        'name',
        'phone',
        'tax_code',
        'fax',
        'email',
        'user_id',
        'province',
        'district',
        'ward',
        'address_detail',
        'website',
        'status',
        'delete_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
