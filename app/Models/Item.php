<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    protected $fillable = ['shortcode', 'u_skucode', 'itemcode', 'itemdesc', 'pckgsize', 'status'];
}
