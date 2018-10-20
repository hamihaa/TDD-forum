<?php

namespace App\Policies;

use App\User;
use App\User as EditedUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before($user)
    {
        if ($user->name == 'admin') {
            return true;
        }
    }
    /**
     * Determine whether the user can view the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        //
    }

    /**
     * Determine whether the user can create users.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param \App\Policies\User|User $user
     * @param \App\Policies\User $updatedUser
     * @return mixed
     */
    public function update(User $user, EditedUser $updatedUser)
    {
        return $user->id == $updatedUser->id;
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $user, EditedUser $editedUser)
    {
        //
    }
}
