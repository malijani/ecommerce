<?php

namespace App;

use Fouladgar\MobileVerification\Contracts\MustVerifyMobile as IMustVerifyMobile;
use Fouladgar\MobileVerification\Concerns\MustVerifyMobile;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Laravel\Passport\HasApiTokens;
use Nagy\LaravelRating\Traits\Rate\CanRate;


class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasApiTokens, CanRate;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'family',
        'mobile', 'email',
        'password',
        'level', 'status',
        'email_verified_at',
        'pic', 'uuid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'level'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function addresses(): HasMany
    {
        return $this->hasMany(UserAddress::class)->orderByDesc('id');
    }

    public function factors()
    {
        return $this->hasMany(Factor::class, 'user_id');
    }

    public function ticketComments()
    {
        return $this->hasMany(TicketComment::class, 'user_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'user_id');
    }

    public function verification_code()
    {
        return $this->hasOne(VerificationCode::class, 'user_id');
    }


    public function getDefaultAddressAttribute()
    {
        return $this->addresses()->where('status', true)->get()->first() ?? $this->addresses()->get()->first();
    }


    /**
     * Check if user is admin // ADMIN LEVEL == 121
     * @return bool
     */
    public function isAdmin()
    {
        if (!is_null($this->level) && $this->level == 121) {
            return true;
        }
        return false;
    }

    /**
     * Check if user is normal // NORMAL LEVEL == 0
     */
    public function isNormal()
    {
        if (!is_null($this->level) && $this->level == 0) {
            return true;
        }
        return false;
    }

    /**
     * Return user full name
     */
    public function getFullNameAttribute()
    {
        return current(array_filter([$this->name ?? '', $this->uuid]));
        /*if(isset($this->name)){
            return $this->name;
        } else {
            return $this->uuid;
        }*/

    }

    public function getContactInformationAttribute()
    {
        return array_filter([$this->mobile, $this->email ?? '']);
        /*if (isset($this->email)) {
             return [$this->mobile ,$this->email];
         } else {
             return $this->mobile;
         }*/
    }

}
