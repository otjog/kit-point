<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Product\Product;
use App\Facades\GlobalData;
use App\Models\Site\Photo360;

class ProductController extends Controller{

    protected $products;

    /**
     * Создание нового экземпляра контроллера.
     *
     * @param  Product $products
     * @return void
     */
    public function __construct(Product $products)
    {
        $this->products = $products;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $photo360 = new Photo360();

        $data['shop']['product'] = $this->products->getActiveProduct($id);

        $data['photo360'] = $photo360->getPhotos($data['shop']['product']['scu']);

        $data['shop']['parcelData'] = $this->products->getJsonParcelParameters([$data['shop']['product']]);

        $globalData = GlobalData::getParametersForController($data,'shop', 'product', 'show', $id);

        return view($globalData['template']['viewKey'], ['global_data' => $globalData]);
    }

}