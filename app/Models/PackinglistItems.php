<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackinglistItems extends Model
{
    protected $appends = [
        'itemdesc'];
    protected $fillable = ['docid','itemcode','remarks','qty','expdate','unit'];
    public function getItemdescAttribute()
    {
        $data = Item::where('itemcode',$this->itemcode)->get();
        return $data[0]->itemdesc;
    }
}
