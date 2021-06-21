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

    public function trnExportD(Request $request)
    {
        config()->set('database.connections.mysql.strict', false);
        \DB::reconnect();

        $item = DB::select(DB::raw("select ih.expdate, ibr.branch,ib.trnType as trnmode,ih.trntype, i.itemdesc,i.itemcode,ib.rono,ib.refno,ib.customer,ib.`from`,ib.`to`,ib.van_no,ib.seal_no,ib.remarks, ih.trndate,i.numperuompu,(ih.drqty+ih.crqty) qty from items_trn_hists ih
            LEFT JOIN items i on i.itemcode=ih.itemcode
            LEFT JOIN items_branches ibr on ibr.itemcode=ih.itemcode and ifnull(ibr.expdate,'1900-01-01')=ifnull(ih.expdate,'1900-01-01')
            LEFT join items_batches ib on ib.batch=ih.batch
            where IF('{$request->branch}'='',''='',ibr.branch='{$request->branch}') and ih.trndate BETWEEN '{$request->trndatefrom}' and '{$request->trndateto}'
            and (ih.drqty+ih.crqty)!=0
            order by ib.trndate, ib.batch,ih.id "));

        config()->set('database.connections.mysql.strict', true);
        \DB::reconnect();

        return \response()->json($item, 200);
    }
    public function getTrnHist(Request $request)
    {
        $pars['branch'] = $request->branch;
        $pars['expdate'] = $request->expdate != '' ? $request->expdate : '1900-01-01';
        $pars['trndatefrom'] = $request->trndatefrom;
        $pars['trndateto'] = $request->trndateto;

        $expdate = $request->expdate != '' ? $request->expdate : '1900-01-01';

        $data = ItemsBranch::select('items.*', 'items_branches.*')->leftJoin('items', 'items.itemcode', 'items_branches.itemcode')
            ->with(['TrnHist' => function ($q) use ($pars) {
                $q->leftJoin('items_batches', 'items_batches.batch', 'items_trn_hists.batch')
                    ->where('branch', '=', $pars['branch'])
                    ->whereBetween('items_trn_hists.trndate', [$pars['trndatefrom'], $pars['trndateto']])
                    ->whereRaw("ifnull(expdate,'1900-01-01')='" . $pars['expdate'] . "'")

                // ->selectRaw('')
                    ->select('items_trn_hists.*', 'rono', 'refno', 'remarks', 'customer',
                        'from', 'to', 'van_no', 'seal_no', 'user_id');
            }])
            ->whereRaw("IF('" . $request->itemcode . "'='',''='',items_branches.itemcode='" . $request->itemcode . "')")
            ->whereRaw("IF('" . $request->expdate . "'='',''='',IFNULL(items_branches.expdate,'1900-01-01')='{$expdate}')")

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
        $data = Item::orderByRaw("status asc")->orderByRaw("(case when itemdesc like '%label%' then 8 when itemdesc like '%ctn%' then 9 else 0 end) asc")
            ->orderByRaw("itemdesc asc")

        #->where('itemdesc', 'not like', '%LABEL%')
        #->where('itemdesc', 'not like', '%CTN%')

            ->get();
        return response()->json($data, 200);

    }

    public function getAllItemsBranch(Request $request)
    {

        $data = ItemsBranch::rightJoin('items', 'items.itemcode', 'items_branches.itemcode')
            ->where('items_branches.branch', '=', auth()->user()->branch)
            ->where('items_branches.qty', '!=', '0')

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

        $data = DB::select("call sp_items_detialed('" . $request->branch . "','" . $request->trndatefrom . "','" . $request->trndateto . "')");

        return response()->json($data, 200);

    }

    public function mytransaction(Request $request)
    {

        $trn = ItemsBatch::where('items_batches.trndate', '=', $request->trndate)
            ->where('items_batches.user_id', '=', auth()->user()->id)
        // ->where('items_batches.branch', '=', auth()->user()->branch)
            ->get();

        return \response()->json($trn, 200);
    }
}
