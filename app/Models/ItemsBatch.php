<?php

namespace App\Models;

use App\Models\ItemsTrnHist;
use Illuminate\Database\Eloquent\Model;

class ItemsBatch extends Model
{
    protected $fillable = ['trnType', 'batch', 'drqty', 'crqty', 'user_id', 'rono', 'refno', 'remarks', 'customer', 'from', 'to', 'trndate', 'year', 'approvedby', 'preparedby', 'receivedby', 'status'];

    public function hist()
    {
        return $this->hasMany(ItemsTrnHist::class, 'batch', 'batch');
    }
}
