<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    //
    protected $guarded = [];

    /**
     * Returns related subject for activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function subject()
    {
        return $this->morphTo();
    }



    public static function getUserActivity(User $user, $quantity = 10)
    {
        return static::where('user_id', $user->id)
            ->latest()
            ->with('subject')
            ->take($quantity)
            ->get()
            ->groupBy(function ($activity) {
                return $activity->created_at->format('d.m.Y');
            });
    }
}
