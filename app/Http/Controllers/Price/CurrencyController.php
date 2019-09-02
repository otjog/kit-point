<?php

namespace App\Http\Controllers\Price;

use App\Models\Shop\Price\Currency;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CurrencyController extends Controller{

    private $url = 'http://www.cbr.ru/scripts/XML_daily.asp';

    public function getCur(){

        $xmlString = $this->connectToSite();

        $sxml = simplexml_load_string($xmlString);

        $currencyModel = new Currency();

        $currencies = $currencyModel->getAllCurrencies();

        foreach ($sxml->Valute as $XmlCurrency){

            foreach ($currencies as $BdCurrency) {
                /* Через if сравнение не срабатывает*/
                switch($XmlCurrency->CharCode){
                    case $BdCurrency->char_code : $this->updateCur($XmlCurrency); break;
                }
            }

        }

    }

    private function connectToSite(){
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    private function updateCur($curXml){
        $cur = DB::table('currency')->where('char_code', $curXml->CharCode)->first();

        $time = time();

        $nominal = (int)$curXml->Nominal;

        $value = (float)str_replace(',', '.', $curXml->Value) / $nominal;

        if($cur === null){
            DB::table('currency')->insert(
                [
                    'name' => $curXml->Name,
                    'char_code' => $curXml->CharCode,
                    'value' => $value,
                    'created_at' => date('Y-m-d H:i:s',$time),
                    'updated_at' => date('Y-m-d H:i:s',$time)
                ]
            );
        }else{
            DB::table('currency')
                ->where('char_code', $curXml->CharCode)
                ->update(['value' => $value, 'updated_at' => date('Y-m-d H:i:s',$time)]);
        }

    }
}
