<?php

namespace App\Http\Controllers\Settings;

use App\Models\Lookup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LookupController extends Controller
{
    public function index(Request $request)
    { 
        
        $data = Lookup::get();
            

        return \response()->json($data, 200); 
    }

}
