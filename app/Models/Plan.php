<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = "plans";

    protected $fillable = [
        'title',
        'price_per_month',
        'price_per_year',
        'details',
        'status',
        'sms_limit',
        'display_limit',
    ];
}
