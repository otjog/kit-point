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

    protected $settings;

    public function __construct(Basket $baskets)
    {
        $this->settings = Settings::getInstance();

        $this->baskets = $baskets;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $token = $request->session()->get('_token');

        $this->baskets->addProductToBasket( $request, $token );

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($token)
    {
        $products = new Product();

        $basket = $this->baskets->getActiveBasketWithProductsAndRelations($token);

        if ($basket->order_id === null) {

            $data['shop']['basket']   = $basket;

            $data['shop']['parcels'] = $products->getParcelParameters($basket->products);

            $globalData = $this->settings->getParametersForController($data, 'shop', 'basket', 'edit');

            return view($globalData['template']['viewKey'], ['global_data' => $globalData]);

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
}