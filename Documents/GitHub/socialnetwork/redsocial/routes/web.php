<?php

Route::get('newMessage','ProfileController@newMessage');
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
	$posts = DB::table('posts')
	->leftJoin('profiles', 'profiles.user_id', 'posts.user_id')
	->leftJoin('users', 'posts.user_id', 'users.id')
	->orderBy('posts.created_at', 'desc')->take(2)
	->get();
	return view('home', compact('posts'));
});

Route::get('postsjson', function(){
	$posts_json = DB::table('posts')
	->leftJoin('profiles', 'profiles.user_id', 'posts.user_id')
	->leftJoin('users', 'posts.user_id', 'users.id')
	->orderBy('posts.created_at', 'desc')->take(3)
	->get();
	return $posts_json;
});

Route::post('addPost', 'PostsController@addPost');

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

Route::get('posts', 'HomeController@index');

Route::get('/logout', 'Auth\LoginController@logout');