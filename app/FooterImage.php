<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FooterImage extends Model
{
    use SoftDeletes;

    protected $table = 'footer_images';

    protected $fillable = [
        'user_id', 'link', 'pic', 'pic_alt',
        'status', 'sort'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
