<?php

namespace App\Http\Controllers;

use App\Activity;
use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

    public function show(User $user)
    {
       // return Activity::getUserActivity($user);
        return view('profiles.show', [
            'profileUser' => $user,
            'activities' => Activity::getUserActivity($user)
        ]);
    }

    public function edit(User $user)
    {
        return view('profiles.edit', compact('user'));
    }

    public function update(User $user, Request $request)
    {
//        dd($request['is_anonymous']);
        $this->authorize('update', $user);

        if($request['password'] == null)
        {
            $this->validate(request(), [
                'name' => 'required|max:255|unique:users,name,'.$user->id,
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            ]);

        } else {
            $this->validate(request(), [
                'name' => 'required|max:255|unique:users,name,'.$user->id,
                'first_name' => 'required|min:1',
                'last_name' => 'required|min:1',
                'email' => 'required|email|max:255|unique:users,email,'.$user->id,
                'password' => 'confirmed|required|min:6',
            ]);
            $pass = $request['password'];
            $user->password = bcrypt($pass);
        }

        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->first_name = $request['first_name'];
        $user->last_name = $request['last_name'];
        $user->is_anonymous = $request['is_anonymous']? '1' : '0';
        $user->save();

        return back();
    }
}