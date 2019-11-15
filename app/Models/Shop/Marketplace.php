<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use App\Models\Shop\Product\Product;

class Marketplace extends Model
{

    protected $table = 'shop_marketplaces';

    public function products(){
        return $this->belongsToMany('App\Models\Shop\Product\Product', 'shop_marketplace_has_product')->withTimestamps();
    }

}
