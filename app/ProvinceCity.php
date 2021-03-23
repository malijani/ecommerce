<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProvinceCity extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'parent', 'title', 'sort'
    ];


    public function children()
    {
        return $this->hasMany(ProvinceCity::class, 'parent', 'id')->orderBy('sort');
    }
}
