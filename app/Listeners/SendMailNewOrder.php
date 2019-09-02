<?php

namespace App\Listeners;

use App\Events\NewOrder;
use App\Mail\OrderShipped;
use App\Facades\GlobalData;
use App\Models\Shop\Order\Order;
use App\Models\Shop\Product\Product;
use Illuminate\Support\Facades\Mail;

class SendMailNewOrder{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(){

    }

    /**
     * Handle the event.
     *
     * @param  NewOrder  $event
     * @return void
     */
    public function handle(NewOrder $event){

        $orders = new Order();

        $products = new Product();

        $data['order'] = $orders->getOrderById($products, $event->orderId);

        $globalData = GlobalData::pushArrayParameters($data);

        Mail::to(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->cc($data['order']->customer->email, $data['order']->customer->full_name )
            ->send(new OrderShipped(['global_data' => $globalData]));
    }
}
