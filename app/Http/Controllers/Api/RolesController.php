<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\Role;

class RolesController extends Controller
{
    public function index()
    {

        $roles = Role::select('id', 'name', 'display_name', 'description')->with(['permissions' => function ($q) {
            $q->pluck('id');
        }])->get();

        return \response()->json($roles, 200);

    }

    public function store(RoleRequest $request)
    {

        // return \response()->json(['success' => $request->permission], 400);

        $role = new Role();
        $role->display_name = $request->display_name;
        $role->name = $request->name;
        $role->description = $request->description;

        if ($role->save()) {
            $role->syncPermissions($request->permission);
        }

        return \response()->json(['success' => 'successfully insert new role'], 200);

    }

    public function update(RoleRequest $request, $id)
    {

        $role = Role::findOrFail($id);
        $role->display_name = $request->display_name;
        $role->description = $request->description;

        if ($role->save()) {
            $role->syncPermissions($request->permission);
        }

        return \response()->json(['success' => $request->all()], 200);

    }

}
