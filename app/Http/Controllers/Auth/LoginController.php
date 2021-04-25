<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function attemptLogin(Request $request)
    {
        $token = $this->guard()->attempt($this->credentials($request));

        if (!$token) {
            return false;
        }

        $this->guard()->setToken($token);

        return true;
    }

    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        $token = (string) $this->guard()->getToken();
        $expiration = $this->guard()->getPayload()->get('exp');

        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expiration - time(),
        ]);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
    }
}
