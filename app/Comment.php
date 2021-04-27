<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
    protected $table = 'comments';
    protected $fillable = [
        'user_id', 'commentable_id', 'commentable_type', 'parent_id',
        'content', 'status'
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'commentable_id')->with('files');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function scopeActive($q)
    {
        return $q->where('status', 1);
    }

    public function scopeSort($q)
    {
        return $q
            ->orderBy('status')
            ->orderByDesc('created_at')
            ->orderByDesc('id');
    }

    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id')->sort();
    }

    public function childrenRecursive()
    {
        return $this->children()
            ->with('childrenRecursive')
            ->active()
            ->sort();
    }

}
