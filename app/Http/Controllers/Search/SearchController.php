<?php

namespace App\Http\Controllers\Search;

use App\Models\Site\Module;
use App\Models\Site\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shop\Product\Product;
use App\Models\Shop\Order\Basket;
use sngrl\SphinxSearch\SphinxSearch;
use App\Models\Settings;

class SearchController extends Controller{

    protected $globalData;

    protected $data;

    protected $template;

    protected $module;

    protected $settings;

    protected $products;

    protected $queryString;

    protected $baskets;

    /**
     * Создание нового экземпляра контроллера.
     *
     * @return void
     */
    public function __construct(Request $request, Product $products, Basket $baskets, Template $template, Module $module){

        $this->settings = Settings::getInstance();

        $this->globalData = $this->settings->getParameters();

        $this->data =& $this->globalData['global_data'];

        $this->template = $template;

        $this->module = $module;

        $this->products = $products;

        $this->baskets  = $baskets;

        $this->queryString = $request->search;

        $this->data['shop']['parameters']  = $request->toArray();


    }

    public function show(){

        $sphinx  = new SphinxSearch();

        $searchIdResult = $sphinx->search($this->queryString, env( 'SPHINXSEARCH_INDEX' ))->query();

        $this->data['shop']['products']    = [];
        $this->data['query'] = $this->queryString;
        $this->data['header_page'] = 'Результаты поиска по запросу: ' . $this->queryString;

        if( isset( $searchIdResult[ 'matches' ] ) && count( $searchIdResult[ 'matches' ] ) > 0 ){
            $this->data['shop']['products'] = $this->products->getProductsById( array_keys( $searchIdResult[ 'matches' ] ) );
        }

        $this->data['template'] = $this->template->getTemplateData($this->data, 'shop', 'search', 'show');

        $this->data['modules'] = $this->module->getModulesData($this->data['template']['schema']);

        return view( $this->data['template']['viewKey'], $this->globalData);
    }

}
