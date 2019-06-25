<?php

namespace App\Models\Shop\Product;

use App\Models\Shop\Parameter\Parameter;

class Brand extends Parameter {

    public function getActiveBrands(){
        return self::select(

            'product_has_parameter.value as name'
        )
            ->where('active', '=', 1)

            ->where('alias', '=', 'brand')

            ->rightJoin('product_has_parameter', function ($join) {
                $join->on('product_parameters.id', '=', 'product_has_parameter.parameter_id');
            })

            ->distinct()
            ->get();

    }

    public function getBrand($name)
    {
        return self::select(
            'product_has_parameter.value as name'
        )

            ->where('active', '=', 1)

            ->where('alias', '=', 'brand')

            ->rightJoin('product_has_parameter', function ($join) use ($name){
                $join->on('product_parameters.id', '=', 'product_has_parameter.parameter_id')
                    ->where('product_has_parameter.value', '=', $name);
            })

            ->distinct()
            ->get();

    }

}
