<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function index(){
    	$posts = DB::table('posts')->get();

    	return view('posts', compact('posts'));
    }

    public function addPost(Request $request){
    	$content = $request->content;
    	$createPost = DB::table('posts')
    	->insert(['content' => $content, 'user_id' => Auth::user()->id, 'status' => 0, 
    		'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")]);

        if($createPost){        //si el post ha sido creado, lo mostramos automaticamente
            $uid= Auth::user()->id;

        $mypost = DB::table('users')->where('id', $uid)->get();

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

            $friends = array_merge($friend1->toArray(), $friend2->toArray(), $mypost->toArray());

            if($friends){
                foreach($friends as $uList){
                $ids[] = $uList->id;
                $uList->id; 
                }
            
                $posts_json = DB::table('posts')
                ->leftJoin('profiles', 'profiles.user_id', 'posts.user_id')
                ->leftJoin('users', 'posts.user_id', 'users.id')
                ->whereIn('posts.user_id', $ids)
                ->orderBy('posts.created_at', 'desc')->take(5)
                ->get();
                return $posts_json;
            }
        }
    }

    public function deletePost($content){
        $deletePost = DB::table('posts')->where('content', $content)->delete();

        if($deletePost){
            $uid= Auth::user()->id;

        $mypost = DB::table('users')->where('id', $uid)->get();

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

            $friends = array_merge($friend1->toArray(), $friend2->toArray(), $mypost->toArray());

            if($friends){
                foreach($friends as $uList){
                $ids[] = $uList->id;
                $uList->id; 
                }
            
                $posts_json = DB::table('posts')
                ->leftJoin('profiles', 'profiles.user_id', 'posts.user_id')
                ->leftJoin('users', 'posts.user_id', 'users.id')
                ->whereIn('posts.user_id', $ids)
                ->orderBy('posts.created_at', 'desc')->take(5)
                ->get();
                return $posts_json;
            }
        }
    }
}
