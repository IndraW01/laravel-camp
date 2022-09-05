<?php

namespace App\Listeners\User;

use App\Mail\User\AfterRegister;
use Illuminate\Support\Facades\Mail;
use App\Events\User\RegisteredSuccess;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailAfterSuccessRegistered
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\User\RegisteredSuccess  $event
     * @return void
     */
    public function handle(RegisteredSuccess $event)
    {
        $userRegistered = $event->user;

        Mail::to($userRegistered->email)->send(new AfterRegister($userRegistered));
    }
}
