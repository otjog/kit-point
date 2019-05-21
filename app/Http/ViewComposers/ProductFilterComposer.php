<?php

namespace App\Http\ViewComposers;

use App\Models\Shop\Category\Filter;
use App\Models\Shop\Product\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductFilterComposer{

    protected $filters;
    protected $routeData;

    public function __construct(Request $request, Filter $filters, Product $products){
        $this->filters = $filters->getActiveFiltersWithParameters($request, $products);
        $this->routeData = $request->route()->parameters;
    }

    public function compose(View $view){
        $view->with(['filters' => $this->filters, 'routeData' => $this->routeData]);
    }
}