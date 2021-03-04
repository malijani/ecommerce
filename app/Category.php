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

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    public function scopeActive($q, $val)
    {
        return $q->where('status', $val);
    }


    public function childrenArray()
    {
        $ids=[];
        foreach($this->children as $children){
            $ids[]= $children->id;
            $ids = array_merge($ids, $this->childrenArray($children));
        }
        return $ids;
    }
}
