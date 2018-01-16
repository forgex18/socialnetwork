<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\friendships;
use App\notifications;
use App\games;
use App\demands;
use Mail;

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


     public function updateGames(){
        $uid = Auth::user()->id;

        $allGames = DB::table('games')->get();
       return view('profile.updateGames', compact('allGames'));
    }

    public function newGames(Request $request) {
      games::create($request->all());

      return redirect('updateGames');
      }

      public function wantGames(Request $request) {
      demands::create($request->all());

      return redirect('login');
      }

      public function picGame($id_game){
        $game = DB::table('games')->where('id', $id_game)->get();
        return view('profile.picGame', compact('game'));
      }

      public function uploadPhotoGame(Request $request, $id_game){
        $file=$request->file('pic');
        $filename = $file->getClientOriginalName();

        $path='public/img/games';
        $file->move($path, $filename);

        //Actualizamos la foto en la bd


        DB::table('games')->where('id', $id_game)->update(['photo'=>$filename]);

        return redirect('login');
    }

    public function play($nick, $id_game){

      Mail::send(['text' =>'mailView'], ['name', 'Fran'], function($message) use ($id_game, $nick){

      $users = DB::table('subscriptions')
      ->where('id_game', $id_game)
      ->get();

      if($users){
            foreach($users as $uList){
              $ids[] = $uList->id_subscriptor;
              $uList->id_subscriptor; 
            }

      $game = DB::table('games')
      ->where('id', $id_game)
      ->get();

      foreach ($game as $uGame) {
          $title = $uGame->title;
        }


        $correo = DB::table('users')
        ->whereIn('id', $ids)
        ->get();


      foreach ($correo as $key => $value) {
        if($value->id != Auth::user()->id){

          $notifications = new notifications;
          $notifications->user_hero = $value->id;
          $notifications->user_logged = Auth::user()->id;
          $notifications->status = '1'; //notificacion sin leer
          $notifications->note = 'busca partida de '.$title;
          $notifications->save();

          $mails = $value->email;
              
              //echo $mails;
              $content = $nick." busca partida - ".$title;
            $message->to($mails)->subject($content);
            $message->from('oplayredsocial@gmail.com', 'O-Play');
        }
      }
    }
    });
        return back()->with('msg', 'Se ha realizado una busqueda de partida');
      
    }

    

}