<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function getUserAuth(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $userAuth = User::where('id', Auth::user()->id)->get();

        return $userAuth;
    }
}
