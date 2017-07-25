<?php

namespace App\Listeners;

use App\Events\ThreadHasNewReply;

class NotifyThreadSubscribers
{

    /**
     * Handle the event. Notify all subscribers of a thread
     *
     * @param  ThreadHasNewReply  $event
     * @return void
    */
    public function handle(ThreadHasNewReply $event)
    {
        $thread = $event->reply->thread;

        $thread->subscriptions
            ->where('user_id', '!=', $event->reply->user_id)
            ->each
            ->notifyAllSubscribers($event->reply);
    }

}
