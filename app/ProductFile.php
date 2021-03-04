<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProductFile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id', 'title', 'link',
        'type', 'sort', 'status'
    ];


    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function scopeDefaultFile($q) : self
    {
        return $q->where(function($query){
            $query->where('status', '2')
                ->orWhere('sort', '1');
        })->get()->first();

    }

    public function getTypeTextAttribute(): string
    {
        // 0 : pic , 1 : video , 2 : link
        switch ($this->type) {
            case "0":
                return "picture";
            case "1":
                return "video";
            case "2":
                return "link";
            default:
                return 'UNKNOWN';
        }
    }
}
