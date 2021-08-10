<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingAdviceItems extends Model
{
    protected $appends = [
        'itemdesc'];
    protected $fillable = ['docid','itemcode','price','qty','total','unit'];
    public function getItemdescAttribute()
    {
        $data = Item::where('itemcode',$this->itemcode)->get();
        return $data[0]->itemdesc;
    }
}
