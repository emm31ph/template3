<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\SalesPerson;
use App\Models\OrderSlipItem;
use Illuminate\Database\Eloquent\Model;

class OrderSlip extends Model
{
    protected $primaryKey = 'docid';
    public $incrementing = true;
    protected $keyType = 'string';

    protected $casts = [
    'custno' => 'string',
];

    protected $fillable = [
        'address','docid','batch','branch','custno','user_id','salesperson','trndate','sono','pono','deliverydate','terms','deliver_to','totalamount','totaldiscount','remarks','acknowledge','creditcollection','approvedby','status'
    ];


    // public function getCustnoAttribute()
    // {
         
    //     return  ($this->attributes['custno']);
    // }


    public function items()
    {
        return $this->hasmany(OrderSlipItem::class,'docid','docid');
    }

    public function customer()
    {
        return $this->hasmany(Customer::class,'custno','custno');
    }

    public function salesperson()
    {
        return $this->hasmany(SalesPerson::class,'salesperson','salesperson');
    }
}