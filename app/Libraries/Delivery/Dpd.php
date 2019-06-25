<?php

namespace App\Libraries\Delivery;

use SoapClient;
use Exception;

class Dpd {

    private $soapClient;

    private $clientNumber;

    private $clientKey;

    private $pickUpCity;

    private $pickUpRegionCode;

    private $pickUpCountryCode;

    private $test;

    private $dpdHosts = [
        0 => 'http://ws.dpd.ru/services/', //рабочий хост
        1 => 'http://wstest.dpd.ru/services/' //тестовый хост
    ];

    private $dpdServices = [
        //список городов с возможностью доставки с нал.платежом
        'getCitiesCashPay'              => [
            'service_name'  => 'geography2',
            'request'       => true
        ],
        //список пунктов, имеющих ограничения, с указанием режима работы.
        'getParcelShops'                => [
            'service_name'  => 'geography2',
            'request'       => true
        ],
        //список подразделений DPD, не имеющих ограничений
        'getTerminalsSelfDelivery2'     => [
            'service_name'  => 'geography2',
            'request'       => false
        ],
        //список сервисов: стоимость доставки по параметрам  посылок по России и странам ТС.
        'getServiceCostByParcels2'      => [
            'service_name'  => 'calculator2',
            'request'       => true
        ],
    ];

    private $message;

    private $geoData;

    private $destinationType;

    public function __construct($geoData){

        $this->geoData = $this->prepareGeoData($geoData);

        $this->clientNumber         = env('SHOP_DELIVERY_DPD_CLIENT_NUMBER', '');

        $this->clientKey            = env('SHOP_DELIVERY_DPD_CLIENT_KEY','');

        $this->pickUpCity           = env('SHOP_DELIVERY_DPD_PICKUP_CITY', 'Москва');

        $this->pickUpRegionCode     = env('SHOP_DELIVERY_DPD_PICKUP_REGION_CODE', '77');

        $this->pickUpCountryCode    = env('SHOP_DELIVERY_DPD_PICKUP_COUNTRY_CODE', 'RU');

        $this->test                 = env('SHOP_DELIVERY_DPD_TEST', '1');

    }

    public function getDeliveryCost($parcelParameters, $destinationType){

        $this->destinationType = $destinationType;

        $data = [];

        switch($this->destinationType){
            case 'toTerminal'   : $selfDelivery = true; break;
            case 'toDoor'       : $selfDelivery = false; break;
            default :   break;
        }

        $services = $this->getServiceCost($parcelParameters, $selfDelivery);

        if( count($services) > 0 ){

            $optimalService = $this->getOptimalService($services);

            $data = $this->prepareResponse($optimalService);

        }

        return $data;
    }

    public function getPointsInCity(){

        $points = [];

        $points['shops'] =  $this->getParcelShops();

        $points['terminals'] =  $this->getTerminals();

        return $points;

    }

    private function getTerminals(){

        $services = $this->getDpdData( 'getTerminalsSelfDelivery2' );

        return $services->terminal;

    }

    private function getParcelShops(){

        $data = [
            'countryCode'   => $this->geoData['countryCode'],
            'regionCode'    => $this->geoData['regionCode']
        ];

        $services = $this->getDpdData( 'getParcelShops', $data );

        if(isset($services->parcelShop))
            return $services->parcelShop;

        return $services;

    }

    private function getServiceCost($parcelParameters, $selfDelivery = true, $serviceCode = null){

        $data = [
            'pickup' => [
                'cityName'      => $this->pickUpCity,
                'regionCode'    => $this->pickUpRegionCode,
                'countryCode'   => $this->pickUpCountryCode
            ],
            'delivery' => $this->geoData,
            'selfPickup' => true, //Доставка от терминала
            'selfDelivery' => $selfDelivery, //Доставка До терминала
            'parcel' => $parcelParameters,
            //'declaredValue' => 1000
        ];

        if($serviceCode !== null){
            $data['serviceCode'] = $serviceCode;
        }

        $services = $this->getDpdData( 'getServiceCostByParcels2', $data );

        return $services;

    }

    private function connectDpd( $method_name ){

        $service = $this->dpdServices[$method_name]['service_name'];

        if ( !$service ) {

            $this->message = 'В свойствах класса нет сервиса "' . $method_name . '"';

            return false;
        }

        $host = $this->dpdHosts[$this->test] . $service . '?WSDL';

        try {

            $this->soapClient = new SoapClient( $host , [ 'exceptions' => 1 ]);

        } catch ( Exception $ex ) {

            $this->message = $ex->getMessage();

            return false;
        }

        return true;
    }

    private function getDpdData( $method_name, $data = [] ){

        if ( $this->connectDpd( $method_name ) ){

            $data['auth'] = [
                'clientNumber' => $this->clientNumber,
                'clientKey' => $this->clientKey
            ];

            if ( $this->dpdServices[$method_name]['request'] ){

                $request['request'] = $data;

            }else{

                $request = $data;

            }

            try {

                $object = $this->soapClient->$method_name( $request );

            } catch ( Exception $ex ) {

                $this->setErrorMessage( $ex , $data);

                return [];
            }

            return $object->return;

        }else{
            //не смогли подключиться к dpd
            return false;//todo нужно выводить сообщение об ошибке, если не удалось подключиться к dpd

        }

    }

    private function getOptimalService($services){

        $cost = array_column($services, 'cost');

        $days = array_column($services, 'days');

        array_multisort($cost, SORT_ASC, $days, SORT_ASC, $services);

        return $services[0];
    }

    private function prepareGeoData($geoData){

        $data = [];

        foreach($geoData as $paramName => $paramValue){

            switch($paramName){
                case 'country_code' : $data['countryCode'] = $paramValue; break;
                case 'region_code'  : $data['regionCode']  = $paramValue; break;
                case 'city_kladr_id': $data['cityCode']    = $paramValue; break;
                case 'city_name'    : $data['cityName']    = $paramValue; break;
                case 'city_id'      : $data['cityId']      = $paramValue; break; //cityId - DPD
                case 'postal_code'  : $data['index']       = $paramValue; break;
            }

        }

        return $data;

    }

    private function prepareResponse($data){

        $response = [
            'type' => $this->destinationType
        ];

        foreach($data as $key => $value){
            switch($key){
                case 'serviceCode'  : $response['service_id']   = $value; break;
                case 'days'         : $response['days']         = $value; break;
                case 'cost'         : $response['price']        = $value; break;
            }
        }

        return $response;
    }

    private function setErrorMessage(Exception $ex, $data){

        //todo отслеживать ошибки

    }

    private function destinationDelivery($selfDelivery){
        if($selfDelivery)
            return ' до пункта выдачи';
        else
            return ' до адреса клиента';
    }

}
