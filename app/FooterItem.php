<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FooterItem extends Model
{
    protected $table = 'footer_items';
    protected $fillable = [
        'user_id', 'title', 'title_en', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function links()
    {
        return $this->hasMany(FooterLink::class, 'item_id');
    }

    public function scopeItem($q, $column)
    {
        return $q
            ->with('links')
            ->where('status', 1)
            ->where('title_en', '=' , $column)
            ->first();
    }
}
