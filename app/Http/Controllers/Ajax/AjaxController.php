<?php

namespace App\Http\Controllers\Ajax;

use App\Models\Shop\Product\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shop\Services\Delivery;
use App\Models\Geo\GeoData;
use App\Models\Settings;

class AjaxController extends Controller{

    /**Инициализируем массив пришедших параметров*/
    protected $request = [];

    /**Инициализируем массив для хранения данных ответа*/
    protected $data = [];

    /**Инициализируем массив для хранения заголовков ответа*/
    protected $headers = [];

    /**Инициализируем переменную Ответ Сервера*/
    protected $response;

    public function index(Request $request){

        $this->request = $request->all();

        if(isset($this->request['module']) && $this->request['module'] !== null){

            //todo вернуть $next если нет Module

            switch($this->request['module']){

                case 'shipment' :

                    $ds = new Delivery();

                    $this->data = $ds->getPrices($this->request['parcel'], $this->request['alias'], $this->request['type'], $this->request['product_ids']);

                    break;

                case 'points' :

                    $ds = new Delivery();

                    $this->data = $ds->getPoints($this->request['alias']);

                    break;

                case 'product_filter' :

                    $products = new Product();

                    $this->data['products'] = $products->getFilteredProducts([], $request->toArray());

                    $url = $request->headers->get('x-previous-url');

                    //Настройка URI для вывода ссылок. Для работы постраничного вывода отфильтрованных товаров
                    $this->data['products']->setPath($url);

                    $this->data['parameters'] = $request->toArray();

                    //Добавляем заголовки в массив
                    $this->headers['Cache-Control'] = 'no-store';

                    break;

                case 'geo'  :

                    /** Записываем введенную пользователем Геолокацию в Сессию */
                    $geoDataObj = GeoData::getInstance();
                    $geoDataObj->setGeoInput($this->request['address_json']);

                    /**
                     * Получаем гео-данные
                     *
                     * После мы их отправим в виде json
                     *
                     * @var array data
                     */
                    $this->data = $geoDataObj->getGeoData();

                    /** Записываем обновленные данные в Глобальный массив */
                    $settings = Settings::getInstance();
                    $settings->addParameter('geo', $this->data);

                    break;

                case 'map'  :

                    $geoDataObj = GeoData::getInstance();
                    $this->data = $geoDataObj->getGeoData();

                    break;
            }

            return $this->sendResponse();

        }

    }

    private function sendResponse(){

        //Присваиваем переменной экземпляр Ответа Сервера
        $this->response = response();

        if($this->request['response'] === 'json') {
            $this->response = $this->response->json($this->data);
        }

        if($this->request['response'] === 'view'){

            $data['ajax'] = $this->data;

            //Получаем обновленные данные из Глобального массива для передачи во фронт
            $settings = Settings::getInstance();
            $globalData = $settings->pushArrayParameters($data);

            $view = $globalData['template']['name'] . '.modules.shop.' . $this->request['module'] . '._reload.' . $this->request['view'];

            //Добавляем к ответу Представление и обновленную переменную с данными
            $this->response = $this->response->view($view, ['global_data' => $globalData]);
        }

        if( count($this->headers) > 0){
            $this->response = $this->response->withHeaders($this->headers);
        }

        return $this->response;
    }

}
