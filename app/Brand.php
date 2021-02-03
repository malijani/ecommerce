<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Brand extends Model
{
    use SoftDeletes;

    protected $fillable =[
        'user_id', 'title', 'title_en',
        'text', 'pic', 'pic_alt', 'color', 'keywords',
        'description', 'sort', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Return a limited text
     */
    public function getTextLimitAttribute()
    {
        return Str::words(strip_tags($this->text), 10);
    }
    /**
     * Return a limited description
     */
    public function getDescriptionLimitAttribute()
    {
        return Str::words(strip_tags($this->description), 10);
    }
}
