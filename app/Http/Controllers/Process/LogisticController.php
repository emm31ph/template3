<?php

namespace App\Http\Controllers\Process;

use App\Http\Controllers\Controller;
use App\Models\Counter;
use App\Models\Packinglist;
use App\Models\PackinglistItems;
use App\Models\ShippingAdvice;
use App\Models\ShippingAdviceItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogisticController extends Controller
{
    public function index(Request $request)
    {
        $data = '';
        switch ($request->trnmode) {
            case 'logspcreate':
                // $data = $request->all();
                $data = $this->CreateShipping($request);
                break;
            case 'log-sp-cancel':
                ShippingAdvice::where('batch', '=', $request->batch)->update(['status' => '99']);
                $data = 'successful';
                break;
            case 'log-sp-approved':
                $this->approveTrnShipping($request);
                $data = 'successful';
                break;
            case 'log-sp-alllist':
                $data = ShippingAdvice::where('branch', $request->branch)->orderBy('status','ASC')->orderBy('trndate','Desc')->get();
                break;
            case 'log-sp-report':
                $data = $this->ReportShipping($request);
                break;
            case 'log-pl-create':
                $data = $this->PackingCreate($request);
                break;
            case 'logplcancel':

                
                $data = Packinglist::where('batch', '=', $request->batch)->update(['status' => '99']);
                // return \response()->json([$data ],400);

                $data = 'successful';
                break;
            case 'logplapproved':
                $this->approveTrnPacking($request);
                $data = 'successful';
                break;
            case 'logplalllist':
                $data = Packinglist::where('branch', $request->branch)->orderBy('status','ASC')->orderBy('trndate','Desc')->get();
                break;
            case 'log-pl-report':
                $data = $this->ReportPacking($request);
                break;

            default:
                $data = [];
                break;
        }

        return \response()->json($data);
    }

    public function PackingCreate($request)
    {
        // DB::beginTransaction();
        // try {
            $counter = Counter::where('key', 'PACKING')
                ->where('branch', auth()->user()->branch)
                ->first();

            $batch = $counter->prefix . sprintf('%011d', $counter->value);

            $pl = new Packinglist;
            $pl->batch = $batch;
            $pl->branch = auth()->user()->branch;
            $pl->user_id = auth()->user()->id;
            $pl->contactperson = $request->contactPerson;
            $pl->consignee = $request->consignee;
            $pl->address = $request->address;
            $pl->shippingLine = $request->shippingLine;
            $pl->pickup = $request->pickup;
            $pl->trndate = $request->trndate;
            $pl->shippingDate = $request->shippingDate;
            $pl->dr_no = $request->dr_no;
            $pl->po_no = $request->po_no;
            $pl->so_no = $request->so_no;
            $pl->ro_no = $request->ro_no;
            $pl->booking_no = $request->booking_no;
            $pl->shippingmethod = $request->shippingMethod;
            $pl->control_no = $request->control_no;
            $pl->seal_no = $request->seal_no;
            $pl->trucking_no = $request->trucking;
            $pl->gross = $request->grosswt;
            $pl->remarks = $request->remarks;
            $pl->status = '01';

            if ($pl->save()) {
                $counter->increment('value');

                $item = [];
                foreach ($request->items as $value) {
                    $qty = str_replace(",", "", $value['qty']);

                    $item =
                        [
                        'docid' => $pl->id,
                        'itemcode' => $value['itemcode'],
                        'qty' => $qty,
                        'unit' => $value['unit'],
                        'expdate' => $value['expdate'],
                        'remarks' => $value['remarks'],
                        'created_at' => date("Y/m/d"),
                        'updated_at' => date("Y/m/d"),
                    ];

                    PackinglistItems::insert($item);
                }
            }
            // \DB::commit();
            return $pl->batch;

        // } catch (\Exception $e) {
        //     DB::rollback();
        //     // return response()->json(['error' => 'something error in data'], 400);
        //     return response()->json(['error' => $e->getMessage()], 400);
        // }
    }
    public function ReportPacking($request)
    {
        $data = Packinglist::with(['items'])
            ->where('batch', '=', $request->id)->get();

        // $data = collect($data);

        return $data[0];

    }
    public function ReportShipping($request)
    {
        $data = ShippingAdvice::with(['items'])
            ->where('batch', '=', $request->id)->get();

        // $data = collect($data);

        return $data[0];

    }
    public function CreateShipping($request)
    {

        DB::beginTransaction();
        try {
            $counter = Counter::where('key', 'SHIPPING')
                ->where('branch', auth()->user()->branch)
                ->first();

            $batch = $counter->prefix . sprintf('%011d', $counter->value);

            $sa = new ShippingAdvice;
            $sa->batch = $batch;
            $sa->branch = auth()->user()->branch;
            $sa->user_id = auth()->user()->id;
            $sa->packlist = $request->packlist;
            $sa->contactperson = $request->contactPerson;
            $sa->consignee = $request->consignee;
            $sa->address = $request->address;
            $sa->trndate = $request->trndate;
            $sa->sa_no = $request->sa_no;
            $sa->dr_no = $request->dr_no;
            $sa->po_no = $request->po_no;
            $sa->so_no = $request->so_no;
            $sa->shippingDate = $request->shippingDate;
            $sa->shippingLine = $request->shippingLine;
            $sa->shippingmethod = $request->shippingMethod;
            $sa->stockrequest = $request->shippingRequest;
            $sa->gross = $request->grosswt;
            $sa->remarks = $request->remarks;
            $sa->pickup = $request->pickup;
            $sa->control_no = $request->control_no;
            $sa->seal_no = $request->seal_no;
            $sa->trucking_no = $request->trucking;
            $sa->status = '02';

            if ($sa->save()) {
                $counter->increment('value');

                $item = [];
                foreach ($request->items as $value) {
                    $qty = str_replace(",", "", $value['qty']);
                    $price = str_replace(",", "", $value['price']) * 100;
                    $total = $price * $qty;
                    $item =
                        [
                        'docid' => $sa->id,
                        'itemcode' => $value['itemcode'],
                        'qty' => $qty,
                        'unit' => $value['unit'],
                        'price' => $price,
                        'total' => floatval($total),
                        'created_at' => date("Y/m/d"),
                        'updated_at' => date("Y/m/d"),
                    ];

                    ShippingAdviceItems::insert($item);
                }

            };

            \DB::commit();
            return $sa->batch;

        } catch (\Exception $e) {
            DB::rollback();
            // return response()->json(['error' => 'something error in data'], 400);
            return response()->json(['error' => $e->getMessage()], 400);
        }

    }

    public function approveTrnShipping($request)
    {

        ShippingAdvice::where('batch', '=', $request->batch)
            ->update([
                'status' => '01',
                'approvedby' => auth()->user()->id,
                'os_no' => $request->os_no,
            ]);
    }
}
