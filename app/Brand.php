<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class Brand extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'title', 'title_en',
        'text', 'pic', 'pic_alt', 'color', 'keywords',
        'description', 'sort', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id', 'id');
    }

    public function scopeSearch($q, $search, $limit = 4)
    {
        return $q->where('status', 1)
            ->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', $search)
                    ->orWhere('title_en', 'LIKE', $search)
                    ->orWhere('text', 'LIKE', $search)
                    ->orWhere('keywords', 'LIKE', $search)
                    ->orWhere('description', 'LIKE', $search);
            })
            ->take($limit)
            ->get();
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
