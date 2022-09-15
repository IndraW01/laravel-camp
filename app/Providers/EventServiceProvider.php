<?php

namespace App\Providers;

use App\Events\User\CheckoutSucess;
use App\Listeners\User\SendEmailAfterSuccessCheckout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        \App\Events\User\RegisteredSuccess::class => [
            \App\Listeners\User\SendEmailAfterSuccessRegistered::class
        ],
        CheckoutSucess::class => [
            SendEmailAfterSuccessCheckout::class
        ],
        \App\Events\Admin\PaidSuccess::class => [
            \App\Listeners\Admin\SendEmailAfterSuccessPaid::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
