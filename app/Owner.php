<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Owner extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'otp',
        'password',
    ];
}
