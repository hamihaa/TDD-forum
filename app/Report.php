<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['reply_id', 'user_id'];

    /**
     *  Get user that created report
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     *  Get reply that belongs to report
     */
    public function reply()
    {
        return $this->belongsTo('App\Reply');
    }
}
