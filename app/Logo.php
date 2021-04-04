<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Logo extends Model
{
    use SoftDeletes;
    protected $table = 'logos';
    protected $fillable = [
      'user_id', 'pic', 'pic_alt', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
