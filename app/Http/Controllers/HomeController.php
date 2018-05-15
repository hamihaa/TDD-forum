<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard, with statistics for last 30 days.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $threadCount= \App\Thread::where('created_at', '>=', \Carbon\Carbon::now()->subMonth())->count();

        $acceptedThreadCount= \App\Thread::where('updated_at', '>=', \Carbon\Carbon::now()->subMonth())
                                ->where('thread_status_id', '5')
                                ->count();

        $popularCategory=
            DB::select('SELECT count(*) as threads_count, categories.name
          FROM threads LEFT JOIN categories  ON threads.category_id=categories.id
          WHERE threads.created_at > NOW() - INTERVAL 1 MONTH 
          GROUP BY threads.category_id
           ORDER BY threads_count desc LIMIT 1');

        if(count($popularCategory)){
            $popularCategory =  $popularCategory[0]->name;
        } else {
            $popularCategory = 'none';
        }

        $voteCount = \App\ThreadVote::where('created_at', '>=', \Carbon\Carbon::now()->subMonth())->count();

        $replyCount = \App\Reply::where('created_at', '>=', \Carbon\Carbon::now()->subMonth())->count();

        $newUserCount = \App\User::where('created_at', '>=', \Carbon\Carbon::now()->subMonth())->count();

        $newslist = \App\News::all();

        return view('home', compact('threadCount', 'acceptedThreadCount', 'popularCategory', 'voteCount', 'replyCount', 'newUserCount', 'newslist'));
    }
}
