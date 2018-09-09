<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model{

    protected $table = 'currency';

    public function getCurrencyIdByCode($code){
        return self::select('id', 'name', 'char_code', 'value')
            ->where('char_code', $code)
            ->get();
    }

    public function getCurrencyIdById($id){
        return self::select('id', 'name', 'char_code', 'value')
            ->where('id', $id)
            ->get();
    }

    public function getAllCurrencies(){
        return self::select('id', 'name', 'char_code', 'value')
            ->get();
    }

}
