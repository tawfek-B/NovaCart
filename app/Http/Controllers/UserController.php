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
        // $filecont = file_get_contents(public_path('user.json'));
        // $filedeco = json;_decode($filecont, true);

        //note: we want to return the users from the databse and not a file 

        $users = User::all();
        return response()->json([
            'message' => 'yes',
            'data' => $users,
        ]);
    }



    public function store(Request $request)
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

        // $filecont = file_get_contents(public_path('user.json'));
        // $filedeco = json_decode($filecont, true);
        // $payload = [
        //     'firstname' => $firstname,
        //     'lastname' => $lastname,
        //     'location' => $location,
        //     'userName' => $userName,
        //     'email' => $email,
        //     'number' => $number,
        //     'password' => $password,
        // ];

        // if (!$filedeco || !is_array($filedeco)) {
        //     $content = [
        //         $payload
        //     ];

        //     file_put_contents(public_path('payload.json'), json_encode($content));
        // } else {
        //     $filedeco[] = $payload;
        //     file_put_contents(public_path('payload.json'), json_encode($filedeco));
        // }
        // User::create($userAttributes);
        return response()->json(['message' => 'ok', 'data' => $userAttributes]);
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
