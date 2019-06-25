<?php

namespace App\Http\Controllers\Search;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shop\Product\Product;
use sngrl\SphinxSearch\SphinxSearch;
use App\Models\Settings;

class SearchController extends Controller{

    protected $settings;

    protected $products;

    protected $queryString;

    /**
     * Создание нового экземпляра контроллера.
     *
     * @return void
     */
    public function __construct(Request $request, Product $products)
    {
        $this->settings = Settings::getInstance();

        $this->products = $products;

        $this->queryString = $request->search;

        $this->data['shop']['parameters']  = $request->toArray();


    }

    public function show()
    {
        $sphinx  = new SphinxSearch();

        $searchIdResult = $sphinx->search($this->queryString, env( 'SPHINXSEARCH_INDEX' ))->query();

        $data['shop']['products']    = [];
        $data['query'] = $this->queryString;
        $data['header_page'] = 'Результаты поиска по запросу: ' . $this->queryString;

        if( isset( $searchIdResult[ 'matches' ] ) && count( $searchIdResult[ 'matches' ] ) > 0 ){
            $data['shop']['products'] = $this->products->getProductsById( array_keys( $searchIdResult[ 'matches' ] ) );
        }

        $globalData = $this->settings->getParametersForController($data, 'shop', 'search', 'show');

        return view($globalData['template']['viewKey'], ['global_data' => $globalData]);
    }

}
