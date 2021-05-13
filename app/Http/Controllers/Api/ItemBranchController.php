<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ItemsBatch;
use App\Models\ItemsBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemBranchController extends Controller
{

    public function reportItem(Request $request)
    {
        $data = ItemsBatch::with('hist.items')
            ->where('items_batches.batch', '=', $request->get('id'))
            ->first();

        $data = collect($data);

        return response()->json($data, 200);

    }
    public function getItems(Request $request)
    {

        $data = DB::select("call sp_items('" . $request->branch . "','" . $request->trndate . "')");

        return response()->json($data, 200);

    }

    public function getAllItems(Request $request)
    {
        $data = Item::where('items_branches.branch', '=', auth()->user()->branch)->orderByRaw("(case when itemdesc like '%label%' then 8 when itemdesc like '%ctn%' then 9 else 0 end) asc")
        #->where('itemdesc', 'not like', '%LABEL%')
        #->where('itemdesc', 'not like', '%CTN%')

            ->get();
        return response()->json($data, 200);

    }

    public function getAllItemsBranch(Request $request)
    {

        $data = ItemsBranch::rightJoin('items', 'items.itemcode', 'items_branches.itemcode')
            ->where('items_branches.branch', '=', auth()->user()->branch)

            ->orderByRaw("ifnull(items_branches.expdate,DATE_ADD(now(), INTERVAL 10 year)) asc , (case when itemdesc like '%label%' then 8 when itemdesc like '%ctn%' then 9 else 0 end) asc")
            ->get();
        return response()->json($data, 200);

    }

    public function getItemsOut(Request $request)
    {

        $data = ItemsBranch::leftJoin('items', 'items.itemcode', 'items_branches.itemcode')
            ->where('qty', '!=', '0')
            ->where('items_branches.branch', '=', auth()->user()->branch)
            ->orderByRaw("ifnull(items_branches.expdate,DATE_ADD(now(), INTERVAL 10 year)) asc ")
            ->get();
        return response()->json($data, 200);

    }
}
