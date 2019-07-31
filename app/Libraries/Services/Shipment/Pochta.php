<?php

namespace App\Libraries\Services\Shipment;

use App\Libraries\Services\Shipment\Contracts\ShipmentServices;

class Pochta implements ShipmentServices
{
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

    private $postalTypeOfAllDestination = [
        'toTerminal' => ["PARCEL_CLASS_1", "POSTAL_PARCEL"],
        'toDoor' => []
    ];

    public function __construct($geoData){

        $this->geoData = $this->prepareGeoData($geoData);

        $this->apiToken       = env('SHOP_DELIVERY_POCHTA_API_TOKEN');

        $this->clientKey      = env('SHOP_DELIVERY_POCHTA_CLIENT_KEY');

        $this->indexFrom      = env('SHOP_DELIVERY_POCHTA_INDEX_FROM');

        $this->maxMass        = env('SHOP_DELIVERY_POCHTA_MAX_MASS');

        $this->maxVolume      = env('SHOP_DELIVERY_POCHTA_MAX_VOLUME');

    }

    public function getDeliveryCost($parcelData, $destinationType)
    {
        $this->destinationType = $destinationType;

        $postalTypes = $this->postalTypeOfAllDestination[$destinationType];

        $services = $this->getServiceCost($parcelData, $postalTypes);

        if(count($services) > 0){

            $optimalService = $this->getOptimalService($services);

            return $this->prepareResponse($optimalService);

        }

        return null;
    }

    public function getPointsInCity()
    {
        return [];
    }

    private function getServiceCost($parcelData, $postalTypes){

        $dimension  = [
            "height"    => 0,
            "length"    => 0,
            "width"     => 0,
            "weight"    => 1
        ];

        foreach($parcelData['parcel'] as $parcel){

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
                "declared-value"        => (int)$parcelData['declaredValue']*100,
                "dimension"             => $dimension,
                "fragile"               => false,
                "index-from"            => $this->indexFrom,
                "index-to"              => $this->geoData['index-to'],
                "mail-category"         => "ORDINARY",
                "mass"                  => $mass,
                "payment-method"        => "CASHLESS",
                "with-order-of-notice"  => false,
                "with-simple-notice"    => false,
            ];

            if (count($postalTypes) > 0)
                $services = $this->getPochtaData('calculate', $data, $postalTypes);

        }

        return $services;

    }

    private function getPochtaData ($service_name, $data = [], $iterationData = [])
    {

        if (count($iterationData) > 0)
            return $this->getMultiData($service_name, $data, $iterationData);
        else
            return$this->getOnceData($service_name, $data);
    }

    private function getOnceData ($service_name, $data = [])
    {
        return [];
    }

    private function getMultiData ($service_name, $data = [], $iterationData)
    {

        /**
         * Массив для созданных десрипторов Curl'a
         */
        $curls = [];

        /**
         * Массив для результатов каждого тарифа
         */
        $services = [];

        $mh = curl_multi_init();

        foreach($iterationData as $postalType){

            $data["mail-type"] = $postalType;

            $curls[$postalType] = curl_init($this->pochtaHost . $this->pochtaServices[ $service_name ]);

            curl_setopt($curls[$postalType], CURLOPT_POST, 1);

            curl_setopt($curls[$postalType], CURLOPT_HTTPHEADER, array(
                'Authorization: AccessToken '   . $this->apiToken,
                'X-User-Authorization: Basic '  . $this->clientKey,
                'Content-Type: application/json;charset=UTF-8'
            ));

            curl_setopt($curls[$postalType], CURLOPT_RETURNTRANSFER, true);

            curl_setopt($curls[$postalType], CURLOPT_POSTFIELDS, json_encode($data));

            /**
             * Добавляем текущий механизм к числу работающих параллельно
             */
            curl_multi_add_handle($mh, $curls[$postalType]);

        }

        /**
         * Инициируем число работающих процессов.
         */
        $running = null;

        /**
         * curl_mult_exec запишет в переменную running количество еще не завершившихся процессов.
         * Пока они есть - продолжаем выполнять запросы.
         */
        do { curl_multi_exec($mh, $running); } while($running > 0);

        /**
         * Собираем из всех созданных механизмов результаты, а сами механизмы удаляем
         */
        foreach ($curls as $data) {
            $result = curl_multi_getcontent($data);
            $result = json_decode($result, true);

            if( isset($result["total-rate"]) && $result["total-rate"] !== 0 ){
                $result['postal_type'] = $postalType;

                $services[] = $result;
            }

            curl_multi_remove_handle($mh, $data);
        }

        /**
         * Освобождаем память от механизма мультипотоков
         */
        curl_multi_close($mh);

        return $services;
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
            'id_response' => 'pochta_' . $this->destinationType,
            'type' => $this->destinationType
        ];

        foreach($data as $key => $value){
            switch($key) {
                case 'postal_type'  :
                    $response['service_id'] = $value;
                    break;
                case 'total-rate'   :
                    $response['price'][] = (int)($value / 100);
                    break;
                case 'delivery-time'  :
                    if(isset($value["min-days"]) && $value["min-days"] !== $value["max-days"] )
                        $response['days'][] = $value["min-days"] . '-' . $value["max-days"];
                    else
                        $response['days'][] = $value["max-days"];
                    break;
            }
        }

        $response['message'] = 'Pochta ' . $this->destinationType
            . ' Стоимость доставки: ' . $response['price'][0];

        if( !isset($response['days']))
            $response['days'][] = '~';
        else
            $response['message'] .= ' Срок доставки: ' . $response['days'][0];

        return $response;
    }

    private function getOptimalService($services){

        $cost = array_column($services, 'total-rate');

        array_multisort($cost, SORT_ASC, $services);

        return $services[0];
    }

}
