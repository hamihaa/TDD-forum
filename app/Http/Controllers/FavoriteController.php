<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Reply;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function store(Reply $reply)
    {
        /*
         * Reply->addFavorite(request())
         * in addFavorite do -> $this->favorites()->attach(...)
         */

        $reply->addFavorite();
        return back();

    }
}
