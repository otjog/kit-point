<?php

namespace App\Http\Controllers\Shop;

use App\Models\Shop\Order\Basket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Facades\GlobalData;

class BasketController extends Controller{

    protected $baskets;

    public function __construct(Basket $baskets)
    {
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($token)
    {
        $basket = $this->baskets->getActiveBasketWithProductsAndRelations($token);

        if ($basket->order_id === null) {

            $data['shop']['basket']   = $basket;

            $globalData = GlobalData::getParametersForController($data, 'shop', 'basket', 'edit');

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