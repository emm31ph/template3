<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
       
        switch ($request->trntype) {
            case 'items-price':
              $data = $this->getCustomerPrice($request);
                break;
            
            default:
            $data = SalesPerson::get();
                break;
        }
        
        return \response()->json($data,200);
    }

    public function getCustomerPrice($request)
    {
        $data = DB::select(DB::raw(''));


        


        return $data;
    }

}
