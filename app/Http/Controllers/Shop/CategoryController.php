<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shop\Category\Category;
use App\Models\Shop\Product\Product;
use App\Facades\GlobalData;

class CategoryController extends Controller{

    protected $categories;

    /**
     * Создание нового экземпляра контроллера.
     *
     * @param  Category $categories
     * @return void
     */
    public function __construct(Category $categories)
    {
        $this->categories = $categories;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['shop']['category'] = $this->categories->getRootCategory();

        $globalData = GlobalData::getParametersForController($data, 'shop', 'category', 'list');

        return view($globalData['template']['viewKey'], ['global_data' => $globalData]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Request $request
     * @param  Product $products
     * @param  int  $id
     * @return array
     */
    public function show(Request $request, Product $products, $id)
    {
        $category = $this->categories->getCategory($id);

        $data['shop']['category']           = $category;
        $data['shop']['parameters']         = [];
        $data['header_page']                = $category[0]->name;

        //todo - продумать функционал для вывода во views component/shop/category/show товары из вложенных категории данной категории

        if ( count( $request->query ) > 0 ) {

            $filterData = $request->toArray();

            $routeData = ['category' => $id];

            $data['shop']['products'] = $products->getFilteredProducts($routeData, $filterData);

            $data['shop']['parameters'] = $request->toArray();

        } else {
            $data['shop']['products'] = $products->getActiveProductsFromCategory($id);
        }

        $globalData = GlobalData::getParametersForController($data, 'shop', 'category', 'show', $id);

        return view($globalData['template']['viewKey'], ['global_data' => $globalData]);
    }

}
