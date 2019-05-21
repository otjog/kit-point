<?php

namespace App\Http\Controllers\Shop;

use App\Libraries\Services\Pay\Contracts\OnlinePayment;
use App\Models\Shop\Customer;
use App\Models\Shop\Order\Payment;
use App\Models\Site\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shop\Order\Basket;
use App\Models\Shop\Order\Order;
use App\Models\Shop\Product\Product;
use App\Models\Settings;
use App\Models\Site\Module;

class OrderController extends Controller{

    protected $orders;

    protected $baskets;

    protected $settings;

    protected $data;

    protected $globalData;

    protected $template;

    protected $module;

    public function __construct(Order $orders, Basket $baskets, Template $template, Module $module){

        $this->settings = Settings::getInstance();

        $this->globalData = $this->settings->getParameters();

        $this->data =& $this->globalData['global_data'];

        $this->template = $template;

        $this->module = $module;

        $this->orders   = $orders;

        $this->baskets  = $baskets;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        //GET
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Payment $payments, OnlinePayment $paymentService, Customer $customers, Product $products){

        $token = $request['_token'];

        $payment = $payments->getMethodById($request->payment_id);

        if($payment[0]->alias === 'online'){

            $basket = $this->baskets->getActiveBasketWithProductsAndRelations();

            return $paymentService->send($request, $basket);

        }else{

            $basket = $this->baskets->getActiveBasket( $token );

            $customer = $customers->findOrCreateCustomer( $request->all() );

            $order = $this->orders->storeOrder( $request->all(), $basket, $customer, $products );

            return redirect('orders/'.$order->id)->with('status', 'Заказ оформлен! Скоро с вами свяжется наш менеджер');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Payment $payments){

        $this->data['shop']['basket']   = $this->baskets->getActiveBasketWithProductsAndRelations();

        $this->data['shop']['payments'] = $payments->getActiveMethods();

        $this->data['template'] = $this->template->getTemplateData($this->data, 'shop', 'order', 'create');

        $this->data['modules'] = $this->module->getModulesData($this->data['template']['schema']);

        return view( $this->data['template']['viewKey'], $this->globalData);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $products, $id){

        $this->data['shop']['order']    = $this->orders->getOrderById($products, $id);

        $this->data['template'] = $this->template->getTemplateData($this->data, 'shop', 'order', 'show');

        $this->data['modules'] = $this->module->getModulesData($this->data['template']['schema']);

        return view( $this->data['template']['viewKey'], $this->globalData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        //GET
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        //PUT/PATCH
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        //DELETE
    }
}