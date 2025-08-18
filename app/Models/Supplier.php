<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
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
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}
}

