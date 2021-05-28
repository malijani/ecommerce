<?php

namespace App;

use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Nagy\LaravelRating\Traits\Rate\Rateable;


/**
 * Product Model
 * @property mixed discount_price
 * @property mixed price
 * @property mixed discount_percent
 * @property mixed price_type
 * @property int entity
 */
class Product extends Model
{
    use SoftDeletes, Rateable;

    protected $table = 'products';

    protected $fillable = [
        'user_id', 'brand_id', 'category_id',
        'title', 'title_en', 'short_text', 'long_text',
        'origin', 'deliver', 'warranty',
        'price_type', 'price', 'discount_percent', 'price_self_buy',
        'entity','sold', 'keywords', 'description', 'visit', 'sort',
        'status', 'before', 'after', 'color', 'weight'
    ];

    protected $hidden = ['user_id', 'price_self_buy'];


    public function scopeActive($q): Builder
    {
        return $q->where('status', 1);/*->where('entity', '>', 0);*/
    }

    public function scopeSearch($q, $search, $limit = 4)
    {
        return $q->where('status', 1)
            ->where('entity', '>', 0)
            ->where('title', 'LIKE', $search)
            ->take($limit)
            ->get();
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function getLink()
    {
        return route('product.show', $this->title_en);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(ProductFile::class, 'product_id')->orderBy('created_at');
    }

    public function attrs(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class)->withPivot('attr_value');
    }

    public function bef(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'before')->where('status', 1)->select('id', 'title', 'title_en');
    }

    public function af(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'after')->where('status', 1)->select('id', 'title', 'title_en');
    }

    public function details(): HasMany
    {
        return $this->hasMany(ProductDetail::class, 'product_id')->orderBy('id');
    }

    public function getShowPriceAttribute(): string
    {
        return number_format($this->price);
    }

    public function getShowDiscountPriceAttribute(): string
    {
        return number_format($this->discount_price);
    }

    public function getDiscountPriceAttribute()
    {
        if ($this->price_type == "0" && $this->discount_percent != "0") {
            return ($this->price - ($this->price * $this->discount_percent) / 100);
        } else {
            return 'تخفیف به درستی تعیین نشده.';
        }
    }


    public function getFinalPriceAttribute()
    {
        if ($this->price_type == 0) {
            return $this->discount_price;
        } elseif ($this->price_type == 1) {
            return $this->price;
        } else {
            return 0;
        }
    }


    public function getPriceTypeTextAttribute(): string
    {
        switch ($this->getAttribute('price_type')) {
            case "0":
                return "دارای تخفیف";
            case "1":
                return "قیمت نهایی(بدون تخفیف)";
            case "2":
                return "قیمت متغیر(تماس برای پرسیدن قیمت)";
            default:
                return "نامشخص";

        }
    }

    public function getOriginTextAttribute(): string
    {
        switch ($this->getAttribute('origin')) {
            case "1":
                return "اورجینال";
            case "2":
                return "درجه ۲";
            case "3":
                return "درجه ۳";
            default:
                return "نامشخص";

        }
    }

    public function getDeliverTextAttribute(): string
    {
        switch ($this->getAttribute('deliver')) {
            case "0":
                return "فوری";
            case "1":
                return "زمان دار";
            default:
                return "نامشخص";
        }


    }

    public function getWarrantyTextAttribute(): string
    {
        switch ($this->getAttribute('warranty')) {
            case "0":
                return "بدون گارانتی";
            case "1":
                return "دارای گارانتی";
            default:
                return "نامشخص";
        }
    }

    public function getDescriptionLimitAttribute(): string
    {
        return Str::words($this->getAttribute('description'), 50);
    }

    public function getLongTextLimitedAttribute(): ?string
    {
        return (!is_null($this->getAttribute('long_text')) ? Str::words(strip_tags($this->getAttribute('long_text')), 10) : null);
    }

    public function getShortTextLimitedAttribute(): ?string
    {
        return (!is_null($this->getAttribute('short_text')) ? Str::words(strip_tags($this->getAttribute('short_text')), 10) : null);
    }

    public function getJalaliUpdatedAtAttribute(): ?string
    {
        return Verta::instance($this->getAttribute('updated_at'));
    }


}
