<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Factor extends Model
{
    use SoftDeletes;
    protected $table = 'factors';
    protected $fillable = [
        'user_id', 'price', 'pay_trans_id',
        'pay_reference', 'pay_tracking',
        'status', 'shipping_cost', 'delivery',
        'post_tracking', 'description',
        'comment', 'raw_price', 'discount_price',
        'discount_code', 'weight'
    ];

    public function products()
    {
        return $this->hasMany(FactorProduct::class, 'factor_id');
    }
}
