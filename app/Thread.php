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


    //eager load objects
    protected $with = ['creator', 'category', 'status']; // + 'favorites'

    //appended to object
    protected $appends = [
        'isSubscribedTo',
        'isDownVotedOn',
        'isUpVotedOn',
        'upvotesCount',
        'downvotesCount'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($thread) {
            $thread->tags()->detach();
        });
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

    public function thumbnail()
    {
        if ($this->image) {
            return $this->image;
        }
        return "categories/" . $this->category->slug . ".jpg";
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
     * thread has a statu
     */
    public function status()
    {
        return $this->belongsTo('App\ThreadStatus', 'thread_status_id');
    }

    /*
     * Changes status of thread
     */
    public function changeStatus($threadStatusId)
    {
        $this->thread_status_id = $threadStatusId;

        //if changing to v_razpravi
        if ($threadStatusId == 2) {
            $this->in_discussion_from = \Carbon\Carbon::now();
        }
        //if changing to v_glasovanju
        if ($threadStatusId == 3) {
            $this->in_voting_from = \Carbon\Carbon::now();
        }
        $this->save();
    }

    /*
    public function statuses()
    {
        return $this->belongsToMany('App\ThreadStatus', 'thread_has_status', 'thread_id', 'thread_status_id')->withPivot('created_at');
    }


    public function getCurrentStatusAttribute()
    {
        return $this->statuses()->orderBy('pivot_created_at', 'desc')->first()->id;
    }
     */

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

    /*
     *  N - N relationship
     *  One thread may have many tags
     *  any tag may be applied to many tags
     *
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag');
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
        event(new ThreadHasNewReply($reply));

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
            'user_id' => $userId ? : auth()->id()
        ]);

        return $this;
    }


    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
            ->where(['user_id' => $userId ? : auth()->id()])
            ->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    /**
     * used in $with attr
     *
     * @return mixed
     */
    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()->where('user_id', auth()->id())
            ->exists();
    }

    /**
     * used in $with attr
     * @return mixed
     */
    public function getIsUpVotedOnAttribute()
    {
        return $this->votes()->where('user_id', auth()->id())
            ->where('vote_type', '1')
            ->exists();
    }

    /**
     * used in $with attr
     * @return mixed
     */
    public function getIsDownVotedOnAttribute()
    {
        return $this->votes()->where('user_id', auth()->id())
            ->where('vote_type', '0')
            ->exists();
    }
    /**
     * Returns collection of votes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votes()
    {
        return $this->hasMany(ThreadVote::class);
    }

    /**
     * User votes for the thread
     *
     * @param null $userId
     * @return $this
     */
    public function vote($userId = null)
    {
        $this->votes()->create([
            'user_id' => $userId ? : auth()->id(),
            'vote_type' => request('vote_type')
        ]);

        return $this;
    }

    public function unvote($userId = null)
    {
        $this->votes()
            ->where(['user_id' => $userId ? : auth()->id()])
            ->delete();
        return $this;
    }

    public function changeVote($userId = null)
    {
        $this->votes()
            ->where(['user_id' => $userId ? : auth()->id()])
            ->update(['vote_type' => request('vote_type')]);
        return $this;
    }

    /**
     * returns count of upvotes for thread
     */
    public function getUpvotesCountAttribute()
    {
        return $this->votes->where('vote_type', '1')->count();
    }

    /**
     * returns count of downvotes for thread
     */
    public function getDownvotesCountAttribute()
    {
        return $this->votes->where('vote_type', '0')->count();
    }


    public function neededVotesToPass()
    {
        $total = \App\User::numberOfActiveUsers();
        $needed = Round($total * 0.05) - $this->upvotesCount - $this->downvotesCount;
        return $needed;
    }
}
