<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemBranchController extends Controller
{
    public function getItems(Request $request)
    {

        $data = DB::select("call sp_items('" . $request->branch . "','" . $request->trndate . "')");

        return response()->json($data, 200);

    }

    public function getAllItems(Request $request)
    {
        $data = Item::orderByRaw("(case when itemdesc like '%label%' then 8 when itemdesc like '%ctn%' then 9 else 0 end) asc")
        #->where('itemdesc', 'not like', '%LABEL%')
        #->where('itemdesc', 'not like', '%CTN%')
            ->get();
        return response()->json($data, 200);

    }
}
