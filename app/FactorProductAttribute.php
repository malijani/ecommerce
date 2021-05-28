<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FactorProductAttribute extends Model
{
    protected $table = 'factor_product_attributes';
    protected $fillable = [
        'factor_product_id', 'product_id',
        'attribute', 'count'
    ];

    public function factor()
    {
        return $this->belongsTo(FactorProduct::class, 'factor_product_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
