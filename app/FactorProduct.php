<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FactorProduct extends Model
{
    protected $fillable = [
        'factor_id', 'product_id',
        'price_type', 'price', 'discount_percent',
        'count'
    ];
}
