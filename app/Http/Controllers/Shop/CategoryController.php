<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Order\Basket;
use App\Models\Site\Module;
use Illuminate\Http\Request;
use App\Models\Shop\Category\Category;
use App\Models\Shop\Product\Product;
use App\Models\Settings;
use App\Models\Site\Template;

class CategoryController extends Controller{

    protected $categories;

    protected $baskets;

    protected $settings;

    protected $template;

    protected $module;

    protected $data;

    protected $globalData;

    /**
     * Создание нового экземпляра контроллера.
     *
     * @param  Category $categories
     * @return void
     */
    public function __construct(Category $categories, Basket $baskets, Template $template, Module $module){

        $this->settings = Settings::getInstance();

        $this->globalData = $this->settings->getParameters();

        $this->data =& $this->globalData['global_data'];

        $this->template = $template;

        $this->module = $module;

        $this->categories = $categories;

        $this->baskets = $baskets;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        $this->data['shop']['category']  =  $this->categories->getCategoriesTree();

        $this->data['header_page'] =  'Категории';

        $this->data['template'] = $this->template->getTemplateData($this->data, 'shop', 'category', 'list');

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
     * @param  Request $request
     * @param  Product $products
     * @param  int  $id
     * @return array
     */
    public function show(Request $request, Product $products, $id){

        $category = $this->categories->getCategory($id);

        $this->data['shop']['category']            = $category;
        $this->data['shop']['children_categories'] = $this->categories->getActiveChildrenCategories($id);
        $this->data['shop']['parameters']          = [];
        $this->data['header_page']         = $category[0]->name;

        if( count( $request->query ) > 0 ){

            $filterData = $request->toArray();

            $routeData = ['category' => $id];

            $this->data['shop']['products'] = $products->getFilteredProducts($routeData, $filterData);

            $this->data['shop']['parameters'] = $request->toArray();

        }else{
            $this->data['shop']['products'] = $products->getActiveProductsFromCategory($id);
        }

        $this->data['template'] = $this->template->getTemplateData($this->data, 'shop', 'category', 'show', $id);

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
    public function update(Request $request, $id){
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
