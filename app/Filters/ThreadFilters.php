<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ThreadFilters extends Filters
{
    protected $filters = ['by', 'popular', 'unanswered', 'votes', 'status', 'tag', 'search', 'dateFrom'];

    /**
     * filter query by given username
     * @param string $username
     * @return mixed
     */
    public function by($username)
    {
        $user = \App\User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

    /**
     * Filter query by given tag (Oznaka)
     * @param $tagName
     */
    public function tag($tagName)
    {
        /*
        $post = \App\Thread::whereHas('tags', function($q) use ($tagName) {
            $q->where('name', '$tagName');
        });
        */
        $tagId = \App\Tag::where('name', $tagName)->first();
        if (!$tagId) {
            return $this->builder;
        }
        return $this->builder
            ->join('tag_thread', 'threads.id', '=', 'tag_thread.thread_id')
            ->where('tag_thread.tag_id', $tagId->id);
    }

    /**
     * Filter query by popularity (replies_count)
     * @return mixed
     */
    protected function popular()
    {
        $this->builder->getQuery()->orders = [];
        return $this->builder->orderBy('replies_count', 'desc');
    }

    protected function unanswered()
    {
        return $this->builder->where('replies_count', 0);
    }

    /**
     *  https://laracasts.com/discuss/channels/eloquent/orderby-relation-count
     * Filter query by number of votes
     * @return mixed
     */
    protected function votes()
    {
        //next line removes ->latest() from existing query in getThreads
        $this->builder->getQuery()->orders = [];
        return $this->builder->withCount('votes')->orderBy('votes_count', 'desc');
    }

    /**
     * filter query by given statusId
     * @param $statusId
     * @return mixed
     * @internal param string $username
     */
    public function status($statusId)
    {
        return $this->builder->where('thread_status_id', $statusId);
    }

    public function dateFrom($query) {
        return $this->builder->where('created_at', '>', $query);
    }

    public function dateTo($query) {
        return $this->builder->where('created_at', '<', $query);
    }
}