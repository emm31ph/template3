<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemsBranch extends Model
{

    protected $primaryKey = 'itemcode';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['branch', 'itemcode', 'expdate', 'status', 'qty'];

    public function branch()
    {
        return hasOne('App\Models\Branch', 'branch', 'branch');
    }

    public function Items()
    {
        return hasOne('App\Models\Items', 'itemcode', 'itemcode');
    }
}
