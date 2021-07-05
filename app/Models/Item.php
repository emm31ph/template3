<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $hidden = [
        'created_at', 'updated_at',
    ];
    protected $fillable = ['shortcode', 'u_stockcode', 'itemcode', 'itemdesc', 'pckgsize', 'status','itemclass'];
}
