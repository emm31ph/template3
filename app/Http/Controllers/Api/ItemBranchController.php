<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemBranchController extends Controller
{
    public function getItems(Request $request)
    {

        $data = DB::select("call sp_items('" . $request->branch . "','" . $request->trndate . "')");

        return response()->json($data, 200);

    }
}
