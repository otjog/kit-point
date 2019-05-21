<?php

namespace App\Models;

use App\Models\Shop\Price\Currency;
use App\Models\Shop\Price\Price;
use Illuminate\Support\Facades\Cache;

class Settings {

    private static $instance = null;

    private $currency;

    private $price;

    public $data;

    public static function getInstance(){
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct(){

        $this->currency = new Currency();

        $this->price = new Price();

        $this->data = config('global-data');

        $this->data['global_data']['components']['shop']['currency'] =
            Cache::rememberForever('config:general:components:shop:currency', function()  {
                return $this->currency
                    ->select('id', 'char_code', 'symbol')
                    ->where('main', '1')
                    ->first();
            });

        $this->data['global_data']['components']['shop']['price'] =
            $this->price
                ->select('id', 'name')
                ->where('name', 'retail')
                ->first();
    }

    private function __clone(){}

    public function addParameter($name, $value){

        $nameArray = explode('.', $name);

        $max = count($nameArray)-1;
        if ($max === 0) {
            $this->data[$name] = $value;
        } else {
            $result = array($nameArray[$max] => $value);
            for($i=$max-1; $i>0; $result = array($nameArray[$i--] => $result));

            $this->data[$nameArray[0]] = $result;
        }

    }

    public function issetParameter($path){
        return false;
    }

    public function getParameters(){
       return $this->data;
    }

    public function getParameter($path){

        $path =  'global_data.' . $path;

        $data = $this->getParameters();

        $pathArray = explode('.', $path);

        $temporary = [];

        foreach( $pathArray as $key => $level ){

            if($key === 0)
                $temporary = $data;

            if(isset($temporary[$level])){

                if($key+1 === count($pathArray))
                    return $temporary[$level];
                else
                    $temporary = $temporary[$level];
            } else {
                return null;
            }



        }

    }

}