<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Site\Module;
use App\Models\Site\Template;

class HomeController extends Controller{

    protected $data;

    protected $template;

    protected $globalData;

    protected $settings;

    protected $module;

    public function __construct(Template $template, Module $module){

        $this->settings = Settings::getInstance();

        $this->module = $module;

        $this->globalData = $this->settings->getParameters();

        $this->data =& $this->globalData['global_data'];

        $this->template = $template;

    }

    public function index(){

        $this->data['template'] = $this->template->getTemplateData($this->data,'home');

        $this->data['modules'] = $this->module->getModulesData($this->data['template']['schema']);

        return view( $this->data['template']['name'] . '.index', $this->globalData);
    }

}
