<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;

class ItemsTrnHist extends Model
{
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    protected $fillable = ['_trn', 'trntype', 'branch', 'status', 'batch', '_cancelled', 'itemcode', 'p', 'preqty', 'drqty', 'crqty', 'curqty', 'trndate', 'expdate', 'year', 'unit'];

    public function branch()
    {
        return $this->hasOne('App\Models\Branch', 'branch', 'branch');
    }

    public function items()
    {
        return $this->hasOne(Item::class, 'itemcode', 'itemcode');
    }

    public function TrnHist()
    {
        return $this->hasOne('App\Models\ItemsBatch', 'batch', 'batch');
    }
}
