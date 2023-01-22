<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = "sections";

	public function department()
	{
	    return $this->hasOne('App\Models\Department', 'id', 'department_id');
	}
}
