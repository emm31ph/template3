<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $fillable = ['branch', 'custno', 'custname', 'status'];

    public function branch()
    {
        return hasOne('App\Models\Branch', 'branch', 'branch');
    }
}
