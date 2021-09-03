<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class OrderSlipItem extends Model
{
    protected $fillable = [
        'line','docid','branch','itemcode','qty','unit','unit_price','discount','total'
     ];

     protected $appends = [
        'itemdesc','pckgsize','shortcode']; 
    public function getItemdescAttribute()
    {
        $data = Item::where('itemcode',$this->itemcode)->get();
        return $data[0]->itemdesc;
    }

    public function getPckgsizeAttribute()
    {
        
        $data = Item::where('itemcode',$this->itemcode)->get();
        return str_replace("/"," x ",$data[0]->pckgsize);
        
    }public function getShortcodeAttribute()
    {
        
        $data = Item::where('itemcode',$this->itemcode)->get();
        return $data[0]->u_stockcode;
    }

    
}