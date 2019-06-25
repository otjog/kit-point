<?php

namespace App\Models\Shop\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use JustBetter\PaginationWithHavings\PaginationWithHavings;
use App\Models\Settings;

class Product extends Model{

    use PaginationWithHavings;

    /******/

    protected $fillable = ['brand_id', 'category_id', 'manufacturer_id', 'active', 'name', 'scu'];

    protected $settings;

    protected $price_id;

    protected $pagination;

    protected $today;

    /***Relations***/

    public function __construct(array $attributes = []){
        parent::__construct($attributes);

        $settings = Settings::getInstance();

        $this->price_id = $settings->getParameter('components.shop.price.id');

        $this->pagination = $settings->getParameter('components.shop.pagination');

        $this->today = $settings->getParameter('today');

    }

    public function images()
    {
        return $this->morphToMany('App\Models\Site\Image', 'imageable');
    }

    public function category()
    {
        return $this->belongsTo(    'App\Models\Shop\Category\Category');
    }

    public function manufacturer()
    {
        return $this->belongsTo(    'App\Models\Shop\Product\Manufacturer');
    }

    public function prices()
    {
        return $this->belongsToMany('App\Models\Shop\Price\Price', 'product_has_price')->withPivot('value', 'currency_id')->withTimestamps();
    }

    public function discounts()
    {
        return $this->belongsToMany('App\Models\Shop\Price\Discount', 'product_has_discount')->withPivot('value')->withTimestamps();
    }

    public function parameters()
    {
        return $this->belongsToMany('App\Models\Shop\Parameter\Parameter', 'product_has_parameter', 'product_id', 'parameter_id')->withPivot('id', 'value')->withTimestamps();
}

    public function basket_parameters()
    {
        return $this->belongsToMany('App\Models\Shop\Parameter\Parameter', 'product_has_parameter', 'product_id', 'parameter_id')->withPivot('id', 'value', 'basket_value')->withTimestamps();
    }

    public function baskets()
    {
        return $this->belongsToMany('App\Models\Shop\Order\Basket', 'shop_basket_has_product', 'product_id', 'basket_id')->withPivot('quantity', 'order_attributes')->withTimestamps();
    }

    public function offers()
    {
        return $this->belongsToMany('App\Models\Shop\Offer\Offer', 'shop_offer_has_product', 'product_id', 'offer_id')->withTimestamps();
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\Shop\Order\Order', 'shop_order_has_product', 'product_id', 'order_id')
            ->withPivot('quantity', 'price_id', 'currency_id', 'price_value', 'order_attributes')
            ->withTimestamps();
    }

    /***Function***/
    public function getAllProducts(){
        return self::select(
            'products.id',
            'products.category_id',
            'products.active',
            'products.name',
            'products.original_name',
            'products.scu',
            'products.description',
            'products.unique'
        )
            ->orderBy('name')
            ->get();
    }

    public function getActiveProduct($id){

        $productsQuery = $this->getOneProductQuery();

        $products = $productsQuery
            ->where('products.id', '=', $id)

            ->where('products.active', '=', 1)

            ->get();

            if( isset($products[0])){
                $products = $this->addRelationCollections($products);

                return $products[0];
            }else{
                return null;
            }

    }

    public function getActiveProductsFromCategory($category_id){

        $productsQuery = $this->getListProductQuery();

        $products = $productsQuery

            ->where('products.active', 1)

            ->where('products.category_id', $category_id)

            ->orderBy('products.name')

            ->paginate($this->pagination);

        return $this->addRelationCollections($products);

    }

    public function getActiveProductsWithFilterParameters($routeData){

        $products = self::select(
            'products.id',
            'product_has_price.value        as price|pivot|value',
            'manufacturers.id               as manufacturer|id',
            'manufacturers.name             as manufacturer|name',
            'categories.id                  as category|id',
            'categories.name                as category|name',

            DB::raw(
                'CASE discounts.type
                           WHEN "percent"
                                    THEN ROUND( ( product_has_price.value - (product_has_price.value / 100 * product_has_discount.value) ) * currency.value )
                           WHEN "value"
                                    THEN ROUND( (product_has_price.value * currency.value) - product_has_discount.value )
                           ELSE ROUND( product_has_price.value * currency.value )
                        END AS "price|value" '
            ),
            DB::raw(
                'CASE discounts.type
                           WHEN "percent"
                                    THEN ROUND( product_has_price.value / 100 * product_has_discount.value * currency.value )
                           WHEN "value"
                                    THEN ROUND( product_has_discount.value * currency.value )
                           ELSE 0
                        END AS "price|sale" '
            )
        );

        switch (key($routeData)) {
            case 'category' :
                $categoryId = (int)$routeData[ key($routeData) ];
                $products = $products->where( 'products.category_id', $categoryId);
                break;
            case 'brand'    :
                $brandName = $routeData[ key($routeData) ];
                $products = $products
                    ->rightJoin('product_has_parameter', function ($join) use ($brandName) {
                    $join->on('products.id', '=', 'product_has_parameter.product_id')
                        ->where('product_has_parameter.value', '=', $brandName);
                })
                    ->rightJoin('product_parameters','product_parameters.id', '=', 'product_has_parameter.parameter_id');
        }

        $products = $products->where('products.active', 1)

            /************PRICE*******************/
            ->leftJoin('product_has_price', function ($join) {
                $join->on('products.id', '=', 'product_has_price.product_id')
                    ->where('product_has_price.active', '=', '1')
                    ->where('product_has_price.price_id', '=', $this->price_id);
            })
            ->leftJoin('prices','prices.id', '=', 'product_has_price.price_id')

            /************CURRENCY****************/
            ->leftJoin('currency', 'currency.id', '=', 'product_has_price.currency_id')

            /************DISCOUNT****************/
            ->leftJoin('product_has_discount', 'products.id', '=', 'product_has_discount.product_id')
            ->leftJoin('discounts', function ($join) {
                $join->on('discounts.id', '=', 'product_has_discount.discount_id')
                    ->where('discounts.active', '=', '1')
                    ->whereDate('to_date', '>=', $this->today);
            })

            /************PARAMETER***************/
            ->with('parameters')

            /************MANUFACTURER***********/
            ->leftJoin('manufacturers', 'manufacturers.id', '=', 'products.manufacturer_id')

            /************CATEGORY***************/
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')

            ->orderBy('products.name')

            ->get();

        return $this->addRelationCollections($products);

    }

    public function getFilteredProducts($routeData, $filterData){

        $productsQuery = $this->getListProductQuery();

        $products = $productsQuery

            ->where('products.active', 1);

        switch (key($routeData)) {
            case 'category' :
                $categoryId = (int)$routeData[ key($routeData) ];
                $products = $products->where( 'products.category_id', $categoryId);
                break;
            case 'brand'    :
                $brandName = $routeData[ key($routeData) ];
                $products = $products
                    ->rightJoin('product_has_parameter', function ($join) use ($brandName) {
                        $join->on('products.id', '=', 'product_has_parameter.product_id')
                            ->where('product_has_parameter.value', '=', $brandName);
                    })
                    ->rightJoin('product_parameters','product_parameters.id', '=', 'product_has_parameter.parameter_id');
        }

        //WHEN's
        $products = $products
            /************PRICE*******************/
            ->when(isset($filterData['price']), function ($query) use ($filterData) {

                list($min, $max) = (explode('|', $filterData['price']));

                return $query->having('price|value', '>=', ($min))
                    ->having('price|value', '<=', ($max));

            })

            /************MANUFACTURER***********/
            ->when(isset($filterData['manufacturer']), function ($query) use ($filterData) {
                return $query->whereIn('products.manufacturer_id', explode('|', $filterData['manufacturer']));
            })

            /************CATEGORY***************/
            ->when(isset($filterData['category']), function ($query) use ($filterData) {
                return $query->whereIn('products.category_id', explode('|', $filterData['category']));
            });

            /************PARAMETERS*************/
            foreach($filterData as $key => $parameter){

                if(strpos($key, 'p_') === 0){
                    $key = str_replace('p_', '', $key);

                    $products = $products->whereHas('parameters', function($query) use ($parameter, $key) {
                        $query->where('product_parameters.alias', '=', $key)
                            ->whereIn('product_has_parameter.value', explode('|', $parameter));
                    });
                }

            }

            $products = $products->with('parameters')

                ->orderBy('products.name')

                ->paginate($this->pagination);

        return $this->addRelationCollections($products);

    }

    public function getActiveProductsOfBrand($brandName){

        $productsQuery = $this->getListProductQuery();

        $products = $productsQuery
            ->addSelect(
                'product_parameters.name        as parameters|name',
                'product_parameters.alias       as parameters|alias',
                'product_has_parameter.value    as parameters|pivot|value',
                'product_has_parameter.basket_value    as parameters|pivot|basket_value'
            )
            ->where('products.active', 1)

            /************PARAMETERS*************/
            ->rightJoin('product_has_parameter', function ($join) use ($brandName) {
                $join->on('products.id', '=', 'product_has_parameter.product_id')
                    ->where('product_has_parameter.value', '=', $brandName);
            })
            ->rightJoin('product_parameters','product_parameters.id', '=', 'product_has_parameter.parameter_id')

            ->orderBy('products.name')

            ->paginate($this->pagination);

        return $this->addRelationCollections($products);

    }

    public function getProductsById($idProducts){

        $productsQuery = $this->getListProductQuery();

        $products = $productsQuery

            ->whereIn('products.id', $idProducts)

            ->where('products.active', 1)

            ->orderBy('products.name')

            ->paginate($this->pagination);

        return $this->addRelationCollections($products);

    }

    public function getProductsFromBasket($basket_id){

        $productsQuery = $this->getListProductQuery();

        $products =  $productsQuery->addSelect(
            'products.weight',
            'products.length',
            'products.width',
            'products.height',
            'shop_basket_has_product.basket_id          as pivot|basket_id',
            'shop_basket_has_product.product_id         as pivot|product_id',
            'shop_basket_has_product.quantity           as pivot|quantity',
            'shop_basket_has_product.order_attributes   as pivot|order_attributes'
        )
            ->where('products.active', 1)

            /************IN_BASKET**************/
            ->join('shop_basket_has_product', function ($join) use ($basket_id) {
                $join->on('products.id', '=', 'shop_basket_has_product.product_id')
                    ->where('shop_basket_has_product.basket_id', $basket_id);
            })
            ->join('shop_baskets', 'shop_baskets.id', '=', 'shop_basket_has_product.basket_id')

            ->orderBy('shop_basket_has_product.id')

            ->get();

        $products = $this->addRelationCollections($products);

        return $this->addSelectedOrderAttributeToPivot($products, 'basket');
    }

    public function getProductsFromOrder($order_id)
    {
        $products =  self::select(
            'products.id',
            'products.manufacturer_id',
            'products.category_id',
            'products.name',
            'products.original_name',
            'products.scu',
            'products.weight',
            'products.length',
            'products.width',
            'products.height',
            'prices.id                      as price|id',
            'prices.name                    as price|name',
            'currency.value                 as price|pivot|currency_value',
            'currency.char_code             as price|pivot|currency_code',
            'currency.id                    as price|pivot|currency_id',
            'manufacturers.id               as manufacturer|id',
            'manufacturers.name             as manufacturer|name',
            'shop_order_has_product.order_id           as pivot|order_id',
            'shop_order_has_product.product_id         as pivot|product_id',
            'shop_order_has_product.quantity           as pivot|quantity',
            'shop_order_has_product.price_id           as pivot|price_id',
            'shop_order_has_product.currency_id        as pivot|currency_id',
            'shop_order_has_product.price_value        as price|value',
            'shop_order_has_product.order_attributes   as pivot|order_attributes'
        )

            /************IN_ORDER**************/
            ->join('shop_order_has_product', function ($join) use ($order_id) {
                $join->on('products.id', '=', 'shop_order_has_product.product_id')
                    ->where('shop_order_has_product.order_id', $order_id);
            })
            ->join('shop_orders', 'shop_orders.id', '=', 'shop_order_has_product.order_id')

            /************PRICE*******************/
            ->leftJoin('prices','prices.id', '=', 'shop_order_has_product.price_id')

            /************CURRENCY****************/
            ->leftJoin('currency', 'currency.id', '=', 'shop_order_has_product.currency_id')

            /************MANUFACTURER***********/
            ->leftJoin('manufacturers', 'manufacturers.id', '=', 'products.manufacturer_id')

            /************PARAMETERS*************/
            ->with(['basket_parameters' => function ($query) {
                $query->where('product_parameters.order_attr', '=', 1);
            }])

            ->orderBy('shop_order_has_product.id')

            ->get();

        $products = $this->addRelationCollections($products);

        return $this->addSelectedOrderAttributeToPivot($products, 'order');

    }

    public function getParcelParameters($products){

        $parameters = [];

        foreach($products as $key=>$product){

            $parameters[] = $this->getParametersForParcel($product);

        }

        return $parameters;
    }

    private function getParametersForParcel($product, $quantity = 1){

        if( isset($product->baskets['pivot']['quantity']) ){
            $quantity = $product->baskets['pivot']['quantity'];
        }

        return [
            'weight'    => $product['weight'],
            'length'    => $product['length'],
            'width'     => $product['width'],
            'height'    => $product['height'],
            'quantity'  => $quantity,

        ];
    }

    private function addRelationCollections($products){

        foreach ( $products as $product){

            foreach ($product->original as $key => $value){

                $match = explode('|', $key, 3);

                switch($match[0]){

                    case 'price'       :
                    case 'category'    :
                    case 'discounts'   :
                    case 'manufacturer':
                    case 'parameters':
                    case 'baskets':
                    case 'pivot':

                        if( !isset($data[ $match[0] ]) ){
                            $data[ $match[0] ] = [] ;
                        }

                        switch( $match[1] ){
                            case 'pivot'    : $data[ $match[0] ] [ $match[1] ] [ $match[2] ] = $value; break;
                            default         : $data[ $match[0] ] [ $match[1] ] = $value; break;
                        }
                        $product->relations[ $match[0] ] = collect($data[ $match[0] ]);

                        break;
                }

            }

        }

        return $products;
    }

    private function getOneProductQuery(){

        $productsQuery = $this->getDefaultProductQuery();

        return $productsQuery
            ->addSelect(
                'products.description',
                'products.weight',
                'products.length',
                'products.width',
                'products.height'
            )
            /************IMAGES*****************/
            ->with('images')

            /************PARAMETERS*************/
            ->with(['parameters' => function ($query) {
                $query->where('product_parameters.order_attr', '=', 0);
            }]);
    }

    private function getListProductQuery(){

        $productsQuery = $this->getDefaultProductQuery();

        return $productsQuery
        /************IMAGES*****************/
        ->with('images');
    }

    private function getDefaultProductQuery(){

        return self::select(
            'products.id',
            'products.manufacturer_id',
            'products.category_id',
            'products.name',
            'products.original_name',
            'products.scu',
            'prices.id                      as price|id',
            'prices.name                    as price|name',
            'product_has_price.value        as price|pivot|value',
            'currency.value                 as price|pivot|currency_value',
            'currency.char_code             as price|pivot|currency_code',
            'currency.id                    as price|pivot|currency_id',
            'discounts.id                   as discounts|id',
            'discounts.name                 as discounts|name',
            'discounts.type                 as discounts|type',
            'product_has_discount.value     as discounts|pivot|value',
            'manufacturers.id               as manufacturer|id',
            'manufacturers.name             as manufacturer|name',
            'categories.id                  as category|id',
            'categories.name                as category|name',

            DB::raw(
                'CASE discounts.type
                           WHEN "percent"
                                    THEN ROUND( ( product_has_price.value - (product_has_price.value / 100 * product_has_discount.value) ) * currency.value )
                           WHEN "value"
                                    THEN ROUND( (product_has_price.value * currency.value) - product_has_discount.value )
                           ELSE ROUND( product_has_price.value * currency.value )
                        END AS "price|value"'
            ),
            DB::raw(
                'CASE discounts.type
                           WHEN "percent"
                                    THEN ROUND( product_has_price.value / 100 * product_has_discount.value * currency.value )
                           WHEN "value"
                                    THEN ROUND( product_has_discount.value * currency.value )
                           ELSE 0
                        END AS "price|sale"'
            )
        )

            /************PRICE******************/
            ->leftJoin('product_has_price', function ($join) {
                $join->on('products.id', '=', 'product_has_price.product_id')
                    ->where('product_has_price.active', '=', '1')
                    ->where('product_has_price.price_id', '=', $this->price_id);
            })
            ->leftJoin('prices','prices.id', '=', 'product_has_price.price_id')

            /************CURRENCY***************/
            ->leftJoin('currency', 'currency.id', '=', 'product_has_price.currency_id')

            /************DISCOUNT***************/
            ->leftJoin('product_has_discount', 'products.id', '=', 'product_has_discount.product_id')
            ->leftJoin('discounts', function ($join) {
                $join->on('discounts.id', '=', 'product_has_discount.discount_id')
                    ->where('discounts.active', '=', '1')
                    ->whereDate('to_date', '>=', $this->today);
            })

            /************MANUFACTURER***********/
            ->leftJoin('manufacturers', 'manufacturers.id', '=', 'products.manufacturer_id')

            /************PARAMETERS*************/
            ->with(['basket_parameters' => function ($query) {
                $query->where('product_parameters.order_attr', '=', 1);
            }])

            /************CATEGORY***************/
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id');

    }

    public function getCustomProductsOffer($offer_id, $take){

        $productsQuery = $this->getListProductQuery();

        $products = $productsQuery

            /************OFFERS****************/
            ->rightJoin('shop_offer_has_product', function ($join) use ($offer_id){
                $join->on('shop_offer_has_product.product_id', '=', 'products.id')
                    ->where('shop_offer_has_product.offer_id', '=', $offer_id);
            })

            ->where('products.active', 1)

            ->orderBy('products.name')

            ->take($take)

            ->get();

        return $this->addRelationCollections($products);
    }

    public function getProductsPrepareOffer($offer_name, $take){

        switch($offer_name){
            case 'sale' :
                $productQuery = $this->getListProductQuery();

                $products = $productQuery
                    ->where('products.active', 1)

                    ->where('discounts.id', '<>', NULL)

                    ->orderBy('products.name')

                    ->take($take)

                    ->get();

                return $this->addRelationCollections($products);

            case 'newest' :
                $productQuery = $this->getListProductQuery();

                $products = $productQuery
                    ->where('products.active', 1)

                    ->orderBy('products.created_at')

                    ->take($take)

                    ->get();

                return $this->addRelationCollections($products);
        }

    }

    private function addSelectedOrderAttributeToPivot($products, $model)
    {
        foreach($products as $key => $product){

            $attributes = explode(',', $product['pivot']['order_attributes']);

            $parameters = $product->basket_parameters;

            $temporary = [];

            foreach($attributes as $attribute){

                foreach($parameters as $parameter){
                    if($parameter->pivot->id === (int)$attribute){
                        $temporary[] = $parameter;
                        switch ($model) {
                            case 'basket' :
                                $product['price|value'] += $parameter->pivot->basket_value;
                                $product->price['value'] += $parameter->pivot->basket_value;
                                break;
                            case 'order' :
                                break;
                        }

                    }
                }

            }

            $product['pivot']['order_attributes_collection'] = $temporary;

            $product->quantity = $product['pivot']['quantity'];
        }
        return $products;
    }
}
