<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderSlip extends Model
{
    protected $primaryKey = 'os_id';
    public $incrementing = false;
    protected $keyType = 'string';
}
