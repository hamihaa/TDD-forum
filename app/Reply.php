<?php

namespace App;

use App\Traits\Favorable;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favorable;

    protected $guarded = [];

    //to eager load owner and favourites with every reply object
    protected $with = ['owner', 'favorites'];

    /**
     * A reply has an owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }


}
