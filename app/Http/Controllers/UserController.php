<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
    public function create(Request $request)
    {
        return view('auth.register');
    }

    public function fetch()
    {
        $filecont = file_get_contents(public_path('user.json'));
        $filedeco = json_decode($filecont, true);
        return response()->json([
            'message' => 'yes',
            'data' => $filedeco,
        ]);
    }
    public function store(Request $request)
    {
        $userAttributes = $request->validate([
            $firstname = 'firstname' => ['required'],
            $lastname = 'lastname' => ['required'],
            $userName = 'userName' => ['required'],
            $location = 'location' => ['required'],
            $email = 'email' => ['required'],
            $number = 'number' => ['required'],
            $password = 'password' => ['required'],
        ]);


        $filecont = file_get_contents(public_path('user.json'));
        $filedeco = json_decode($filecont, true);
        $payload = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'location' => $location,
            'email' => $email,
            'number' => $number,
            'password' => $password,
        ];

        if (!$filedeco || !is_array($filedeco)) {
            $content = [
                $payload
            ];

            file_put_contents(public_path('payload.json'), json_encode($content));
        } else {
            $filedeco[] = $payload;
            file_put_contents(public_path('payload.json'), json_encode($filedeco));
        }
        User::create($userAttributes);
        return response()->json(['message' => 'ok', 'data' => $payload]);
        // dd($request -> name);


        //copied khaled's code from our previous laravel homework to fetch the data in the JSON file
        //he finally has a use
    }
    public function update(Request $request)
    {
        $logopath = $request->logo->store();
        // User::update($logopath);
    }
}
