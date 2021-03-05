<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent() : BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function children() : HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function childrenRecursive() : HasMany
    {
        return $this->children()->with('childrenRecursive');
    }

    public function activeChildren() : HasMany
    {
        return $this->children()->where('status',1)->where('menu', 1);
    }

    public function subActiveChildren() : HasMany
    {
        return $this->childrenRecursive()->where('status',1);
    }

    public function scopeActive($q)
    {
        return $q->where('status', '1');
    }


    public function childrenArray() : array
    {
        $ids=[];
        foreach($this->children as $children){
            $ids[]= $children->id;
            $ids = array_merge($ids, $this->childrenArray($children));
        }
        return $ids;
    }
}
