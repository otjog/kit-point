<?php

namespace App\Http\Controllers\Info;

use App\Models\Site\Module;
use App\Models\Site\Page;
use App\Models\Site\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Facades\GlobalData;

class PageController extends Controller{

    protected $pages;

    /**
     * Создание нового экземпляра контроллера.
     *
     * @param  Page $pages
     * @return void
     */
    public function __construct(Page $pages)
    {
        $this->pages = $pages;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['blog']['page'] = $this->pages->getPageIfActive($id);

        $globalData = GlobalData::getParametersForController($data, 'blog', 'page', 'show', $id);

        return view($globalData['template']['viewKey'], ['global_data' => $globalData]);
    }

}
