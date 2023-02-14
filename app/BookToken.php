<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookToken extends Model
{
    public function department() 
    {
        return $this->hasOne('App\Models\Department', 'id', 'department_id');
    }

    public function counter() 
    {
        return $this->hasOne('App\Models\Counter', 'id', 'counter_id');
    }

    public function section()
    {
        return $this->hasOne('App\Models\Section', 'id', 'section_id');
    }

    public function officer() 
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function generated_by() 
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }
}
