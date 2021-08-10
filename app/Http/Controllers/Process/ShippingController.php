<?php

namespace App\Http\Controllers\Process;

use App\Models\Counter;
use Illuminate\Http\Request;
use App\Models\ShippingAdvice;
use Illuminate\Support\Facades\DB;
use App\Models\ShippingAdviceItems;
use App\Http\Controllers\Controller;

class ShippingController extends Controller
{
    public function index(Request $request)
    {
        $data = '';
        switch ($request->trnmode) {
            case 'create':
                // $data = $request->all();
                $data = $this->CreateShipping($request);
                break;
            case 'cancel':
                    ShippingAdvice::where('batch', '=', $request->batch)->update(['status' => '99']);
                    $data = 'successful';
                    break;
            case 'approved':
                    $this->approveTrn($request);
                    $data = 'successful';
                break;
            case 'alllist':
                    $data =  ShippingAdvice::where('branch',$request->branch)->get();
                break;
            case 'report':
                    // $data = $request->all();
                    $data = $this->ReportShipping($request);
                    break;
                
            default:
                $data = [];
                break;
        }


        return \response()->json($data);
    }
    public function ReportShipping($request)
    { 
        $data = ShippingAdvice::with(['items'])
        ->where('batch','=',$request->id)->get();

        // $data = collect($data);

        
        return $data[0];
    }
    public function CreateShipping($request){

        DB::beginTransaction();
        try {
            $counter = Counter::where('key', 'SHIPPING')
            ->where('branch', auth()->user()->branch)
            ->first();

    
        $batch = $counter->prefix . sprintf('%011d', $counter->value);

            $sa = new ShippingAdvice;
            $sa->packlist = $request->packlist;
            $sa->batch = $batch;
            $sa->branch = auth()->user()->branch;
            $sa->user_id = auth()->user()->id;
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
            $sa->shippingMethod = $request->shippingMethod;
            $sa->stockrequest = $request->shippingRequest;
            $sa->gross = $request->grosswt;
            $sa->remarks = $request->remarks;
            $sa->pickup = $request->pickup; 
            $sa->control_no = $request->control_no;
            $sa->seal_no = $request->seal_no;
            $sa->trucking_no = $request->trucking;
            $sa->status = '02';

            if($sa->save()){
                $counter->increment('value');

                $item = [];
                foreach ($request->items as $value) {
                    $qty = str_replace(",","",$value['qty']);
                    $price = str_replace(",","",$value['price'])*100;
                    $total = $price * $qty;
                    $item = 
                    [ 
                        'docid' =>  $sa->id, 
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

        public function approveTrn($request)
        {
            
            ShippingAdvice::where('batch', '=', $request->batch)
            ->update([
                'status' => '01',
                'approvedby' => auth()->user()->id,
                'os_no' => $request->os_no
            ]);
        }
    
}
