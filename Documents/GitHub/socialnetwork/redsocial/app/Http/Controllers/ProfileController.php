<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\friendships;
use App\notifications;

class ProfileController extends Controller
{
    public function index($slug){

        $data = DB::table('users')->leftJoin('profiles', 'profiles.user_id','users.id')->where('users.id', Auth::user()->id)->get();

        $userData = DB::table('users')
        ->leftJoin('profiles', 'profiles.user_id', 'users.id')
        ->where('slug', $slug)
        ->get();

    	return view('profile.index', compact('userData'))->with('data', $data);
    }

    public function uploadPhoto(Request $request){
    	$file=$request->file('pic');
    	$filename = $file->getClientOriginalName();

    	$path='public/img';
    	$file->move($path, $filename);

    	//Actualizamos la foto en la bd
    	$user_id=Auth::user()->id;

    	DB::table('users')->where('id', $user_id)->update(['pic'=>$filename]);

    	return back();
    }

    public function editProfileForm(){
        $data = DB::table('users')->leftJoin('profiles', 'profiles.user_id','users.id')->where('users.id', Auth::user()->id)->get();

        return view('profile.editProfile')->with('data', $data);
    }

    public function updateProfile(Request $request){
        $user_id=Auth::user()->id;
        DB::table('profiles')->where('user_id', $user_id)->update($request->except('_token'));
        //return back();

        $data = DB::table('users')->leftJoin('profiles', 'profiles.user_id','users.id')->where('users.id', Auth::user()->id)->get();

        return view('profile.index')->with('data', $data);
    }

    public function findFriends(){
        $uid = Auth::user()->id;
        //$allUsers = DB::table('users')->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')->where('users.id', '!=', $uid)->get();
        $allUsers = DB::table('profiles')->leftJoin('users', 'users.id', '=', 'profiles.user_id')->where('users.id', '!=', $uid)->get();
       return view('profile.findFriends')->with('allUsers',$allUsers);
/*
        foreach ($allUsers as $u) {
            echo $u->name;
            echo "<br>";
        }

*/
    }
    public function sendRequest($id){
        
        Auth::user()->addFriend($id);
        return back();
    }

    public function requests() {
        $uid = Auth::user()->id;
        $FriendRequests = DB::table('friendships')
                        ->rightJoin('users', 'users.id', '=', 'friendships.requester')
                        ->where('status', null) //si esta a 0, tengo peticiones, si esta a 1, ya lo he aceptado
                        ->where('friendships.user_requested', '=', $uid)->get();

        return view('profile.requests', compact('FriendRequests'));
       //return "$FriendRequests";
    }

    public function accept($name, $id){
    $uid = Auth::user()->id;


       // $checkRequest = friendships::where('requester',$uid)
          //              ->where('user_requested', $id)
        $checkRequest = friendships::where('requester', $id)
                        ->where('user_requested', $uid)
                        ->first();
        if($checkRequest){
            $updateFriendship=DB::table('friendships')
            ->where('user_requested',$uid)
            ->where('requester', $id)
            ->update(['status' => 1]);

            $notifications = new notifications;
            $notifications->user_hero = $id;
            $notifications->user_logged = Auth::user()->id;
            $notifications->status = '1'; //notificacion sin leer
            $notifications->note = 'ha aceptado tu solicitud';
            $notifications->save();


            if($updateFriendship){
                return back()->with('msg', 'Te has hecho amigo de '. $name);
            }
            
        }
        else{
            return back()->with('msg', 'Ya sois amigos');
        }
    }

    public function friends(){
        $uid= Auth::user()->id;

        $friend1 = DB::table('friendships')
                    ->leftJoin('users', 'users.id', 'friendships.user_requested') //not loggedin
                    ->where('status', 1)
                    ->where('requester', $uid) //loggedin
                    ->get(); //quien me envia una solicitud

       // dd($friend1);
        $friend2 = DB::table('friendships')
                    ->leftJoin('users', 'users.id', 'friendships.requester')
                    ->where('status', 1)
                    ->where('user_requested', $uid)
                    ->get(); // yo envio una peticion al usuario

        //dd($friend2);

        $friends = array_merge($friend1->toArray(), $friend2->toArray());
        //dd($friends);

        return view('profile.friends', compact('friends'));
    }

    public function requestRemove($id){
        DB::table('friendships')
                ->where('user_requested', Auth::user()->id)
                ->where('requester', $id)
                ->delete();
        return back()->with('msg', 'Has rechazado la solicitud');
    }

    public function notifications($id){
        $notes = DB::table('notifications')
                    ->leftJoin('users', 'users.id', 'notifications.user_logged')
                    ->where('notifications.id', $id)
                    ->where('user_hero', Auth::user()->id)
                    ->orderBy('notifications.created_at', 'desc')
                    ->get();

        $updateNoti = DB::table('notifications')
                        ->where('notifications.id', $id)
                        ->update(['status'=>0]);
                        
        return view('profile.notifications', compact('notes'));
    }

}
