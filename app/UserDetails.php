<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class UserDetails extends Model
{
    protected $fillable = [
        'user_id','avatar','avatar_flag',
        'news_receive','national_code','sex',
        'bill','bill_cart','birthday', 'status'
    ];


    protected $hidden = [
      'bill', 'bill_cart', 'national_code'
    ];
}
