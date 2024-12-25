<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function gett(Request $request) {
        dd(Auth::id());
    }
    public function changeLogo(Request $request)
    {
        $user = Auth::user();//we didnt use the token before, fixed it

        $validated = $request->validate([
            'newLogo' => 'required|string',
        ]);
        $newLogo = $request->input('newLogo');
        $user->logo = $newLogo;
        $user->save();
        return response()->json([
            $user
        ]);
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

            return response()->json(['success' => 'true']);
            }
        else {
            return response()->json([
                'success' => "false",
            ]);
        }
    }

    public function fetch() {
        return Auth::user();
    }


    public function getUsers()//don't worry, I kept your fetch function ;)
    {
        $users = User::all();
        return response()->json([
            'data' => $users,
        ]);
    }
}
