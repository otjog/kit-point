<?php

namespace App\Models\Shop\Services;

use App\Models\Shop\Order\Shipment;
use Illuminate\Database\Eloquent\Model;
use App\Libraries\Services\Shipment\Dpd;
use App\Libraries\Services\Shipment\Cdek;
use App\Libraries\Services\Shipment\Pochta;
use App\Libraries\Services\Shipment\OwnShipment;
use App\Libraries\Services\Shipment\DefaultShipment;
use App\Libraries\Helpers\DeclesionsOfWord;
use App\Models\Geo\GeoData;
use App\Models\Site\Image;
use App\Models\Settings;

class ShipmentService extends Model
{
    public function getPrices($shipmentData)
    {
        $shipments = new Shipment();

        $shipmentService = $shipments->getShipmentMethodByAlias($shipmentData['alias']);

        $shipmentData['parcel_data'] = $this->getParcelParameters($shipmentData['parcel_data']);

        $serviceObj = $this->getServiceObject($shipmentService);

        if ($serviceObj !== null) {
            $data = $serviceObj->getDeliveryCost($shipmentData['parcel_data'], $shipmentData['type']);
            if ($data !== null ) {
                $data['days'][] = $this->getDeclisionOfDays($data['days'][0]);
                $data['price'][] = $this->getCurrency();
                $shipmentService[0]->offer = $data;
            }
        }

        return $shipmentService[0];

    }

    public function getPoints($shipmentServiceAlias)
    {
        $shipments = new Shipment();

        $shipmentService = $shipments->getShipmentMethodByAlias($shipmentServiceAlias);

        $image = new Image();

        $data = [];

        $serviceObj = $this->getServiceObject($shipmentService);

        if ($serviceObj !== null) {
            $data[$shipmentServiceAlias]['points'] = $serviceObj->getPointsInCity();
            if(count($data[$shipmentServiceAlias]['points']) > 0)
                $data[$shipmentServiceAlias]['mapMarker'] = $image->getSrcImage('default', 'marker', $shipmentService[0]->images[0]->src, $shipmentService[0]->id, 'png');
        }

        return $data;
    }

    public function getDeliveryDataFromRequest($data)
    {
        if (count($data) > 0) {

            $parcels = [];

            foreach ($data as $name => $params) {

                $arr = explode('|', $params);

                foreach ($arr as $key => $param) {

                    $parcels[$key][$name] = $param;

                }
            }
        }

        return $parcels;

    }

    private function getServiceObject($shipmentService)
    {
        $geo = new GeoData();

        $geoData = $geo->getGeoData();

        $serviceObj = null;

        switch ($shipmentService[0]->alias) {

            case 'dpd'      :
                $serviceObj = new Dpd($geoData);
                break;

            case 'cdek'     :
                $serviceObj = new Cdek($geoData);
                break;

            case 'pochta'   :
                $serviceObj = new Pochta($geoData);
                break;

            case 'own'   :
                $serviceObj = new OwnShipment($geoData);
                break;

            default :
                $serviceObj = new DefaultShipment($shipmentService);
        }

        return $serviceObj;

    }

    private function getDeclisionOfDays($days)
    {
        if($days === '~')
            return '';

        $daysArray = explode('-', $days);

        if (count($daysArray) > 1)
            $maxDay = (int)$daysArray[1];
        else
            $maxDay = (int)$daysArray[0];

        return DeclesionsOfWord::make($maxDay, ['день', 'дня', 'дней']);
    }

    private function getCurrency()
    {
        $settings = Settings::getInstance();

        return $settings->getParameter('components.shop.currency.symbol');
    }

    private function getParcelParameters($json)
    {
        return json_decode($json, true);
    }
}