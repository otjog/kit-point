<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class CustomerGroup extends Model
{
    protected $table = 'shop_customer_groups';

    public function customers()
    {
        return $this->hasMany('App\Models\Shop\Customer');
    }

    public function maillings()
    {
        return $this->hasMany('App\Models\Site\Mailling');
    }

    public function price()
    {
        return $this->belongsTo(    'App\Models\Shop\Price\Price');
    }

    public function getDefaultCustomerGroup()
    {
        return self::select(
            'id',
            'active',
            'alias',
            'name',
            'price_id',
            'default'
        )
            ->where('default', '=',1)
            ->first();
    }

    public function getCustomerGroupById($id)
    {
        return self::select(
            'id',
            'active',
            'alias',
            'name',
            'price_id',
            'default'
        )
            ->where('id', '=', $id)
            ->first();
    }
}
