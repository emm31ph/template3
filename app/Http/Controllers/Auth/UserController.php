<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function current(Request $request)
    {
        return response()->json($request->user());
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        return tap($user)->update($request->only('name', 'email'));
    }
}