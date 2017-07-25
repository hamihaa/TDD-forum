<?php

namespace App\Listeners;

use App\Events\ThreadBodyWasUpdated;

class NotifyAllWhoVoted
{
    /**
     * Handle the event.
     * @param  ThreadBodyWasUpdated  $event
     * @return void
     */
    public function handle(ThreadBodyWasUpdated $event)
    {
        $event->thread->votes
            ->where('user_id', '!=', $event->thread->creator->id)
            ->each
            ->notifyEveryoneWhoVoted();
    }
}
