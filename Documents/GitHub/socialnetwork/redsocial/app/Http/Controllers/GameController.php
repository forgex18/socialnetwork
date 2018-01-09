<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\friendships;
use App\notifications;

class GameController extends Controller
{
    public function index($id){

        $data = DB::table('games')->where('games.id', $id)->get();

    	return view('profile.game', compact('data'));
    }

    public function findGames(){
        $uid = Auth::user()->id;
        //$allUsers = DB::table('users')->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')->where('users.id', '!=', $uid)->get();
       // $allUsers = DB::table('profiles')->leftJoin('users', 'users.id', '=', 'profiles.user_id')->where('users.id', '!=', $uid)->get();

        $allGames = DB::table('games')->get();
       return view('profile.findGames', compact('allGames'));
/*
        foreach ($allUsers as $u) {
            echo $u->name;
            echo "<br>";
        }

*/
    }

    public function games(){
        $uid= Auth::user()->id;

        $games = DB::table("subscriptions")
        			->leftJoin('games', 'games.id', 'subscriptions.id_game')
        			->where('id_subscriptor', $uid)
        			->get();

        return view('profile.games', compact('games'));
    }

    public function subcription($id_game){
    	$uid= Auth::user()->id;

          $subs= DB::table('subscriptions')->insert([
            'id_game' => $id_game,
            'id_subscriptor' => $uid,
          ]);

          return back();
    }

    public function mygames(){
    	$uid= Auth::user()->id;

    	 $mygames = DB::table('subscriptions')
                    ->leftJoin('games', 'games.id', 'subscriptions.id_game') //not loggedin
                    ->where('id_subscriptor', $uid) //loggedin
                    ->get(); //quien me envia una solicitud

        return view('profile.mygames', compact('mygames'));
    }

}