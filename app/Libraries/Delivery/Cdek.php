<?php

namespace App\Libraries\Delivery;

use SimpleXMLElement;

class Cdek {

    private $test;

    private $clientAuthData;

    private $senderCityPostCode;

    private $cdekServices = [
        //расчет стоимости доставки по параметрам посылок по России и странам ТС.
        'calculate'      => [
            'host'      => 'https://api.cdek.ru',
            'url'       => '/calculator/calculate_price_by_json.php',
            'method'    => 'POST'
        ],
        //список пунктов выдачи заказов
        'pvzlist'      => [
            'host'      => 'http://integration.cdek.ru',
            'url'       => '/pvzlist/v1/xml',
            'method'    => 'GET'
        ],

        'regions'      => [
            'host'      => 'https://integration.cdek.ru',
            'url'       => '/v1/location/regions',
            'method'    => 'GET'
        ]

    ];

    private $message;

    private $geoData;

    private $destinationType;

    public function __construct($geoData){

        $this->geoData = $this->prepareGeoData($geoData);

        $this->clientAuthData     = [
            //Параметры рабочей версии
            0 => [
                'Account' => 'f0ccc1a1b95b394277b212cac907b2db',
                'Secure_password' => '3dedc3d754de58b61c6a58f334e25f7c'
            ],
            //Параметры тестовой версии
            1 => [
                'Account' => '98f9bf62204c260cc3f902a92dd8b498',
                'Secure_password' => '3f46ddc6fd72cf5352084ae789bb4ffa'
            ]
        ];

        $this->senderCityPostCode = env('SHOP_DELIVERY_CDEK_INDEX_FROM');

        $this->test = env('SHOP_DELIVERY_CDEK_TEST');

    }

    public function getDeliveryCost($parcelParameters, $destinationType){

        $this->destinationType = $destinationType;

        $parcelParameters = $this->getParcelParameters($parcelParameters);

        $data = [];

        switch($this->destinationType){
            case 'toTerminal'   :   $tariffs = ['136', '5', '10', '15', '62', '63']; break;
            case 'toDoor'       :   $tariffs = ['137', '12', '16']; break;
            default :   break;
        }

        $services = $this->getServiceCost($parcelParameters, $tariffs);

        if( count($services) > 0 ){

            $optimalService = $services[0];

            $data = $this->prepareResponse($optimalService);

        }

        return $data;
    }

    public function getPointsInCity(){

        $points = [];

        $points['shops'] =  $this->getParcelShops();

        return $points;

    }

    private function getServiceCost($parcelParameters, $tariffs){

        $date = date('Y-m-d');

        $clientAuthData = $this->clientAuthData[ $this->test ];

        $data = [
            "version"               => "1.0",
            "dateExecute"           => $date,
            "authLogin"             => $clientAuthData['Account'],
            "secure"                => md5($date . '&' . $clientAuthData['Secure_password']),
            "senderCityPostCode"    => $this->senderCityPostCode,
            "receiverCityPostCode"  => $this->geoData['cityPostCode'],
            "goods"                 => $parcelParameters,

        ];

        $services = [];

        foreach($tariffs as $tariffId){

            $data["tariffId"] = $tariffId;

            $rawResult = $this->getCdekData('calculate', $data);

            $result = json_decode($rawResult);

            if( isset( $result->result ) ){
                $services[] = $result->result;
            }

        }

        return $services;

    }

    private function getParcelShops(){

        $data = [
            'regionid'  => json_decode($this->getRegionCode()),
        ];

        $xmlPointsData = $this->getCdekData( 'pvzlist', $data );

        $rawPoints = new SimpleXMLElement($xmlPointsData);

        $points = [];

        foreach($rawPoints as $key=> $point){

            $points[] = $this->prepareResponse($point->attributes());

        }

        return $points;

    }

    private function getRegionCode(){

        $xmlRegionsData = $this->getCdekData('regions');

        $regions = new SimpleXMLElement($xmlRegionsData);

        $region = $regions->xpath("//Region[@regionCodeExt=" . $this->geoData['regionCodeExt'] ."]");

        return $region[0]['regionCode'];
    }

    private function getCdekData($service_name, $data = []){

        $service = $this->cdekServices[ $service_name ];

        if($service['method'] !== 'POST'){
            $service[ 'url' ] .= $this->getQuery($data);
        }

        $ch = curl_init($service['host'] . $service[ 'url' ]);

        if($service['method'] === 'POST'){
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json;'
            ));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;

    }

    private function getParcelParameters($parcelParameters){

        $data = [];

        foreach($parcelParameters as $scuItem){

            $quantity = (int)$scuItem['quantity'];
            unset($scuItem['quantity']);

            for($i = 0; $i < $quantity; $i++){
                $data[] = $scuItem;
            }

        }

        return $data;

    }

    private function prepareGeoData($geoData){

        $data = [];

        foreach($geoData as $paramName => $paramValue){

            switch($paramName){
                case 'postal_code'  : $data['cityPostCode']   = $paramValue; break;
                case 'region_code'  : $data['regionCodeExt']  = $paramValue; break;
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
                //Calculate
                case 'tariffId'             : $response['service_id']   = $value; break;
                case 'price'                : $response['price']        = (int)$value; break;
                case 'deliveryPeriodMin'    :
                case 'deliveryPeriodMax'    :
                    if( isset($response['days']) ){
                        if($response['days'] !== (string)$value){

                            $response['days'] .= '-' . $value;
                        }
                    }else{
                        $response['days'] = (string)$value;
                    }
                    break;

                //Points
                case 'coordX'   : $response['geoCoordinates']['longitude']  = json_decode($value); break;
                case 'coordY'   : $response['geoCoordinates']['latitude']   = json_decode($value); break;
            }
        }

        return $response;
    }

    private function getQuery($parameters){
        $query = '?';

        foreach($parameters as $key => $value){

            if($query !== '?')
                $query .= '&';

            $query .= $key . '=' . urlencode($value);

        }

        return $query;
    }

}
