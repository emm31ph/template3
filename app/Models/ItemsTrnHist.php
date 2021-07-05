<?php

namespace App\Models;

use App\Models\Item;
use App\Models\User;
use App\Models\ItemsBranch;
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

    public function scopeOfType($query, $type)
    {
        return $query->whereType($type);
    }
    protected $appends = [
        'itemdesc', 
        'numperuompu',
        'shortcode',
        'drQtyCase', 
        'crQtyCase', 
        'bal',  
        
    ];
    
    public function getBalAttribute()
    {
        $data = ItemsBranch::where('itemcode',$this->itemcode)->where('branch',$this->branch)->get();
         return $data[0]->qty;
        // return  $data;
    }
    public function getItemdescAttribute()
    {
        $data = Item::where('itemcode',$this->itemcode)->get();
        return $data[0]->itemdesc;
    }
    public function getNumperuompuAttribute()
    {
        $data = Item::where('itemcode',$this->itemcode)->get();
        return $data[0]->numperuompu;
    }
    public function getShortcodeAttribute()
    {
        $data = Item::where('itemcode',$this->itemcode)->get();
        return $data[0]->shortcode;
    }
    public function getDrQtyCaseAttribute()
    {
        $data = Item::where('itemcode',$this->itemcode)->get();
        return $this->drqty/$data[0]->numperuompu;
    } 
    public function getCrQtyCaseAttribute()
    {
        $data = Item::where('itemcode',$this->itemcode)->get();
        return $this->crqty/$data[0]->numperuompu;
    }
    
}
