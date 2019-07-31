<?php

namespace App\Libraries\Services\Shipment;

use App\Libraries\Services\Shipment\Contracts\ShipmentServices;

class DefaultShipment implements ShipmentServices
{
    protected $shipmentMethod;

    public function __construct($shipmentMethod)
    {
        $this->shipmentMethod = $shipmentMethod;
    }

    public function getDeliveryCost($parcelData, $destinationType)
    {
        return [
            'error' => [
                'message' => 'У данного метода доставки нет Сервиса Расчета Доставки'
            ],
            'message' => $this->shipmentMethod[0]->description,
            'type'  => $destinationType,
            'days'  => ['~'],
            'price' => ['~'],
            'id_response' => $this->shipmentMethod[0]->alias . '_' . $destinationType,
        ];
    }

    public function getPointsInCity()
    {
        return [];
    }
}