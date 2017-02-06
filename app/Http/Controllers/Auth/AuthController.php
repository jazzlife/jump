<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Authenticates an user.
     *
     * @param  Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()) {

            Auth::user()->logout();

            return response(null)->header('Guest', '1');
        }

        $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:4|max:255'
        ]);

        $user = User::attempt($request->email, $request->password);

        if ($user) {

            return response(null)->header('User', $user->auth_token);
        }

        return response(null, 401);
    }

    /**
     * Deauthenticates an user.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        if (!Auth::user()) {

            return response(null, 401);
        }

        Auth::user()->logout();

        return response(null)->header('Guest', '1');
    }
}