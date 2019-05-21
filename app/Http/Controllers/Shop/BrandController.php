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

    protected $baskets;

    protected $settings;

    protected $data;

    protected $globalData;

    protected $template;

    protected $module;

    /**
     * Создание нового экземпляра контроллера.
     *
     * @return void
     */
    public function __construct(Brand $brands, Basket $baskets, Template $template, Module $module)
    {

        $this->settings = Settings::getInstance();

        $this->globalData = $this->settings->getParameters();

        $this->data =& $this->globalData['global_data'];

        $this->template = $template;

        $this->module = $module;

        $this->brands = $brands;

        $this->baskets = $baskets;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        $this->data['shop']['brands']  = $this->brands->getActiveBrands();

        $this->data['header_page'] =  'Бренды';

        $this->data['template'] = $this->template->getTemplateData($this->data, 'shop', 'brand', 'list');

        $this->data['modules'] = $this->module->getModulesData($this->data['template']['schema']);

        return view( $this->data['template']['viewKey'], $this->globalData);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Product $products, $name){

        $brand = $this->brands->getBrand($name);

        $this->data['shop']['brand']       = $brand;
        $this->data['shop']['parameters']  = [];
        $this->data['header_page'] = 'Товары бренда ' . $brand[0]->name;

        if (count($request->query) > 0) {

            $routeData = ['brand' => $name];

            $filterData = $request->toArray();

            $this->data['shop']['products'] = $products->getFilteredProducts($routeData, $filterData);
        } else {
            $this->data['shop']['products'] = $products->getActiveProductsOfBrand($name);
        }

        $this->data['template'] = $this->template->getTemplateData($this->data, 'shop', 'brand', 'show');

        $this->data['modules'] = $this->module->getModulesData($this->data['template']['schema']);

        return view( $this->data['template']['viewKey'], $this->globalData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
