<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;

class PriceItemsList extends Model
{
    protected $fillable = [
        'itemcode', 'pricelist', 'price', 'discount' 
    ];

    public function items()
    {
        return $this->hasMany(Item::class, 'itemcode', 'itemcode');
    }

}
