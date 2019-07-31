<?php

namespace App\Libraries\Services\Shipment\Contracts;

interface ShipmentServices
{
    public function getDeliveryCost($parcelData, $destinationType);

    public function getPointsInCity();
}