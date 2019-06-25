<?php

namespace App\Models\Shop\Parameter;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model{

    protected $table = 'product_parameters';

    public function products()
    {
        return $this->belongsToMany('App\Models\Shop\Product\Product', 'product_has_parameter', 'parameter_id', 'product_id')
            ->withPivot('id', 'value')
            ->withTimestamps();
    }

}
