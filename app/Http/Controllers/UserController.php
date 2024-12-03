<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        $user = User::create($userAttributes);

        Auth::login($user);
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
    public function changePassword(Request $request) {
        $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required'
        ]);
        $oldPassword = $request->input('oldPassword');
        $newPassword = $request->input('newPassword');
        $user = Auth::user();
        if(Hash::check($oldPassword, $user->password)) {
            $user->password = Hash::make($newPassword);
            $user->save();

            return response()->json(['message' => 'Password updated successfully']);
            }
        else {
            echo($oldPassword);
        }
    }
}
