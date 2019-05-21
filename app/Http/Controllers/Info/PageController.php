<?php

namespace App\Http\Controllers\Info;

use App\Models\Site\Module;
use App\Models\Site\Page;
use App\Models\Site\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Settings;

class PageController extends Controller{

    protected $pages;

    protected $settings;

    protected $data;

    protected $globalData;

    protected $template;

    protected $module;

    /**
     * Создание нового экземпляра контроллера.
     *
     * @param  Page $pages
     * @return void
     */
    public function __construct(Page $pages, Template $template, Module $module){

        $this->settings = Settings::getInstance();

        $this->globalData = $this->settings->getParameters();

        $this->data =& $this->globalData['global_data'];

        $this->template = $template;

        $this->module = $module;

        $this->pages = $pages;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){

        $this->data['info']['page']  = $this->pages->getPageIfActive($id);

        $this->data['template'] = $this->template->getTemplateData($this->data, 'info', 'page', 'show', $id);

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

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){

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
