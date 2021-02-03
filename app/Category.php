<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
      'user_id', 'parent_id', 'title', 'title_en',
      'text', 'pic', 'pic_alt', 'color', 'keywords',
      'description', 'sort', 'status', 'menu',
    ];
    protected $hidden = [
      'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }
}
