<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class ThreadBodyWasUpdated
{
    use SerializesModels;
    public $thread;

    /**
     * Create a new event instance.
     *
     * @param |App\Thread $thread
     * @param \App\Reply $reply
     */
    public function __construct($thread)
    {
        $this->thread = $thread;
    }
}
