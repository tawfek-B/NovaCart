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
            return response()->json([
                $user->createToken('API Token')->plainTextToken,
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
        return response()->json(['messeage' => 'WEllcum']);


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

    public function logout()
    {
        Auth::logout();
    }
}
