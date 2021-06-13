<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Factor extends Model
{
    use SoftDeletes;

    protected $table = 'factors';
    protected $fillable = [
        'uuid', 'user_id', 'price', 'pay_trans_id',
        'pay_reference', 'pay_tracking',
        'status', 'shipping_cost', 'delivery',
        'post_tracking', 'description',
        'comment', 'raw_price', 'discount_price',
        'discount_code', 'weight', 'count', 'paid_at',
        'shipping_name_family', 'shipping_address', 'shipping_mobile',
        'shipping_tell', 'shipping_post_code',
    ];

    protected $archive_days = 2;

    public function products()
    {
        return $this->hasMany(FactorProduct::class, 'factor_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeSort($query)
    {
        return $query->orderByDesc('updated_at');
    }

    protected function archiveDate()
    {
        return Carbon::now()->subDays($this->archive_days);
    }


    public function scopeDeletedFactors($query)
    {
        return $query
            ->onlyTrashed()
            ->orderBy('deleted_at');
    }

    public function scopeFactorShow($query)
    {
        return $query
            ->withoutTrashed()
            ->whereDate('created_at', '>=', $this->archiveDate())
            ->orWhere('status', '=', '1');
    }

    public function scopePaidFactors($query)
    {
        return $query
            ->withoutTrashed()
            ->where('status', '=', '1')
            ->whereDate('created_at', '>=', $this->archiveDate());
    }

    public function scopeActiveFactors($query)
    {
        return $query
            ->withoutTrashed()
            ->where('status', '!=', '1')
            ->whereDate('created_at', '>=', $this->archiveDate());
    }

    public function scopeArchivedFactors($query)
    {
        return $query
            ->withoutTrashed()
            ->where('status', '!=', 1)
            ->whereDate('created_at', '<', $this->archiveDate());
    }
}
