<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Page extends Model{

    protected $moduleMethods = [
        'show' => 'getPageIfActive',
    ];

    public function getModuleMethods($moduleMethod)
    {
        return $this->moduleMethods[$moduleMethod];
    }

    public function page_menus(){
        return $this->belongsToMany('App\Models\Site\PageMenu', 'page_menu_has_page')->withTimestamps();
    }

    public function getAllPages(){
        return self::select(
            'pages.id',
            'pages.active',
            'pages.alias',
            'pages.name',
            'pages.description',
            'pages.sort',
            'pages.created_at',
            'pages.updated_at'
        )
            ->get();
    }

    public function getActivePages(){
        return self::select(
            'pages.id',
            'pages.active',
            'pages.alias',
            'pages.name',
            'pages.description',
            'pages.sort',
            'pages.created_at',
            'pages.updated_at'
        )
            ->where('active', 1)
            ->get();
    }

    public function getActivePagesById($ids){
        return self::select(
            'pages.id',
            'pages.active',
            'pages.alias',
            'pages.name',
            'pages.description',
            'pages.sort',
            'pages.created_at',
            'pages.updated_at'
        )
            ->where('active', 1)
            ->whereIn('id', $ids)
            ->get();
    }

    public function getPageIfActive($id){
        return self::select(
            'pages.id',
            'pages.active',
            'pages.alias',
            'pages.name',
            'pages.description'
        )
            ->where('id', $id)
            ->where('active', 1)
            ->first();
    }

    public function getPage($id){
        return self::select(
            'pages.id',
            'pages.active',
            'pages.alias',
            'pages.name',
            'pages.description'
        )
            ->where('id', $id)
            ->first();
    }

    public function updatePage($id, $inputs){

        $data = $this->getFormDataFromRequest($inputs);

        self::where('id', $id)
            ->update($data);
    }


    /********Helpers**********/
    protected function getFormDataFromRequest($inputs){
        $data = ['active' => '0'];
        foreach ($inputs as $name => $value) {
            if($name !== '_method' && $name !== '_token' && $name !== 'files'){
                if($name === 'active'){
                    $value = '1';
                }
                $data[$name] = $value;
            }
        }
        return $data;
    }
}
