<?php

namespace App\Http\Controllers\Settings;

use App\Models\SalesPerson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SalesPersonController extends Controller
{
    public function index(Request $request)
    {
       
        switch ($request->trntype) {
            case 'update':
              $data = $this->updateSalesPerson($request);
                break;
            
            default:
            $data = SalesPerson::get();
                break;
        }
        
        return \response()->json($data,200);
    }
    public function updateSalesPerson($request)
    {
        
        $this->validate($request,[
            'salesperson'=>'required|unique:sales_persons,salesperson,'.$request->id,
            'salespersonname'=>'required',
            'link_id'=>'required|unique:sales_persons,user_id,'.$request->id
         ]);

        $user = SalesPerson::findOrFail($request->id);
        $user->salesperson = $request->salesperson;
        $user->salespersonname = $request->salespersonname;
        $user->user_id = $request->link_id;
        $user->save();

        return \response()->json(['data'=>'successfull'],200);
    }
}
