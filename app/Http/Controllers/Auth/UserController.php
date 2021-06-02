<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return User::where('id', '!=', Auth::user()->id)->with('roles')->orderBy('status', 'asc')->orderBy('created_at', 'desc')->get();
    }

    public function store(Request $request)
    {
        // DB::disableQueryLog();
        // DB::beginTransaction();
        // // return \response()->json(['data' => $request->selectedOptions], 400);

        // try {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required',
            'branch' => 'required',
        ]);

        // return User::create([
        //     'name' => $request['name'],
        //     'email' => $request['email'],
        //     'username' => $request['username'],
        //     'password' => Hash::make($request['password']),
        //     'branch' => $request['branch'],
        // ]);
        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->branch = $request->branch;

        if ($user->save()) {
            if ($request->selectedOptions) {
                $user->syncRoles($request->selectedOptions);
            }
            \DB::commit();

            return \response()->json(['data' => 'successfull'], 200);

        }
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     // return response()->json(['error' => 'something error in data'], 400);
        //     return response()->json(['error' => $e->getMessage()], 400);
        // }

    }
    public function updateUser(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
        ]);

        $user = User::findOrFail($request->id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = $request->password == '' ? $user->password : Hash::make($request->password);
        $user->branch = $request->branch;
        // $user->branch = $request->branch;
        if ($user->save()) {

            if ($request->selectedOptions) {
                $user->syncRoles($request->selectedOptions);
            }

        }

        return \response()->json(['data' => 'success'], 200);
    }
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

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|confirmed|min:6',
        ]);

        $request->user()->update([
            'password' => bcrypt($request->password),
        ]);

        return response()->json(null, 204);
    }

    public function destroy($user)
    {

        User::find($user)->update(['status' => '99']);

        return \response()->json(['data' => 'successful'], 200);
    }
}
