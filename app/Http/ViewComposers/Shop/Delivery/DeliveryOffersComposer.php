<?php

namespace App\Http\ViewComposers\Shop\Delivery;

use App\Models\Shop\Order\Shipment;
use Illuminate\View\View;

class DeliveryOffersComposer{

    protected $data;

    protected $shipment;


    public function __construct(Shipment $shipment){

        $this->shipment = $shipment;

        $shipmentServices = $this->shipment->getShipmentServices();

        if (count($shipmentServices) !== 0) {
            $this->data = $shipmentServices;
        } else {
            $this->data = $this->shipment->getDefaultShipments();
        }

    }

    public function compose(View $view){
        $view->with('shipments', $this->data);
    }
}