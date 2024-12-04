<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller

{
    public function login(Request $request)
    {
        // $user = User::where('email', $request->email)->first();

        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        if(Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('API Token Of'.$user->name)->plainTextToken;
            $user->remember_token = $token;
            $user->save();
            return response()->json([
                'token' => $user->remember_token,//get the names right UwU
                'user' => $user,
            ]);
            }
            else {
                return response()->json([
                    'you are an idiot',
                ]);
        }

        // if (! $user || ! Hash::check($request->password, $user->password)) {
        //     return response()->json(['message' => 'Invalid credentials'], 401);
        // }
        // Auth::login($user, true);
        // $token = $user->createToken('API Token')->plainTextToken;
        // $user->rememberToken->$token;


        // dd('login');
        // $attributes = request()->validate([
        //     'email' => ['required', 'email'],
        //     'password' => ['required']
        // ]);

        // if (! Auth::attempt($attributes)) {
        //     dd('login failed');
        // }

        // request()->session()->regenerate();
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

    public function logout()
    {
        Auth::logout();
        return response()->json(['msg' =>'kicked out by dasdqw clan leader']);
    }
}
