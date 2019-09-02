<?php

namespace App\Models\Shop\Offer;

use Illuminate\Database\Eloquent\Model;
use App\Models\Shop\Product\Product;

class Offer extends Model{

    protected $moduleMethods = [
        'show' => 'getActiveOfferByName',
    ];

    public function getModuleMethods($moduleMethod)
    {
        return $this->moduleMethods[$moduleMethod];
    }

    protected $table = 'shop_offers';

    public function products()
    {
        return $this->belongsToMany('App\Models\Shop\Product\Product', 'shop_offer_has_product', 'offer_id', 'product_id')
            ->withTimestamps();
    }

    //TODO поле name сделать уникальным
    public function getActiveOffers(){

        return self::select(
            'id',
            'name',
            'header',
            'related'
        )
            ->where('active', 1)
            ->get();

    }

    public function getProductsOffers($take = 10)
    {
        $offers = $this->getActiveOffers();

        return $this->addProductsToOffers($offers, $take);

    }

    public function getActiveOfferByName($name, $take = 6){

        $offers = self::select(
            'id',
            'name',
            'header',
            'related'
        )
            ->where('active', 1)
            ->where('name', $name)
            ->get();

        return $this->addProductsToOffers($offers, $take);

    }

    protected function addProductsToOffers($offers, $take)
    {
        $newOffers = collect();

        $products = new Product();

        foreach($offers as $offer){

            if($offer->related){
                /*Выводит товары из предложения созданного нами*/
                $offerProducts = $products->getCustomProductsOffer($offer->id, $take);

                $offer->relations = ['products' => $offerProducts];

            }else{
                /*Выводит товары из предложения созданного автоматически*/
                $offerProducts = $products->getProductsPrepareOffer($offer->name, $take);

                $offer->relations = ['products' => $offerProducts];
            }

            $newOffers->put($offer->name, $offer);
        }

        unset($offers);

        return $newOffers;
    }
}
