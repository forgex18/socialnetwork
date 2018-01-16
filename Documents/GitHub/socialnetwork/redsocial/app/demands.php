<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use App\Traits\Friendable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\profile;

class demands extends Authenticatable
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tit', 'company', 'years', 'console', 'coment'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

   public $timestamps = false;

   

    public function demands()
    {
        return $this->belongsTo('App\demands');
    }
}
