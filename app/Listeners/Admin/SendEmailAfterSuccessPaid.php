<?php

namespace App\Listeners\Admin;

use App\Events\Admin\PaidSuccess;
use App\Mail\Admin\AfterPaid;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailAfterSuccessPaid
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
     * @param  \App\Events\Admin\PaidSuccess  $event
     * @return void
     */
    public function handle(PaidSuccess $event)
    {
        $checkout = $event->checkout;

        Mail::to($checkout->user->email)->send(new AfterPaid($checkout));
    }
}
