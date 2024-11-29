<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
class SessionController extends Controller

{
    public function store()
    {
        dd('login');
        // $attributes = request()->validate([
        //     'email' => ['required', 'email'],
        //     'password' => ['required']
        // ]);

        // if (! Auth::attempt($attributes)) {
        //     dd('login failed');
        // }

        // request()->session()->regenerate();
    }

    public function destroy()
    {
        Auth::logout();
    }
}
