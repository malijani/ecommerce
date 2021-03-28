<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductDetail extends Model
{
    protected $fillable = [
      'product_id', 'title', 'detail'
    ];

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
