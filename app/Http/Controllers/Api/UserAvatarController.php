<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserAvatarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store()
    {

        $this->validate(request(), [
            'avatar' => ['required', 'image']
        ]);

        auth()->user()->update([
            'thumbnail' => request()->file('avatar')->store('avatars', 'public')
        ]);

        return back();
    }
}
