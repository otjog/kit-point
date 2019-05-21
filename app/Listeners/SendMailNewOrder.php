<?php

namespace App\Listeners;

use App\Events\NewOrder;
use App\Mail\OrderShipped;
use App\Models\Settings;
use App\Models\Shop\Order\Order;
use App\Models\Shop\Product\Product;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendMailNewOrder{

    private $data;

    private $globalData;
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

        $settings = Settings::getInstance();

        $this->globalData = $settings->getParameters();

        $this->data =& $this->globalData['global_data'];

        $this->data['order'] = $orders->getOrderById($products, $event->orderId);

        Mail::to(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->send(new OrderShipped($this->globalData));
    }
}
