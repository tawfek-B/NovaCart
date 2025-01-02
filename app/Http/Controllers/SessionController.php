<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class SessionController extends Controller
{
    public function adminlogin(Request $request) {
        $credentials = $request->validate([
            'number' => 'required',
            'email' => 'nullable|email', // Email is optional
            'password' => 'required',
        ]);

        if(is_null($credentials['email'])) {
            if (Auth::attempt(['number' => $credentials['number'], 'password' => $credentials['password']])) {
                // Find user by number
                $user = User::where('number', $credentials['number'])->first();

                if ($user && $user->admin) {
                    return view('welcome');
                } else {
                    return redirect()->back()->withErrors(['login' => "Not an admin"])->withInput();
                }
            } else {
                return redirect()->back()->withErrors(['login' => "Invalid credentials."])->withInput();
            }
        }
        else {
            if (Auth::attempt(['number' => $credentials['number'],'email' => $credentials['email'], 'password' => $credentials['password']])) {
                // Find user by number
                $user = User::where('number', $credentials['number'])->first();

                if ($user && $user->admin) {
                    return view('welcome');
                } else {
                    return redirect()->back()->withErrors(['login' => "Not an admin"])->withInput();
                }
            } else {
                return redirect()->back()->withErrors(['login' => "Invalid credentials."])->withInput();
            }
        }
    }


    public function login(Request $request)
    {
        // $user = User::where('email', $request->email)->first();

        if ($request->input('email') == null) {
            $credentials = $request->validate([
                'number' => 'required',
                'password' => 'required'
            ]);
        } else {
            $credentials = $request->validate([
                'number' => 'required',
                'email' => 'required',
                'password' => 'required'
            ]);
        }
        //this if-else was made so whether the user decides to input his email or not.
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('API Token Of' . $user->name)->plainTextToken;
            $user->remember_token = $token;
            $user->save();
            return response()->json([
                'success' => "true",
                'token' => $user->remember_token,//get the names right UwU (O_O)
                'user' => $user,
            ]);
        } else {
            $isFound = false;
            $isMatching = false;
            foreach(User::all() as $user) {
                if($user->number == $request->input('number') && $request->input('email')!=null && $user->email == $request->input('email')) {
                    $isFound = true;
                    $isMatching = true;
                    break;
                }
                else if($user->number == $request->input('number')  && $request->input('email')!=null && $user->email != $request->input('email')) {
                    $isFound = true;
                    break;
                }
                else if($user->number == $request->input('number')  && $request->input('email')==null) {
                    $isFound = true;
                    $isMatching = true;
                    break;
                }
            }//this basically goes through all of the database to first check for the number
            if($isFound && $isMatching) {
                return response()->json([
                    'success' => "false", //You're still an idiot
                    'reason' => "Wrong Password",
                ]);
            }
            else if($isFound) {
                return response()->json([
                    'success' => "false", //You're still an idiot
                    'reason' => "Wrong Email",
                ]);
            }
            else {
                return response()->json([
                    'success' => "false", //You're still an idiot
                    'reason' => "Wrong Number",
                ]);
            }
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
        $validator = Validator::make($request->all(), [
        'email' => 'required|email|unique:users,email',
        'userName' => 'required|string|unique:users,userName',
        'number' => 'required|string|unique:users,number',
        'password' => 'required|string',
    ], [
        'email.unique' => 'Already Used',
        'userName.unique' => 'Already Used',
        'number.unique' => 'Already Used',
    ]);//this will check if these are unique or already in use by other users
    //we return each one that wasn't unique so the frontend can highlight all the fields that are already in use

    if ($validator->fails()) {
        // Return all validation errors
        return response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422);
    }
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
        $user -> isDriver = 0;
        $user -> isAccepted = 0;
        $user -> logo = "Users/default.png";

        //made it so the user is logged in after signing up... makes sense
        $token = $user->createToken('API Token Of' . $user->name)->plainTextToken;
        $user->remember_token = $token;
        $user->save();

        Auth::login($user);
        return response()->json(['success' => 'true','token' =>$token, 'user' => $user]);//we return a "success" field so the frontend can see if the sign up process failed or not
    }

    public function logout(Request $request)
    {
        Auth::user()->remember_token = null;
        Auth::user()->save();//did this because the token didn't get deleted from the database when logging out before
        Auth::user()->currentAccessToken()->delete();


        return response() -> json([
            'success' => 'true',
        ]);
        // return response()->json(['msg' => 'kicked out by dasdqw clan leader']);  //as fun as this message is, it has to go
    }
}
