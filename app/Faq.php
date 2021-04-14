<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Faq extends Model
{
    use SoftDeletes;
    protected $table = 'faqs';
    protected $fillable = [
        'user_id', 'question', 'answer',
        'status', 'collapse', 'sort'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getAnswerShortAttribute()
    {
        return Str::words(strip_tags($this->answer), 10);
    }
}
