<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Metatags extends Model{

    private $data;

    private $search = [];

    private $replace = [];

    protected $casts = [
        'relations' => 'array',
        'values' => 'array',
    ];

    public function getTagsForPage($data){

        $this->data = $data;

        $metatagsKey = $this->data['template']['metatagsKey'];

        $contentKey = $this->data['template']['contentKey'];

        $componentKey = $this->getResourceName();

        $resourceData = $this->getResourceData($componentKey);

        $configData = $this->getConfigData($contentKey, $metatagsKey);

        if($configData !== null)
            $configData = $this->replaceData($configData, $resourceData);
        else
            $configData = $this->searchData();

        return $configData;
    }

    private function getResourceName(){
        if(isset($this->data['template']['componentKey']) && $this->data['template']['componentKey'] !== null){
            return $this->data['template']['componentKey'];
        }else{
            return 'home';
        }
    }

    private function getResourceData($componentKey){

        $resource = array_get($this->data, $componentKey, null);

        if(isset($resource[0])){
            return $resource[0];
        }elseif(isset($resource)){
            return $resource;
        }
        return [];
    }

    private function getConfigData($contentKey, $metatagsKey){

        // Ищем тэги для конкретного ресурса: shop.product.show.1
        $individualConfigData = $this->getMetaTagsFromDB($metatagsKey);
        // Ищем тэги общие для ресурса: shop.product.show
        $resourceConfigData = $this->getMetaTagsFromDB($contentKey);
        // Ищем тэги по умолчанию: home
        $defaultConfigData = $this->getMetaTagsFromDB('home');

        $configData = array_replace_recursive($defaultConfigData, $resourceConfigData, $individualConfigData);

        if(count($configData)>0)
            return $configData;
        return null;
    }

    private function replaceData($configData, $resourceData){

        $configRelations = $configData['relations'];

        foreach ($configRelations as $pattern => $relation) {
            $this->search[] = '{{' . $pattern . '}}';

            if(isset($resourceData[$relation]) && $resourceData[$relation] !== null){
                $this->replace[] = $resourceData[$relation];
            }else{
                $this->replace[] = '';
            }
        }

        $configValues = $configData['values'];

        foreach ($configValues as $pattern => $value) {

            $this->search[] = '{{' . $pattern . '}}';

            $this->replace[] = $value;
        }

        $this->search[] = '{{siteName}}';

        $this->replace[] = env('APP_NAME');


        $resultTags = [];

        foreach ($configData as $nameTag => $strTag) {
            $resultTags[$nameTag] = str_replace($this->search, $this->replace, $configData[$nameTag]);
        }

        return $resultTags;

    }

    private function searchData(){

        $title =& $metatags['title'];

        $resource = array_get($this->data, $this->data['template']['componentKey']);
        //dd($resource);
        $title = env('APP_NAME');

        if (isset($resource[0]['name']))
            $title .= ' - ' . $resource[0]['name'];
        elseif (isset($resource['name']))
            $title .= ' - ' . $resource['name'];

        return $metatags;

    }

    private function getMetaTagsFromDB($metatagsKey){
        $configData =  self::select(
            'title as title',
            'description as description',
            'keywords as keywords',
            'relations',
            'values'
        )
            ->where('key', $metatagsKey)
            ->first();

        if($configData === null)
            return [];
        else
            $configData = $configData->toArray();

        foreach ($configData as $key => $value) {
            if($value === null)
                $configData[$key] = [];
        }

        return $configData;
    }

}
