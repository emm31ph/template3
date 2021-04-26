<?php

use App\Models\ItemsBranch;
use Carbon\Carbon;

function getYear()
{
    $date = Carbon::now();
    return $date->year;
}

function getCurrQty($data = [])
{
    $val = ItemsBranch::where('itemcode', '=', $data['ITEMCODE'])
        ->where('expdate', '=', $data['EXPDATE'])
        ->where('branch', '=', $data['BRANCH'])->first();

    return ($val === null) ? 0 : $val->qty;
}

function getPrevQty($data = [])
{
    $val = ItemsBranch::where('itemcode', '=', $data['ITEMCODE'])
        ->where('expdate', '=', $data['EXPDATE'])
        ->where('branch', '=', $data['BRANCH'])->first();

    return ($val === null) ? 0 : $val->qty;
}
