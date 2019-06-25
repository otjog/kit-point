<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use App\Models\Shop\Product\Product;

class Banner extends Model{

    protected $moduleMethods = [
        'index' => 'getActiveBanners',
        'show' => 'getBannerByNameIfActive',
    ];

    public function getModuleMethods($moduleMethod)
    {
        return $this->moduleMethods[$moduleMethod];
    }

    public function slides()
    {
        return $this->hasMany('App\Models\Site\BannerSlide');
    }

    public function getActiveBanners()
    {
        return self::select(
            'id',
            'name'
        )
            ->with(['slides' => function($query)
            {
                $query->where('active', 1);
            }])
            ->where('active', 1)
            ->get();
    }

    public function getBannerByNameIfActive($name)
    {
        return self::select(
            'id',
            'name'
        )
            ->with('slides')
            ->where('active', 1)
            ->where('name', $name)
            ->get();
    }

}
