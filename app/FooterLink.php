<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FooterLink extends Model
{
    protected $table = 'footer_links';
    protected $fillable = [
      'user_id', 'item_id', 'title', 'link', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function item()
    {
        return $this->belongsToMany(FooterItem::class, 'item_id');
    }
}
