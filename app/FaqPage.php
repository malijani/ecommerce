<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class FaqPage extends Model
{

    protected $table = 'faq_pages';

    protected $fillable = [
        'title', 'keywords', 'description'
    ];

}
