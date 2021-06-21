<?php

namespace App\Models;

use App\Models\Item;
use App\Models\ItemsTrnHist;
use Illuminate\Database\Eloquent\Model;

class ItemsBranch extends Model
{

    protected $primaryKey = 'itemcode';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $hidden = [
        'created_at',
    ];
    protected $fillable = ['branch', 'itemcode', 'expdate', 'status', 'qty'];

    public function branch()
    {
        return hasOne('App\Models\Branch', 'branch', 'branch');
    }

    public function Items()
    {
        return $this->belongsToMany(Item::class, 'items_branches.itemcode', 'itemcode');
    }

    public function TrnHist()
    {
        return $this->hasMany(ItemsTrnHist::class, 'itemcode', 'itemcode');
        // return $this->hasMany(ItemsTrnHist::class, 'batch', 'batch');

    }

}
