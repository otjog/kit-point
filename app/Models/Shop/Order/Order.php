<?php

namespace App\Models\Shop\Order;

use App\Models\Shop\Services\PaymentService;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shop\Product\Product;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    public function getNameAttribute($value)
    {
        if($value === null)
            return 'Ваш заказ';
        return $value;
    }

    protected $table = 'shop_orders';

    protected $fillable = [
        'shop_basket_id',
        'payment_id',
        'shipment_id',
        'customer_id',
        'products_json',
        'address',
        'comment',
        'paid',
        'pay_id',
        'address_json'
    ];

    public function products(){
        return $this->belongsToMany('App\Models\Shop\Product\Product', 'shop_order_has_product', 'order_id', 'product_id')
            ->withPivot('quantity', 'price_id', 'currency_id', 'price_value', 'order_attributes')
            ->withTimestamps();
    }

    public function shopBasket(){
        return $this->belongsTo('App\Models\Shop\Order\Basket', 'shop_basket_id');
    }

    public function shipment(){
        return $this->belongsTo('App\Models\Shop\Order\Shipment');
    }

    public function payment(){
        return $this->belongsTo('App\Models\Shop\Order\Payment');
    }

    public function customer(){
        return $this->belongsTo('App\Models\Shop\Customer');
    }

    public function getOrderById(Product $products, $id){
        $order = self::select(
            'id',
            'shop_basket_id',
            'payment_id',
            'shipment_id',
            'customer_id',
            'address as delivery_address',
            'comment',
            'paid',
            'pay_id',
            'address_json as delivery_address_json',
            'created_at'
        )
            ->where('id', $id)

            /************CUSTOMER***********/
            ->with('customer')

            /************SHIPMENT***********/
            ->with('shipment')

            /************PAYMENT***********/
            ->with('payment')

            ->get();

        if( count( $order ) > 0){

            $order[0]->relations['products'] = $products->getProductsFromOrder( $order[0]->id );

            $order[0]->total = $this->getOrderTotalPrice($order[0]->products);

            $order[0]->count_scu = count((array)$order[0]->products);

            return $order[0];

        }else{
            return null;
        }
    }

    public function getOrderByPayId($payId){
        return self::select(
            'id',
            'shop_basket_id',
            'payment_id',
            'shipment_id',
            'customer_id',
            'products_json',
            'address as delivery_address',
            'comment',
            'paid',
            'pay_id',
            'address_json as delivery_address_json'
        )
            ->where('pay_id', $payId)
            ->get();
    }

    public function getDataForCreateOrder()
    {
        $baskets = new Basket();

        $data['basket']   = $baskets->getActiveBasketWithProductsAndRelations();

        $payments = new PaymentService();

        $data['payments'] = $payments->getActiveMethodsWithTax($data['basket']['total']);

        $products = new Product();

        $data['parcelData'] = $products->getJsonParcelParameters($data['basket']->products);

        return $data;
    }

    public function storeOrder($data, $basket, $customer, Product $products){

        $data_order = $this->getDataForStoreOrder($data, $basket, $customer);

        $order = self::create($data_order);

        $insertColumns = $this->getDataForRelationOrder($products, $basket, $order);

        $this->insertInExistingPivot('shop_order_has_product', $insertColumns);

        $order->relations['customer'] = $customer;

        $basket->order_id = $order->id;

        $basket->save();

        return $order;
    }

    private function getDataForStoreOrder($data, $basket, $customer){

        $data_order = [
            'shop_basket_id'    => $basket->id,
            'customer_id'       => $customer->id,
            'comment'           => '',
        ];

        foreach($data as $key => $value){
            switch($key){
                case 'payment_id'       :
                case 'address'          :
                case 'address_json'     :
                case 'paid'             :
                case 'pay_id'           :
                    $data_order[$key] = $value;
                    break;
                case 'comment'          :
                    $data_order[$key] .= "\n" . $value;
                    break;
                case 'shipment_id'      :
                    $shipmentData = explode('_', $value);
                    $data_order[$key] = $shipmentData[0];
                    $data_order['comment'] .= "\n" . $value;
                    break;
            }
        }

        return $data_order;
    }

    private function getDataForRelationOrder(Product $products, $basket, $order){

        $productsFromBasket = $products->getProductsFromBasket( $basket->id );

        $insertColumns = [];

        foreach($productsFromBasket as $product){
            $insertColumns[] = [
                'order_id'          => $order->id,
                'product_id'        => $product->id,
                'quantity'          => $product->pivot['quantity'],
                'order_attributes'  => $product->pivot['order_attributes'],
                'price_id'          => $product->price['id'],
                'currency_id'       => $product->price['pivot']['currency_id'],
                'price_value'       => $product->price['value'],
            ];
        }

        return $insertColumns;
    }

    private function getOrderTotalPrice($products){

        $total = 0;

        foreach($products as $product){

            $total += $product['pivot']['quantity'] * $product->price['value'];

        }

        return $total;

    }

    private function insertInExistingPivot(string $tableName, array $insertColumns){
        DB::table($tableName)->insert($insertColumns);

    }

}