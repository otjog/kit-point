<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Site\Module;
use App\Models\Site\Template;

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
