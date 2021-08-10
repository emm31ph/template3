<?php

namespace App\Models;

use App\Models\ShippingAdvice;
use App\Models\ShippingAdviceItems;
use Illuminate\Database\Eloquent\Model;

class ShippingAdvice extends Model
{
    
    protected $fillable = ['address','batch','branch','consignee','contactperson','control_no','dr_no','gross','packlist','pickup','po_no','remarks','sa_no','seal_no','shippingdate','shippingline','shippingmethod','so_no','status','stockrequest','trndate','trnType','trucking_no','user_id'];
 
    public function items()
    {
        return $this->hasmany('App\Models\ShippingAdviceItems','docid','id');
    }
}
