<?php

namespace App\Http\Controllers;

use App\Notifications\YouWereMentioned;
use App\Reply;
use App\User;
use Illuminate\Http\Request;
use App\Thread;

class ReplyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(3);
    }

    /** 
     * Mark answer as government reply on thread
     */
    public function markAsAnswer(Request $request, Reply $reply)
    {
        $reply->government_reply = 1;
        $reply->save();
    }
    /**
     * Store a new Reply to Thread Object
     *
     * @param $categoryId
     * @param Thread $thread
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function store($categoryId, Thread $thread)
    {
        $this->validate(request(), [
            'body' => 'required'
        ]);

        return $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ])->load('owner');

        return back()->with('flash', 'Vaš komentar je bil uspešno dodan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Reply $reply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function edit(Reply $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reply $reply)
    {
        $this->authorize('update', $reply);
        $this->validate(request(), [
            'body' => 'required'
        ]);

        $reply->update(['body' => request('body')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('delete', $reply);
        $reply->delete();
        if (request()->expectsJson()) {
            return response(['status' => 'odgovor izbrisan.']);
        }
        return back();
    }
}
