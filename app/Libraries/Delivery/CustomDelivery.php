<?php

namespace App\Libraries\Delivery;

use App\Models\Shop\Product\Product;

class CustomDelivery {

    protected $product;

    protected $productIds;

    public function __construct($geoData, $productIds)
    {
        $this->productIds = explode('|', $productIds);

        $this->product = new Product();

    }

    public function getDeliveryCost($parcelParameters, $destinationType)
    {
        /*
         * Мы создали параметр товара: Бесплатная доставка _free_ship_
         * Если у товара есть этот параметр, то:
         *   - на странице товара в калькуляторе доставки появится еще одно поле с доставкой До терминала за 0руб.
         *   - на странице оформление заказа доставка за 0руб. появится если хотя бы у одного из заказанных товаров есть параметр бесплатной доставки
         * Пока так!)
         */
        if($destinationType === 'toTerminal'){

            if($this->existsFreeShipProduct()){
                return [
                    "type" => "toTerminal",
                    "price" => 0,
                    "days" => "~",
                    "service_id" => "free"
                ];
            }
        }
        return [];
    }

    public function getPointsInCity()
    {
        return [];
    }

    private function existsFreeShipProduct()
    {
        $products = $this->product
            ->whereIn('id', $this->productIds)
            ->whereHas('parameters', function ($query) {
                $query->where('alias', '_free_delivery_');
            })
            ->get();

         return count($products);
    }

}
