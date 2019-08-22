<?php

namespace App\Models\Shop\Store;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $table = 'shop_stores';

    public function products(){
        return $this->belongsToMany('App\Models\Shop\Product\Product', 'shop_store_has_product')->withPivot('quantity')->withTimestamps();
    }

}
