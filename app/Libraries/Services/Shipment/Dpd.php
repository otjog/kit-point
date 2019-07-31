<?php

namespace App\Libraries\Services\Shipment;

use App\Libraries\Services\Shipment\Contracts\ShipmentServices;
use SoapClient;
use Exception;

class Dpd implements ShipmentServices
{
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

    private $dpdOptions = [
        'ОЖД' => [
            'desc' => 'Примерка/проверка',
            'params' => [
                'reason_delay' => [
                    'ПРОС' => 'Внешний осмотр',
                    'ПРИМ' => 'С примеркой',
                    'РАБТ' => 'Проверка работоспособности',
                ]
            ]
        ],
        'НПП' => [
            'desc' => 'Наложенный платеж',
            'params' => [
                'sum_npp' => 'Макс.сумма'
            ]
        ],
        'ТРМ' => [
            'desc' => 'Температурный режим'
        ],
        'Payment' => [
            'desc' => 'Оплата наличными'
        ],
        'PaymentByBankCard' => [
            'desc' => 'Оплата картой'
        ],
        'SelfPickup' => [], // если нет значения desc, то не будет учитываться в опциях
        'SelfDelivery' => []
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

    public function getDeliveryCost ($parcelData, $destinationType)
    {
        $this->destinationType = $destinationType;

        switch ($this->destinationType) {
            case 'toTerminal' :
                $selfDelivery = true;
                break;
            case 'toDoor' :
                $selfDelivery = false;
                break;
        }

        $services = $this->getServiceCost($parcelData, $selfDelivery);

        if ($services !== false && count($services) > 0) {

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
                'title' => $this->getNamePoint($point->brand, $point->parcelShopType),
                'address' => $this->getAddressPoint($point->address),
                'timeTable' => $this->getTimeTablePoint($point->schedule),
                'options' => $this->getOptionsPoint($point->extraService, $point->schedule),
            ];

            $data[] = [
                'geoCoordinates' => $point->geoCoordinates,
                'markerInfo' => view('_kp.modules.shop.shipment._elements.marker', ['point' => $dataMarker])->render(),
            ];
        }

        return $data;
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

    private function getServiceCost($parcelData, $selfDelivery = true, $serviceCode = null){

        $data = [
            'pickup' => [
                'cityName'      => $this->pickUpCity,
                'regionCode'    => $this->pickUpRegionCode,
                'countryCode'   => $this->pickUpCountryCode
            ],
            'delivery' => $this->geoData,
            'selfPickup' => true, //Доставка от терминала
            'selfDelivery' => $selfDelivery, //Доставка До терминала
            'parcel' => $parcelData['parcel'],
            'declaredValue' => $parcelData['declaredValue']
        ];

        if($serviceCode !== null){
            $data['serviceCode'] = $serviceCode;
        }

        $services = $this->getDpdData( 'getServiceCostByParcels2', $data );

        return $services;

    }

    private function connectDpd($method_name)
    {
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
            'id_response' => 'dpd_' . $this->destinationType,
            'message' => 'DPD' . $this->destinationType,
            'type' => $this->destinationType
        ];

        foreach($data as $key => $value){
            switch($key){
                case 'serviceCode' :
                    $response['service_id'] = $value;
                    break;
                case 'days' :
                    $response['days'][] = $value;
                    $response['message'] .= ' Срок доставки: ' . $value;
                    break;
                case 'cost' :
                    $response['price'][] = round($value, 0);
                    $response['message'] .= ' Стоимость доставки: ' . $value;
                    break;
            }
        }

        return $response;
    }

    private function setErrorMessage(Exception $ex, $data){

        //todo отслеживать ошибки

    }

    private function getAddressPoint($addressObj)
    {
        $address = '';
        if (isset($addressObj->cityName))
            $address .= $addressObj->cityName . ', ';
        if (isset($addressObj->streetAbbr))
            $address .= $addressObj->streetAbbr . '.';
        if (isset($addressObj->street))
            $address .= $addressObj->street . ' ';
        if (isset($addressObj->houseNo))
            $address .= 'д.' . $addressObj->houseNo . ' ';
        if (isset($addressObj->building))
            $address .= 'корп.' . $addressObj->building;
        if (isset($addressObj->structure))
            $address .= 'стр.' . $addressObj->structure;
        if (isset($addressObj->ownership))
            $address .= 'влад.' . $addressObj->ownership;
        return $address;

    }

    private function getTimeTablePoint($pointSchedule)
    {
        $timeTable = [];
        if (is_array($pointSchedule)) {
            $shedulesArray = $pointSchedule;
        } else {
            $shedulesArray[] = $pointSchedule;
        }

        foreach ($shedulesArray as $schedule) {
            if ($schedule->operation === "SelfDelivery") {

                $timeTableArray = [];

                if (is_array($schedule->timetable))
                    $timeTableArray = $schedule->timetable;
                else
                    $timeTableArray[] = $schedule->timetable;


                foreach ($timeTableArray as $daysRange) {
                    $days = explode(',', $daysRange->weekDays);
                    foreach ($days as $day) {
                        $timeTable[] = [
                            'day' => $day,
                            'time' => $daysRange->workTime
                        ];
                    }
                }
            }
        }

        return $timeTable;
    }

    private function getOptionsPoint($services, $schedule)
    {
        $data = [];
        foreach ($services as $service) {
            $dataService = [];
            if(is_object($service)){
                $dataService['desc'] = $this->dpdOptions[$service->esCode]['desc'];
                if (isset($this->dpdOptions[$service->esCode]['params'])) {

                    foreach ($this->dpdOptions[$service->esCode]['params'] as $key=>$param) {
                        if ($service->params->name === $key) {
                            if (is_array($this->dpdOptions[$service->esCode]['params'][$key])) {

                                $values = explode(', ', $service->params->value);

                                foreach ($values as $value) {
                                    $dataService['params'][] = $this->dpdOptions[$service->esCode]['params'][$key][$value];
                                }

                            } else {
                                $dataService['params'][$param] = $service->params->value;
                            }
                        }
                    }


                }
                $data[] = $dataService;
            }
        }

        if (isset($schedule->operation))
            $scheduleArrayService = [$schedule];
        else
            $scheduleArrayService = $schedule;

        foreach ($scheduleArrayService as $serviceSchedule) {
            if (is_object($serviceSchedule)) {
                if (isset($this->dpdOptions[$serviceSchedule->operation]['desc'])) {
                    $data[] = [
                        'desc' => $this->dpdOptions[$serviceSchedule->operation]['desc']
                    ];
                }
            }
        }
        return $data;
    }

    private function getNamePoint($brand, $type)
    {
        $title = 'DPD';
        if($brand !== 'DPD'){
            if($type === 'П')
                $title .= ' : Постамат - '. $brand;
            else
                $title .= ' : Партнер - '. $brand;
        } else {
            $title .= ' : Основной терминал';
        }
        return $title;
    }

}
