<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThreadStatus extends Model
{
    protected $table = 'thread_status';
    protected $guarded = [];

    /*
     * 1 - nepotrjeno
     * 2 - v_razpravi
     * 3 - v_glasovanju
     * 4 - posredovano
     * 5 - organ_sprejel
     * 6 - organ_zavrnil  5 in 6 sta enako z_odzivom
     * 7 - neustrezno
     *  */

    public function threads()
    {
        return $this->hasMany('App\Thread');
    }

    /*
    public function threads()
    {
        return $this->belongsToMany('App\Thread', 'thread_has_status', 'thread_status_id', 'thread_id')->withTimestamps();
    }
    */
}
