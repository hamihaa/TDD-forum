<?php

namespace App\Listeners;

use App\Events\ThreadHasNewReply;
use App\Notifications\YouWereMentioned;
use App\User;

class NotifyMentionedUsers
{

    /**
     * Handle the event.
     * @param  ThreadHasNewReply  $event
     * @return void
     */
    public function handle(ThreadHasNewReply $event)
    {
        //with regex inspect body of reply if there are usernames tagged in there
        //all matches are then saved in $matches
        preg_match_all('/@([\w\-]+)/', $event->reply->body, $matches);

        $names = $matches[1];
        //notify each user that was mentioned
        foreach ($names as $name) {
            $user = User::whereName($name)->where('get_notifications', 1)->first();
            if ($user) {
                $user->notify(new YouWereMentioned($event->reply));
            }
        }
    }
}
