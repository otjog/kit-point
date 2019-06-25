<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
    //Home
    Route::get('/',         'HomeController@index'          )->name('home');

    //Search
    Route::get('/search',    'Search\SearchController@show' )->name('search');

    //Products
    Route::resource('/products',    'Shop\ProductController',   [ 'only' => [ 'show' ]]);

    //Categories
    Route::resource('/categories',  'Shop\CategoryController',  [ 'only' => [ 'index', 'show' ]]);

    //Brands
    Route::resource('/brands',      'Shop\BrandController',     [ 'only' => [ 'index', 'show' ]]);

    //Orders
    Route::resource('/orders',      'Shop\OrderController',     [ 'only' => [ 'store', 'create', 'show' ]]);

    //Pages
    Route::resource('/pages',       'Info\PageController',      [ 'only' => [ 'show' ]]);

    //Basket
    Route::resource('/baskets',     'Shop\BasketController',    [ 'only' => [ 'store', 'edit', 'update' ]]);

    //Pay
    Route::group(['prefix' => 'pay'], function(){

        Route::post('/confirm', 'Shop\PayController@confirm');

        Route::post('/execute', 'Shop\PayController@execute');

        Route::post('/redirect/{msg}', 'Shop\PayController@redirect');
    });

    //Image
    Route::resource('models.sizes.images',     'Image\ImageController',    [ 'only' => [ 'show' ]]);

    //Forms
    Route::group(['prefix' => 'form'], function () {

        //GeoData

        Route::post('geodata', function (\Illuminate\Http\Request $request, \App\Models\Geo\GeoData $geoData){
            $geoData->setGeoInput( $request->address_json );
            return back();
        })->name('GetGeo');

    });

    //Ajax
    Route::match(['get', 'post'], '/ajax', 'Ajax\AjaxController@index');

    /************************Админка*************************************************/

    Route::group(['prefix' => 'admin'], function () {
        Voyager::routes();
    });


    /******************Конец*Админка*************************************************/

    Route::get('/parse/{from}', 'Parse\ParseController@load');
    Route::get('/curs', 'Price\CurrencyController@getCur');
    Route::get('/test', function(){

    });