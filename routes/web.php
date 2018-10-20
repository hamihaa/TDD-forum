<?php

use App\CommentVote;
use App\Reply;
use Illuminate\Support\Facades\Session;
use App\User;

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

 // php 7.2 count() error fix 
// https://github.com/laravel/framework/issues/20248
if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
    // Ignores notices and reports all other kinds... and warnings
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    // error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}

Auth::routes();

Route::get('/test', function () {

    $users = User::where('get_newsletter', 1)->get();

    $lastPosts = \App\Thread::where('created_at', '<', \Carbon\Carbon::now()->subDays(7))->limit(5)->get();

    $lastWithResponse = \App\Thread::where('created_at', '<', \Carbon\Carbon::now()->subDays(7))->whereIn('thread_status_id', [5, 6])->limit(5)->get();

    $mostVoted = \App\Thread::where('created_at', '<', \Carbon\Carbon::now()->subDays(7))->withCount('votes')->orderBy('votes_count', 'desc')->limit(5)->get();

    $mostCommented = \App\Thread::where('created_at', '<', \Carbon\Carbon::now()->subDays(7))->withCount('replies')->orderBy('replies_count', 'desc')->limit(5)->get();

    foreach ($users as $user) {
        Mail::send('emails.newsletter', compact('lastPosts', 'lastWithResponse', 'mostVoted', 'mostCommented'), function ($message) use ($user) {
            $message->from('predlagam.vladi@test.test', 'Tedenski bilten na predlagam.vladi');
            $message->to($user->email);
        });
    }

});

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

Route::get('/threads', 'ThreadController@index');
Route::get('/threads/create', 'ThreadController@create');
Route::post('/threads', 'ThreadController@store');
Route::get('/threads/{category}', 'ThreadController@index');
Route::get('/threads/{category}/{thread}', 'ThreadController@show');
Route::delete('/threads/{category}/{thread}', 'ThreadController@destroy');
Route::get('/threads/{category}/{thread}/edit', 'ThreadController@edit');
Route::patch('/threads/{category}/{thread}', 'ThreadController@update');


// TODO Route::post('/threads/{thread}/favorite', 'FavoriteController@store');
///** instead of all these default CRUD paths for Threads, use Route::resource('threads', 'ThreadController')

Route::post('/threads/{category}/{thread}/replies', 'ReplyController@store');
Route::get('/threads/{category}/{thread}/replies', 'ReplyController@index');


Route::patch('/replies/{reply}', 'ReplyController@update');
Route::delete('/replies/{reply}', 'ReplyController@destroy');

Route::post('/threads/{category}/{thread}/subscriptions', 'ThreadSubscriptionController@store');
Route::delete('/threads/{category}/{thread}/subscriptions', 'ThreadSubscriptionController@destroy');

Route::post('/threads/{category}/{thread}/votes', 'ThreadVoteController@store');
Route::patch('/threads/{category}/{thread}/votes', 'ThreadVoteController@update');
Route::delete('/threads/{category}/{thread}/votes', 'ThreadVoteController@destroy');

Route::post('/replies/{reply}/favorite', 'FavoriteController@store');
Route::delete('/replies/{reply}/favorite', 'FavoriteController@destroy');

Route::post('/replies/{reply}/vote/{type}', 'CommentVotesController@storeVote');
Route::patch('/replies/{reply}/vote/{type}', 'CommentVotesController@updateVote');
Route::delete('/replies/{reply}/vote', 'CommentVotesController@destroy');

Route::get('profiles/{user}', 'ProfileController@show');
Route::patch('profiles/{user}', 'ProfileController@update');
Route::get('profiles/{user}/edit', 'ProfileController@edit');
Route::get('profiles/{user}/notifications', 'UserNotificationController@index');
Route::delete('profiles/{user}/notifications/{notification}', 'UserNotificationController@destroy');

Route::get('/admin', 'AdminController@index');

Route::get('/api/user', 'Api\UserController@index');
Route::patch('/api/user/{user}/avatar', 'Api\UserAvatarController@store')->name('avatar');

Route::resource('news', 'NewsController');
//Route::get('news/create', 'NewsController@create');
//Route::get('news/{news}', 'NewsController@show');
//Route::post('news', 'NewsController@store');
//Route::delete('')

// reporting replies
Route::post('/replies/{reply}/report', 'ReportController@store');

// marking as answer
Route::post('/replies/{reply}/mark-as-answer', 'ReplyController@markAsAnswer');