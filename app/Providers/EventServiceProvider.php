<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\NewOrder' => [
            'App\Listeners\SendMailNewOrder',
        ],
        'App\Events\NewCustomer' => [
            'App\Listeners\SendMailNewCustomer',
        ],
        'App\Events\MaillingForRegister' => [
            'App\Listeners\SendMailForRegister',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
