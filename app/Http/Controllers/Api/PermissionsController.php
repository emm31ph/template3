<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;

class PermissionsController extends Controller
{
    public function index()
    {

        $permissions = Permission::get();
        return \response()->json($permissions, 200);

    }
}
