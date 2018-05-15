<?php

namespace App;

use App\Notifications\ThreadWasChanged;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Model;

class ThreadVote extends Model
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
     * Vote belongs to a thread
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function notifyEveryoneWhoVoted()
    {
        $this->user->notify(new ThreadWasChanged($this->thread));
    }
}
