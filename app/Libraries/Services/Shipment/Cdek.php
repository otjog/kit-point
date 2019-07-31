<?php

namespace App\Libraries\Services\Shipment;

use App\Libraries\Services\Shipment\Contracts\ShipmentServices;
use SimpleXMLElement;

class Cdek implements ShipmentServices
{
    private $test;

    private $clientAuthData;

    private $senderCityPostCode;

    private $cdekServices = [
        //расчет стоимости доставки по параметрам посылок по России и странам ТС.
        'calculate'      => [
            'host'      => 'https://api.cdek.ru',
            'url'       => '/calculator/calculate_tarifflist.php',
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
        ],
        'cities'      => [
            'host'      => 'https://integration.cdek.ru',
            'url'       => '/v1/location/cities/json',
            'method'    => 'GET'
        ],

    ];

    private $message;

    private $geoData;

    private $destinationType;

    private $tariffsOfAllDestination = [
        'toTerminal' => [
            ['id' => '136'],
            ['id' => '5'],
            ['id' => '10'],
            ['id' => '15'],
            ['id' => '62'],
            ['id' => '63'],
            ['id' => '234'],
            ['id' => '291'],
        ],
        'toDoor' => [
            ['id' => '137'],
            ['id' => '12'],
            ['id' => '16'],
            ['id' => '233'],
            ['id' => '294'],
        ],
    ];

    public function __construct($geoData)
    {
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

    public function getDeliveryCost($parcelData, $destinationType)
    {
        $this->destinationType = $destinationType;

        $parcelData['parcel'] = $this->getParcelParameters($parcelData['parcel']);

        $tariffList = $this->tariffsOfAllDestination[$this->destinationType];

        $services = $this->getServiceCost($parcelData, $tariffList);

        if( count($services) > 0 ){

            $optimalService = $this->getOptimalService($services);

            return $this->prepareResponse($optimalService);

        }

        return null;
    }

    public function getPointsInCity()
    {
        $data = [];

        $points = $this->getParcelShops();

        foreach ($points as $point) {
            $dataMarker = [
                'title' => $this->getNamePoint($point),
                'address' => $this->getAddressPoint($point->City, $point->Address),
                'timeTable' => $this->getTimeTablePoint($point->WorkTime),
                'options' => $this->getOptionsPoint($point),
            ];

            $data[] = [
                'geoCoordinates' => $this->getGeoCoordinates($point->coordX, $point->coordY),
                'markerInfo' => view('_kp.modules.shop.shipment._elements.marker', ['point' => $dataMarker])->render(),
            ];
        }

        return $data;
    }

    private function getServiceCost($parcelData, $tariffList)
    {
        $date = date('Y-m-d');

        $clientAuthData = $this->clientAuthData[ $this->test ];

        $data = [
            "version"               => "1.0",
            "dateExecute"           => $date,
            "authLogin"             => $clientAuthData['Account'],
            "secure"                => md5($date . '&' . $clientAuthData['Secure_password']),
            "senderCityPostCode"    => $this->senderCityPostCode,
            "receiverCityPostCode"  => $this->geoData['receiverCityPostCode'],
            "receiverCityId"        => $this->geoData['receiverCityId'],
            "goods"                 => $parcelData['parcel'],
            'tariffList'            => $tariffList,
            "services"              =>
                [
                    [
                        "id" => "2",
                        "param"=> $parcelData['declaredValue']
                    ]
                ]
        ];

        $services = [];

        $rawResult = $this->getCdekData('calculate', $data);

        $results = json_decode($rawResult, true);

        if ($results !== null && isset($results['result'])) {
            foreach($results['result'] as $service){

                if ($service['status']) {
                    $services[] = $service['result'];
                }

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

        foreach ($rawPoints as $key=> $point) {
            $points[] = $point->attributes();
        }

        return $points;

    }

    private function getRegionCode(){

        $xmlRegionsData = $this->getCdekData('regions');

        $regions = new SimpleXMLElement($xmlRegionsData);

        $region = $regions->xpath("//Region[@regionCodeExt=" . $this->geoData['regionCodeExt'] ."]");

        if (isset($region[0]['regionCode']))
            return $region[0]['regionCode'];
        return null;
    }

    private function getCityCdekId($cdekGeoData)
    {
        $jsonData = $this->getCdekData('cities', $cdekGeoData);
        $cityParam = json_decode($jsonData);

        if (isset($cityParam[0]->cityCode))
            return $cityParam[0]->cityCode;
        return null;
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

    private function getParcelParameters($parcelParameters)
    {
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
                case 'postal_code'  :
                    $data['receiverCityPostCode'] = $paramValue;
                    break;
                case 'region_code'  :
                    $data['regionCodeExt'] = $paramValue;
                    break;
                case 'city_name'  :
                    $data['cityName'] = $paramValue;
                    break;
                case 'country_code'  :
                    $data['countryCode'] = $paramValue;
                    break;
            }

        }

        $data['receiverCityId'] = $this->getCityCdekId($data);

        return $data;

    }

    private function prepareResponse($data){

        $response = [
            'id_response' => 'cdek_' . $this->destinationType,
            'type' => $this->destinationType
        ];

        foreach($data as $key => $value){
            switch($key){
                //Calculate
                case 'tariffId' :
                    $response['service_id'] = $value;
                    break;
                case 'priceByCurrency' :
                    $response['price'][] = round($value, 0);
                    break;
                case 'deliveryPeriodMin' :
                case 'deliveryPeriodMax' :
                    if( isset($response['days']) ){
                        if($response['days'][0] !== (string)$value){

                            $response['days'][0] .= '-' . $value;
                        }
                    }else{
                        $response['days'][] = (string)$value;
                    }
                    break;
                case 'services' :
                    foreach ($value as $service) {
                        $response['price'][0] += round($service['price'],0);
                    }
                    break;
            }
        }

        $response['message'] = 'CDEK ' . $this->destinationType
            . ' Срок доставки: ' . $response['days'][0]
            . ' Стоимость доставки: ' . $response['price'][0];

        return $response;
    }

    private function getQuery($parameters){
        $query = '?';

        foreach($parameters as $key => $value){

            if ($value !== '' && $value !== null) {
                if($query !== '?')
                    $query .= '&';

                $query .= $key . '=' . urlencode($value);
            }

        }

        return $query;
    }

    private function getAddressPoint($city, $address)
    {
        $address = $city . ', ' . $address;

        return $address;
    }

    private function getTimeTablePoint($schedule)
    {
        $timeTable = [];

        $timeTableArray = explode(', ', $schedule);

        $weekDaysArray = [
            'Пн' => 0,
            'Вт' => 1,
            'Ср' => 2,
            'Чт' => 3,
            'Пт' => 4,
            'Сб' => 5,
            'Вс' => 6,
        ];

        foreach ($timeTableArray as $rangeArray) {

            list($days, $workTime) = explode(' ', $rangeArray);

            $daysArray = explode('-', $days);

            if (count($daysArray) === 1) {
                $daysArray[1] = $daysArray[0];
            }

            $startDay = $daysArray[0]; //Пт
            $endDay = $daysArray[1]; //Вс

            $startIndex = $weekDaysArray[$startDay]; //4
            $endIndex = $weekDaysArray[$endDay]; //6

            for ($i = $startIndex; $i <= $endIndex; $i++) {

                $dayName = array_search($i, $weekDaysArray);

                $timeTable[$i] = [
                    'day' => $dayName,
                    'time' => $workTime
                ];
            }

        }

        if (count($timeTable) < 7) {
            for ($i=0; $i <=6; $i++) {
                if (!isset($timeTable[$i])) {
                    $dayName = array_search($i, $weekDaysArray);
                    $timeTable[$i] = [
                        'day' => $dayName,
                        'time' => 'Выходной'
                    ];
                }
            }
        }

        return $timeTable;
    }

    private function getGeoCoordinates($coordX, $coordY)
    {
        return [
            'longitude' => (string)json_decode($coordX),
            'latitude' => (string)json_decode($coordY),
        ];
    }

    private function getOptionsPoint($point)
    {
        $data = [];

        if($point->isDressingRoom)
            $data[] = ['desc'=>'Примерка/Проверка'];
        if($point->AllowedCod)
            $data[] = ['desc'=>'Наложенный платеж'];
        if($point->HaveCashless)
            $data[] = ['desc'=>'Оплата картой'];
        $data[] = ['desc'=>'Оплата наличными'];

        return $data;
    }

    private function getNamePoint($point)
    {
        $title = 'CDEK : ';
        if($point->Type == 'PVZ')
            $title .= 'Пункт выдачи ';
        elseif($point->Type == 'POSTOMAT')
            $title .= 'Постомат ';

        if($point->ownerCode === 'InPost')
            $title .= 'InPost ';

        return $title;
    }

    private function getOptimalService($services){

        $cost = array_column($services, 'priceByCurrency');

        array_multisort($cost, SORT_ASC, $services);

        return $services[0];
    }
}
