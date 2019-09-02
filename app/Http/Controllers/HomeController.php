<?php

namespace App\Http\Controllers;

use App\Facades\GlobalData;

class HomeController extends Controller{

    public function index()
    {
        $globalData = GlobalData::getParametersForController([],'home');

        return view($globalData['template']['name'] . '.index', ['global_data' => $globalData]);
    }
}
