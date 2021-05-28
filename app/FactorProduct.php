<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FactorProduct extends Model
{
    protected $table = 'factor_products';
    protected $fillable = [
        'factor_id', 'product_id', 'price_type',
        'price', 'discount_percent', 'count',
        'weight', 'discount_price',
    ];


    public function factor()
    {
        return $this->belongsTo(Factor::class, 'factor_id');
    }

    public function attributes()
    {
        return $this->hasMany(FactorProductAttribute::class, 'factor_product_id');
    }
}
