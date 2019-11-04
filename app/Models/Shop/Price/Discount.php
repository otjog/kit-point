<?php

namespace App\Models\Shop\Price;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model{

    public function products(){
        return $this->belongsToMany('App\Models\Shop\Product\Product', 'product_has_discount')->withPivot('value')->withTimestamps();
    }

    public function price()
    {
        return $this->belongsTo(    'App\Models\Shop\Price\Price');
    }
}
