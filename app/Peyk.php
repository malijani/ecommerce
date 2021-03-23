<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peyk extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'date', 'time_start', 'time_end',
        'count', 'weight', 'price', 'description', 'sort'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
