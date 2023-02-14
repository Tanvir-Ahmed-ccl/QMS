<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TokenSetting extends Model
{
    protected $table = "token_setting";

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

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
