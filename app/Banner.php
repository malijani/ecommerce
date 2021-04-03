<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use SoftDeletes;
    protected $table = 'banners';
    protected $fillable = ['user_id', 'link', 'pic', 'pic_alt', 'status'];
}
