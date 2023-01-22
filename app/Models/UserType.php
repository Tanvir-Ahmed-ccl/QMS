<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
	protected $fillable = ['company_id', 'name', 'status'];
}
