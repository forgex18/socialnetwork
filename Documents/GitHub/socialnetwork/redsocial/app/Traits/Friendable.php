<?php

namespace App\Traits;
use App\friendships;

trait Friendable
{
    public function test(){
        return 'hi';
    }

    public function addFriend($id){
        $Friendship = friendships::create([
            'requester' => $this->id,   //el que realiza la peticion
            'user_requested' => $id,   //el q la recibe
        ]);
        if($Friendship)
        {
            return $Friendship;
        }
        return 'failed';
    }
}