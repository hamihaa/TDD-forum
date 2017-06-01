<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;


use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ThreadHasNewReply
{
    use SerializesModels;
    public $thread;
    public $reply;

    /**
     * Create a new event instance.
     *
     * @param |App\Thread $thread
     * @param \App\Reply $reply
     */
    public function __construct($thread, $reply)
    {
        $this->thread = $thread;
        $this->reply = $reply;
    }

}
