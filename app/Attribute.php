<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Attribute extends Model
{
    protected $table = 'attributes';
    protected $fillable = ['title'];

    public function products() : BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

}
