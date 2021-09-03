<?php

namespace App\Http\Controllers\Invoices;

use App\Models\Counter;
use App\Models\OrderSlip;
use App\Models\SalesPerson;
use Illuminate\Http\Request;
use App\Models\OrderSlipItem;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
       
       
         
        switch ($request->trnmode) {
            case 'newbooking':
                $data = $this->newBooking($request);
                break;
            case 'report1':
                $data = $this->getReport1($request);
                break;
            case 'bookingcancel':

                break;
            case 'items-list':
              $data = $this->getCustomerPrice($request);
                break; 
            case 'listproces':
              $data = $this->getListProces($request);
                break;
            
            default:
            $data = SalesPerson::get();
                break;
        }
        
        return \response()->json($data);
    }
    public function getListProces($request)
    {
        $data = OrderSlip::leftJoin('customers','customers.custno','order_slips.custno')
        // ->select('oders_slips.*')
        
        ->where('order_slips.branch',$request->branch)
        ->get();

        return $data;
    }
    public function getReport1($request)
    {
        $data = OrderSlip::with(['items','customer','salesperson'])
        ->where('batch', '=', $request->id)->first();


        return $data;
    }
    public function newBooking($request)
    {
         DB::beginTransaction();
        try {
            $counter = Counter::where('key', 'BOOKING')
            ->where('branch', auth()->user()->branch)
            ->first();

            $batch = $counter->prefix . sprintf('%011d', $counter->value);

         $bk = new OrderSlip;   
         $bk->batch = $batch; 
         $bk->custno =  $request['custno'];
         $bk->branch =  $request['branch'];
         $bk->address =  $request['address'];
         $bk->deliver_to =  $request['deliverto'];
         $bk->pono =  $request['pono'];
         $bk->sono =  $request['sono'];
         $bk->salesperson =  $request['salesperson'];
         $bk->trndate =  $request['trndate'];
         $bk->deliverydate =  $request['deliverydate'];
         $bk->terms =  $request['terms'];
         $bk->remarks =  $request['remarks'];
         $bk->user_id =  $request['userid'];
         $bk->acknowledge =  $request['acknowledge'];
         $bk->creditcollection =  $request['creditcollection'];
         $bk->totalamount =  0;
         $bk->totaldiscount =  0;
         $bk->status =  '02';

            if($bk->save()){ 
                 
                $counter->increment('value');
                $item = [];
                $total = 0;
                $totalDiscount = 0;
                foreach ($request->items as $value) {
                    $qty = str_replace(",", "", $value['qty']);
                    $cleanString = preg_replace('/([^0-9\.,])/i', '', $value['price']);
                    $total += $value['linetotal']*100;
                    $totalDiscount += $value['disc']*100;
                    $item =
                        [
                        'docid' => $bk->docid,
                        'branch' => $bk->branch,
                        'itemcode' => $value['itemcode'],
                        'qty' => $qty,
                        'unit' => $value['unit'],
                        'unitprice' => $value['unitprice']*100,
                        'price' => $value['price']*100,
                        'discount' => $value['disc']*100,
                        'linetotal' => $value['linetotal']*100,
                        'created_at' => date("Y/m/d"),
                        'updated_at' => date("Y/m/d"),
                    ];
                    
                    OrderSlipItem::insert($item);
                }

                $bk->totalamount =  $total;
                $bk->totaldiscount =  $totalDiscount;
                $bk->save();
            }
        DB::commit();
        return  $bk->batch;
        } catch (\Exception $e) {
            DB::rollback();
            // return response()->json(['error' => 'something error in data'], 400);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function getCustomerPrice($request)
    {
        $data = DB::select(DB::raw("
        select * from (
            select itemcode,price, 'pcl' as b,pcl.discount, pcl.custno,'' pricelist 
            from price_customer_lists as pcl  where pcl.custno='{$request['custno']}' 
            UNION all 
            select itemcode,price, 'pil' as b, pil.discount, '' custno, pil.pricelist  
            from price_items_lists pil where pil.pricelist='{$request['pricelist']}'
            ) as qqq 
            LEFT JOIN items i on i.itemcode=qqq.itemcode 
             "));
 
        return $data;
    }

}