<?php

namespace App\Models;

use App\Models\PriceItemsList;
use Illuminate\Database\Eloquent\Model;

class PriceCategoryList extends Model
{
    protected $fillable = [
        'pricelist', 'fulltitle' 
    ];


    public function PriceItems()
    {
        return $this->hasMany(PriceItemsList::class, 'pricelist', 'pricelist');
    }

}
