<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use App\Models\Settings;

class CustomMailServiceProvider extends ServiceProvider
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
        
        // $set = Settings::first();

        // if ($set) {

        //     $data = collect($set->data);


        //     $maildriver = $data->firstWhere('name', 'maildriver');
        //     $mailhost = $data->firstWhere('name', 'mailhost');
        //     $mailport = $data->firstWhere('name', 'mailport');
        //     $mailusername = $data->firstWhere('name', 'mailusername');
        //     $mailpassword = $data->firstWhere('name', 'mailpassword');
    
        //     $config = [
        //         'transport' => $maildriver['value'] ?? 'smtp',
        //         'host' => $mailhost['value'] ?? 'smtp.mailgun.org',
        //         'port' => $mailport['value'] ?? 587,
        //         'username' => $mailusername['value'] ?? null,
        //         'password' => $mailpassword['value'] ?? null
        //     ];

        //     Config::set('mail.mailers.smtp', $config);
        //     Config::set('mail.default', 'smtp');
        // }
    }
}
