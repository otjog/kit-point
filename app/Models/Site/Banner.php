<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use App\Models\Shop\Product\Product;

class Banner extends Model{

    protected $moduleMethods = [
        'index' => 'getActiveBanners',
    ];

    public function getModuleMethods($moduleMethod)
    {
        return $this->moduleMethods[$moduleMethod];
    }

    public function getActiveBanners(){
        $banners = self::select(
            'id',
            'source',
            'img',
            'title'
        )
            ->where('active', 1)
            ->get();

        return $this->composeSourceBanners($banners);

    }

    private function composeSourceBanners($banners){

        foreach($banners as $banner){
            //list( $banner->component, $banner->resource, $banner->resource_id) = explode('|', $banner->source);

            $matches = explode('|', $banner->source);

            if( count($matches) === 1 ){
                $banner->type = 'static';
            }else{
                $banner->type = 'dinamic';
                switch($banner->resource){
                    case 'product' :
                        $products = new Product();

                        $banner->data = $products->getActiveProduct($banner->resource_id);
                }
            }
        }
        return $banners;
    }

}
