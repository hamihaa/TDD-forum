<?php

namespace App;

use App\Traits\Favorable;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favorable, RecordsActivity;

    protected $guarded = [];

    //to eager load owner, favourites and  with every reply object
    protected $with = ['owner', 'favorites', 'thread'];

    //adds custom attributes to an array everytime Reply is casted
    protected $appends = ['favoritesCount', 'upvotesCount', 'downvotesCount', 'isFavorited', 'isDownvoted', 'isUpvoted'];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($reply) {
            $reply->thread->increment('replies_count');
        });

        static::deleted(function ($reply) {
            $reply->thread->decrement('replies_count');
        });

    }

    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }

    /**
     * A reply has an owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo('App\Thread');
    }

    public function setBodyAttribute($body)
    {
        $this->attributes['body'] = preg_replace(
            '/@([\w\-]+)/',
            '<a href="/profiles/$1">$0</a>',
            $body
        );
    }

    public function votes()
    {
        return $this->hasMany(CommentVote::class, 'reply_id');
    }

    public function upvotes()
    {
        return $this->votes()->where('vote_type', 1);
    }

    public function downvotes()
    {
        return $this->votes()->where('vote_type', 0);
    }

    public function getUpvotesCountAttribute()
    {
        return $this->upvotes()->count();
    }

    public function getDownvotesCountAttribute()
    {
        return $this->downvotes()->count();
    }

    public function getIsUpvotedAttribute()
    {
        return !!$this->upvotes()->where('user_id', auth()->id())->count();
    }

    public function getIsDownvotedAttribute()
    {
        return !!$this->downvotes()->where('user_id', auth()->id())->count();
    }

    /**
     * User votes for the thread
     *
     * @param null $userId
     * @return $this
     */
    public function vote($type)
    {
        $this->votes()->create([
            'user_id' => auth()->id(),
            'vote_type' => $type
        ]);

        return $this;
    }

    public function unvote()
    {
        $this->votes()
            ->where(['user_id' => auth()->id()])
            ->delete();
        return $this;
    }

    public function changeVote($type)
    {
        $this->votes()
            ->where(['user_id' => auth()->id()])
            ->update(['vote_type' => $type]);
        return $this;
    }

}
