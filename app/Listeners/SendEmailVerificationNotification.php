<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Registered;

class SendEmailVerificationNotification
{
  
    public function __construct()
    {
        //
    }

   
    public function handle(UserRegistered $event)
    {
        event(new Registered($event->user));
    }
}
