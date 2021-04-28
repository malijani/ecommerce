<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    protected $table = 'social_media';

    protected $fillable = [
        'user_id',
        'title', 'link', 'icon',
        'side_image', 'banner_image',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
