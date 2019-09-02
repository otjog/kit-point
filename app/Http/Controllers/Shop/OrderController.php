<?php

namespace App\Http\Controllers\Shop;

use App\Libraries\Services\Pay\Contracts\OnlinePayment;
use App\Models\Shop\Customer;
use App\Models\Shop\Order\Payment;
use App\Models\Shop\Services\PaymentService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shop\Order\Basket;
use App\Models\Shop\Order\Order;
use App\Models\Shop\Product\Product;
use App\Facades\GlobalData;
use App\Events\NewOrder;

class OrderController extends Controller
{
    protected $orders;

    protected $baskets;

    public function __construct(Order $orders, Basket $baskets)
    {
        $this->orders   = $orders;

        $this->baskets  = $baskets;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Payment $payments, OnlinePayment $paymentService, Customer $customers, Product $products)
    {
        $token = $request['_token'];

        $payment = $payments->getMethodById($request->payment_id);

        if ($payment[0]->alias === 'online') {

            $basket = $this->baskets->getActiveBasketWithProductsAndRelations();

            return $paymentService->send($request, $basket);

        } else {

            $basket = $this->baskets->getActiveBasket( $token );

            $customer = $customers->getAuthCustomer($request->all());

            $order = $this->orders->storeOrder( $request->all(), $basket, $customer, $products );

            event(new NewOrder($order->id));

            return redirect('orders/'.$order->id)->with('status', 'Заказ оформлен! Скоро с вами свяжется наш менеджер');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['shop'] = $this->orders->getDataForCreateOrder();

        $globalData = GlobalData::getParametersForController($data, 'shop', 'order', 'create');

        return view($globalData['template']['viewKey'], ['global_data' => $globalData]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $products, $id)
    {
        $data['shop']['order']    = $this->orders->getOrderById($products, $id);

        $globalData = GlobalData::getParametersForController($data, 'shop', 'order', 'show');

        return view($globalData['template']['viewKey'], ['global_data' => $globalData]);
    }

}