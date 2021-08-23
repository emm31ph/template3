<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Signatory;
use Illuminate\Http\Request;

class SignatoriesController extends Controller
{
    public function index(Request $request)
    {

        $data = '';
        switch ($request->trnmode) {
            case 'print':
                $data = Signatory::where('branch', auth()->user()->branch)->where('type', $request->trntype)
                    ->orWhere('lookupcode', $request->trntype)->where('branch', auth()->user()->branch)->get();
                break;

            case 'search':
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
