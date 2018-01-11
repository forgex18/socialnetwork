<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use App\Traits\Friendable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\profile;

class games extends Authenticatable
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'photo', 'des', 'comp', 'year', 'video'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

   public $timestamps = false;

   

    public function game()
    {
        return $this->belongsTo('App\games');
    }
}
