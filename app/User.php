<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'family', 'mobile', 'email', 'password', 'level', 'status'
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


    /**
     * Check if user is admin // ADMIN LEVEL == 121
     * @return bool
     */
    public function isAdmin()
    {
        if(!is_null($this->level) && $this->level == 121){
            return true;
        }
        return false;
    }
    /**
     * Check if user is normal // NORMAL LEVEL == 0
     */
    public function isNormal()
    {
        if(!is_null($this->level) && $this->level == 0){
            return true;
        }
        return false;
    }

    /**
     * Return user full name
     */
    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->family;
    }
}
