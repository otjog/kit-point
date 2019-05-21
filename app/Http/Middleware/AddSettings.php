<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Settings;
use App\Models\Geo\GeoData;

class AddSettings{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){

        $settings = Settings::getInstance();

        $geoData = GeoData::getInstance();

        $settings->addParameter( 'geo', $geoData->getGeoData());

        return $next($request);

    }
}
