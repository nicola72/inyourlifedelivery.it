<?php

namespace App\Model\Cms;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserCms extends Authenticatable
{
    use Notifiable;

    protected $guard = 'cms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['role_id','shop_id','name', 'email', 'password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['email_verified_at' => 'datetime'];


    public function role()
    {
        return $this->belongsTo('App\Model\Cms\RoleCms');
    }

    public function shop()
    {
        return $this->belongsTo('App\Model\Shop');
    }

    public function clear_pwd()
    {
        return $this->hasOne('App\Model\Cms\ClearcmsPassword');
    }


}
