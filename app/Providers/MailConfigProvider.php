<?php

namespace App\Providers;

use App\Models\AppSettings;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class MailConfigProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // $configuration = AppSettings::first();

        // if(!is_null($configuration))
        // {
        //     $config = [
        //         'driver'        => 'smtp',
        //         'host'          => $configuration->MAIL_HOST ?? 'localhost',
        //         'port'          => $configuration->MAIL_PORT ?? '587',
        //         'encryption'    => $configuration->MAIL_ENCRYPTION ?? 'tls',
        //         'username'      => $configuration->MAIL_USERNAME ?? 'root',
        //         'password'      => $configuration->MAIL_PASSWORD ?? '',
        //         'from'          => [
        //             'address' => $configuration->MAIL_FROM_ADDRESS ?? "noreply@gokiiw.com",
        //             'name'    => $configuration->APP_NAME ?? "Go Kiiw",
        //         ],
        //         'sendmail'  => '/usr/sbin/sendmail -bs',
        //         'pretend'   => false,
        //     ];

        //     Config::set('mail', $config);
        // }
    }
}
