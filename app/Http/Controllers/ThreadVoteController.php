<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class ThreadVoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store($channelId = null, Thread $thread)
    {
        //$voteType = request('vote_type');
        $this->authorize('vote', $thread);
        $thread->vote();
        return back();
    }

    public function update($channelId = null, Thread $thread)
    {
        $this->authorize('vote', $thread);
        $thread->changeVote();
        return back();
    }

    public function destroy($channelId = null, Thread $thread)
    {
        $this->authorize('vote', $thread);
        $thread->unvote();
        return back();
    }
}
