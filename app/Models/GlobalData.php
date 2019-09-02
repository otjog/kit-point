<?php

namespace App\Models;

use App\Models\Shop\CustomerGroup;
use App\Models\Shop\Price\Currency;
use App\Models\Site\Breadcrumb;
use Illuminate\Support\Facades\Cache;
use App\Models\Geo\GeoData;
use App\Models\Site\Template;
use App\Models\Site\Metatags;
use App\Models\Site\Module;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GlobalData
{
    public $data;

    public function __construct()
    {
        $json = DB::table('global_data')
            ->select('options')
            ->first();

        $this->data = json_decode($json->options, true);

        $this->data['today'] = date('Y-m-d');

        /* Add Currency */
        $currency = new Currency();

        $this->data['components']['shop']['currency'] =
            Cache::rememberForever('config:general:components:shop:currency', function() use($currency) {
                return $currency
                    ->select('id', 'char_code', 'symbol')
                    ->where('main', '1')
                    ->first();
            });
        /* End Currency */

        /* Add Geo */
        $geoData = new GeoData();

        $this->data['geo'] = $geoData->getGeoData();
        /* End Geo */

        $customer = Auth::user();

        $this->data['components']['shop']['customer'] = $customer;

        $customerGroup = new CustomerGroup();

        $this->data['components']['shop']['default_customer_group'] = $customerGroup->getDefaultCustomerGroup();

        if(isset($this->data['components']['shop']['customer']) && $this->data['components']['shop']['customer'] !== null)
            $this->data['components']['shop']['customer_group'] = $this->data['components']['shop']['customer']->customer_group;
        else
            $this->data['components']['shop']['customer_group'] = $this->data['components']['shop']['default_customer_group'];

    }

    public function addParameter($name, $value)
    {
        array_set($this->data, $name, $value);
    }

    public function pushArrayParameters($addData)
    {
        $this->data = array_merge($this->data, $addData);

        return $this->data;
    }

    public function getParameters()
    {
        return $this->data;
    }

    public function getParameter($path)
    {
        $pathArray = explode('.', $path);

        $temporary = [];

        foreach( $pathArray as $key => $level ){

            if($key === 0)
                $temporary = $this->data;

            if(isset($temporary[$level])){

                if($key+1 === count($pathArray))
                    return $temporary[$level];
                else
                    $temporary = $temporary[$level];
            } else {
                return null;
            }

        }
    }

    public function getParametersForController($data, $component, $model=null, $view=null, $id=null)
    {
        /* Add Template */
        $template = new Template();
        $data['template'] = $template->getTemplateData($component, $model, $view, $id);
        /* End Template */

        /* Add Metatags */
        $metatags = new Metatags();
        $data['template']['metatags'] = $metatags->getTagsForPage($data);
        /* End Metatags */

        /* Add Modules */
        $module = new Module();
        $data['modules'] = $module->getModulesData($data['template']['schema']);
        /* End Modules */

        $this->pushArrayParameters($data);

        /* Add Breadcrumbs */
        $breadcrumbs = new Breadcrumb();
        $modelCollection = $this->getParameter($component.'.'.$model);
        $this->data['breadcrumbs'] = $breadcrumbs->getBreadcrumbs($modelCollection, $component);
        /* End Breadcrumbs */

        return $this->data;
    }

}