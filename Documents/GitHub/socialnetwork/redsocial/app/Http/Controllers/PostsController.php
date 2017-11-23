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
            $posts_json = DB::table('posts')
            ->leftJoin('profiles', 'profiles.user_id', 'posts.user_id')
            ->leftJoin('users', 'posts.user_id', 'users.id')
            ->orderBy('posts.created_at', 'desc')->take(3)
            ->get();
            return $posts_json;
        }
    }
}
