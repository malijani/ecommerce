<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialMediaButton extends Model
{
    protected $table = 'social_media_buttons';

    protected $fillable = [
      'user_id', 'title', 'image', 'link', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
