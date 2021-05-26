<?php

use App\Models\Item;
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
function getUOM($itemcode = null)
{
    $val = Item::where('itemcode', '=', $itemcode)->first();

    return ($val === null) ? 1 : $val->numperuompu;
}

function convertCase($unit = 'Case', $qty = 0)
{
    if ($unit == 'CASE') {

        return $qty * 100;
    }
    return $qty;
}

function convertTin($unit = 'Case', $qty = 0, $uom = 1)
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
