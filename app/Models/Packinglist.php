<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Packinglist extends Model
{
    protected $fillable = ['address','batch','branch','consignee','contactperson','control_no','dr_no','gross','pickup','po_no','remarks','sa_no','seal_no','shippingdate','shippingline','shippingmethod','ro_no','status','booking_no','trndate','trnType','trucking_no','user_id'];
 
    public function items()
    {
        return $this->hasmany('App\Models\PackinglistItems','docid','id');
    }
}
