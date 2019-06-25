<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Model;
use App\Libraries\Geo\GeoLite;

class GeoData extends Model{

    private static $instance = null;

    public static function getInstance(){
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /** @return array */
    public function getGeoData(){

        return session()->get('geoInput', function() {

            if(session()->get('geoIp') === null){
                $this->setGeoIp();
            }
            return session()->get('geoIp');
        });
    }

    public function setGeoInput($json){

        if($json !== null){
            $objectData = json_decode($json);

            $geoData = [
                'postal_code'   => $objectData->postal_code,
                'country_code'  => $this->getCountryCode($objectData->country),
                'country_name'  => $objectData->country,
                'region_code'   => substr($objectData->region_kladr_id, 0, 2),
                'region_name'   => $objectData->region,
                'region_type'   => $objectData->region_type,
                'area_name'     => $objectData->area,
                'area_type'     => $objectData->area_type,
                'city_name'     => $objectData->city,
                'city_type'     => $objectData->city_type,
                'city_kladr_id' => $objectData->city_kladr_id,
                'street_name'   => $objectData->street,
                'street_type'   => $objectData->street_type,
                'latitude'      => $objectData->geo_lat,
                'longitude'     => $objectData->geo_lon,
            ];

            if($geoData['city_name'] === null){
                $geoData['city_name']       = $objectData->settlement;
                $geoData['city_type' ]      = $objectData->settlement_type;
                $geoData['city_kladr_id']   = $objectData->settlement_kladr_id;
            }

            session(['geoInput' => $geoData]);

        }

    }

    public function setGeoIp(){

        $ipAddress = $_SERVER['REMOTE_ADDR'];

        if($_SERVER['REMOTE_ADDR'] === '127.0.0.1'){

            //$ipAddress = '213.87.147.113'; //Москва
            //$ipAddress = '178.216.79.66'; //Белгород
            //$ipAddress = '92.37.241.243'; //Комсомольск-на-Амуре (Хабаровский край)
            $ipAddress = '94.243.63.255'; //Чита (Забайкальский край)

        }

        $geolite = new GeoLite();

        $objectData = $geolite->getGeoCity($ipAddress);

        $geoData = [
            'postal_code'   => $objectData->postal->code,
            'country_code'  => $objectData->raw['country']['iso_code'],
            'country_name'  => $objectData->country->names['ru'],
            'city_name'     => $objectData->city->names['ru'],
            'latitude'      => $objectData->location->latitude,
            'longitude'     => $objectData->location->longitude,
        ];

        if( isset( $objectData->subdivisions[0]->names['ru'] ) ){

            $regionData = $this->getRegionData($objectData->subdivisions[0]->names['ru']);

            $geoData = array_merge( $geoData, $regionData );

            session(['geoIp' => $geoData]);

        }else{

            session(['geoIp' => null]);// todo что отдавать, если geoIp NULL????

        }


    }

    private function getCountryCode($countryName){
        switch($countryName){
            case 'Россия'   : return 'RU';
            case 'Украина'  : return 'UA';
        }
    }

    private function getRegionData($fullRegionName){

        $regionTypes = [
            'АО' => 'АО', 'край' => 'край', 'Аобл' => 'Автономная область', 'обл' => 'область'
        ];

        $data = ['region_name' => $fullRegionName];

        foreach($regionTypes as $key => $type){
            if(mb_stripos($fullRegionName, ' '.$type) !== false){
                $data['region_name'] = mb_stristr($fullRegionName, ' '.$type, true);
                $data['region_type'] = $key;
            }
        }

        $data['region_code'] = $this->getRegionCodeByShortRegionName($data['region_name']);

        return $data;
    }

    private function getRegionCodeByShortRegionName($regionName){
        switch($regionName){
            case 'Адыгея'                   : return '01'; break;
            case 'Башкортостан'             : return '02'; break;
            case 'Бурятия'                  : return '03'; break;
            case 'Алтай'                    : return '04'; break;
            case 'Дагестан'                 : return '05'; break;
            case 'Ингушетия'                : return '06'; break;
            case 'Кабардино-Балкария'       : return '07'; break;
            case 'Калмыкия'                 : return '08'; break;
            case 'Карачаево-Черкессия'      : return '09'; break;
            case 'Карелия'                  : return '10'; break;
            case 'Коми'                     : return '11'; break;
            case 'Марий Эл'                 : return '12'; break;
            case 'Мордовия'                 : return '13'; break;
            case 'Саха (Якутия)'            : return '14'; break;
            case 'Северная Осетия'          : return '15'; break;
            case 'Татарстан'                : return '16'; break;
            case 'Тува'                     : return '17'; break;
            case 'Удмуртия'                 : return '18'; break;
            case 'Хакасия'                  : return '19'; break;
            case 'Чечня'                    : return '20'; break;
            case 'Чувашия'                  : return '21'; break;
            case 'Алтайский'                : return '22'; break;
            case 'Краснодарский'            : return '23'; break;
            case 'Красноярский'             : return '24'; break;
            case 'Приморский'               : return '25'; break;
            case 'Ставрополье'              : return '26'; break;
            case 'Хабаровский'              : return '27'; break;
            case 'Амурская'                 : return '28'; break;
            case 'Архангельская'            : return '29'; break;
            case 'Астраханская'             : return '30'; break;
            case 'Белгородская'             : return '31'; break;
            case 'Брянская'                 : return '32'; break;
            case 'Владимирская'             : return '33'; break;
            case 'Волгоградская'            : return '34'; break;
            case 'Вологодская'              : return '35'; break;
            case 'Воронежская'              : return '36'; break;
            case 'Ивановская'               : return '37'; break;
            case 'Иркутская'                : return '38'; break;
            case 'Калининградская'          : return '39'; break;
            case 'Калужская'                : return '40'; break;
            case 'Камчатский'               : return '41'; break;
            case 'Кемеровская'              : return '42'; break;
            case 'Кировская'                : return '43'; break;
            case 'Костромская'              : return '44'; break;
            case 'Курганская'               : return '45'; break;
            case 'Курская'                  : return '46'; break;
            case 'Ленинградская'            : return '47'; break;
            case 'Липецкая'                 : return '48'; break;
            case 'Магаданская'              : return '49'; break;
            case 'МО'                       : return '50'; break;
            case 'Мурманская'               : return '51'; break;
            case 'Нижегородская'            : return '52'; break;
            case 'Новгородская'             : return '53'; break;
            case 'Новосибирская'            : return '54'; break;
            case 'Омская'                   : return '55'; break;
            case 'Оренбургская'             : return '56'; break;
            case 'Орловская'                : return '57'; break;
            case 'Пензенская'               : return '58'; break;
            case 'Пермская'                 : return '59'; break; //Пермский Край
            case 'Псковская'                : return '60'; break;
            case 'Ростовская'               : return '61'; break;
            case 'Рязанская'                : return '62'; break;
            case 'Самарская'                : return '63'; break;
            case 'Саратовская'              : return '64'; break;
            case 'Сахалин'                  : return '65'; break;
            case 'Свердловская'             : return '66'; break;
            case 'Смоленская'               : return '67'; break;
            case 'Тамбовская'               : return '68'; break;
            case 'Тверская'                 : return '69'; break;
            case 'Томская'                  : return '70'; break;
            case 'Тульская'                 : return '71'; break;
            case 'Тюмень'                   : return '72'; break;
            case 'Ульяновская'              : return '73'; break;
            case 'Челябинская'              : return '74'; break;
            case 'Забайкальский'            : return '75'; break;
            case 'Ярославская'              : return '76'; break;
            case 'Москва'                   : return '77'; break;
            case 'Санкт-Петербург'          : return '78'; break;
            case 'Еврейская'                : return '79'; break;
            case 'Крым'                     : return '82'; break; //???
            case 'Ненецкий'                 : return '83'; break;
            case 'Ханты-Мансийский'         : return '86'; break;
            case 'Чукотский'                : return '87'; break;
            case 'Ямало-Ненецкий'           : return '89'; break;
            case 'Севастополь'              : return '91'; break;
            default : return null;

        }
    }

}