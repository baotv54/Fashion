<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantAttributeValue extends Model
{
    use HasFactory;

    protected $fillable = ['variant_id', 'attribute_value_id'];

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function attributeValue()
    {
        return $this->belongsTo(AttributeValue::class, 'attribute_value_id');
    }
    
    public function attribute()
    {
        return $this->hasOneThrough(
            Attribute::class,
            AttributeValue::class,
            'id', // Foreign key on AttributeValue table
            'id', // Foreign key on Attribute table
            'attribute_value_id', // Local key on VariantAttributeValue table
            'attribute_id' // Local key on AttributeValue table
        );
    }
}
