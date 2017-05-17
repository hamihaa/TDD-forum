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
    protected static function bootFavorable()
    {
        static::deleting(function ($model) {
           $model->favorites->each->delete();
        });
    }

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

    function unFavorite()
    {
        $attributes = ['user_id' => auth()->id()];

        $this->favorites()->where($attributes)->get()->each->delete();

    }

    public function isFavorited()
    {
        return !! $this->favorites->where('user_id', auth()->id())->count();
    }


    /**
     * Used for attribute in vue, to check $reply->isFavorited
     */
    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }
    /**
     * returns count of favourites for every reply
     */
    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}