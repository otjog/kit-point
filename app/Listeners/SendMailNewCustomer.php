<?php

namespace App\Listeners;

use App\Events\NewCustomer;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerCreate;
use App\Facades\GlobalData;

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
        $data['customer'] = $event->customer;

        $globalData = GlobalData::pushArrayParameters($data);

        Mail::to(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->cc($event->customer->email, $event->customer->full_name )
            ->send(new CustomerCreate(['global_data' => $globalData]));
    }
}
