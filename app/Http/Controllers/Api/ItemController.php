<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryRequest;
use App\Http\Requests\FptdRequest;
use App\Http\Requests\RRMRequest;
use App\Http\Requests\RRRequest;
use App\Models\Counter;
use App\Models\ItemsBatch;
use App\Models\ItemsBranch;
use App\Models\ItemsTrnHist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{

    public function import(Request $request)
    {

        $data = $request->get('importItems');

        DB::disableQueryLog();
        DB::beginTransaction();

        try {

            $counter = Counter::where('key', 'IMPORT')->first();

            $items = [];
            $batch = $counter->prefix . $counter->value;
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
                $curr = getCurrQty([
                    'ITEMCODE' => $rows['ITEMCODE'],
                    'EXPDATE' => $rows['EXPDATE'],
                    'BRANCH' => $branch,
                ]) + ((float) (($rows['TRNTYPE'] != 'OD') ? (convertTinImport($whole, $uom) + $fraction) : ((convertTinImport($whole, $uom) + $fraction) * -1)));

                $prev = getPrevQty([
                    'ITEMCODE' => $rows['ITEMCODE'],
                    'EXPDATE' => $rows['EXPDATE'],
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
                    ->where('expdate', '=', $rows['EXPDATE'])->first();

                if ($itembranch !== null) {

                    ItemsBranch::where('branch', '=', $branch)
                        ->where('itemcode', '=', $rows['ITEMCODE'])
                        ->where('expdate', '=', $rows['EXPDATE'])
                        ->update(['qty' => $curr]);

                } else {
                    ItemsBranch::create(['branch' => $branch, 'itemcode' => $rows['ITEMCODE'], 'expdate' => $rows['EXPDATE'], 'qty' => $curr]);
                }

            }

            $dateInvt['batch'] = $counter->prefix . $counter->value;
            $dateInvt['remarks'] = $data[0]['REMARKS'];
            $dateInvt['trndate'] = substr($data[0]['TRNDATE'], 0, 10);
            $dateInvt['trntype'] = '003';

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

        return response()->json($request->all(), 400);

        DB::disableQueryLog();
        DB::beginTransaction();

        try {

            $counter = Counter::where('key', 'DELIVERY')->first();

            $items = [];
            $batch = $counter->prefix . $counter->value;
            $totalcr = 0;
            $totaldr = 0;
            $branch = auth()->user()->branch;
            $data = $request->get('items');

            foreach ($data as $rows) {

                $uom = getUOM($rows['itemcode']);
                $totaldr = $totaldr + ((float) (($rows['trntype'] == 'OD') ? convertTin($rows['unit'], $rows['qty'], $uom) : 0));
                $totalcr = $totalcr + ((float) (($rows['trntype'] != 'OD') ? convertTin($rows['unit'], $rows['qty'], $uom) : 0));
                $curr = getCurrQty([
                    'ITEMCODE' => $rows['itemcode'],
                    'EXPDATE' => $rows['expdate'],
                    'BRANCH' => $branch,
                ]) + ((float) (($rows['trntype'] != 'OD') ? convertTin($rows['unit'], $rows['qty'], $uom) : (convertTin($rows['unit'], $rows['qty'], $uom) * -1)));

                $prev = getPrevQty([
                    'ITEMCODE' => $rows['itemcode'],
                    'EXPDATE' => $rows['expdate'],
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
                    ->where('expdate', '=', $rows['expdate'])->first();

                if ($itembranch !== null) {

                    ItemsBranch::where('branch', '=', $branch)
                        ->where('itemcode', '=', $rows['itemcode'])
                        ->where('expdate', '=', $rows['expdate'])
                        ->update(['qty' => $curr]);

                } else {
                    ItemsBranch::create(['branch' => $branch, 'itemcode' => $rows['itemcode'], 'expdate' => $rows['expdate'], 'qty' => $curr]);
                }

            }

            $dateInvt['batch'] = $counter->prefix . $counter->value;
            $dateInvt['remarks'] = $request->get('remarks');

            $dateInvt['trndate'] = substr($request->get('trndate'), 0, 10);
            $dateInvt['trntype'] = '001';
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

        // return response()->json($request->all(), 200);

        DB::disableQueryLog();
        DB::beginTransaction();

        try {

            $counter = Counter::where('key', 'FPTD')->first();

            $items = [];
            $batch = $counter->prefix . $counter->value;
            $totalcr = 0;
            $totaldr = 0;
            $branch = auth()->user()->branch;
            $data = $request->get('items');

            foreach ($data as $rows) {

                $uom = getUOM($rows['itemcode']);
                $totaldr = $totaldr + ((float) (convertTin($rows['unit'], $rows['drqty'], $uom)));
                $totalcr = $totalcr + ((float) (convertTin($rows['unit'], $rows['crqty'], $uom)));
                $curr = getCurrQty([
                    'ITEMCODE' => $rows['itemcode'],
                    'EXPDATE' => $rows['expdate'],
                    'BRANCH' => $branch,
                ]) + ((float) ($rows['crqty'] + ($rows['drqty'] * -1)));

                $prev = getPrevQty([
                    'ITEMCODE' => $rows['itemcode'],
                    'EXPDATE' => $rows['expdate'],
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
                    ->where('expdate', '=', $rows['expdate'])->first();

                if ($itembranch !== null) {

                    ItemsBranch::where('branch', '=', $branch)
                        ->where('itemcode', '=', $rows['itemcode'])
                        ->where('expdate', '=', $rows['expdate'])
                        ->update(['qty' => $curr]);

                } else {
                    ItemsBranch::create(['branch' => $branch, 'itemcode' => $rows['itemcode'], 'expdate' => $rows['expdate'], 'qty' => $curr]);
                }

            }

            $dateInvt['batch'] = $counter->prefix . $counter->value;
            $dateInvt['remarks'] = $request->get('remarks');

            $dateInvt['trndate'] = substr($request->get('trndate'), 0, 10);
            $dateInvt['trntype'] = '001';
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

            $counter = Counter::where('key', 'FPTD')->first();

            $items = [];
            $batch = $counter->prefix . $counter->value;
            $totalcr = 0;
            $totaldr = 0;
            $branch = auth()->user()->branch;
            $data = $request->get('items');

            foreach ($data as $rows) {

                $uom = getUOM($rows['itemcode']);
                $totaldr = $totaldr + ((float) (convertTin($rows['unit'], $rows['drqty'], $uom)));
                $totalcr = $totalcr + ((float) (convertTin($rows['unit'], $rows['crqty'], $uom)));
                $curr = getCurrQty([
                    'ITEMCODE' => $rows['itemcode'],
                    'EXPDATE' => $rows['expdate'],
                    'BRANCH' => $branch,
                ]) + ((float) ($rows['crqty'] + ($rows['drqty'] * -1)));

                $prev = getPrevQty([
                    'ITEMCODE' => $rows['itemcode'],
                    'EXPDATE' => $rows['expdate'],
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
                    ->where('expdate', '=', $rows['expdate'])->first();

                if ($itembranch !== null) {

                    ItemsBranch::where('branch', '=', $branch)
                        ->where('itemcode', '=', $rows['itemcode'])
                        ->where('expdate', '=', $rows['expdate'])
                        ->update(['qty' => $curr]);

                } else {
                    ItemsBranch::create(['branch' => $branch, 'itemcode' => $rows['itemcode'], 'expdate' => $rows['expdate'], 'qty' => $curr]);
                }

            }

            $dateInvt['batch'] = $counter->prefix . $counter->value;
            $dateInvt['remarks'] = $request->get('remarks');

            $dateInvt['trndate'] = substr($request->get('trndate'), 0, 10);
            $dateInvt['trntype'] = '001';
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

            $counter = Counter::where('key', $request->get('trnmode'))->first();

            $items = [];
            $batch = $counter->prefix . $counter->value;
            $totalcr = 0;
            $totaldr = 0;
            $branch = auth()->user()->branch;
            $data = $request->get('items');

            foreach ($data as $rows) {

                $uom = getUOM($rows['itemcode']);
                $totaldr = $totaldr + ((float) (($rows['trntype'] == 'OD') ? convertTin($rows['unit'], $rows['qty'], $uom) : 0));
                $totalcr = $totalcr + ((float) (($rows['trntype'] != 'OD') ? convertTin($rows['unit'], $rows['qty'], $uom) : 0));
                $curr = getCurrQty([
                    'ITEMCODE' => $rows['itemcode'],
                    'EXPDATE' => $rows['expdate'],
                    'BRANCH' => $branch,
                ]) + ((float) (($rows['trntype'] != 'OD') ? convertTin($rows['unit'], $rows['qty'], $uom) : (convertTin($rows['unit'], $rows['qty'], $uom) * -1)));

                $prev = getPrevQty([
                    'ITEMCODE' => $rows['itemcode'],
                    'EXPDATE' => $rows['expdate'],
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
                    ->where('expdate', '=', $rows['expdate'])->first();

                if ($itembranch !== null) {

                    ItemsBranch::where('branch', '=', $branch)
                        ->where('itemcode', '=', $rows['itemcode'])
                        ->where('expdate', '=', $rows['expdate'])
                        ->update(['qty' => $curr]);

                } else {
                    ItemsBranch::create(['branch' => $branch, 'itemcode' => $rows['itemcode'], 'expdate' => $rows['expdate'], 'qty' => $curr]);
                }

            }

            $dateInvt['batch'] = $counter->prefix . $counter->value;
            $dateInvt['remarks'] = $request->get('remarks');

            $dateInvt['trndate'] = substr($request->get('trndate'), 0, 10);
            $dateInvt['trntype'] = '001';
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

            $counter = Counter::where('key', $request->get('trnmode'))->first();

            $items = [];
            $batch = $counter->prefix . $counter->value;
            $totalcr = 0;
            $totaldr = 0;
            $branch = auth()->user()->branch;
            $data = $request->get('items');

            foreach ($data as $rows) {

                $uom = getUOM($rows['itemcode']);
                $totaldr = $totaldr + ((float) (($rows['trntype'] == 'OD') ? convertTin($rows['unit'], $rows['qty'], $uom) : 0));
                $totalcr = $totalcr + ((float) (($rows['trntype'] != 'OD') ? convertTin($rows['unit'], $rows['qty'], $uom) : 0));
                $curr = getCurrQty([
                    'ITEMCODE' => $rows['itemcode'],
                    'EXPDATE' => $rows['expdate'],
                    'BRANCH' => $branch,
                ]) + ((float) (($rows['trntype'] != 'OD') ? convertTin($rows['unit'], $rows['qty'], $uom) : (convertTin($rows['unit'], $rows['qty'], $uom) * -1)));

                $prev = getPrevQty([
                    'ITEMCODE' => $rows['itemcode'],
                    'EXPDATE' => $rows['expdate'],
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
                    ->where('expdate', '=', $rows['expdate'])->first();

                if ($itembranch !== null) {

                    ItemsBranch::where('branch', '=', $branch)
                        ->where('itemcode', '=', $rows['itemcode'])
                        ->where('expdate', '=', $rows['expdate'])
                        ->update(['qty' => $curr]);

                } else {
                    ItemsBranch::create(['branch' => $branch, 'itemcode' => $rows['itemcode'], 'expdate' => $rows['expdate'], 'qty' => $curr]);
                }

            }

            $dateInvt['batch'] = $counter->prefix . $counter->value;
            $dateInvt['remarks'] = $request->get('remarks');

            $dateInvt['trndate'] = substr($request->get('trndate'), 0, 10);
            $dateInvt['trntype'] = '001';
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

}
