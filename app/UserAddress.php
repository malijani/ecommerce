<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAddress extends Model
{
    use SoftDeletes;

    protected $fillable = [
      'user_id', 'name_family', 'mobile',
      'tell', 'province', 'city', 'address',
      'post_code', 'status',
    ];

    protected $hidden = [
        'mobile', 'tell',
    ];
}
