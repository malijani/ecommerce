<?php

namespace App;

use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Nagy\LaravelRating\Traits\Rate\Rateable;

class Article extends Model
{
    use SoftDeletes, Rateable;

    protected $fillable = [
        'user_id', 'category_id', 'title', 'title_en',
        'keywords', 'description', 'short_text', 'long_text',
        'period', 'before', 'after', 'sort', 'visit', 'status',
        'pic', 'pic_alt'
    ];
    protected $hidden = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function activeComments()
    {
        return $this->comments()->where('status', 1);
    }

    public function getLink()
    {
        return route('blog.show', $this->title_en);
    }

    public function getDescriptionLimitAttribute()
    {
        return Str::words($this->description, 50);
    }

    public function getLongTextLimitedAttribute()
    {
        return (!is_null($this->long_text) ? Str::words(html_entity_decode(strip_tags($this->long_text)), 50) : null);
    }

    public function getShortTextLimitedAttribute()
    {
        return (!is_null($this->short_text) ? Str::words(html_entity_decode(strip_tags($this->short_text)), 10) : null);
    }

    public function getJalaliUpdatedAtAttribute()
    {
        return Verta::instance($this->updated_at);
    }

    /**
     * Find active status articles
     * @param $q
     * @param $val
     * @return mixed
     */
    public function scopeActive($q)
    {
        return $q->where('status', 1);
    }

    public function scopeSearch($q, $search = null, $limit = 4)
    {
        return $q->where('status', 1)
            ->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', $search)
                    ->orWhere('title_en', 'LIKE', $search)
                    ->orWhere('short_text', 'LIKE', $search)
                    ->orWhere('keywords', 'LIKE', $search)
                    ->orWhere('description', 'LIKE', $search);
            })
            ->take($limit)
            ->get();
    }

    /**
     * Relation between posts as previous article => ux , seo
     * @return mixed
     */
    public function bef()
    {
        return $this->belongsTo(Article::class, 'before')->active();
    }

    /**
     * Relation between posts as next article => ux , seo
     */
    public function af()
    {
        return $this->belongsTo(Article::class, 'after')->active();
    }


}
