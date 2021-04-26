<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemsTrnHist extends Model
{

    protected $fillable = ['_trn', 'trntype', 'branch', 'status', 'batch', '_cancelled', 'itemcode', 'p', 'preqty', 'drqty', 'crqty', 'curqty', 'trndate', 'expdate', 'year'];

    public function branch()
    {
        return hasOne('App\Models\Branch', 'branch', 'branch');
    }

    public function Items()
    {
        return hasOne('App\Models\Items', 'itemcode', 'itemcode');
    }

    public function TrnHist()
    {
        return hasOne('App\Models\ItemsBatch', 'batch', 'batch');
    }
}
