<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ThreadFilters extends Filters
{
    protected $filters = ['by', 'popular', 'unanswered'];

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
}