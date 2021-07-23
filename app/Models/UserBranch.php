<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBranch extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'branch', 'branchcode');
    }
}
