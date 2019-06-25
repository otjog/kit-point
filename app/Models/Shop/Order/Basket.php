<?php

namespace App\Models\Shop\Order;

use Illuminate\Database\Eloquent\Model;
use App\Models\Shop\Product\Product;
use Illuminate\Support\Facades\DB;
use App\Libraries\Helpers\DeclesionsOfWord;

class Basket extends Model
{
    protected $moduleMethods = [
        'show' => 'getActiveBasketWithProductsAndRelations',
    ];

    public function getModuleMethods($moduleMethod)
    {
        return $this->moduleMethods[$moduleMethod];
    }

    protected $table = 'shop_baskets';

    public function products()
    {
        return $this->belongsToMany('App\Models\Shop\Product\Product', 'shop_basket_has_product', 'basket_id', 'product_id')
            ->withPivot('quantity', 'order_attributes')
            ->withTimestamps();
    }

    public function shopOrder()
    {
        return $this->hasOne('App\Models\Shop\Order\Order', 'order_id');
    }

    public function getActiveBasket($token)
    {
        return self::select('id', 'token', 'order_id')
            ->where('token', $token)
            ->where('order_id', null)
            ->first();
    }

    public function getActiveBasketWithProducts($token){
        return self::select('id', 'token', 'order_id')
            ->where('token', $token)
            ->where('order_id', null)
            ->with('products')
            ->first();
    }

    public function getExistProduct($token, $product_id, $attributes){
        return self::select('id', 'token', 'order_id')
            ->where('token', $token)
            ->where('order_id', null)
            ->with(['products' => function ($query) use ( $product_id, $attributes ){
                $query->select('product_id', 'basket_id', 'quantity', 'order_attributes')
                ->where('product_id', '=', $product_id)
                    ->where('order_attributes', '=', $attributes);
            }])
            ->first();
    }

    public function getActiveBasketWithProductsAndRelations($token = null)
    {
        $products = new Product();

        if($token === null)
            $token = session('_token');

        $basket = $this->getActiveBasket( $token );

        if( $basket !== null ){

            $basket->relations['products'] = $products->getProductsFromBasket( $basket->id );

            $basket->total      = $this->getTotal($basket->products);

            $basket->count_scu  = count($basket->products);

            $basket->declesion  = DeclesionsOfWord::make($basket->count_scu, ['товар', 'товара', 'товаров']);

        }

        return $basket;

    }

    public function addProductToBasket($request, $token )
    {
        $basket = $this->getActiveBasket( $token );

        $orderParameters = $request->all();

        if( isset($orderParameters['order_attributes']) ){
            $orderParameters['order_attributes'] = implode(',', $orderParameters['order_attributes']);
        }else{
            $orderParameters['order_attributes'] = null;
        }

        unset($orderParameters['_token']);

        if($basket === null){

            $baskets = new Basket();

            $baskets->token = $token;

            $baskets->save();

            $basket = $this->getActiveBasket( $token );

            $basket->products()->attach($orderParameters['product_id'], $orderParameters);

        }else{

            $checkProducts = $this->getExistProduct($token, $orderParameters['product_id'], $orderParameters['order_attributes']);

            if( count($checkProducts->products) > 0){

                $tableName = 'shop_basket_has_product';

                $relationColumns = [
                    'basket_id' => $checkProducts->id,
                    'product_id' => $checkProducts->products[0]->product_id,
                    'order_attributes' => $checkProducts->products[0]->order_attributes
                ];

                $updateColumns = [
                    'quantity' => $checkProducts->products[0]->quantity +  (int)$orderParameters['quantity']
                ];

                $this->updateExistingPivot($tableName, $relationColumns, $updateColumns);

            }else{

                $basket->products()->attach($orderParameters['product_id'], $orderParameters);

            }

        }
    }

    public function updateBasket( $request )
    {
        $parameters = $request->all();

        $token = $request['_token'];

        unset($parameters['_token']);
        unset($parameters['_method']);

        $basket = $this->getActiveBasketWithProducts($token);

        $tableName = 'shop_basket_has_product';

        foreach($parameters as $parameter){

            foreach($basket->products as $product){

                if($product->id === (int)$parameter['product_id'] && $product->pivot['order_attributes'] === $parameter['order_attributes']){

                    $quantity = (int)$parameter['quantity'];

                    if($product->pivot['quantity'] !==  $quantity){

                        $relationColumns = [
                            'basket_id' => $basket->id,
                            'product_id' => $parameter['product_id'],
                            'order_attributes' => $parameter['order_attributes']
                        ];

                        $updateColumns = [
                            'quantity' => $parameter['quantity']
                        ];

                        if($quantity !== 0){

                            $this->updateExistingPivot($tableName, $relationColumns, $updateColumns);

                        }else if($quantity === 0){

                            $this->deleteExistingPivot($tableName, $relationColumns);

                        }

                    }

                }

            }

        }

    }

    private function getTotal($products)
    {
        $total = 0;

        foreach($products as $product){

            $total += $product['pivot']['quantity'] * $product->price['value'];

        }

        return $total;

    }

    //todo вынести в общую библиотеку
    private function updateExistingPivot( string $tableName, array $relationColumns, array $updateColumns)
    {
        $table = DB::table($tableName);

        foreach($relationColumns as $columnName => $columnValue){
            $table->where($columnName, $columnValue);
        }

        $table->update($updateColumns);
    }

    private function deleteExistingPivot( string $tableName, array $relationColumns)
    {
        $table = DB::table($tableName);

        foreach($relationColumns as $columnName => $columnValue){
            $table->where($columnName, $columnValue);
        }

        $table->delete();
    }

}
