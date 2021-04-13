<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TopNav extends Model
{
    use SoftDeletes;

    protected $table = 'top_navs';

    protected $fillable = [
        'user_id', 'title', 'link',
        'status', 'sort', 'screen'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
