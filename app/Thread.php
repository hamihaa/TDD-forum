<?php

namespace App;

use App\Events\ThreadHasNewReply;
use App\Notifications\ThreadWasUpdated;
use App\Traits\Favorable;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use Favorable, RecordsActivity;

    protected $guarded = [];

    protected $with = ['creator', 'category']; // + 'favorites'

    protected $appends = ['isSubscribedTo']; //appended to object

    protected static function boot()
    {
        parent::boot();

        /*replies_count is always available when calling $thread object
        /* replaced by updating migration for threads table, added replies_count
        static::addGlobalScope('replyCount', function($builder){
            $builder->withCount('replies');
        });
        */
    }

    /**
     * Return a string path to thread.
     *
     * @return string
     */
    public function path()
    {
         return "/threads/{$this->category->slug}/{$this->id}";
    }

    /**
     * Get the user who created this thread.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\User', 'user_id');
    }


    /**
     * A thread can have many replies.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany('App\Reply');
    }

    /**
     * thread belongs to a category
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }


    /**
     * Add a reply to the thread.
     * On add, also create notification for all users
     *
     * @param $reply
     * @return Model
     */
    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);

        //make an announcement that thread has new reply, it is caught in eventserviceprovider by listener
        event(new ThreadHasNewReply($this, $reply));

        return $reply;
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    /**
     * Subscribe user to this thread
     *
     * @param null $userId
     * @return $this
     */
    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
           'user_id' => $userId? : auth()->id()
        ]);

        return $this;
    }


    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
            ->where(['user_id' => $userId? : auth()->id()])
            ->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()->where('user_id', auth()->id())
            ->exists();
    }
}
