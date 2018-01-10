<?php

Route::get('send/{id_game}', 'mailController@send');

Route::get('try', function(){
	return App\posts::with('user', 'likes')->get();
});

Route::get('likes', function(){
	return App\likes::all();
});

Route::get('/home', function(){
	$likes = App\likes::all();
	return view('home', compact('likes'));
});

Route::get('newMessage','ProfileController@newMessage');
Route::get('newMessageOnline/{id}','ProfileController@newMessageOnline');
Route::post('sendNewMessage', 'ProfileController@sendNewMessage');
Route::post('/sendMessage', 'ProfileController@sendMessage');

Route::get('/messages', function(){
	return view('messages');
});

Route::get('/getMessages', function(){
	$allUsers1 = DB::table('users')
	->join('conversation', 'users.id', 'conversation.user_one')
	->where('conversation.user_two', Auth::user()->id)->get();

	$allUsers2 = DB::table('users')
	->join('conversation', 'users.id', 'conversation.user_two')
	->where('conversation.user_one', Auth::user()->id)->get();

	return array_merge($allUsers1->toArray(), $allUsers2->toArray());
});

Route::get('/getMessages/{id}', function($id){
	$userMsg = DB::table('messages')
	->join('users', 'users.id', 'messages.user_from')
	->where('messages.conversation_id', $id)->get();
		return $userMsg;
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function(){

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

        if($friends){
        	foreach($friends as $uList){
        	$ids[] = $uList->id;
        	$uList->id;	
        	}

			$posts = DB::table('posts')
			->leftJoin('profiles', 'profiles.user_id', 'posts.user_id')
			->leftJoin('users', 'posts.user_id', 'users.id')
			->whereIn('posts.user_id', $ids)
			->orderBy('posts.created_at', 'desc')->take(5)
			->get();
			return view('home', compact('post'));
        }
        else{
        	return view('home');
        }
});

Route::get('postsjson', function(){

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
        
});

Route::post('addPost', 'PostsController@addPost');

Route::get('/deletePost/{idpost}', 'PostsController@deletePost');

Route::get('/likePost/{idpost}', 'PostsController@likePost');

Auth::routes();

/*Aqui creamos un middleware para que solo los usuarios logueados puedan acceder a la vista index de profile*/
Route::group(['middleware' => 'auth'], function () {

	//Route::get('/home', 'HomeController@index')->name('home');
	Route::get('profile/{slug}', 'ProfileController@index');

	Route::get('/changePhoto', function(){
		return view('profile.pic');
	});
	Route::post('/uploadPhoto', 'ProfileController@uploadPhoto');

	Route::get('editProfile', 'ProfileController@editProfileForm');

	Route::post('/updateProfile', 'ProfileController@updateProfile');

	Route::get('/findFriends', 'ProfileController@findFriends');

	Route::get('/addFriend/{id}', 'ProfileController@sendRequest');

	Route::get('/requests', 'ProfileController@requests');

	Route::get('/accept/{name}/{id}', 'ProfileController@accept');

	Route::get('friends', 'ProfileController@friends');

	Route::get('/requestRemove/{id}', 'ProfileController@requestRemove');

	Route::get('/notifications/{id}', 'ProfileController@notifications');

	Route::get('/unfriend/{id}', function($id){
             $loggedUser = Auth::user()->id;
              DB::table('friendships')
              ->where('requester', $loggedUser)
              ->where('user_requested', $id)
              ->delete();
              DB::table('friendships')
              ->where('user_requested', $loggedUser)
              ->where('requester', $id)
              ->delete();
               return back()->with('msg', 'You are not friend with this person');
        });
		
});

Route::get('/findGames', 'GameController@findGames');

Route::get('posts', 'HomeController@index');

Route::get('/game/{id}', 'GameController@index');

Route::get('/subcription/{id_game}', 'GameController@subcription');

Route::get('/mygames', 'GameController@mygames');

Route::get('/logout', 'Auth\LoginController@logout');