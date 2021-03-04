<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProductFile extends Model
{
    use SoftDeletes;
    protected $fillable = [
      'product_id', 'title', 'link',
      'type', 'sort', 'status'
    ];


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function getTypeTextAttribute()
    {
        // 0 : pic , 1 : video , 2 : link
        switch($this->type){
            case "0":
                return "picture";
                break;
            case "1":
                return "video";
                break;
            case "2":
                return "link";
                break;
            default:
                return 'UNKNOWN';
        }
    }
}
