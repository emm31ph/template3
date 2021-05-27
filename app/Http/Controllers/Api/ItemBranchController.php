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

    public function getTrnHist(Request $request)
    {
        $pars['branch'] = $request->branch;
        $pars['expdate'] = $request->expdate;
        $pars['trndatefrom'] = $request->trndatefrom;
        $pars['trndateto'] = $request->trndateto;

        $data = ItemsBranch::select('items.*', 'items_branches.*')->leftJoin('items', 'items.itemcode', 'items_branches.itemcode')
            ->with(['TrnHist' => function ($q) use ($pars) {
                $q->leftJoin('items_batches', 'items_batches.batch', 'items_trn_hists.batch')
                    ->where('branch', '=', $pars['branch'])
                    ->whereBetween('items_trn_hists.trndate', [$pars['trndatefrom'], $pars['trndateto']])
                    ->whereRaw("ifnull(expdate,'1900-01-01')='" . $pars['expdate'] . "'")

                // ->selectRaw('')
                    ->select('items_trn_hists.*', 'rono', 'refno', 'remarks', 'customer',
                        'from', 'to', 'van_no', 'seal_no');
            }])
            ->where('items_branches.itemcode', '=', $request->itemcode)
            ->whereRaw("IFNULL(items_branches.expdate,'1900-01-01')='" . $request->expdate . "'")
            ->where('items_branches.branch', '=', $request->branch)

            ->get();

        return \response()->json($data, 200);
    }
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

        $data = DB::select("call sp_items('" . $request->branch . "','" . $request->trndatefrom . "','" . $request->trndateto . "')");

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

        $data = ItemsBranch::select('items.itemcode', 'items.itemdesc', 'qty', 'expdate', 'numperuompu')
        // ->selectRaw('Round((qty div numperuompu)+((qty mod numperuompu)/100),2) as qty')
            ->selectRaw("concat('',(qty div numperuompu),' / ',(qty mod numperuompu)) as qtyDesc")
            ->leftJoin('items', 'items.itemcode', 'items_branches.itemcode')
            ->where('qty', '!=', '0')
            ->where('items_branches.branch', '=', auth()->user()->branch)
            ->orderByRaw("ifnull(items_branches.expdate,DATE_ADD(now(), INTERVAL 10 year)) asc ")
            ->get();
        return response()->json($data, 200);

    }

    public function getItemDetailTran(Request $request)
    {
        // config()->set('database.connections.mysql.strict', false);
        //     \DB::reconnect();

        //     $data = ItemsBranch::select('items_branches.branch', 'items.itemcode', 'items.itemdesc', 'items.numperuompu', 'items.pckgsize', 'items_branches.expdate'
        //     )
        //         ->selectRaw(DB::RAW("ifnull((select preqty from items_trn_hists ith1  where ith1.id=min(items_trn_hists.id)),qty) as minid")
        //         )
        //         ->selectRaw("sum(if(items_trn_hists.trntype='BR', items_trn_hists.crqty,0)) BRqty")
        //         ->selectRaw("sum(if(items_trn_hists.trntype='RR', items_trn_hists.crqty,0)) RRqty")
        //         ->selectRaw("sum(if(items_trn_hists.trntype='WP', items_trn_hists.crqty,0)) WPqty")
        //         ->selectRaw("sum(if(items_trn_hists.trntype='OD', items_trn_hists.drqty,0)) ODqty")
        //         ->selectRaw(DB::RAW('ifnull((select curqty from items_trn_hists ith1  where ith1.id=max(items_trn_hists.id)),qty) as maxid '))

        //         ->leftJoin('items_trn_hists', function ($q) use ($request) {
        //             $q->on('items_branches.itemcode', '=', 'items_trn_hists.itemcode')
        //                 ->whereRaw("ifnull(items_branches.expdate,'1900-01-01')=ifnull(items_trn_hists.expdate,'1900-01-01')")
        //                 ->whereBetween('items_trn_hists.trndate', [$request->trndatefrom, $request->trndateto]);
        //         })->leftJoin('items', 'items.itemcode', 'items_branches.itemcode')
        //         ->where('items_branches.branch', '=', $request->branch)
        //         ->groupBy(DB::RAW('1,2,3,4,5,6'))
        //         ->orderBy('itemdesc', 'ASC')
        //         ->orderBy('expdate', 'ASC')
        //         ->get();

        //     config()->set('database.connections.mysql.strict', true);
        //     \DB::reconnect();

        $data = DB::select("call sp_items_detialed('" . $request->branch . "','" . $request->trndatefrom . "','" . $request->trndateto . "')");

        return response()->json($data, 200);

    }
}
