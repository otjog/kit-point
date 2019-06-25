<?php

namespace App\Libraries\Delivery;


class Pochta {

    private $apiToken;

    private $clientKey;

    private $indexFrom;

    private $maxMass; //кг

    private $maxVolume; //350 × 190 × 130 см

    private $pochtaHost = 'https://otpravka-api.pochta.ru';

    private $pochtaServices = [
        //расчет стоимости пересылк.
        'calculate' => '/1.0/tariff',
    ];

    private $geoData;

    private $destinationType;


    public function __construct($geoData){

        $this->geoData = $this->prepareGeoData($geoData);

        $this->apiToken       = env('SHOP_DELIVERY_POCHTA_API_TOKEN');

        $this->clientKey      = env('SHOP_DELIVERY_POCHTA_CLIENT_KEY');

        $this->indexFrom      = env('SHOP_DELIVERY_POCHTA_INDEX_FROM');

        $this->maxMass        = env('SHOP_DELIVERY_POCHTA_MAX_MASS');

        $this->maxVolume      = env('SHOP_DELIVERY_POCHTA_MAX_VOLUME');

    }

    public function getDeliveryCost($parcelParameters, $destinationType){

        $this->destinationType = $destinationType;

        $data = [];

        if($destinationType === 'toTerminal'){
            $postalTypes = [
                "PARCEL_CLASS_1",
                "POSTAL_PARCEL",
            ];

            $services = $this->getServiceCost( $parcelParameters, $postalTypes );

            if( count($services) > 0 ){

                $optimalService = $this->getOptimalService($services);

                $data = $this->prepareResponse($optimalService);

            }

            return $data;
        }else{
            return [];
        }
    }

    private function getServiceCost($parcelParameters, $postalTypes){

        $dimension  = [
            "height"    => 0,
            "length"    => 0,
            "width"     => 0,
            "weight"    => 1
        ];

        foreach($parcelParameters as $parcel){

            $dimension['height'] += (int)$parcel['height'] * (int)$parcel['quantity'];
            $dimension['length'] += (int)$parcel['length'];
            $dimension['width']  += (int)$parcel['width'];
            $dimension['weight'] += (float)$parcel['weight'] * (int)$parcel['quantity'] * 1000;

        }

        $mass = (int)$dimension['weight'];

        $volume = ( ($dimension['height']/100) * ($dimension['length']/100) * ($dimension['width']/100) );

        $services   = [];

        if( ($mass/1000) < $this->maxMass && $volume < $this->maxVolume ){
            $data       = [
                "courier"               => false,
                "declared-value"        => 0,
                "dimension"             => $dimension,
                "fragile"               => false,
                "index-from"            => $this->indexFrom,
                "index-to"              => $this->geoData['index-to'],
                "mail-category"         => "ORDINARY",
                "mass"                  => $mass,
                "payment-method"        => "CASHLESS",
                "with-order-of-notice"  => false,
                "with-simple-notice"    => false
            ];

            foreach ($postalTypes as $postalType){

                $data["mail-type"] = $postalType;

                $rawResult = $this->getPochtaData('calculate', $data);

                $service = json_decode($rawResult);

                if( isset($service->{"total-rate"}) && $service->{"total-rate"} !== 0 ){
                    $service->postal_type = $postalType;

                    $services[] = $service;
                }


            }
        }

        return $services;

    }

    private function getPochtaData($service_name, $data = []){

        $ch = curl_init($this->pochtaHost . $this->pochtaServices[ $service_name ]);

        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: AccessToken '   . $this->apiToken,
            'X-User-Authorization: Basic '  . $this->clientKey,
            'Content-Type: application/json;charset=UTF-8'
        ));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }

    private function prepareGeoData($geoData){

        $data = [];

        foreach($geoData as $paramName => $paramValue){

            switch($paramName){
                case 'postal_code'  : $data['index-to']       = $paramValue; break;
            }

        }

        return $data;

    }

    private function prepareResponse($data){

        $response = [
            'type' => $this->destinationType
        ];

        foreach($data as $key => $value){
            switch($key) {
                case 'postal_type'  :
                    $response['service_id'] = $value;
                    break;
                case 'total-rate'   :
                    $response['price'] = (int)($value / 100);
                    break;
                case 'delivery-time'  :
                    if(isset($value->{"min-days"}) && $value->{"min-days"} !== $value->{"max-days"} )
                        $response['days'] = $value->{"min-days"} . '-' . $value->{"max-days"};
                    else
                        $response['days'] = $value->{"max-days"};
                    break;
            }
        }

        if( !isset($response['days']))
            $response['days'] = null;

        return $response;
    }

    private function getOptimalService($services){

        $cost = array_column($services, 'total-rate');

        array_multisort($cost, SORT_ASC, $services);

        return $services[0];
    }

}
