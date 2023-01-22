<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
	use HasApiTokens, Notifiable;

	protected $fillable = ['company_id', 'firstname', 'lastname', 'email',  'password', 'department_id', 'mobile', 'photo', 'user_type', 'user_role_id', 'remember_token', 'status', 'subscription_plan', 'subscribe_at', 'subscribe_out', 'token', 'qrcode', 'otp', 'avg_token_completed_time'];
	
    protected $hidden = ['password', 'remember_token', 'token', 'otp'];

    public $timestamps = false;

    protected $table = "user";

    protected $avaliableRoles = [
        'Admin'   => '5',
        'Officer' => '1',
        'Receptionist' => '2',
        // 'Client'  => '3',
    ];

    public function hasRole($role)
    {  
        return ($this->user_type == $this->avaliableRoles[ucfirst($role)]);
    }

    public function role()
    {  
        $roles = array_flip($this->avaliableRoles);
        return $roles[$this->user_type];
    } 

    public function roles($user_type = null)
    {   
        $roles = array_flip($this->avaliableRoles);
        $list = $roles;
        unset($list['5']); 

        return (!empty($user_type)?($roles[$user_type]):$list);
    } 


    public function userRole()
    {
        return $this->belongsTo('App\Models\UserType','user_role_id', 'id');
    }

    public function accounts()
    {
	    return $this->hasMany('App\Models\UserSocialAccount');
	}

    public function department() 
    {
        return $this->hasOne('App\Models\Department', 'id', 'department_id');
    }

    public function setting()
    {
        return $this->belongsTo('App\Models\Setting', 'id', 'company_id');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\User', 'company_id', 'id');
    }

}
