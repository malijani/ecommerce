<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FooterLicense extends Model
{
    protected $table = 'footer_licenses';
    protected $fillable = [
      'user_id', 'title', 'image', 'link', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
