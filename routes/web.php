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
Route::get('/', function() {
   return redirect('/threads');
});

Route::get('/home', 'HomeController@index');

Route::get('/threads/', 'ThreadController@index');
Route::get('/threads/create', 'ThreadController@create');
Route::post('/threads', 'ThreadController@store');
Route::get('/threads/{category}', 'ThreadController@index');
Route::get('/threads/{category}/{thread}', 'ThreadController@show');

// TODO Route::post('/threads/{thread}/favorite', 'FavoriteController@store');
///** instead of all these default CRUD paths for Threads, use Route::resource('threads', 'ThreadController')

Route::post('/threads/{category}/{thread}/replies', 'ReplyController@store');
Route::post('/replies/{reply}/favorite', 'FavoriteController@store');