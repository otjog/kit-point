<?php


namespace App\Libraries\Services\Shipment;

use App\Libraries\Services\Shipment\Contracts\ShipmentServices;
use App\Facades\GlobalData;
use App\Models\Shop\Product\Product;

class OwnShipment implements ShipmentServices
{
    private $geoData;

    public function __construct($geoData)
    {
        $this->geoData = $geoData;
    }

    public function getDeliveryCost($parcelData, $destinationType)
    {
        switch ($destinationType) {
            case 'toTerminal' :
                if($this->geoData['region_code'] === '31') {
                    return [
                        "type" => "toTerminal",
                        "price" => [0],
                        "days" => ['0'],
                        "service_id" => "toTerminal",
                        'id_response' => 'own_' . $destinationType,
                        'message' => 'Самовывоз с нашего офиса',
                    ];
                } elseif($this->existsFreeShipProduct($parcelData['products_id'])){
                    return [
                        "type" => "toTerminal",
                        "price" => [0],
                        "days" => ["~"],
                        "service_id" => "toTerminal",
                        'id_response' => 'own_' . $destinationType,
                        'message' => 'Доставка за наш счет',
                    ];
                }
                break;
            case 'toDoor' :
                if($this->geoData['region_code'] === '31' && $this->geoData['city_name'] === 'Белгород'){
                    return [
                        "type" => "toDoor",
                        "price" => [0],
                        "days" => ["1"],
                        "service_id" => "toDoor",
                        'id_response' => 'own_' . $destinationType,
                        'message' => 'Доставка за наш счет',
                    ];
                }
                break;
        }

        return null;

    }

    public function getPointsInCity()
    {
        $data = [];

        $dataMarker = [
            'title' => 'Офис компании ' . GlobalData::getParameter('info.company_name'),
            'address' => GlobalData::getParameter('info.address'),
            'timeTable' => $this->getTimeTablePoint(),
        ];

        $data[] = [
            'geoCoordinates' => [
                'longitude' => '36.589006',
                'latitude' => '50.612896',
                ],
            'markerInfo' => view('_kp.modules.shop.shipment._elements.marker', ['point' => $dataMarker])->render(),
        ];

        return $data;
    }

    private function getTimeTablePoint()
    {
        return [
            ['day' => 'Пн', 'time' => '10:00 - 19:00'],
            ['day' => 'Вт', 'time' => '10:00 - 19:00'],
            ['day' => 'Ср', 'time' => '10:00 - 19:00'],
            ['day' => 'Чт', 'time' => '10:00 - 19:00'],
            ['day' => 'Пт', 'time' => '10:00 - 19:00'],
            ['day' => 'Сб', 'time' => '12:00 - 18:00'],
            ['day' => 'Вс', 'time' => '12:00 - 18:00'],
        ];
    }

    private function existsFreeShipProduct($productIdsArray)
    {
        $productModel = new Product();

        $products = $productModel
            ->whereIn('id', $productIdsArray)
            ->whereHas('parameters', function ($query) {
                $query->where('alias', '_free_delivery_');
            })
            ->get();

        return count($products);
    }

}