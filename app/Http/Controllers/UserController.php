<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    public function fetch()
    {
        $users = User::all();
        return response()->json([
            'message' => 'yes',
            'data' => $users,
        ]);
    }

    public function signUp(Request $request)
    {
        $userAttributes = $request->validate([
            $firstname = 'firstName' => ['required'],
            $lastname = 'lastName' => ['required'],
            $userName = 'userName' => ['required'],
            $location = 'location' => ['required'],
            $email = 'email' => ['required'],
            $number = 'number' => ['required'],
            $password = 'password' => ['required'],
        ]);

        User::factory()->create([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'location' => $location,
            'userName' => $userName,
            'email' => $email,
            'number' => $number,
            'password' => $password
        ]);

        return response()->json(['message' => 'ok', 'data' => $userAttributes]);
    }

    public function changeLogo(Request $request)
    {
        $request->validate([
            'userName' => 'required|string',
            'newLogo' => 'required|string',
        ]);
        $userName = $request->input('userName');
        $newLogo = $request->input('newLogo');

        $user = User::where('userName', $userName)->first();
        $user->logo = $newLogo;
    }
}
