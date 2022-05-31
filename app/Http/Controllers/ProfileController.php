<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class ProfileController extends Controller
{
    public function getUser($id)
    {
        $user = User::where('id', $id)->first();

        return response()->json($user);
    }

    public function saveData(Request $req)
    {
        $user = User::where('id', '=', $req->user_id)->first();

        $user->name = $req->user['userName'];
        $user->email = $req->user['userEmail'];

        $user->save();

        return response()->noContent();
    }

    public function changePassword(Request $req)
    {
        $user = User::where('id', '=', $req->user_id)->first();

        $user->password =  Hash::make($req->newPass);

        $user->save();

        return response()->noContent();
    }

}
