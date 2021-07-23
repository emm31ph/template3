<?php

use App\Models\Item;
use App\Models\ItemsBranch;
use Carbon\Carbon;

function getYear()
{
    $date = Carbon::now();
    return $date->year;
}

function getCurrQty($data = []): float
{
    $val = ItemsBranch::where('itemcode', '=', $data['ITEMCODE'])
        ->whereRaw("ifnull(items_branches.expdate,'1900-01-01') = ifnull('" . $data['EXPDATE'] . "','1900-01-01')")
        ->where('branch', '=', $data['BRANCH'])
        ->first();

    // return ($val === null) ? 0 : $val->qty > 0 ? $val->qty * -1 : $val->qty;
    return ($val === null) ? 0 : $val->qty * 1;
}

function getPrevQty($data = []): float
{
    $val = ItemsBranch::where('itemcode', '=', $data['ITEMCODE'])
        ->whereRaw("ifnull(items_branches.expdate,'1900-01-01') = ifnull('" . $data['EXPDATE'] . "','1900-01-01')")
        ->where('branch', '=', $data['BRANCH'])
        ->first();

    return ($val === null) ? 0 : $val->qty * 1;
}
function getUOM($itemcode = null)
{
    $val = Item::where('itemcode', '=', $itemcode)->first();

    return ($val === null) ? 1 : $val->numperuompu;
}

function convertCase($unit = 'CASE', $qty = 0)
{
    if ($unit == 'CASE') {

        return $qty * 100;
    }
    return $qty;
}

function convertTin($unit = 'CASE', $qty = 0, $uom = 1)
{
    if ($unit == 'CASE') {

        return $qty * $uom;
    }
    return $qty;
}

function convertTinImport($qty = 0, $uom = 1)
{

    return $qty * $uom;

}
