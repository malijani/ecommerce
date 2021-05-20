<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favicon extends Model
{
    protected $table = 'favicons';
    protected $fillable = [
        'user_id', 'pic', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
