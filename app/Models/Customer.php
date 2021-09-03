<?php

namespace App\Models;

use App\Models\SalesPerson;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

protected $casts = [
    'custno' => 'string',
];
    // protected $appends = [
    //     'SalesPersons'
    // ];

    protected $fillable = ['branch', 'custno', 'custname', 'status','pricelist','region'];

    public function branch()
    {
        return  $this->hasOne('App\Models\Branch', 'branch', 'branch');
    }

    // public function getSalesPersonsAttribute()
    // {
    //     // return $this->salesperson;
    //     // return $this->belongsToMany('App\Models\SalesPerson', 'App\Models\Customer','salesperson','salesperson');

    // // return $this->hasManyThrough('App\Models\UserBranch','App\Models\Branch');
    // // $data = SalesPerson::where('salesperson','=',$this->salesperson)->get();
    //     // return   $this->belongsToMany(SalesPerson::class,'salesperson','salesperson');
    //     $data = SalesPerson::where('salesperson',$this->attributes['salesperson'])->get();
    //     return $data;
    // }
// public function setCustnoAttribute($value)
// {
//     $this->attributes['custno'] = strtolower($value);
// }
     
}