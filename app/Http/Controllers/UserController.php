<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
    public function create(Request $request) {
        return view ('auth.register');
    }

    public function store(Request $request) {
        $userAttributes = $request->validate([
            'name' => ['required'],
            'email' => ['required'],
            'number' => ['required'],
            'password' => ['required'],
        ]);

        User::create($userAttributes);
        // dd($request -> name);

    }
    public function update(Request $request) {
        $logopath = $request->logo->store();
        User::update($logopath);

    }
}
