<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function profilePicture()
    {
        $email = \Auth::user()->email;

        if( strpos($email, 'mich') !== false){
            return '/img/profile_pic_mich.jpg';
        }else if( strpos($email, 'jim') !== false){
            return '/img/profile_pic_jim.jpg';
        }else {
            return '/img/profile_pic_boss.jpg';
        }
    }
}
