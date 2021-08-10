<?php

namespace App\Models;

use App\Models\UserBranch;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use LaratrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'branch', 'username', 'status','usertype',
    ];

    protected $appends = [
        'photo_url',
        'allPermissions',
        'myBranch',
    ];

    public function getPhotoUrlAttribute()
    {
        return vsprintf('https://www.gravatar.com/avatar/%s.jpg?s=200&d=%s', [
            md5(strtolower($this->email)),
            $this->name ? urlencode("https://ui-avatars.com/api/$this->name") : 'mp',
        ]);
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
        'created_at', 'updated_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return int
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
 

    public function getAllPermissionsAttribute()
    {
        return ($this->allPermissions());
    }
    public function syncBranch()
    {
        return $this->belongsToMany('App\Models\Branch','App\Models\UserBranch','user_id','branchcode');
    }

    public function getMyBranchAttribute()
        {
        // return $this->hasManyThrough('App\Models\UserBranch','App\Models\Branch');
        $data = UserBranch::join('branches','branch','branchcode')->where('user_id',$this->id)->get();
        return  $data;
        }

    public function getBranch()
    {
        return  $this->hasOne('App\Models\Branch', 'branch', 'branch');
    }
}
