<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemsBatch extends Model
{
    protected $fillable = ['trnType', 'batch', 'drqty', 'crqty', 'user_id', 'rono', 'refno', 'remarks', 'customer', 'from', 'to', 'trndate', 'year', 'approvedby', 'preparedby', 'receivedby', 'status'];

    public function TrnHist()
    {
        return hasMany('App\Models\ItemsTrnHist', 'batch', 'batch');
    }
}
