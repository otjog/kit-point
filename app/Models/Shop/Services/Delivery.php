<?php

namespace App\Models\Shop\Services;

use App\Models\Shop\Order\Shipment;
use Illuminate\Database\Eloquent\Model;
use App\Libraries\Delivery\Dpd;
use App\Libraries\Delivery\Cdek;
use App\Libraries\Delivery\Pochta;
use App\Libraries\Delivery\CustomDelivery;
use App\Libraries\Helpers\DeclesionsOfWord;
use App\Models\Geo\GeoData;

class Delivery extends Model
{
    protected $shipments;

    protected $geoData;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->shipments = new Shipment();

        $geo = new GeoData();

        $this->geoData = $geo->getGeoData();
    }

    public function getPrices($parcel, $shipmentServiceAlias, $destinationType, $productIds){

        $shipmentService = $this->shipments->getShipmentServiceByAlias($shipmentServiceAlias);

        $parcelParameters = $this->getDeliveryDataFromRequest($parcel);

        switch ($shipmentServiceAlias) {

            case 'dpd'      :
                $serviceObj = new Dpd($this->geoData);
                break;

            case 'cdek'     :
                $serviceObj = new Cdek($this->geoData);
                break;

            case 'pochta'   :
                $serviceObj = new Pochta($this->geoData);
                break;

            case 'custom'   :
                $serviceObj = new CustomDelivery($this->geoData, $productIds);
                break;

            default : break; //todo сделать выход из foreach

        }

        $data = $serviceObj->getDeliveryCost($parcelParameters, $destinationType);

        if ( count($data) > 0 ) {

            $data['declision'] = $this->getDeclisionOfDays($data['days']);

            $shipmentService[0]->offer = $data;

        }

        return $shipmentService[0];

    }

    public function getPoints($shipmentServiceAlias)
    {
        $data = [];

        $serviceObj = null;

        switch ($shipmentServiceAlias) {

            case 'dpd'  : $serviceObj = new Dpd( $this->geoData ); break;

            case 'cdek' : $serviceObj = new Cdek( $this->geoData ); break;
        }

        if ($serviceObj !== null) {
            $data['points'][$shipmentServiceAlias] = $serviceObj->getPointsInCity();
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

    private function getDeclisionOfDays($days)
    {
        $daysArray = explode('-', $days);

        if (count($daysArray) > 1)
            $maxDay = (int)$daysArray[1];
        else
            $maxDay = (int)$daysArray[0];

        return DeclesionsOfWord::make($maxDay, ['день', 'дня', 'дней']);
    }
}