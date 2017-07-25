<?php

namespace App\Policies;

use App\User;
use App\Thread;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThreadPolicy
{
    use HandlesAuthorization;


    /**
     * Will return true on all, instant authorization, used for admins or any other role
     * @param $user
     * @return bool
     */
    public function before($user)
    {
        if($user->name == 'admin')
        {
            return true;
        }
    }

    public function vote(User $user, Thread $thread)
    {
        return $thread->thread_status_id == 2 || $thread->thread_status_id == 3;
    }

    /**
     * Determine whether the user can view the thread.
     *
     * @param  \App\User  $user
     * @param  \App\Thread  $thread
     * @return mixed
     */
    public function view(User $user, Thread $thread)
    {
        //
    }

    /**
     * Determine whether the user can create threads.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the thread.
     *
     * @param  \App\User  $user
     * @param  \App\Thread  $thread
     * @return mixed
     */
    public function update(User $user, Thread $thread)
    {
        return $thread->user_id == $user->id;
    }

    public function editBody(User $user, Thread $thread)
    {
        return $thread->thread_status_id == 1 || $thread->thread_status_id == 2 && $thread->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the thread.
     *
     * @param  \App\User  $user
     * @param  \App\Thread  $thread
     * @return mixed
     */
    public function delete(User $user, Thread $thread)
    {
        return $thread->user_id == $user->id;
    }
}
