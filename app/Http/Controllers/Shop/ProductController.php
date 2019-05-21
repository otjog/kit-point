<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Order\Basket;
use App\Models\Site\Module;
use App\Models\Site\Template;
use Illuminate\Http\Request;
use App\Models\Shop\Product\Product;
use App\Models\Settings;
use App\Models\Site\Photo360;

class ProductController extends Controller{

    protected $products;

    protected $baskets;

    protected $settings;

    protected $data;

    protected $template;

    protected $module;

    protected $globalData;

    /**
     * Создание нового экземпляра контроллера.
     *
     * @param  Product $products
     * @return void
     */
    public function __construct(Product $products, Basket $baskets, Template $template, Module $module){

        $this->settings = Settings::getInstance();

        $this->globalData = $this->settings->getParameters();

        $this->data =& $this->globalData['global_data'];

        $this->template = $template;

        $this->module = $module;

        $this->products = $products;

        $this->baskets = $baskets;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){

        $photo360 = new Photo360();

        $this->data['shop']['product'] = $this->products->getActiveProduct($id);

        $this->data['photo360'] = $photo360->getPhotos($this->data['shop']['product']['scu']);

        $this->data['template'] = $this->template->getTemplateData($this->data,'shop', 'product', 'show', $id);

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
    public function destroy($id){
        //
    }

}