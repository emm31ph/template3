<?php

namespace App\Http\Controllers\Settings;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function index(Request $request)
    { 
        $data = '';
        // $parm = $request->parms;

        // return \response()->json('aaa',200);

        switch ($request->trntype) {
            case 'customer-list':
                $data = $this->GetCustomer($request);
                break; 
            default:
                // PriceItems();
                break;
        }

        return \response()->json($data, 200); 
    }

    private function GetCustomer($request)
    {
        $data = Customer::where('status','=','1')
        ->where('branch','=',$request->branch)
        ->get();


        return  $data;
    }
}
