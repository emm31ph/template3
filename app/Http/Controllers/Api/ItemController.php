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

                $totaldr = $totaldr + ((float) (($rows['trntype'] == 'OD') ? $rows['qty'] : 0) * 100);
                $totalcr = $totalcr + ((float) (($rows['trntype'] != 'OD') ? $rows['qty'] : 0) * 100);
                $curr = getCurrQty([
                    'ITEMCODE' => $rows['itemcode'],
                    'EXPDATE' => $rows['expdate'],
                    'BRANCH' => $branch,
                ]) + ((float) (($rows['trntype'] != 'OD') ? $rows['qty'] : ($rows['qty'] * -1)) * 100);

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
                    'p' => $rows['PCNT'] ?: '',
                    'preqty' => $prev,
                    'drqty' => ((float) (($rows['trntype'] == 'OD') ? $rows['qty'] : 0) * 100),
                    'crqty' => ((float) (($rows['trntype'] != 'OD') ? $rows['qty'] : 0) * 100),
                    'curqty' => $curr,
                    'expdate' => $rows['expdate'],
                    'year' => getYear(),
                    'trndate' => $rows['TRNDATE'],
                ]);

                $itembranch = ItemsBranch::updateOrCreate(
                    ['branch' => $branch, 'itemcode' => $rows['itemcode'], 'expdate' => $rows['expdate']],
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

        // return response()->json($request->all(), 200);

        // DB::disableQueryLog();
        // DB::beginTransaction();

        // try {

        $counter = Counter::where('key', 'DELIVERY')->first();

        $items = [];
        $batch = $counter->prefix . $counter->value;
        $totalcr = 0;
        $totaldr = 0;
        $branch = auth()->user()->branch;
        $data = $request->get('items');

        foreach ($data as $rows) {

            $totaldr = $totaldr + ((float) (($rows['trntype'] == 'OD') ? $rows['qty'] : 0) * 100);
            $totalcr = $totalcr + ((float) (($rows['trntype'] != 'OD') ? $rows['qty'] : 0) * 100);
            $curr = getCurrQty([
                'ITEMCODE' => $rows['itemcode'],
                'EXPDATE' => $rows['expdate'],
                'BRANCH' => $branch,
            ]) + ((float) (($rows['trntype'] != 'OD') ? $rows['qty'] : ($rows['qty'] * -1)) * 100);

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
                'p' => '',
                'preqty' => $prev,
                'drqty' => ((float) (($rows['trntype'] == 'OD') ? $rows['qty'] : 0) * 100),
                'crqty' => ((float) (($rows['trntype'] != 'OD') ? $rows['qty'] : 0) * 100),
                'curqty' => $curr,
                'expdate' => $rows['expdate'],
                'year' => getYear(),
                'trndate' => substr($request->get('trndate'), 0, 10),
            ]);

            $itembranch = ItemsBranch::updateOrCreate(
                ['branch' => $branch, 'itemcode' => $rows['itemcode'], 'expdate' => $rows['expdate']],
                [
                    'qty' => $curr,
                ]
            );

        }

        $dateInvt['batch'] = $counter->prefix . $counter->value;
        $dateInvt['remarks'] = $request->get('remarks');

        $dateInvt['trndate'] = substr($request->get('trndate'), 0, 10);
        $dateInvt['trntype'] = '001';
        $dateInvt['drqty'] = $totaldr;
        $dateInvt['crqty'] = $totalcr;
        $dateInvt['user_id'] = auth()->user()->id;
        $dateInvt['status'] = '01';
        $dateInvt['year'] = getYear();
        $counter->increment('value');
        ItemsBatch::create($dateInvt);
        \DB::commit();
        return response()->json(['message' => 'success'], 200);

        // } catch (\Exception $e) {
        //     DB::rollback();
        //     return response()->json(['error' => 'something error in data'], 400);
        // }
        return response()->json($data, 200);

    }
}
