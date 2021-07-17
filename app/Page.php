<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Page extends Model
{
    use SoftDeletes;

    protected $table = 'pages';

    protected $fillable = [
        'user_id', 'title', 'menu_title', 'title_en', 'content',
        'keywords', 'description',
        'visit', 'menu', 'status', 'sort'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getContentShortAttribute(): string
    {
        return html_entity_decode(strip_tags(Str::words($this->content, 70, '')));
    }

    public function getTitleEnPureAttribute()
    {
        return str_replace('-', ' ', $this->title_en);
    }

    public function getKeywordsShortAttribute(): string
    {
        return Str::words($this->keywords, 10);
    }

    public function getDescriptionShortAttribute(): string
    {
        return Str::words($this->description, 10);
    }
}
