<?php

namespace App\Http\Controllers\Shop;

use App\Models\Shop\Product\Product;
use App\Models\Shop\Order\Basket;
use App\Models\Site\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Models\Site\Module;

class BasketController extends Controller{

    protected $baskets;

    protected $data;

    protected $globalData;

    protected $template;

    protected $module;

    protected $settings;

    public function __construct(Basket $baskets, Template $template, Module $module){

        $this->settings = Settings::getInstance();

        $this->globalData = $this->settings->getParameters();

        $this->data =& $this->globalData['global_data'];

        $this->template = $template;

        $this->module = $module;

        $this->baskets = $baskets;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        $token = $request->session()->get('_token');

        $this->baskets->addProductToBasket( $request, $token );

        return back();
    }

    /**
     * Display the specified resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function show($token){


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($token){

        $products = new Product();

        $basket = $this->baskets->getActiveBasketWithProductsAndRelations($token);

        if($basket->order_id === null){

            $this->data['shop']['basket']   = $basket;

            $this->data['shop']['parcels'] = $products->getParcelParameters($basket->products);

            $this->data['template'] = $this->template->getTemplateData($this->data, 'shop', 'basket', 'edit');

            $this->data['modules'] = $this->module->getModulesData($this->data['template']['schema']);

            return view( $this->data['template']['viewKey'], $this->globalData);

        } else {

            return redirect('orders.show', $basket->order_id);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->baskets->updateBasket($request);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}