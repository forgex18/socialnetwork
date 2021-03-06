<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use App\Traits\Friendable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\profile;

class User extends Authenticatable
{
    use Notifiable;
    use Friendable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'slug', 'gender', 'pic', 'nick'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    public function isRole(){
        return $this->role;
    }

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
