<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\friendships;
use App\notifications;
use App\User;

class ProfileController extends Controller
{
    public function index($slug){

        $data = DB::table('users')->leftJoin('profiles', 'profiles.user_id','users.id')->where('users.id', Auth::user()->id)->get();

        $userData = DB::table('users')
        ->leftJoin('profiles', 'profiles.user_id', 'users.id')
        ->where('slug', $slug)
        ->get();

    	return view('profile.index')->with('userData', $userData);
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
        $userData = DB::table('users')->leftJoin('profiles', 'profiles.user_id','users.id')->where('users.id', Auth::user()->id)->get();

        return view('profile.editProfile')->with('userData', $userData);
    }

    public function updateProfile(Request $request){
        $user_id=Auth::user()->id;
        DB::table('profiles')->where('user_id', $user_id)->update($request->except('_token'));
        //return back();

        $userData = DB::table('users')->leftJoin('profiles', 'profiles.user_id','users.id')->where('users.id', Auth::user()->id)->get();

        return view('profile.index')->with('userData', $userData);
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

     public  function sendMessage(Request $request){
      $conID = $request->conID;
      $msg = $request->msg;
      $checkUserId = DB::table('messages')->where('conversation_id', $conID)->get();
      if($checkUserId[0]->user_from== Auth::user()->id){
        // fetch user_to
        $fetch_userTo = DB::table('messages')->where('conversation_id', $conID)
        ->get();
          $userTo = $fetch_userTo[0]->user_to;
      }else{
      // fetch user_to
      $fetch_userTo = DB::table('messages')->where('conversation_id', $conID)
      ->get();
        $userTo = $fetch_userTo[0]->user_to;
      }
        // now send message
        $sendM = DB::table('messages')->insert([
          'user_to' => $userTo,
          'user_from' => Auth::user()->id,
          'msg' => $msg,
          'status' => 1,
          'conversation_id' => $conID
        ]);
        if($sendM){
          $userMsg = DB::table('messages')
          ->join('users', 'users.id','messages.user_from')
          ->where('messages.conversation_id', $conID)->get();
          return $userMsg;
        }
    }

    public function newMessage(){
      $uid = Auth::user()->id;
      $friends1 = DB::table('friendships')
              ->leftJoin('users', 'users.id', 'friendships.user_requested') // who is not loggedin but send request to
              ->where('status', 1)
              ->where('requester', $uid) // who is loggedin
              ->get();
      $friends2 = DB::table('friendships')
              ->leftJoin('users', 'users.id', 'friendships.requester')
              ->where('status', 1)
              ->where('user_requested', $uid)
              ->get();
      $friends = array_merge($friends1->toArray(), $friends2->toArray());
      return view('newMessage', compact('friends', $friends));
    }
    
    public function sendNewMessage(Request $request){
        $msg = $request->msg;
        $friend_id = $request->friend_id;
        $myID = Auth::user()->id;
        //check if conversation already started or not
        $checkCon1 = DB::table('conversation')->where('user_one',$myID)
        ->where('user_two',$friend_id)->get(); // if loggedin user started conversation
        $checkCon2 = DB::table('conversation')->where('user_two',$myID)
        ->where('user_one',$friend_id)->get(); // if loggedin recviced message first
        $allCons = array_merge($checkCon1->toArray(),$checkCon2->toArray());
        if(count($allCons)!=0){
          // old conversation
          $conID_old = $allCons[0]->id;
          //insert data into messages table
          $MsgSent = DB::table('messages')->insert([
            'user_from' => $myID,
            'user_to' => $friend_id,
            'msg' => $msg,
            'conversation_id' =>  $conID_old,
            'status' => 1
          ]);
        }else {
          // new conversation
          $conID_new = DB::table('conversation')->insertGetId([
            'user_one' => $myID,
            'user_two' => $friend_id
          ]);
          echo $conID_new;
          $MsgSent = DB::table('messages')->insert([
            'user_from' => $myID,
            'user_to' => $friend_id,
            'msg' => $msg,
            'conversation_id' =>  $conID_new,
            'status' => 1
          ]);
          
        }
    }

    public function newMessageOnline($id){
      $uid = Auth::user()->id;
      
      $user = DB::table('users')
      ->where('id', $id)
      ->get();

      return view('newMessageOnline', compact('user', $user));
    }

    public function search(Request $request){
      $term = $request->term;
      $nicks = User::where('nick', 'LIKE', '%'.$term.'%')->get();
      if(count($nicks) == 0){
        $searchResult[] = 'No se encuentran resultados';
      }else{
        foreach ($nicks as $key => $value) {
          $searchResult[] = $value->nick;
        }
      }
      return $searchResult;
    }
      
    public function holidays(){
      $uid = Auth::user()->id;
      $value = Auth::user()->noti;
      

      if($value==null){
        $option=1;
      }
      else{
        $option=null;
      }

      DB::table('users')->where('id', $uid)->update(['noti'=>$option]);
      return back()->with('msg', 'Notificaciones por correo modificadas');

    }

}
