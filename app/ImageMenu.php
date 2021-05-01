<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageMenu extends Model
{
    protected $table = 'image_menus';
    protected $fillable = [
      'user_id', 'title', 'link', 'image', 'type', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getTypeTextAttribute()
    {
        switch ($this->type){
            case 0 :
                return 'صفحات نحوه فروش و ارسال';
            case 1 :
                return 'منو تصویری صفحه اصلی';
            case 2 :
                return 'منو تصاویر بزرگ صفحه اصلی';
            case 3 :
                return 'منو صفحات جانبی';
            case 4:
                return 'منو تصاویر بزرگ فوتر';
            default:
                return 'نامشخص';
        }
    }
}
