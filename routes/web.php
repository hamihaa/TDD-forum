<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('login/github', 'Auth\LoginController@redirectToProvider');
Route::get('login/github/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/', function() {
   return redirect('/threads');
});

Route::get('/home', 'HomeController@index');

Route::get('/threads', 'ThreadController@index');
Route::get('/threads/create', 'ThreadController@create');
Route::post('/threads', 'ThreadController@store');
Route::get('/threads/{category}', 'ThreadController@index');
Route::get('/threads/{category}/{thread}', 'ThreadController@show');
Route::delete('/threads/{category}/{thread}', 'ThreadController@destroy');

// TODO Route::post('/threads/{thread}/favorite', 'FavoriteController@store');
///** instead of all these default CRUD paths for Threads, use Route::resource('threads', 'ThreadController')

Route::post('/threads/{category}/{thread}/replies', 'ReplyController@store');
Route::get('/threads/{category}/{thread}/replies', 'ReplyController@index');

Route::patch('/replies/{reply}', 'ReplyController@update');
Route::delete('/replies/{reply}', 'ReplyController@destroy');

Route::post('/threads/{category}/{thread}/subscriptions', 'ThreadSubscriptionController@store');
Route::delete('/threads/{category}/{thread}/subscriptions', 'ThreadSubscriptionController@destroy');

Route::post('/replies/{reply}/favorite', 'FavoriteController@store');
Route::delete('/replies/{reply}/favorite', 'FavoriteController@destroy');

Route::get('profiles/{user}', 'ProfileController@show');
Route::get('profiles/{user}/notifications', 'UserNotificationController@index');
Route::delete('profiles/{user}/notifications/{notification}', 'UserNotificationController@destroy');