<?php

namespace App;

use App\Events\ThreadBodyWasUpdated;
use App\Notifications\ThreadWasCommented;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class ThreadSubscription extends Model
{

    protected $guarded = [];

    /**
     * Subscription belongs to a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Subscription belongs to a thread
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    /**
     * Notify the user(anyone who is subscribed to the thread that was commented)
     *
     * @param $reply
     */
    public function notifyAllSubscribers($reply)
    {
        $this->user->notify(new ThreadWasCommented($this->thread, $reply));
    }

}
