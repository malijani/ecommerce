<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Factor extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'price', 'pay_trans_id',
        'pay_reference', 'pay_tracking',
        'status', 'shipping_cost', 'delivery',
        'post_tracking', 'description',
        'comment'
    ];
}
