<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use SoftDeletes;
    protected $table = 'sliders';
    protected $fillable = [
        'user_id','title',
        'pic', 'pic_alt', 'link',
        'sort', 'status'
    ];
}
