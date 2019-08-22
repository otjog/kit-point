<?php

namespace App\Listeners;

use App\Events\NewCustomer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerCreate;
use App\Models\Settings;

class SendMailNewCustomer
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
     * @param  NewCustomer  $event
     * @return void
     */
    public function handle(NewCustomer $event)
    {
        $settings = Settings::getInstance();

        $data['customer'] = $event->customer;

        $globalData = $settings->getParametersForController($data,'shop', 'customer', 'show', $event->customer->id);

        Mail::to(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->cc($event->customer->email, $event->customer->full_name )
            ->send(new CustomerCreate(['global_data' => $globalData]));
    }
}
