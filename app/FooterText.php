<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FooterText extends Model
{
    protected $table = 'footer_texts';
    protected $fillable = [
        'user_id', 'title', 'content', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getLimitContentAttribute()
    {
        return Str::words(strip_tags($this->content), 10);
    }
}
