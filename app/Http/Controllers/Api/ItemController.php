<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryRequest;
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

                $totaldr = $totaldr + ((float) (($rows['TRNTYPE'] == 'OD') ? $rows['QTY'] : 0) * 100);
                $totalcr = $totalcr + ((float) (($rows['TRNTYPE'] != 'OD') ? $rows['QTY'] : 0) * 100);
                $curr = getCurrQty([
                    'ITEMCODE' => $rows['ITEMCODE'],
                    'EXPDATE' => $rows['EXPDATE'],
                    'BRANCH' => $branch,
                ]) + ((float) (($rows['TRNTYPE'] != 'OD') ? $rows['QTY'] : ($rows['QTY'] * -1)) * 100);

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
                    'preqty' => $prev,
                    'drqty' => ((float) (($rows['TRNTYPE'] == 'OD') ? $rows['QTY'] : 0) * 100),
                    'crqty' => ((float) (($rows['TRNTYPE'] != 'OD') ? $rows['QTY'] : 0) * 100),
                    'curqty' => $curr,
                    'expdate' => $rows['EXPDATE'],
                    'year' => getYear(),
                    'trndate' => $rows['TRNDATE'],
                ]);

                $itembranch = ItemsBranch::updateOrCreate(
                    ['branch' => $branch, 'itemcode' => $rows['ITEMCODE'], 'expdate' => $rows['EXPDATE']],
                    [
                        'qty' => $curr,
                    ]
                );

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
            return response()->json(['error' => 'something error in data'], 400);
        }
        return response()->json($data, 200);
    }

    public function DeliveryTrans(DeliveryRequest $request)
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

                $totaldr = $totaldr + ((float) (($rows['TRNTYPE'] == 'OD') ? $rows['QTY'] : 0) * 100);
                $totalcr = $totalcr + ((float) (($rows['TRNTYPE'] != 'OD') ? $rows['QTY'] : 0) * 100);
                $curr = getCurrQty([
                    'ITEMCODE' => $rows['ITEMCODE'],
                    'EXPDATE' => $rows['EXPDATE'],
                    'BRANCH' => $branch,
                ]) + ((float) (($rows['TRNTYPE'] != 'OD') ? $rows['QTY'] : ($rows['QTY'] * -1)) * 100);

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
                    'preqty' => $prev,
                    'drqty' => ((float) (($rows['TRNTYPE'] == 'OD') ? $rows['QTY'] : 0) * 100),
                    'crqty' => ((float) (($rows['TRNTYPE'] != 'OD') ? $rows['QTY'] : 0) * 100),
                    'curqty' => $curr,
                    'expdate' => $rows['EXPDATE'],
                    'year' => getYear(),
                    'trndate' => $rows['TRNDATE'],
                ]);

                $itembranch = ItemsBranch::updateOrCreate(
                    ['branch' => $branch, 'itemcode' => $rows['ITEMCODE'], 'expdate' => $rows['EXPDATE']],
                    [
                        'qty' => $curr,
                    ]
                );

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
            return response()->json(['error' => 'something error in data'], 400);
        }
        return response()->json($data, 200);

    }
}
