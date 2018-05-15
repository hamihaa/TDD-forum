<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, CanResetPassword;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'last_login', 'thumbnail', 'first_name', 'last_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden = [
        'password', 'remember_token', 'email'
    ];

    /**
     * Default route key for model binding is name of user
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }

    /** use for validation
     * @return bool
     */
    public function isAdmin()
    {
        return $this->name == 'admin';
    }

    public function threads()
    {
        return $this->hasMany('App\Thread')->latest();
    }

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    public function avatar()
    {
        return $this->thumbnail ?: 'avatars/default.png';
    }

    /*
     * Returns number of active users
     */
    public static function numberOfActiveUsers()
    {
        $total = static::where('last_login', '>=', Carbon::now()->subMonth())->count();
        return $total;
    }

}
