<?php

namespace App\Http\Controllers;

use App\Models\Settings;

class HomeController extends Controller{

    protected $settings;

    public function __construct()
    {
        $this->settings = Settings::getInstance();
    }

    public function index()
    {
        $globalData = $this->settings->getParametersForController([],'home');

        return view($globalData['template']['name'] . '.index', ['global_data' => $globalData]);
    }
}
