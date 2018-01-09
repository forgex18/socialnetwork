<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\friendships;
use App\notifications;
use Mail;

class mailController extends Controller
{

    public function send($id_game){

        Mail::send(['text' =>'mailView'], ['name', 'Fran'], function($message) use ($id_game){

        	$user_id=Auth::user()->nick;
        	

        	$users = DB::table('subscriptions')
			->where('id_game', $id_game)
			->get();

			$game = DB::table('games')
			->where('id', $id_game)
			->get();

			

			if($users){
	        	foreach($users as $uList){
	        		$ids[] = $uList->id_subscriptor;
	        		$uList->id_subscriptor;	
	        	}
	        

				$correo = DB::table('users')
				->whereIn('id', $ids)
				->get();

				foreach ($game as $uGame) {
					$title = $uGame->title;
				}

				
				if($correo){
	        	foreach($correo as $uMail){
	        		$mails = $uMail->email;
	        		
	        		//echo $mails;
	        		$content = $user_id." busca partida - ".$title;
	    			$message->to($mails)->subject($content);
	    			$message->from('oplayredsocial@gmail.com', 'O-Play');
	    			}
	    		}
	    		else{
	    			echo "hola";
	    		}
    		}	
    	});
        return back();
    }
    
}
