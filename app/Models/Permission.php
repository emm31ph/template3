<?php

namespace App\Models;

use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
    public $guarded = [];
    protected $hidden = [
        'created_at', 'updated_at', 'pivot',
    ];
}
