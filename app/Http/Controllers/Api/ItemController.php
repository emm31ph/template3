<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryRequest;
use App\Http\Requests\FptdRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ReclassRequest;
use App\Http\Requests\RRMRequest;
use App\Http\Requests\RRRequest;
use App\Models\Counter;
use App\Models\Item;
use App\Models\ItemsBatch;
use App\Models\ItemsBranch;
use App\Models\ItemsTrnHist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{

    public function importTrndate(Request $request)
    {
        $trndate = ItemsBatch::where('trndate', '=', $request->trndate)
            ->where('batch', 'like', 'IMP-' . auth()->user()->branch . '%')
            ->first();

        // return response()->json($trndate, 400);

        return response()->json($trndate == null ? true : false, 200);
    }
    public function import(Request $request)
    {

        $data = $request->get('importItems');

        DB::disableQueryLog();
        DB::beginTransaction();

        try {

            $counter = Counter::where('key', 'IMPORT')
                ->where('branch', auth()->user()->branch)
                ->first();

            $items = [];
            $batch = $counter->prefix . sprintf('%011d', $counter->value);
            $totalcr = 0;
            $totaldr = 0;
            $branch = auth()->user()->branch;

            foreach ($data as $rows) {

                $uom = getUOM($rows['ITEMCODE']);

                $n = $rows['QTY'];
                $whole = floor($n); // 1
                $fraction = ($n - $whole) * 100; // .25

                $totaldr = $totaldr + ((float) (($rows['TRNTYPE'] == 'OD') ? convertTinImport($whole, $uom) + $fraction : 0));
                $totalcr = $totalcr + ((float) (($rows['TRNTYPE'] != 'OD') ? convertTinImport($whole, $uom) + $fraction : 0));
                $expdate = (String) $rows['EXPDATE'] != '' ? $rows['EXPDATE'] : '1900-01-01';

                $curr = getCurrQty([
                    'ITEMCODE' => $rows['ITEMCODE'],
                    'EXPDATE' => $expdate,
                    'BRANCH' => $branch,
                ]) + ((float) (($rows['TRNTYPE'] != 'OD') ? (convertTinImport($whole, $uom) + $fraction) : ((convertTinImport($whole, $uom) + $fraction) * -1)));

                $prev = getPrevQty([
                    'ITEMCODE' => $rows['ITEMCODE'],
                    'EXPDATE' => $expdate,
                    'BRANCH' => $branch,
                ]);

                ItemsTrnHist::create([
                    'trntype' => $rows['TRNTYPE'],
                    'batch' => $batch,
                    'status' => '01',
                    'branch' => $branch,
                    'itemcode' => $rows['ITEMCODE'],
                    'p' => $rows['PCNT'] ?: '',
                    'unit' => 'TIN',
                    'preqty' => $prev,
                    'drqty' => ((float) (($rows['TRNTYPE'] == 'OD') ? convertTinImport($whole, $uom) + $fraction : 0)),
                    'crqty' => ((float) (($rows['TRNTYPE'] != 'OD') ? convertTinImport($whole, $uom) + $fraction : 0)),
                    'curqty' => $curr,
                    'expdate' => $rows['EXPDATE'],
                    'year' => getYear(),
                    'trndate' => $rows['TRNDATE'],
                ]);

                $itembranch = ItemsBranch::where('branch', '=', $branch)
                    ->where('itemcode', '=', $rows['ITEMCODE'])
                    ->whereRaw("ifnull(items_branches.expdate,'1900-01-01') = ifnull('" . $expdate . "','1900-01-01')")
                    ->first();

                if ($itembranch != null && $itembranch['itemcode'] != null) {

                    ItemsBranch::where('branch', '=', $branch)
                        ->where('itemcode', '=', $rows['ITEMCODE'])
                        ->whereRaw("ifnull(items_branches.expdate,'1900-01-01') = ifnull('" . $expdate . "','1900-01-01')")
                        ->update(['qty' => $curr]);

                } else {

                    ItemsBranch::create(['branch' => $branch, 'itemcode' => $rows['ITEMCODE'], 'expdate' => $expdate, 'qty' => $curr]);
                }

            }

            $dateInvt['batch'] = $counter->prefix . sprintf('%011d', $counter->value);
            $dateInvt['remarks'] = $data[0]['REMARKS'];
            $dateInvt['trndate'] = substr($data[0]['TRNDATE'], 0, 10);
            $dateInvt['trnType'] = '008';

            $dateInvt['drqty'] = $totaldr;
            $dateInvt['crqty'] = $totalcr;

            $dateInvt['user_id'] = auth()->user()->id;
            $dateInvt['status'] = '01';
            $dateInvt['year'] = getYear();
            $counter->increment('value');
            ItemsBatch::create($dateInvt);
            \DB::commit();
            return response()->json(['message' => 'success'], 200);

        } catch (\Exception $e) {
            DB::rollback();
            // return response()->json(['error' => 'something error in data'], 400);
            return response()->json(['error' => $e->getMessage()], 400);
        }
        return response()->json($data, 200);
    }

    public function DeliveryTrans(DeliveryRequest $request)
    {

       $stat = [];
        // return response()->json($request->input('reversal'), 400);
        DB::disableQueryLog();
        DB::beginTransaction();
            if($request->input('reversal')!=''){
                $stat = $this->reversalDelivery($request->input('reversal'));
            }
         
               
            try {
                $branch = $stat['branch']?:auth()->user()->branch;
                $counter = Counter::where('key', 'DELIVERY')
                    ->where('branch', $branch)
                    ->first();

                $items = [];
                $batch = $counter->prefix . sprintf('%011d', $counter->value);
                $totalcr = 0;
                $totaldr = 0;
                
               
                $data = $request->get('items');

                foreach ($data as $rows) {

                    $uom = getUOM($rows['itemcode']);
                    $totaldr = $totaldr + ((float) (($rows['trntype'] == 'OD') ? convertTin($rows['unit'], $rows['qty'], $uom) : 0));
                    $totalcr = $totalcr + ((float) (($rows['trntype'] != 'OD') ? convertTin($rows['unit'], $rows['qty'], $uom) : 0));
                    $expdate = (String) $rows['expdate'] != '' ? $rows['expdate'] : '1900-01-01';

                    $curr = getCurrQty([
                        'ITEMCODE' => $rows['itemcode'],
                        'EXPDATE' => $expdate,
                        'BRANCH' => $branch,
                    ]) + ((float) (($rows['trntype'] != 'OD') ? convertTin($rows['unit'], $rows['qty'], $uom) : (convertTin($rows['unit'], $rows['qty'], $uom) * -1)));

                    $prev = getPrevQty([
                        'ITEMCODE' => $rows['itemcode'],
                        'EXPDATE' => $expdate,
                        'BRANCH' => $branch,
                    ]);

                    ItemsTrnHist::create([
                        'trntype' => $rows['trntype'],
                        'batch' => $batch,
                        'status' => '01',
                        'branch' => $branch,
                        'itemcode' => $rows['itemcode'],
                        'unit' => $rows['unit'],
                        'p' => '',
                        'preqty' => $prev,
                        'drqty' => ((float) (($rows['trntype'] == 'OD') ? convertTin($rows['unit'], $rows['qty'], $uom) : 0)),
                        'crqty' => ((float) (($rows['trntype'] != 'OD') ? convertTin($rows['unit'], $rows['qty'], $uom) : 0)),
                        'curqty' => $curr,
                        'expdate' => $rows['expdate'],
                        'year' => getYear(),
                        'trndate' => substr($request->get('trndate'), 0, 10),
                    ]);

                    $itembranch = ItemsBranch::where('branch', '=', $branch)
                        ->where('itemcode', '=', $rows['itemcode'])
                        ->whereRaw("ifnull(items_branches.expdate,'1900-01-01') = ifnull('" . ($expdate) . "','1900-01-01')")
                        ->first();

                    if ($itembranch !== null) {

                        ItemsBranch::where('branch', '=', $branch)
                            ->where('itemcode', '=', $rows['itemcode'])
                            ->whereRaw("ifnull(items_branches.expdate,'1900-01-01') = ifnull('" . ($expdate) . "','1900-01-01')")
                            ->update(['qty' => $curr]);

                    } else {
                        ItemsBranch::create(['branch' => $branch, 'itemcode' => $rows['itemcode'], 'expdate' => $rows['expdate'], 'qty' => $curr]);
                    }

                }

                $dateInvt['batch'] = $counter->prefix . sprintf('%011d', $counter->value);
                $dateInvt['remarks'] = $request->get('remarks').' '. $stat['id'];

                $dateInvt['trndate'] = substr($request->get('trndate'), 0, 10);
                $dateInvt['trnType'] = '001';
                $dateInvt['drqty'] = $totaldr;
                $dateInvt['crqty'] = $totalcr;
                $dateInvt['refno'] = $request->get('refno');
                $dateInvt['rono'] = $request->get('rono');
                $dateInvt['from'] = $request->get('from');
                $dateInvt['to'] = $request->get('to');
                $dateInvt['customer'] = $request->get('customer');

                $dateInvt['user_id'] = auth()->user()->id;
                $dateInvt['status'] = '01';
                $dateInvt['year'] = getYear();
                $counter->increment('value');
                ItemsBatch::create($dateInvt);
                \DB::commit();

                return response()->json(['branch' => 'success', 'id' => $batch], 200);

            } catch (\Exception $e) {
                DB::rollback();
                // return response()->json(['error' => 'something error in data'], 400);
                return response()->json(['error' => $e->getMessage()], 400);
            }
            return response()->json($data, 200);
        
    }
    public function reversalDelivery($request)
    { 
        DB::disableQueryLog();
        DB::beginTransaction(); 
        try { 
            $items = []; 
            $totalcr = 0;
            $totaldr = 0;
          
            $data = $request['items'];
 
            foreach ($data as $rows) {
                $counter = Counter::where('key', 'REVERSAL')
                ->where('branch', $rows['branch'])
                ->first(); 
                $batch = $counter->prefix . sprintf('%011d', $counter->value);
                $branch =  $rows['branch'];

               
                ItemsBatch::where('batch', '=', $request['batch'])->update(['status' =>'80','remarks'=>'Edit Base on '.$batch]);
               
                
                $uom = getUOM($rows['itemcode']);
                $totaldr = $totaldr + ((float) (($rows['trntype'] == 'OD') ? convertTin($rows['unit'], $rows['qty'], $uom) : 0));
                $totalcr = $totalcr + ((float) (($rows['trntype'] != 'OD') ? convertTin($rows['unit'], $rows['qty'], $uom) : 0));
                $expdate = (String) $rows['expdate'] != '' ? $rows['expdate'] : '1900-01-01';

                $curr = getCurrQty([
                    'ITEMCODE' => $rows['itemcode'],
                    'EXPDATE' => $expdate,
                    'BRANCH' => $branch,
                ]) + ((float) (($rows['trntype'] != 'OD') ? convertTin($rows['unit'], $rows['qty'], $uom) : (convertTin($rows['unit'], $rows['qty'], $uom) * -1)));

                 

                $prev = getPrevQty([
                    'ITEMCODE' => $rows['itemcode'],
                    'EXPDATE' => $expdate,
                    'BRANCH' => $branch,
                ]);

                ItemsTrnHist::create([
                    'trntype' => $rows['trntype'],
                    'batch' => $batch,
                    'status' => '01',
                    'branch' => $branch,
                    'itemcode' => $rows['itemcode'],
                    'unit' => $rows['unit'],
                    'p' => '',
                    'preqty' => $prev,
                    'drqty' => ((float) (($rows['trntype'] == 'OD') ? convertTin($rows['unit'], $rows['qty'], $uom) : 0)),
                    'crqty' => ((float) (($rows['trntype'] != 'OD') ? convertTin($rows['unit'], $rows['qty'], $uom) : 0)),
                    'curqty' => $curr,
                    'expdate' => $rows['expdate'],
                    'year' => getYear(),
                    'trndate' => substr($request['trndate'], 0, 10),
                ]);

                $itembranch = ItemsBranch::where('branch', '=', $branch)
                    ->where('itemcode', '=', $rows['itemcode'])
                    ->whereRaw("ifnull(items_branches.expdate,'1900-01-01') = ifnull('" . ($expdate) . "','1900-01-01')")
                    ->first();

                if ($itembranch !== null) {

                    ItemsBranch::where('branch', '=', $branch)
                        ->where('itemcode', '=', $rows['itemcode'])
                        ->whereRaw("ifnull(items_branches.expdate,'1900-01-01') = ifnull('" . ($expdate) . "','1900-01-01')")
                        ->update(['qty' => $curr]);

                } else {
                    ItemsBranch::create(['branch' => $branch, 'itemcode' => $rows['itemcode'], 'expdate' => $rows['expdate'], 'qty' => $curr]);
                }

               

            }

            $dateInvt['batch'] = $counter->prefix . sprintf('%011d', $counter->value);
            $dateInvt['remarks'] = $request['remarks'];
            $dateInvt['basebatch'] =$request['batch'];

            $dateInvt['trndate'] = substr($request['trndate'], 0, 10);
            $dateInvt['trnType'] = '007';
            $dateInvt['drqty'] = $totaldr;
            $dateInvt['crqty'] = $totalcr;
            $dateInvt['refno'] = $request['refno'];
            $dateInvt['rono'] = $request['rono']?:'';
            #$dateInvt['from'] = $request['from']?:'';
            #$dateInvt['to'] = $request['to'];
            $dateInvt['customer'] = $request['customer'];

            $dateInvt['user_id'] = auth()->user()->id;
            $dateInvt['status'] = '01';
            $dateInvt['year'] = getYear();
             $counter->increment('value');
             ItemsBatch::create($dateInvt);
            \DB::commit();

            return ['branch' => $branch, 'id' => $batch];

        } catch (\Exception $e) {
            DB::rollback();
            // return response()->json(['error' => 'something error in data'], 400);
            return response()->json(['error' => $e->getMessage()], 400);
        }
        return response()->json($data, 200);
    
    }
    public function CancelTrans(Request $request)
    { 
        
        // return response()->json($request->all(), 400);
        //
            DB::disableQueryLog();
            DB::beginTransaction(); 
            try { 
                $items = []; 
                $totalcr = 0;
                $totaldr = 0;
            
                $data = $request->items;
    
                foreach ($data as $rows) {
                    $counter = Counter::where('key', 'CANCEL')
                    ->where('branch', $rows['branch'])
                    ->first(); 
                    $batch = $counter->prefix . sprintf('%011d', $counter->value);
                    $branch =  $rows['branch'];

                
                    ItemsBatch::where('batch', '=', $request->batch)->update(['status' =>'90','remarks'=>$request->remarks.' Cancel Base on '.$batch]);
                
                    
                    $uom = getUOM($rows['itemcode']);
                    $totaldr = $totaldr + ((float) (convertTin($rows['unit'], $rows['drqty'], $uom)));
                    $totalcr = $totalcr + ((float) (convertTin($rows['unit'], $rows['crqty'], $uom)));
                    $expdate = (String) $rows['expdate'] != '' ? $rows['expdate'] : '1900-01-01';

                    $curr = getCurrQty([
                        'ITEMCODE' => $rows['itemcode'],
                        'EXPDATE' => $expdate,
                        'BRANCH' => $branch,
                    ]) + ((float) ((convertTin($rows['unit'], $rows['drqty'], $uom) * -1)))
                        + ((float) ((convertTin($rows['unit'], $rows['crqty'], $uom))));

                    

                    $prev = getPrevQty([
                        'ITEMCODE' => $rows['itemcode'],
                        'EXPDATE' => $expdate,
                        'BRANCH' => $branch,
                    ]);

                    ItemsTrnHist::create([
                        'trntype' => $rows['trntype'],
                        'batch' => $batch,
                        'status' => '01',
                        'branch' => $branch,
                        'itemcode' => $rows['itemcode'],
                        'unit' => $rows['unit'],
                        'p' => '',
                        'preqty' => $prev,
                        'drqty' => ((float) (convertTin($rows['unit'], $rows['drqty'], $uom) )),
                        'crqty' => ((float) (convertTin($rows['unit'], $rows['crqty'], $uom) )),
                        'curqty' => $curr,
                        'expdate' => $rows['expdate'],
                        'year' => getYear(),
                        'trndate' => substr($request->trndate, 0, 10),
                    ]);

                    $itembranch = ItemsBranch::where('branch', '=', $branch)
                        ->where('itemcode', '=', $rows['itemcode'])
                        ->whereRaw("ifnull(items_branches.expdate,'1900-01-01') = ifnull('" . ($expdate) . "','1900-01-01')")
                        ->first();

                    if ($itembranch !== null) {

                        ItemsBranch::where('branch', '=', $branch)
                            ->where('itemcode', '=', $rows['itemcode'])
                            ->whereRaw("ifnull(items_branches.expdate,'1900-01-01') = ifnull('" . ($expdate) . "','1900-01-01')")
                            ->update(['qty' => $curr]);

                    } else {
                        ItemsBranch::create(['branch' => $branch, 'itemcode' => $rows['itemcode'], 'expdate' => $rows['expdate'], 'qty' => $curr]);
                    }

                

                }

                $dateInvt['batch'] = $counter->prefix . sprintf('%011d', $counter->value);
                $dateInvt['remarks'] = $request->remarks;
                $dateInvt['basebatch'] =$request->batch;

                $dateInvt['trndate'] = substr($request->trndate, 0, 10);
                $dateInvt['trnType'] = '007';
                $dateInvt['drqty'] = $totaldr;
                $dateInvt['crqty'] = $totalcr;
                $dateInvt['refno'] = $request->refno;
                $dateInvt['rono'] = $request->rono?:'';
                $dateInvt['from'] = $request->from?:'';
                $dateInvt['to'] = $request->to?:'';
                $dateInvt['customer'] = $request->customer?:'';

                $dateInvt['user_id'] = auth()->user()->id;
                $dateInvt['status'] = '01';
                $dateInvt['year'] = getYear();
                 $counter->increment('value');
                 ItemsBatch::create($dateInvt);
                \DB::commit();

                return ['branch' => $branch, 'id' => $batch];

            } catch (\Exception $e) {
                DB::rollback();
                // return response()->json(['error' => 'something error in data'], 400);
                return response()->json(['error' => $e->getMessage()], 400);
            }
            return response()->json($data, 200);
        //
    
    }

    public function AdjustmentTrans(ReclassRequest $request)
    {

        // return response()->json($request->all(), 400);
        // return response()->json($request->all(), 200);
        // DB::enableQueryLog(); // Enable query log
        // DB::disableQueryLog();
        DB::beginTransaction();

        try {

            $counter = Counter::where('key', 'ADJUSTMENT')
                ->where('branch', auth()->user()->branch)
                ->first();

            $items = [];
            $batch = $counter->prefix . sprintf('%011d', $counter->value);
            $totalcr = 0;
            $totaldr = 0;
            $branch = auth()->user()->branch;
            $data = $request->get('items');

            foreach ($data as $rows) {

                $uom = getUOM($rows['itemcode']);
                $totaldr = $totaldr + ((float) (convertTin($rows['unit'], $rows['drqty'], $uom)));
                $totalcr = $totalcr + ((float) (convertTin($rows['unit'], $rows['crqty'], $uom)));
                $expdate = (String) $rows['expdate'] != '' ? $rows['expdate'] : '1900-01-01';

                $curr = (getCurrQty([
                    'ITEMCODE' => $rows['itemcode'],
                    'EXPDATE' => $expdate,
                    'BRANCH' => $branch,
                ])) + (convertTin($rows['unit'], $rows['crqty'], $uom) + (convertTin($rows['unit'], $rows['drqty'], $uom) * -1));

                $prev = getPrevQty([
                    'ITEMCODE' => $rows['itemcode'],
                    'EXPDATE' => $expdate,
                    'BRANCH' => $branch,
                ]);

                ItemsTrnHist::create([
                    'trntype' => $rows['trntype'],
                    'batch' => $batch,
                    'status' => '01',
                    'branch' => $branch,
                    'itemcode' => $rows['itemcode'],
                    'unit' => $rows['unit'],
                    'p' => '',
                    'preqty' => $prev,
                    'drqty' => ((float) convertTin($rows['unit'], $rows['drqty'], $uom)),
                    'crqty' => ((float) convertTin($rows['unit'], $rows['crqty'], $uom)),
                    'curqty' => $curr,
                    'expdate' => $rows['expdate'],
                    'year' => getYear(),
                    'trndate' => substr($request->get('trndate'), 0, 10),
                ]);

                $itembranch = ItemsBranch::where('branch', '=', $branch)
                    ->where('itemcode', '=', $rows['itemcode'])
                    ->whereRaw("ifnull(items_branches.expdate,'1900-01-01') = ifnull('" . $expdate . "','1900-01-01')")
                    ->first();

                if ($itembranch != null && $itembranch['itemcode'] != null) {

                    ItemsBranch::where('branch', '=', $branch)
                        ->where('itemcode', '=', $rows['itemcode'])
                        ->whereRaw("ifnull(items_branches.expdate,'1900-01-01') = ifnull('" . $expdate . "','1900-01-01')")
                        ->update(['qty' => $curr]);

                } else {

                    ItemsBranch::create(['branch' => $branch, 'itemcode' => $rows['itemcode'], 'expdate' => $expdate, 'qty' => $curr]);
                }

            }

            $dateInvt['batch'] = $counter->prefix . sprintf('%011d', $counter->value);
            $dateInvt['remarks'] = $request->get('remarks');

            $dateInvt['trndate'] = substr($request->get('trndate'), 0, 10);
            $dateInvt['trnType'] = '009';
            $dateInvt['drqty'] = $totaldr;
            $dateInvt['crqty'] = $totalcr;
            $dateInvt['user_id'] = auth()->user()->id;
            $dateInvt['status'] = '01';
            $dateInvt['refno'] = $request->get('refno');
            $dateInvt['rono'] = $request->get('rono');
            $dateInvt['from'] = $request->get('from');
            $dateInvt['to'] = $request->get('to');

            $dateInvt['year'] = getYear();
            $counter->increment('value');
            ItemsBatch::create($dateInvt);
            \DB::commit();
            return response()->json(['status' => 'success', 'id' => $batch], 200);

        } catch (\Exception $e) {
            DB::rollback();
            // return response()->json(['error' => 'something error in data'], 400);
            return response()->json(['error' => $e->getMessage()], 400);
        }
        return response()->json($data, 200);

    }

    public function FPTDRJCTTrans(FptdRequest $request)
    {


        DB::disableQueryLog();
        DB::beginTransaction();

        try {

            $counter = Counter::where('key', $request->trnmode)
                ->where('branch', auth()->user()->branch)
                ->first();
 
            $items = [];
            $batch = $counter->prefix . sprintf('%011d', $counter->value);
            $totalcr = 0;
            $totaldr = 0;
            $branch = auth()->user()->branch;
            $data = $request->get('items');

            foreach ($data as $rows) {

                $uom = getUOM($rows['itemcode']);
                $totaldr = $totaldr + ((float) (convertTin($rows['unit'], $rows['drqty'], $uom)));
                $totalcr = $totalcr + ((float) (convertTin($rows['unit'], $rows['crqty'], $uom)));
                $expdate = (String) $rows['expdate'] != '' ? $rows['expdate'] : '1900-01-01';

                $curr = (getCurrQty([
                    'ITEMCODE' => $rows['itemcode'],
                    'EXPDATE' => $expdate,
                    'BRANCH' => $branch,
                ])) + ((float) (convertTin($rows['unit'], $rows['crqty'], $uom) + (convertTin($rows['unit'], $rows['drqty'], $uom) * -1)));

                $prev = getPrevQty([
                    'ITEMCODE' => $rows['itemcode'],
                    'EXPDATE' => $expdate,
                    'BRANCH' => $branch,
                ]);

                ItemsTrnHist::create([
                    'trntype' => $rows['trntype'],
                    'batch' => $batch,
                    'status' => '01',
                    'branch' => $branch,
                    'itemcode' => $rows['itemcode'],
                    'unit' => $rows['unit'],
                    'p' => '',
                    'preqty' => $prev,
                    'drqty' => ((float) convertTin($rows['unit'], $rows['drqty'], $uom)),
                    'crqty' => ((float) convertTin($rows['unit'], $rows['crqty'], $uom)),
                    'curqty' => $curr,
                    'expdate' => $rows['expdate'],
                    'year' => getYear(),
                    'trndate' => substr($request->get('trndate'), 0, 10),
                ]);

                $itembranch = ItemsBranch::where('branch', '=', $branch)
                    ->where('itemcode', '=', $rows['itemcode'])
                    ->whereRaw("ifnull(items_branches.expdate,'1900-01-01') = ifnull('" . $expdate . "','1900-01-01')")
                    ->first();

                if ($itembranch != null && $itembranch['itemcode'] != null) {

                    ItemsBranch::where('branch', '=', $branch)
                        ->where('itemcode', '=', $rows['itemcode'])
                        ->whereRaw("ifnull(items_branches.expdate,'1900-01-01') = ifnull('" . $expdate . "','1900-01-01')")
                        ->update(['qty' => $curr]);

                } else {

                    ItemsBranch::create(['branch' => $branch, 'itemcode' => $rows['itemcode'], 'expdate' => $expdate, 'qty' => $curr]);
                }

            }

            $dateInvt['batch'] = $counter->prefix . sprintf('%011d', $counter->value);
            $dateInvt['remarks'] = $request->get('remarks');

            $dateInvt['trndate'] = substr($request->get('trndate'), 0, 10);
            $dateInvt['trnType'] = '002';
            $dateInvt['drqty'] = $totaldr;
            $dateInvt['crqty'] = $totalcr;
            $dateInvt['user_id'] = auth()->user()->id;
            $dateInvt['status'] = '01';
            $dateInvt['refno'] = $request->get('refno');
            $dateInvt['rono'] = $request->get('rono');
            $dateInvt['from'] = $request->get('from');
            $dateInvt['to'] = $request->get('to');

            $dateInvt['year'] = getYear();
            $counter->increment('value');
            ItemsBatch::create($dateInvt);
            \DB::commit();
            return response()->json(['status' => 'success', 'id' => $batch], 200);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'something error in data'], 400);
        }
        return response()->json($data, 200);

    }


    public function RJCTTrans(RJCTRequest $request)
    {

        // return response()->json($request->all(), 200);

        DB::disableQueryLog();
        DB::beginTransaction();

        try {

            $counter = Counter::where('key', 'FPTD')
                ->where('branch', auth()->user()->branch)
                ->first();

            $items = [];
            $batch = $counter->prefix . sprintf('%011d', $counter->value);
            $totalcr = 0;
            $totaldr = 0;
            $branch = auth()->user()->branch;
            $data = $request->get('items');

            foreach ($data as $rows) {

                $uom = getUOM($rows['itemcode']);
                $totaldr = $totaldr + ((float) (convertTin($rows['unit'], $rows['drqty'], $uom)));
                $totalcr = $totalcr + ((float) (convertTin($rows['unit'], $rows['crqty'], $uom)));
                $expdate = (String) $rows['expdate'] != '' ? $rows['expdate'] : '1900-01-01';

                $curr = getCurrQty([
                    'ITEMCODE' => $rows['itemcode'],
                    'EXPDATE' => $expdate,
                    'BRANCH' => $branch,
                ]) + ((float) (convertTin($rows['unit'], $rows['crqty'], $uom) + (convertTin($rows['unit'], $rows['drqty'], $uom) * -1)));

                $prev = getPrevQty([
                    'ITEMCODE' => $rows['itemcode'],
                    'EXPDATE' => $expdate,
                    'BRANCH' => $branch,
                ]);

                ItemsTrnHist::create([
                    'trntype' => $rows['trntype'],
                    'batch' => $batch,
                    'status' => '01',
                    'branch' => $branch,
                    'itemcode' => $rows['itemcode'],
                    'unit' => 'TIN',
                    'p' => '',
                    'preqty' => $prev,
                    'drqty' => ((float) convertTin($rows['unit'], $rows['drqty'], $uom)),
                    'crqty' => ((float) convertTin($rows['unit'], $rows['crqty'], $uom)),
                    'curqty' => $curr,
                    'expdate' => $rows['expdate'],
                    'year' => getYear(),
                    'trndate' => substr($request->get('trndate'), 0, 10),
                ]);

                $itembranch = ItemsBranch::where('branch', '=', $branch)
                    ->where('itemcode', '=', $rows['itemcode'])
                    ->whereRaw("ifnull(items_branches.expdate,'1900-01-01') = ifnull('" . $expdate . "','1900-01-01')")
                    ->first();

                if ($itembranch != null && $itembranch['itemcode'] != null) {

                    ItemsBranch::where('branch', '=', $branch)
                        ->where('itemcode', '=', $rows['itemcode'])
                        ->whereRaw("ifnull(items_branches.expdate,'1900-01-01') = ifnull('" . $expdate . "','1900-01-01')")
                        ->update(['qty' => $curr]);

                } else {

                    ItemsBranch::create(['branch' => $branch, 'itemcode' => $rows['itemcode'], 'expdate' => $expdate, 'qty' => $curr]);
                }

            }

            $dateInvt['batch'] = $counter->prefix . sprintf('%011d', $counter->value);
            $dateInvt['remarks'] = $request->get('remarks');

            $dateInvt['trndate'] = substr($request->get('trndate'), 0, 10);
            $dateInvt['trnType'] = '005';
            $dateInvt['drqty'] = $totaldr;
            $dateInvt['crqty'] = $totalcr;
            $dateInvt['user_id'] = auth()->user()->id;
            $dateInvt['status'] = '01';
            $dateInvt['refno'] = $request->get('refno');
            $dateInvt['rono'] = $request->get('rono');
            $dateInvt['from'] = $request->get('from');
            $dateInvt['to'] = $request->get('to');

            $dateInvt['year'] = getYear();
            $counter->increment('value');
            ItemsBatch::create($dateInvt);
            \DB::commit();
            return response()->json(['status' => 'success', 'id' => $batch], 200);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'something error in data'], 400);
        }
        return response()->json($data, 200);

    }

    public function RRMTrans(RRMRequest $request)
    {

        // return response()->json($request->all(), 200);

        DB::disableQueryLog();
        DB::beginTransaction();

        try {

            $counter = Counter::where('key', $request->get('trnmode'))
                ->where('branch', auth()->user()->branch)
                ->first();

            $items = [];
            $batch = $counter->prefix . sprintf('%011d', $counter->value);
            $totalcr = 0;
            $totaldr = 0;
            $branch = auth()->user()->branch;
            $data = $request->get('items');

            foreach ($data as $rows) {

                $uom = getUOM($rows['itemcode']);
                $totaldr = $totaldr + ((float) (($rows['trntype'] != 'RRM') ? convertTin($rows['unit'], $rows['qty'], $uom) : 0));
                $totalcr = $totalcr + ((float) (($rows['trntype'] == 'RRM') ? convertTin($rows['unit'], $rows['qty'], $uom) : 0));
                $expdate = (String) $rows['expdate'] != '' ? $rows['expdate'] : '1900-01-01';

                $curr = getCurrQty([
                    'ITEMCODE' => $rows['itemcode'],
                    'EXPDATE' => $expdate,
                    'BRANCH' => $branch,
                ]) + ((float) (($rows['trntype'] != 'RRM') ? convertTin($rows['unit'], $rows['qty'], $uom) : (convertTin($rows['unit'], $rows['qty'], $uom) * -1)));

                $prev = getPrevQty([
                    'ITEMCODE' => $rows['itemcode'],
                    'EXPDATE' => $expdate,
                    'BRANCH' => $branch,
                ]);

                ItemsTrnHist::create([
                    'trntype' => $rows['trntype'],
                    'batch' => $batch,
                    'status' => '01',
                    'branch' => $branch,
                    'itemcode' => $rows['itemcode'],
                    'unit' => $rows['unit'],
                    'p' => '',
                    'preqty' => $prev,
                    'drqty' => ((float) (($rows['trntype'] == 'RRM') ? convertTin($rows['unit'], $rows['qty'], $uom) : 0)),
                    'crqty' => ((float) (($rows['trntype'] != 'RRM') ? convertTin($rows['unit'], $rows['qty'], $uom) : 0)),
                    'curqty' => $curr,
                    'expdate' => $rows['expdate'],
                    'year' => getYear(),
                    'trndate' => substr($request->get('trndate'), 0, 10),
                ]);

                $itembranch = ItemsBranch::where('branch', '=', $branch)
                    ->where('itemcode', '=', $rows['itemcode'])
                    ->whereRaw("ifnull(items_branches.expdate,'1900-01-01') = ifnull('" . $expdate . "','1900-01-01')")
                    ->first();

                if ($itembranch != null && $itembranch['itemcode'] != null) {

                    ItemsBranch::where('branch', '=', $branch)
                        ->where('itemcode', '=', $rows['itemcode'])
                        ->whereRaw("ifnull(items_branches.expdate,'1900-01-01') = ifnull('" . $expdate . "','1900-01-01')")
                        ->update(['qty' => $curr]);

                } else {

                    ItemsBranch::create(['branch' => $branch, 'itemcode' => $rows['itemcode'], 'expdate' => $expdate, 'qty' => $curr]);
                }

            }

            $dateInvt['batch'] = $counter->prefix . sprintf('%011d', $counter->value);
            $dateInvt['remarks'] = $request->get('remarks');

            $dateInvt['trndate'] = substr($request->get('trndate'), 0, 10);
            $dateInvt['trnType'] = '004';
            $dateInvt['drqty'] = $totaldr;
            $dateInvt['crqty'] = $totalcr;
            $dateInvt['refno'] = $request->get('refno');
            $dateInvt['rono'] = $request->get('rono');
            $dateInvt['from'] = $request->get('from');
            $dateInvt['to'] = $request->get('to');
            $dateInvt['user_id'] = auth()->user()->id;
            $dateInvt['status'] = '01';
            $dateInvt['year'] = getYear();
            $counter->increment('value');
            ItemsBatch::create($dateInvt);
            \DB::commit();
            return response()->json(['status' => 'success', 'id' => $batch], 200);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'something error in data'], 400);
        }
        return response()->json($data, 200);

    }

    public function RRTrans(RRRequest $request)
    {

        // return response()->json($request->all(), 200);

        DB::disableQueryLog();
        DB::beginTransaction();

        try {

            $counter = Counter::where('key', $request->get('trnmode'))
                ->where('branch', auth()->user()->branch)
                ->first();

            $items = [];
            $batch = $counter->prefix . sprintf('%011d', $counter->value);
            $totalcr = 0;
            $totaldr = 0;
            $branch = auth()->user()->branch;
            $data = $request->get('items');

            foreach ($data as $rows) {

                $uom = getUOM($rows['itemcode']);
                $totaldr = $totaldr + ((float) (($rows['trntype'] == 'OD') ? convertTin($rows['unit'], $rows['qty'], $uom) : 0));
                $totalcr = $totalcr + ((float) (($rows['trntype'] != 'OD') ? convertTin($rows['unit'], $rows['qty'], $uom) : 0));
                $expdate = (String) $rows['expdate'] != '' ? $rows['expdate'] : '1900-01-01';

                $curr = getCurrQty([
                    'ITEMCODE' => $rows['itemcode'],
                    'EXPDATE' => $expdate,
                    'BRANCH' => $branch,
                ]) + ((float) (($rows['trntype'] != 'OD') ? convertTin($rows['unit'], $rows['qty'], $uom) : (convertTin($rows['unit'], $rows['qty'], $uom) * -1)));

                $prev = getPrevQty([
                    'ITEMCODE' => $rows['itemcode'],
                    'EXPDATE' => $expdate,
                    'BRANCH' => $branch,
                ]);

                ItemsTrnHist::create([
                    'trntype' => $rows['trntype'],
                    'batch' => $batch,
                    'status' => '01',
                    'branch' => $branch,
                    'itemcode' => $rows['itemcode'],
                    'unit' => $rows['unit'],
                    'p' => '',
                    'preqty' => $prev,
                    'drqty' => ((float) (($rows['trntype'] == 'OD') ? convertTin($rows['unit'], $rows['qty'], $uom) : 0)),
                    'crqty' => ((float) (($rows['trntype'] != 'OD') ? convertTin($rows['unit'], $rows['qty'], $uom) : 0)),
                    'curqty' => $curr,
                    'expdate' => $rows['expdate'],
                    'year' => getYear(),
                    'trndate' => substr($request->get('trndate'), 0, 10),
                ]);

                $itembranch = ItemsBranch::where('branch', '=', $branch)
                    ->where('itemcode', '=', $rows['itemcode'])
                    ->whereRaw("ifnull(items_branches.expdate,'1900-01-01') = ifnull('" . $expdate . "','1900-01-01')")
                    ->first();

                if ($itembranch != null && $itembranch['itemcode'] != null) {

                    ItemsBranch::where('branch', '=', $branch)
                        ->where('itemcode', '=', $rows['itemcode'])
                        ->whereRaw("ifnull(items_branches.expdate,'1900-01-01') = ifnull('" . $expdate . "','1900-01-01')")
                        ->update(['qty' => $curr]);

                } else {

                    ItemsBranch::create(['branch' => $branch, 'itemcode' => $rows['itemcode'], 'expdate' => $expdate, 'qty' => $curr]);
                }

            }

            $dateInvt['batch'] = $counter->prefix . sprintf('%011d', $counter->value);
            $dateInvt['remarks'] = $request->get('remarks');

            $dateInvt['trndate'] = substr($request->get('trndate'), 0, 10);
            $dateInvt['trnType'] = '003';
            $dateInvt['drqty'] = $totaldr;
            $dateInvt['crqty'] = $totalcr;
            $dateInvt['refno'] = $request->get('refno');
            $dateInvt['van_no'] = $request->get('van_no');
            $dateInvt['customer'] = $request->get('customer');
            $dateInvt['seal_no'] = $request->get('seal_no');
            $dateInvt['user_id'] = auth()->user()->id;
            $dateInvt['status'] = '01';
            $dateInvt['year'] = getYear();
            $counter->increment('value');
            ItemsBatch::create($dateInvt);
            \DB::commit();
            return response()->json(['status' => 'success', 'id' => $batch], 200);

        } catch (\Exception $e) {
            DB::rollback();
            // return response()->json(['error' => 'something error in data'], 400);
            return response()->json(['error' => $e->getMessage()], 400);
        }
        return response()->json($data, 200);

    }

    public function store(ProductRequest $request)
    {
        $product = new Item;
        $product->itemcode = $request->itemcode;
        $product->itemdesc = $request->itemdesc;
        $product->u_stockcode = $request->u_stockcode;
        $product->pckgsize = $request->pckgsize;
        $product->uompu = $request->uompu;
        $product->numperuompu = $request->numperuompu;
        $product->save();
        // $request['type'] = 'new';
        // $user = User::WherePermissionIs('users-notify')->get();
        // $user->each->notify(new ItemsNotify(Auth::user(), ['data' => $request->all()]));

        return \response()->json(['message' => 'successfull'], 200);
    }

    public function update(ProductRequest $request)
    {
        $product = Item::where('itemcode', '=', $request->itemcode)
            ->update([
                'itemdesc' => $request->itemdesc,
                'u_stockcode' => $request->u_stockcode,
                'pckgsize' => $request->pckgsize,
                'uompu' => $request->uompu,
                'numperuompu' => $request->numperuompu,
            ]);
        // $request['type'] = 'update';
        // $user = User::WherePermissionIs('users-notify')->get();
        // $user->each->notify(new ItemsNotify(Auth::user(), ['data' => $request->all()]));

        return \response()->json(['message' => 'successfull'], 200);
    }

    public function destroy($itemcode)
    {

        $request['type'] = 'delete';
        $request['id'] = $id;
        // $user = User::WherePermissionIs('users-notify')->get();
        // $user->each->notify(new ItemsNotify(Auth::user(), ['data' => $request->all()]));
        Item::where('id', '=', $id)->update(['status' => '99']);

        return \response()->json(['data' => 'successful'], 200);
    }
}
