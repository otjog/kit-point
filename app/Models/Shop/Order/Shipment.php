<?php

namespace App\Models\Shop\Order;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model{

    protected $moduleMethods = [
        'index' => 'getActiveShipmentMethods',
        'show' => 'getShipmentServiceByAlias',
    ];

    public function getModuleMethods($moduleMethod)
    {
        return $this->moduleMethods[$moduleMethod];
    }

    public function shopOrders(){
        return $this->hasMany('App\Models\Shop\Order\Order');
    }

    public function images()
    {
        return $this->morphToMany('App\Models\Site\Image', 'imageable');
    }

    public function getActiveShipmentMethods(){
        return self::select(
            'id',
            'alias',
            'name',
            'description',
            'is_service'
        )
            ->with('images')
            ->where('active', 1)
            ->get();
    }

    public function getShipmentServices(){
        $services =  self::select(
            'id',
            'alias',
            'name',
            'description',
            'is_service'
        )
            ->with('images')
            ->where('active', 1)
            ->where('is_service', 1)
            ->get();

        if (count($services) === 0)
            return $this->getDefaultShipments();

        return $services;
    }

    public function getDefaultShipments(){
        return self::select(
            'id',
            'alias',
            'name',
            'description',
            'is_service'
        )
            ->with('images')
            ->whereIn('alias', ['self', 'delivery'])
            ->get();
    }

    public function getShipmentServiceByAlias($alias){
        return self::select(
            'id',
            'alias',
            'name',
            'description',
            'is_service'
        )
            ->with('images')
            ->where('active', 1)
            ->where('is_service', 1)
            ->where('alias', $alias)
            ->get();
    }

    public function getShipmentMethodByAlias($alias){
        return self::select(
            'id',
            'alias',
            'name',
            'description',
            'is_service'
        )
            ->with('images')
            ->where('active', 1)
            ->where('alias', $alias)
            ->get();
    }

}
