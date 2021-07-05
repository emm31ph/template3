<?php

namespace App\Models;

use App\Models\User;
use App\Models\ItemsTrnHist;
use Illuminate\Database\Eloquent\Model;

class ItemsBatch extends Model
{
    protected $hidden = [
        'created_at', 'updated_at',
    ];
    protected $fillable = ['trnType', 'batch', 'drqty', 'crqty', 'user_id', 'rono', 'refno', 'remarks', 'customer',
        'from', 'to', 'van_no', 'seal_no', 'trndate', 'year', 'approvedby', 'preparedby', 'receivedby', 'status','basebatch'];

    public function hist()
    {
        return $this->hasMany(ItemsTrnHist::class, 'batch', 'batch');
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id')->select(['id', 'name',]); 
    }
  
   
}
