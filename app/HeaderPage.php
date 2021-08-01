<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * HeaderPage model implements meta for different pages
 * The page property presents destination page in query
 * @property string $page
 * @property string $title
 * @property string $keywords
 * @property string $description
 *
 * @property-read User $user
 */
class HeaderPage extends Model
{
    protected $table = 'header_pages';

    protected $fillable = [
        'user_id', 'page', 'title', 'keywords', 'description'
    ];
    protected $hidden = ['user_id'];

    /**
     * User relation of HeaderPage
     * each HeaderPage belongs to 'one' specific user
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
