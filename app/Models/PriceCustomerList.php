<?php

namespace App\Models;

use App\Models\Item;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;

class PriceCustomerList extends Model
{
    protected $fillable = [
        'custno', 'itemcode', 'price' , 'branch' 
    ];

    public function items()
    {
        return $this->hasMany(Item::class, 'itemcode', 'itemcode');
    }

    public function customer()
    {
        return $this->hasMany(Customer::class, 'custno', 'custno');
    }
}
