<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shop\Order\Basket;

class BasketProductController extends Controller
{
    protected $baskets;

    public function __construct(Basket $baskets)
    {
        $this->baskets = $baskets;
    }

    /**
     * Добавить товар  в корзину
     *
     * @param string $token Id of the Basket
     * @param int $productId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($token, Request $request)
    {
        unset($request['_token']);

        $this->baskets->storeProduct($request, $token);

        return back();
    }

    /**
     * Добавить или отнять количество данного продукта
     *
     * @param string $token Id of the Basket
     * @param  \Illuminate\Http\Request  $request
     * @param  int $productId
     * @return \Illuminate\Http\Response
     */
    public function update($token, $productId, Request $request)
    {
        unset($request['_method']);
        unset($request['_token']);

        $this->baskets->updateProduct($token, $productId, $request);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $productId
     * @return \Illuminate\Http\Response
     */
    public function destroy($productId)
    {
        //
    }
}
