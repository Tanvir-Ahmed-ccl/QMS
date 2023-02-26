<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSettings extends Model
{
    protected $fillable = [
        'ABOUT_US_ONE', 
        'ABOUT_US_TWO', 
        'TW_SID', 
        'TW_TOKEN',
        'TW_FROM',
        'APP_NAME',
        'APP_LOGO',
        'COPYRIGHT_TEXT',
        'STRIPE_KEY',
        'STRIPE_SECRET',
        'MAIL_HOST',
        'MAIL_PORT',
        'MAIL_USERNAME',
        'MAIL_PASSWORD',
        'MAIL_ENCRYPTION',
        'MAIL_FROM_ADDRESS',
        'CURRENCY_CODE',
        'CURRENCY_SIGN',
        'terms'
];
}
