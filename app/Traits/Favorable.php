<?php
/**
 * Created by PhpStorm.
 * User: Miha
 * Date: 05-May-17
 * Time: 22:40
 */

namespace App\Traits;


trait Favorable
{

    public function favorites()
    {
        return $this->morphMany('App\Favorite', 'favorited');
    }

    /**
     * @return Model
     */
    public function addFavorite()
    {
        //if favorite doesn't yet exist
        if(! $this->favorites()->where(['user_id' => auth()->id()])->exists()) {
            return $this->favorites()->create(['user_id' => auth()->id()]);
        }
    }

    public function isFavorited()
    {
        return !! $this->favorites->where('user_id', auth()->id())->count();
    }

    /**
     * returns count of favourites for every reply
     */
    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}