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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id')->orderByDesc('created_at');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    public function activeChildren()
    {
        return $this->children()->where('status', 1);
    }
}
