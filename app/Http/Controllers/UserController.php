<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function gett(Request $request)
    {
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
            'success' => 'true',
        ]);
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required'
        ]);
        $oldPassword = $request->input('oldPassword');
        $newPassword = $request->input('newPassword');
        $user = Auth::user();
        if (Hash::check($oldPassword, $user->password)) {
            $user->password = Hash::make($newPassword);
            $user->save();

            return response()->json(['success' => 'true']);
        } else {
            return response()->json([
                'success' => "false",
            ]);
        }
    }

    public function changeUserName(Request $request) {
        $authUser = Auth::user();
        $userName = $request->input('userName');
        foreach(User::all() as $user) {
            if($user->id == Auth::id()) {
                continue;
            }
            if($user->userName == $userName) {
                return response()->json([
                    'success' => 'false',
                ]);
            }
        }
        $authUser->userName = $userName;
        $authUser->save();
        return response()->json([
            'success' => 'true',
            'user' => $authUser,
        ]);
    }

    public function fetch()
    {
        return Auth::user();
    }


    public function getUsers()//don't worry, I kept your fetch function ;)
    {
        $users = User::all();
        return response()->json([
            'data' => $users,
        ]);
    }

    public function getfavs()
    {
        return response()->json([
            'favourites'=>json_decode(Auth::user()->favourites),
        ]);
    }

    public function modifyFavs(Request $request)
    {

        if (!is_int($request->input('product_id'))) {
            return response()->json([
                'message' => 'Product not found'
            ], 400);
        }
        $user = Auth::user();
        $productId = $request->input('product_id');
        $favourites = json_decode($user->favourites, true);
        if (!is_null($favourites)) {
            foreach ($favourites as $index => $item) {
                if ($item['product_id'] == $request->input('product_id')) {
                    $favourites = array_filter($favourites, fn($item) => $item['product_id'] != $request->input('product_id'));
                    $user->favourites = json_encode($favourites);
                    $user->save();
                    return response() -> json([
                        'success' => 'true',
                    ]);//you forgot this
                }
            }
        }
        $newItem = [
            'product_id' => $productId,
        ];
        $favourites[] = $newItem;
        $user->favourites = $favourites;
        $user->save();
        return response()->json([
            "success" => "true"
        ]);
    }

}
