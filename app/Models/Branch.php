<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = ['branch', 'branchname'];
    protected $hidden = [
        'created_at', 'updated_at',
    ];
}
