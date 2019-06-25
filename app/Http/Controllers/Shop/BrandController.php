<?php

namespace App\Http\Controllers\Shop;

use App\Models\Shop\Product\Brand;
use App\Models\Site\Module;
use App\Models\Site\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shop\Product\Product;
use App\Models\Shop\Order\Basket;
use App\Models\Settings;

class BrandController extends Controller{

    protected $brands;

    protected $settings;

    /**
     * Создание нового экземпляра контроллера.
     *
     * @return void
     */
    public function __construct(Brand $brands)
    {
        $this->settings = Settings::getInstance();

        $this->brands = $brands;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['shop']['brands']  = $this->brands->getActiveBrands();

        $data['header_page'] =  'Бренды';

        $globalData = $this->settings->getParametersForController($data, 'shop', 'brand', 'list');

        return view($globalData['template']['viewKey'], ['global_data' => $globalData]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Product $products, $name)
    {
        $brand = $this->brands->getBrand($name);

        $data['shop']['brand']       = $brand;
        $data['shop']['parameters']  = [];
        $data['header_page'] = 'Товары бренда ' . $brand[0]->name;

        if (count($request->query) > 0) {

            $routeData = ['brand' => $name];

            $filterData = $request->toArray();

            $data['shop']['products'] = $products->getFilteredProducts($routeData, $filterData);
        } else {
            $data['shop']['products'] = $products->getActiveProductsOfBrand($name);
        }

        $globalData = $this->settings->getParametersForController($data, 'shop', 'brand', 'show');

        return view($globalData['template']['viewKey'], ['global_data' => $globalData]);
    }

}
