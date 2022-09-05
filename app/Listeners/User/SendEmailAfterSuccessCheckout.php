<?php

namespace App\Listeners\User;

use App\Events\User\CheckoutSucess;
use App\Mail\User\AfterCheckout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailAfterSuccessCheckout
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
     * @param  \App\Events\CheckoutSucess  $event
     * @return void
     */
    public function handle(CheckoutSucess $event)
    {
        $checkout = $event->checkout;

        Mail::to($checkout->user->email)->send(new AfterCheckout($checkout));
    }
}
