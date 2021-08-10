<?php

namespace App\Http\Controllers\Settings;

use App\Models\Signatory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SignatoriesController extends Controller
{
    public function index(Request $request)
    {
        
        $data = '';
        switch ($request->trnmode) {
            case 'print': 
                $data = Signatory::where('type',$request->trntype)->where('branch',auth()->user()->branch)->get();
                break;
            
            case 'report':
                    // $data = $request->all();
                    //$data = $this->ReportShipping($request);
                    break;
                
            default:
                $data = [];
                break;
        }


        return \response()->json($data);
    }
}
