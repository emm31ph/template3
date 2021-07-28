<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesPerson extends Model
{
    protected $table = 'sales_persons';
    protected $primary = 'salesperson';
    protected $fillable = [
        'salesperson', 'salespersonname', 'user_id' 
    ];
}
