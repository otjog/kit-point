<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shop\Product\Product;
use App\Models\Shop\Category\Category;
use App\Models\Shop\Price\Pricelists;

class PricelistController extends Controller
{
    public $pricelistModel;

    public $categoryModel;

    public $productModel;

    public function __construct(Pricelists $pricelistModel, Category $categoryModel, Product $productModel)
    {
        $this->pricelistModel = $pricelistModel;

        $this->categoryModel = $categoryModel;

        $this->productModel = $productModel;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  string  $pl_alias
     * @return \Illuminate\Http\Response
     */
    public function show($pl_alias)
    {
        $categories = $this->categoryModel->getActiveCategories();

        $products = $this->productModel->getActiveProducts();

        $xmlString = $this->pricelistModel->getPriceList($products, $categories, $pl_alias);

        return response($xmlString, 200)
            ->header('Content-Type', 'text/xml');
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
