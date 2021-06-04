<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Response;

class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function login(Request $request)
    {

        $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = (array($fieldType => $request->email, 'password' => $request->password));

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $cookie = cookie('jwt', $token, 60 * 24);

        return \response()->json(['token' => $token], 200)->withCookie($cookie);

    }

    public function logout(Request $request)
    {

        $cookie = Cookie::forget('jwt');
        return \response()->json(['message' => 'Successfully logged out'])->withCookie($cookie);

    }
}
