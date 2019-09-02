<?php

namespace App\Http\Controllers\Price;

use App\Http\Controllers\Controller;
use phpQuery;
use App\Models\Shop\Product\Product;
use App\Models\Shop\Category\Category;
use App\Models\Shop\Price\Price;
use Illuminate\Support\Facades\DB;

class ParseController extends Controller{

    private $products;
    private $categories;
    private $prices;

    private $url = 'http://kombiyedekparcaal.com';
    private $cookieFile = 'cookie.txt';
    private $pathToCurrentFolder = '../public/storage/';
    private $imageFolder = 'img/shop/product/';

    public function __construct(Product $products, Category $categories, Price $prices){
        $this->categories   = $categories;
        $this->products     = $products;
        $this->prices       = $prices;
    }

    public function parse(){

        $html_str = $this->connectToSite();

        $this->updateCategories($html_str);

        $this->updateProducts();

        unlink($this->pathToCurrentFolder.$this->cookieFile);

    }

    private function connectToSite(){
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded',
            'Cookie: language=en; currency=EUR;'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->pathToCurrentFolder . $this->cookieFile);
        $html_str = curl_exec($ch);
        curl_close($ch);

        return $html_str;
    }

    private function connectWithSession($url){
        $ch = curl_init($url.'?limit=10000');
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->pathToCurrentFolder.$this->cookieFile);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    private function updateCategories($html_str){

        $currentTableName = 'categories';

        $this->categories
            ->where('active', '1')
            ->update(['active' => '0']);

        $categoriesCollection = $this->categories->getAllCategories();

        $newData = [
            'new'       => [],
            'update'    => []
        ];

        $html_dom = phpQuery::newDocument($html_str);
        $links = $html_dom->find('div.box-category > ul > li > a');

        foreach($links as $link){

            $pq_link = pq($link);

            $currentParameters = [
                'active'        => '1',
                'original_name' => trim($pq_link->text()),
                'url'           => $pq_link->attr('href'),
            ];

            $category = $this->getCurrentCategory($categoriesCollection, $currentParameters['original_name']);

            if($category !== null){
                foreach($currentParameters as $name_param => $value ){
                    switch($name_param){
                        case 'active'           :
                        case 'original_name'    :
                        case 'url'              :
                            if($value !== $category[$name_param]){
                                $newData['update'][$name_param][$category['id']] = $value;
                            }
                            break;
                    }
                }
            }else{

                $currentParameters = $this->addTimeStamp($currentParameters);

                $newData['new'][] = $currentParameters;
            }

        }

        phpQuery::unloadDocuments();
        $this->updateCurrentTable($newData, $currentTableName);

    }

    private function updateProducts(){

        $currentTableName = 'products';

        $this->products
            ->where('active', '1')
            ->update(['active' => '0']);

        $productsCollection = $this->products->getAllProducts();

        $categoriesCollection = $this->categories->getAllCategories();

        $newData = [
            'new'       => [],
            'update'    => []
        ];

        $priceData = [];
        $imageData = [];

        foreach($categoriesCollection as $category){

            $html_str = $this->connectWithSession($category->url);
            $category_html_dom = phpQuery::newDocument($html_str);

            $links = $category_html_dom->find('ul.product-list > li > div.name > a');

            if(count($links) > 0){
                foreach($links as $link){

                    $pq_link = pq($link);

                    $html_str = $this->connectWithSession($pq_link->attr('href'));

                    $currentParameters = [
                        'active'        => '1',
                        'category_id'   => $category->id,
                        'url'           => $pq_link->attr('href'),
                        'image'         => null,
                        'thumbnail'     => null,
                    ];

                    $price = 0;
                    $html_dom = phpQuery::newDocument($html_str);

                    $image          = $html_dom->find('#content #overview div.left  div.image img#image');
                    $name           = $html_dom->find('#content #overview div.right h1');
                    $productInfo    = $html_dom->find('#content #overview div.right div.description');
                    $description    = $html_dom->find('#content #description p');

                    if(count($productInfo->elements) > 0){

                        $matches = preg_split('/<br>/', strip_tags(trim(str_replace(' ', '', $productInfo->html())),'<br>'));

                        foreach($matches as $match){

                            $result = explode(':', trim($match));

                            if($result[0] === 'Price'){
                                $price  = (float) $result[1];
                                $tax    = (float) $result[2];
                            }else{
                                switch($result[0]){
                                    case 'ProductCode' : $currentParameters['scu']   = $result[1]; break;
                                }
                            }

                        }

                    }

                    if(isset($currentParameters['scu'])){

                        file_put_contents(
                            $this->pathToCurrentFolder . 'scu.txt',
                            $currentParameters['scu']."\r\n",
                            FILE_APPEND);

                        $priceData[$currentParameters['scu']] = $price;

                        if(count($image->elements) > 0){
                            $imageData[$currentParameters['scu']] = $image->attr('src');
                        }

                        $currentParameters['original_name'] = $name->text();
                        $currentParameters['description']   = $description->text();

                        $product = $this->getCurrentProduct($productsCollection, $currentParameters['scu']);
                        if($product !== null){
                            foreach($currentParameters as $name_param => $value ){
                                switch($name_param){
                                    case 'active'           :
                                    case 'category_id'      :
                                    case 'scu'              :
                                    case 'original_name'    :
                                    case 'url'              :
                                    case 'description'      :

                                        if($value !== $product[$name_param]){
                                            $newData['update'][$name_param][$product['id']] = $value;
                                        }
                                        break;
                                }
                            }
                        }else{

                            $currentParameters = $this->addTimeStamp($currentParameters);

                            $newData['new'][$currentParameters['scu']] = $currentParameters;
                        }
                    }else{
                        // dump($pq_link->attr('href'));
                    }

                    phpQuery::unloadDocuments($html_dom->documentID);

                }

            }

            phpQuery::unloadDocuments($category_html_dom->documentID);

        }

        $this->updateCurrentTable($newData, $currentTableName);

        $this->updatePrice($priceData);

        $this->updateImage($imageData);

    }

    private function updatePrice($priceData, $price_name = 'recommended', $productPrices = []){
        $currentTableName = 'product_has_price';

        //todo переписать функцию, а то там '*'
        $price = Price::firstOrCreate([
            'name' =>  $price_name
        ]);

        DB::table($currentTableName)
            ->where('active', 1)
            ->where('price_id', $price->id)
            ->update(['active' => 0]);

        $newData = [
            'new'       => [],
            'update'    => []
        ];

        if( count( $priceData ) > 0){
            $productsCollection = $this->products->getAllProducts();

            foreach($priceData as $scu => $price) {

                $product = $this->getCurrentProduct($productsCollection, $scu);

                if($product !== null){

                    $currentParameters = [
                        'active'        => '1',
                        'product_id'    => $product->id,
                        'price_id'      => $price->id,
                        'value'         => $price
                    ];

                    $currentParameters = $this->addTimeStamp($currentParameters);

                    $newData['new'][] = $currentParameters;
                }
            }

        }elseif( count( $productPrices ) > 0 ){

            foreach($productPrices as $productPrice){

                $productPrice->price_id    = $price->id;
                $productPrice->value       = ceil($productPrice->value * $productPrice->quotation);
                unset( $productPrice->quotation );

                $productPrice = $this->addTimeStamp($productPrice->toArray());

                $newData['new'][] = $productPrice;

            }
        }

        $this->updateCurrentTable($newData, $currentTableName);
    }

    private function updateImage($imageData){

        $currentTableName = 'products';

        $productsCollection = $this->products->getAllProducts();

        $thumbHeight    = 150;
        $thumbWidth     = 150;

        $imageHeight    = 500;
        $imageWidth     = 500;

        $newData = [
            'new'       => [],
            'update'    => []
        ];

        foreach($imageData as $scu => $src){

            $product = $this->getCurrentProduct($productsCollection, $scu);
            if($product !== null){
                $newImageParameters = [
                    'thumb' => [
                        'height'    => $thumbHeight,
                        'width'     => $thumbWidth,
                        'name'      => $scu .'-thumbnail-' . $thumbWidth . 'x'. $thumbHeight
                    ],
                    'image' => [
                        'height'    => $imageHeight,
                        'width'     => $imageWidth,
                        'name'      => $scu
                    ]
                ];

                if($this->notExistImages($newImageParameters)){

                    $currentParameters = [
                        'image'     => null,
                        'thumbnail' => null
                    ];

                    $parsedUrl = parse_url($src);
                    $path = explode('/', $parsedUrl['path']);

                    $url = $parsedUrl['scheme'].'://'.$parsedUrl['host'];
                    foreach ($path as $key => $folder) {

                        if( count($path)-1 === $key ){
                            $url .= rawurlencode( $folder );
                        }else{
                            $url .= $folder.'/';
                        }

                    }

                    $thumb = imagecreatetruecolor($newImageParameters['thumb']['width'], $newImageParameters['thumb']['height']);
                    $image = @imagecreatefromjpeg($url);

                    $sourceImageData =  getimagesize($url);

                    $sourceImageParameters = [
                        'width'     => $sourceImageData[0],
                        'height'    => $sourceImageData[1],
                        'type'      => explode('/', $sourceImageData['mime'])
                    ];

                    $newThumb = imagecopyresized(
                        $thumb,
                        $image,
                        0,
                        0,
                        0,
                        0,
                        $newImageParameters['thumb']['width'],
                        $newImageParameters['thumb']['height'],
                        $sourceImageParameters['width'],
                        $sourceImageParameters['height']);

                    $newThumbName = $newImageParameters['thumb']['name'] . '.' . $sourceImageParameters['type'][1];
                    $newImageName = $newImageParameters['image']['name'] . '.' . $sourceImageParameters['type'][1];

                    if($newThumb){
                        $res = imagejpeg($thumb, $this->pathToCurrentFolder.$this->imageFolder.'thumbnail/'.$newThumbName, 100);

                        if($res){
                            $currentParameters['thumbnail'] = $newThumbName;
                        }

                    }

                    if($image){
                        $res = imagejpeg($image, $this->pathToCurrentFolder.$this->imageFolder.$newImageName, 100);

                        if($res){
                            $currentParameters['image'] = $newImageName;
                        }
                    }

                    foreach($currentParameters as $name_param => $value ){
                        switch($name_param){
                            case 'image'            :
                            case 'thumbnail'        :
                                if($value !== $product[$name_param]){
                                    $newData['update'][$name_param][$product['id']] = $value;
                                }
                                break;
                        }
                    }
                }
            }
        }

        $this->updateCurrentTable($newData, $currentTableName);
    }

    /***********************************************/

    private function getCurrentCategory($categories, $original_name){
        return $categories->first(function($value, $key) use ($original_name){
            return $value->original_name === $original_name;
        });
    }

    private function getCurrentProduct($products, $scu){
        return $products->first(function($value, $key) use ($scu){
            return $value->scu === $scu;
        });
    }

    private function updateCurrentTable($data, $currentTableName){
        foreach($data as $condition => $parameters){
            if( count($parameters) > 0 ){
                switch($condition){
                    case 'new'      :   $this->insertRowsInTable($data[$condition], $currentTableName); break;
                    case 'update'   :   $this->updateRowsInTable($data[$condition], $currentTableName); break;
                }
            }
        }
    }

    private function insertRowsInTable($data, $currentTableName){

        DB::table($currentTableName)->insert(
            $data
        );
    }

    private function updateRowsInTable($data, $currentTableName){
        $sqlQueryString = "UPDATE " . $currentTableName . " SET";
        $cntParams = 0;
        $arrayIds = [];
        $params = [];
        foreach($data as $name_param => $array_params){
            if($cntParams !== 0){
                $sqlQueryString .=",";
            }
            $cntParams++;

            $sqlQueryString .= " " . $name_param . " = CASE ";
            foreach($array_params as $id => $param){
                $sqlQueryString .= "WHEN id = " . $id . " THEN ? ";

                if(!(in_array($id, $arrayIds))){
                    $arrayIds[] = $id;
                }

                $params[] = $param;
            }
            $sqlQueryString .= "ELSE " . $name_param . " END";
        }

        $cnt = 0;
        $ids = "";
        foreach($arrayIds as $id){
            if($cnt !== 0){
                $ids .= ", ";
            }
            $ids .= $id;
            $cnt++;
        }

        $sqlQueryString .= " WHERE id IN (" . $ids . ")";

        return DB::update($sqlQueryString, $params);
    }

    private function notExistImages($imageParameters){
        $path = $this->pathToCurrentFolder.$this->imageFolder;
        $formats = ['jpeg', 'jpg', 'png', 'gif'];

        foreach($formats as $format){
            if( file_exists($path.$imageParameters['thumb']['name'].$format ) && file_exists($path.$imageParameters['image']['name'].$format ) )
                return false;
        }

        return true;
    }

    private function addTimeStamp($currentParameters){
        $currentParameters['created_at'] = date('Y-m-d H:i:s',time());
        $currentParameters['updated_at'] = date('Y-m-d H:i:s',time());

        return $currentParameters;
    }

    /////////////////////////////////////////////////

    public function rename(){

        $currentTableName = 'products';

        $brandReName      = [
            'AIRFEL'        =>  'Airfel',
            'AIRFELL'       =>  'Airfel',
            'AİRFELL'       =>  'Airfel',
            'AİRFEL'        =>  'Airfel',
            'ALARKO'        =>  'Alarko',
            'ARCELIK'       =>  'Arcelik',
            'ARÇELİK'       =>  'Arcelik',
            'ARİSTON'       =>  'Ariston',
            'ARISTON'       =>  'Ariston',
            'BAXI'          =>  'Baxi',
            'BAYMAK'        =>  'Baxi',
            'BAYKAN'        =>  'Baykan',
            'BERETTA'       =>  'Beretta',
            'BOSCH'         =>  'Bosch',
            'BUDERUS'       =>  'Buderus',
            'DEMİRDÖKÜM'    =>  'Demirdokum',
            'DEMİIDOKUM'    =>  'Demirdokum',
            'DEMIRDOKUM'    =>  'Demirdokum',
            'D.DOKUM'       =>  'Demirdokum',
            'ECA'           =>  'Eca',
            'VAILLANT'      =>  'Vaillant',
            'FERROLI'       =>  'Ferroli',
            'FERROLİ'       =>  'Ferroli',
            'IMMERGAS'      =>  'Immergas',
            'İMMERGAS'      =>  'Immergas',
            'PROTHERM'      =>  'Protherm',
            'SUSLER'        =>  'Protherm',
            'SÜSLER'        =>  'Protherm',
            'VAİLLANT'      =>  'Vaillant',
            'VAILANT'       =>  'Vaillant',
            'VIESSMANN'     =>  'Viessmann',
            'VİESSMANN'     =>  'Viessmann',
            'VIESSMAN'      =>  'Viessmann',
            'VİESSMAN'      =>  'Viessmann',
            'WOLF,'         =>  'Wolf',
            'WOLF'          =>  'Wolf',
            'AUER'          =>  'Auer',
        ];
        $productReName    = [

            'HONEYWEL'                          => 'HONEYWELL',
            'EGS'                               => 'EGIS',
            'VİTODENTS'                         => 'VITODENS',
            'LEOPART'                           => 'Леопард',
            'LYNX'                              => 'Рысь',
            'GRUNFOS'                           => 'GRUNDFOS',
            'CLASIC'                            => 'CLASSIC',
            'BLACK MAMBA'                       => 'BLACK-MAMBA',
            'BERATTA'                           => 'BERETTA',

            'BOILER SPACE ANCHOR'                                       => 'Анкер',
            'CHIMNEY MICRO SWITCH'                                      => 'Микроавключатель в сборе',
            'STUD NUT'                                                  => 'Направляющая шпильки микропереключателя (втулка латунная)',
            'CONNECTING PIPE FOR'                                       => 'Присоединительный патрубок для',
            'CONNECTING PART FOR'                                       => 'Присоединительный патрубок для',
            'HERMETIC BOILER CHIMNEY'                                   => 'Коаксиальный дымоход -',
            'HERMETIC CHIMNEY'                                          => 'Коаксиальный дымоход -',
            'FLANGE CHIMNEY MIRROR'                                     => 'розетка 110мм',
            'CHIMNEY MIRRORS'                                           => 'розетка 110мм',
            'CHIMNEY'                                                   => 'Дымоход -',
            'CONNECTION SEAL PLASTIC'                                   => 'Соединительная муфта дымохода',
            'EXTENSION PIPE'                                            => 'удлинительная труба',
            'EXTENSION TUBE'                                            => 'удлинительная труба',
            'STANDARD BOILER TOOL SETS'                                 => 'комплект 75см',
            'BOILER UPGRADE'                                            => 'угол и удлинительная труба',
            'CARD SOCKET PUMP'                                          => 'Циркуляционный насос с разъемом',
            'DOUBLE WATER INLET'                                        => 'с двойным подключением воды',
            'DOUBLE WATER INLER'                                        => 'с двойным подключением воды',
            'PUMP RECOR KIT 11/2'                                       => 'Гайки циркуляционного насоса',
            'PUMP AIRVENT KIT'                                          => 'Комплект воздухоотводчика для циркуляционного насоса',
            'THREE WAY MOTOR VALVE CONNECTION CLIPS'                    => 'Клипса крепления мотора трехходового клапана',
            '3 WAY MOTOR CONNECTION CABLE'                              => 'Кабель подключения мотора трехходового клапана',
            'WIRED NTC SENSOR'                                          => 'Датчик NTC с проводом',
            'MAIN EXCHANGER PLUG IN CLIPS'                              => 'Клипса основного теплообменника',
            'EXPANSION TANK PRESSURE MEASUREMENT APPARATUS'             => 'Манометр для расширительных баков',
            'THERMOMANOMETER PRESSURE AND TEMPERATURE GAUGE'            => 'Термоманометр',
            'TEHRMOMANOMETER PRESSURE AND TEMPERATURE GAUGE'            => 'Термоманометр',
            'PRESSURE AND TEMPERATURE GAUGE'                            => 'Термоманометр',
            'THREE WAY PLASTIC GROUP'                                   => 'Блок трехходового клапана пластик',
            'TIN PLATE DIAPHRAGM-MEBRAN SEAL'                           => 'Мембрана с тарелкой',
            'BALL VALVE DISCHARGE FAUCET'                               => 'Сливной шаровый кран',
            'DISCHARGE FAUCET'                                          => 'Сливной клапан',
            'WATER DOUBLE MICROSWITCH'                                  => 'Датчик давления теплоносителя',
            'WATER PRESSURE MICROSWITCH'                                => 'Датчик давления теплоносителя',
            'WATER PRESSURE SWITCH'                                     => 'Датчик давления теплоносителя',
            'WATER PRESSURE TRANSDUCER'                                 => 'Датчик давления теплоносителя',
            'WATER PRESSURE PROBE'                                      => 'Датчик давления теплоносителя',
            'WATER PRESSUR SWITCH'                                      => 'Датчик давления теплоносителя',
            'WATER PRESSURE TURBINE PLATE'                              => 'Датчик давления теплоносителя',
            'FAN DOUBLE VENTURE'                                        => 'Трубка вентури вентилятора, двойная',
            'FAN MOTOR SINGLE VENTURE'                                  => 'Трубка вентури вентилятора, одинарная',
            'FILLING FAUCET HEAD'                                       => 'Ручка подпиточного клапана',
            'SQUARE MOUTH FAN MOTOR'                                    => 'Вентилятор с квадратным подключением',
            'WHITE BUTTON'                                              => 'Белая ручка',
            'BLACK IMMERSION NTC SENSOR'                                => 'Датчик NTC погружной, черного цвета',
            'TRANSMITTER CLIPS'                                         => 'Клипса преобразователя',
            'THE EXTENSION OF THE EXPANSION TANK'                       => 'Удлинитель для расширительного бака',
            'PLUMBING CLEANING CHEMICALS'                               => 'Промывочная жидкость',
            'CLEANING PLUMBING'                                         => 'Промывочная жидкость',
            'RADIATOR CLEANING CHEMICAL'                                => 'Промывочная жидкость',
            'RUST REMOVER LUBRICANTS'                                   => 'удалитель ржавчины, смазка',
            'BOILER PLUMBING PROTECTION CHEMICALS'                      => 'Ингибитор коррозии',
            'PLUMBING CLEANER CHEMICAL'                                 => 'Промывочная жидкость',
            'PLUMBING PROTECTIVE'                                       => 'Ингибитор коррозии',
            'NOISE REDUCER'                                             => 'Шумоподавляющая смазка',
            'PLUMBING LEAK SEALER CHEMICAL'                             => 'Добавка против утечек',
            'LEAK REDUCTION'                                            => 'Добавка против утечек',
            'PLUMBING LEAK SEALER'                                      => 'Добавка против утечек',
            'INSTALLATION CLEANING MACHINE'                             => 'Насос для чистки систем отопления',
            'PLUMBING CLEANING MACHINE'                                 => 'Насос для чистки систем отопления',
            'LEAK DETECTION SPRAY'                                      => 'Спрей проверки герметичности соединений',
            'GAS ALARM DETECTOR'                                        => 'Газоанализатор',
            'ELECTRONIC CART WITH LED'                                  => 'Плата управления с LED-дисплеем',
            'DOUBLE MICRO SWITCH'                                       => 'Двойной микровыключатель',
            'PRESSURE REDUCER'                                          => 'Редуктор давления',
            'PANEL RADIATOR AIR VENT'                                   => 'Панельный радиатор - Ключ воздухоотводчика',
            'CARTRIDGE BIG'                                             => 'трехходовой клапан с большим картриджем',
            'PLASTIC PROSESTAT'                                         => 'Датчик давления воздуха',
            'SAFETY VALVE CONNECTION'                                   => 'Коннектор предохранительного клапана',
            'EXCHANGER PLASTIC'                                         => 'Патрубок для теплообменника',
            'DOUBLE CABLE IGNITION ELECTRODE'                           => 'Двойной блок электродов с кабелем',
            'WATER HEAER FLOW TURBINE'                                  => 'Датчик протока с датчиком температуры',
            'WATER HEATER  TURBINE'                                     => 'Датчик протока с датчиком температуры',
            'IGNITION ELECTRODE CABLE'                                  => 'Кабель электрода розжига',
            'TIN PLATE FAN MOTOR'                                       => 'Вентилятор с посадочной пластиной',
            'CARD READER TURBINE'                                       => 'Датчик протока с платой',
            'TURBINE READER WİTH CARD'                                  => 'Датчик протока с платой',
            'VALVE APPARATUS'                                           => 'подключение теплообменника',
            'WATER PROSSESTAT'                                          => 'водный прессостат',
            'NATURAL GAS PASTE'                                         => 'уплотнительная паста для газа',
            'CABLE CLIPS'                                                   => 'стяжные хомуты',

            'OLD TYPE'                          => 'Старого образца',
            'NEW TYPE'                          => 'Нового образца',
            'YENİ'                              => 'Нового образца',
            'L TYPE'                            => 'Угловой (L-type)',
            'Y TYPE'                            => 'Угловой (Y-type)',
            'VERTICAL'                          => 'вертикальный',
            'HOOKLESS'                          => 'с крюком',
            'HOOK'                              => 'с крюком',
            'SINGLE-STAGE'                      => 'односкоростной',
            'DOUBLE CYCLE'                      => 'двухскоростной',
            'TWO-STAGE'                         => 'двухскоростной',
            'SURFACE TYPE PLUG IN'              => 'Накладной',
            'SURFACE TYPE BEAT'                 => 'Накладной',
            'PLUG IN PIPE TYPE'                 => 'Накладной, под трубу диаметром',
            'INTERNAL KIT'                      => 'рем.комплект',
            'REPAIR KIT'                        => 'рем.комплект',
            'WITH BUTTON'                       => 'с кнопкой',
            'WITH CARD'                         => 'с платой',
            'CARD READER'                       => 'с платой',
            'LT '                               => 'л. ',
            'PLAKA'                             => 'пластин',
            'GREEN'                             => 'зеленого цвета',
            'GREY'                              => 'серого цвета',
            'WHITE'                             => 'белого цвета',
            'BLACK'                             => 'черный цвет ',
            'RED'                               => 'красный цвет ',
            'DOUBLE '                           => 'Двойная',
            'SQUARE MOUTH'                      => 'квадратное подключение',
            'METAL'                             => 'Металлический',
            'OUTSIDE DENTAL'                    => 'с нар.резьбой',
            'EXTERNAL'                          => 'с нар.резьбой',
            'INTERNAL GEAR'                     => 'с вн.резьбой',
            'WITH  PLASTIC GEAR'                => 'с пластиковой резьбой',
            'WITH SEAL'                         => 'с прокладкой',
            'WITH ORNIK'                        => 'с муфтой',
            'PLASTIC GEAR'                      => 'с пластиковой резьбой',
            'WITH READER'                       => 'с датчиком протока',
            'ONE GEAR'                          => 'с одной резьбой',
            'GEARS'                             => 'с резьбой',
            'GEAR'                              => 'с резьбой',
            'PLASTIC'                           => 'Пластиковый',
            'RECTANGULAR HOOKLESS'              => 'Прямоугольный',
            'RECTANGULAR'                       => 'Прямоугольный',
            'RECTANCULAR'                       => 'Прямоугольный',
            'SQUARE'                            => 'Прямоугольный',
            'ENERGY EFFICIENCY'                 => 'Энергоэффективный',
            'THIN'                              => 'Тонкий',
            'PLUG IN'                           => 'под клипсу',
            'BUTTERFLY HEAD'                    => 'Бабочка',
            'BUTTERFLY'                         => 'Бабочка',
            'WIRELESS'                          => 'беспроводной',
            'LONG RECOR'                        => 'с длинной резьбой',
            'LONG SIBOP'                        => 'с длинным ниппелем',
            'WİTH RECOR'                        => 'с гайкой',
            'WITH FAUCET'                       => 'с краном',
            'WITH CABLE'                        => 'с кабелем',
            'CONDENSING BOILER'                 => '(для конденсационного котла)',
            'CONDENSİNG BOILER'                 => '(для конденсационного котла)',
            'CONDENSING DEVICES'                => '(для конденсационного котла)',
            'CONDENSING'                        => '(для конденсационного котла)',
            'COVER CLIPS'                       => 'клипса облицовочной панели',
            'CLIPS'                             => 'клипса',
            'CONNECTION NUT'                    => 'гайка соединения',
            'SHORT'                             => 'короткий',
            'AUTOMATIC'                         => 'Автоматический',
            'AUTOMATİC'                         => 'Автоматический',
            '(BRASS)'                           => '(Латунь)',
            'BRASS'                             => '(Латунь)',
            'SOCKETS'                           => 'контакта',
            'SOCKET'                            => 'контакта',
            'BACK OUTPUT'                       => '(выход сзади)',
            'INDOOR KIT'                        => '(внутренний комплект)',
            'LONG SHAFT'                        => '(длинный шток)',
            'ELBOW'                             => 'угол',
            'DEGREES'                           => 'градусов',
            'LONG'                              => 'длинный',




            'VENTURE'                           => 'Трубка вентури',
            'OF INTERCONNECTORS KMP SEGMENT'    => 'соединительный элемент',
            'INTERCONNECTORS SEGMENT'           => 'соединительный элемент',
            'INTERCONNECTOR SEGMENT'            => 'соединительный элемент',
            'INTERCONNECTOR KMP'                => 'соединительный элемент',
            'HYDRAULIC GROUP'                   => 'Гидравлическая группа',
            'COLD WATER BLOCK'                  => 'узел холодной воды',
            'HOT WATER BLOCK'                   => 'узел горячей воды',
            'CHECK VALVE'                       => 'Обратный клапан ',
            'AIR PROSESTAT'                     => 'Датчик давления воздуха',
            'AIR PROSSESTAT'                    => 'Датчик давления воздуха',
            'PROSSESTAT'                        => 'Датчик давления воздуха',
            'AIR SWITCH'                        => 'Датчик давления воздуха',
            'NATUREL GAS VALVE'                 => 'Газовый кран',
            'EXCHANGER ORINGS'                  => 'Комплект прокладок теплообменника',
            'ORING'                             => 'Прокладка',
            'CLEANER'                           => 'Жидкость для удаления шлама',
            'PANEL RADIATOR'                    => 'Панельный радиатор -',
            'TEFLON BANT'                       => 'ФУМ-лента',
            'TRANSMITTER'                       => 'Преобразователь',
            'CHIMNEY EXTENSION PIPE'            => 'Удлинитель дымохода',
            'CHIMNEY EXTENSION TUBE'            => 'Удлинитель дымохода',
            'EXTENSION'                         => 'Удлинитель',
            'HEATER DIAPHRAGM -MEBRAN SEAL'     => 'Мембрана',
            'DIAPHRAGM MEBRAN SEAL'             => 'Мембрана',
            'DIAPHRAGM -MEBRAN SEAL'            => 'Мембрана',
            'DIAPHRAGM-MEBRAN SEAL'             => 'Мембрана',
            'DIAPHRAGM SEAL'                    => 'Мембрана',
            'MEBRAN SEAL'                       => 'Мембрана',
            'DIAPHRAGM KIT'                     => 'Комплект мембраны',
            'DIAPHARAGM KIT'                    => 'Комплект мембраны',
            'HEAT SETTİNG BUTTON'               => 'Ручка регулятора температуры',
            'SETTING BUTTON'                    => 'Ручка регулятора',
            'SETTİNG BUTTON'                    => 'Ручка регулятора',
            'BUTTON KIT'                        => 'Ручка',
            'POTENT ON-OFF BUTTON'              => 'Ручка Вкл/Выкл',
            'ON-OFF BUTTON'                     => 'Ручка Вкл/Выкл',
            'BUTTON'                            => 'Ручка',
            'BY-PASS APPARATUS'                 => 'Байпас патрубок',
            'BY PASS PART'                      => 'Байпас комплект',
            'BY-PASS'                           => 'Байпас',
            'BLOWER READER'                     => 'Датчик оборотов вентилятора',
            'CHIMNEY FAN MOTOR'                 => 'Вентилятор',
            'FAN MOTOR'                         => 'Вентилятор',
            'FAN'                               => 'Вентилятор',
            'BLOWER MOTOR'                      => 'Вентилятор',
            'BLOWER'                            => 'Вентилятор',
            'FOLD PLATE EXCHANGER'              => 'Пластинчатый теплообменник',
            'PLATE EXCHANGER'                   => 'Пластинчатый теплообменник',
            'ACTUATOR THREE WAY MOTOR VALVE'    => 'Трехходовой клапан с мотором',
            'STEP MOTOR THREE WAY VALVE'        => 'Мотор трехходового клапана',
            '3 WAY RIGHT BLOCK'                 => 'Блок трехходового клапана',
            '3 WAY VALVE WATER GROUP'           => 'Блок трехходового клапана',
            'THREE WAY D TYPE VALVE'            => 'Блок трехходового клапана',
            'THREE WAY VALVE GROUP'             => 'Блок трехходового клапана',
            'THREE WAY GROUP'                   => 'Блок трехходового клапана',
            'THREE WAY BLOCK'                   => 'Блок трехходового клапана',
            '3 WAY BLOCK'                       => 'Блок трехходового клапана',
            '3 WAY GROUP'                       => 'Блок трехходового клапана',
            'THREE-WAY VALVE MOTOR'             => 'Мотор трехходового клапана',
            'THREE WAY MOTOR VALVE'             => 'Мотор трехходового клапана',
            '3 WAY MOTOR VALVE'                 => 'Мотор трехходового клапана',
            '3 WAY MOTOR'                       => 'Мотор трехходового клапана',
            'VALVE MOTOR'                       => 'Мотор трехходового клапана',
            'THREE WAY VALVE'                   => 'Трехходовой клапан',
            'THREE-WAY VALVE'                   => 'Трехходовой клапан',
            '3 WAY VALVE'                       => 'Трехходовой клапан',
            '3 WAY'                             => 'Трехходовой клапан',
            'MAIN HEAT EXCHANGER'               => 'Основной теплообменник',
            'MAIN  HEAT EXCHANGER'              => 'Основной теплообменник',
            'MAIN HEAT XCHANGER'                => 'Основной теплообменник',
            'MAIN EXCHANGER'                    => 'Основной теплообменник',
            'MAİN EXCHANGER'                    => 'Основной теплообменник',
            'THERMOMANOMETER'                   => 'Термоманометр',
            'MANOMETER'                         => 'Манометр',
            'DIFFERENTIAL PRESSURE'             => 'Дифференциальный',
            'SAFETY VALVE'                      => 'Предохранительный клапан',
            'GAS VALVE'                         => 'Газовый клапан',
            'GAZ VALVE'                         => 'Газовый клапан',
            'TEMPERATURE (IMMERSION) SENSOR'    => 'Датчик температуры погружной',
            'IMMERSION SENSOR'                  => 'Датчик температуры погружной',
            'IMMERSION TYPE SENSOR'             => 'Датчик температуры погружной',
            'IMMERSION NTC SENSOR'              => 'Датчик NTC погружной',
            'THERMISTOR NTC SENSOR'             => 'Датчик NTC погружной',
            'IMMERSION TYPE NTC SENSOR'         => 'Датчик NTC погружной',
            'YOĞUŞMALI KOMBİ NTC SENSÖR'        => 'Датчик NTC погружной',
            'NTC SENSOR'                        => 'Датчик NTC',
            'SENSOR NTC'                        => 'Датчик NTC',
            'WATER HEATER SENSOR'               => 'Датчик NTC',
            'WATER PRESSURE SENSOR'             => 'Датчик давления теплоносителя',
            'FLOW REGULATOR'                    => 'Ограничитель потока',
            'WATER FLOW SWITCH'                 => 'Датчик протока',
            'MOON TURBINE READER'               => 'Датчик протока',
            'SU AKIŞ TÜRBİNİ'                   => 'Датчик протока',
            'WATER FLOW SWİTCH'                 => 'Датчик протока',
            'FLOW SWITCH READER'                => 'Датчик протока',
            'FLOW SWITCH'                       => 'Датчик протока',
            'FLOW READER'                       => 'Датчик протока',
            'EXPANSION TANK'                    => 'Расширительный бак',
            'EXPANSION.TANK'                    => 'Расширительный бак',
            'E.TANK'                            => 'Расширительный бак',
            'VOLTAGE REGULATOR'                 => 'Регулятор напряжения',
            'IGNITION  ELECTRODE'               => 'Электрод розжига',
            'IGNITION ELECTRODE'                => 'Электрод розжига',
            'IGNITION - GROUNDING ELECTRODE'    => 'Электрод розжига и датчик пламени',
            'IONIZATION ELECTRODE'              => 'Датчик пламени',
            'GROUNDİNG ELECTRODE'               => 'Датчик пламени',
            'IGNITION TRANSFORMER'              => 'Трансформатор розжига',
            'IGNITION CARD'                     => 'Блок розжига',
            'LIGHTER'                           => 'Блок розжига',
            'FILLING TAP'                       => 'Подпиточный клапан',
            'FILLING FAUCET'                    => 'Подпиточный клапан',
            'FILLINF FAUCET'                    => 'Подпиточный клапан',
            'CAGE-MID MORNING'                  => 'Наконечник коаксиалльного дымохода',
            'CONNECTION FLEX'                   => 'Подсоединительный шланг',
            'MONTAGE SET'                       => 'Монтажный набор подключения',
            'TIMER'                             => 'Таймер управления',
            'LOCAL FLOW TURBINE'                => 'Датчик протока (турбина)',
            'FLOW  TURBINE'                     => 'Датчик протока (турбина)',
            'FLOW TUBINE'                       => 'Датчик протока (турбина)',
            'FLOW TURBİNE'                      => 'Датчик протока (турбина)',
            'FLOW TURBINE'                      => 'Датчик протока (турбина)',
            'TURBIN READER'                     => 'Датчик протока (турбина)',
            'CABLE GROUP'                       => 'Кабель  подключения датчика протока',
            'AIR VENT'                          => 'Воздухоотводчик',
            'AIRVENT'                           => 'Воздухоотводчик',
            'AIR EVACUATION DEVICE'             => 'Воздухоотводчик',
            'PUMP BACK'                         => 'Циркуляционный насос, задняя часть',
            'PUMP BODY'                         => 'Циркуляционный насос, задняя часть',
            'PUMP VOLUTE'                       => 'Циркуляционный насос',
            'CIRCULATION PUMP'                  => 'Циркуляционный насос',
            'CIRCULATING PUMP'                  => 'Циркуляционный насос',
            'PUMP'                              => 'Циркуляционный насос',
            'TURBINE BED'                       => 'Патрубок датчика протока',
            'PLUG'                              => 'Пробка',
            'EXCHANGER SEAL'                    => 'Прокладки теплообменника',
            'KLINGIRIT SEAL'                    => 'Паронитовое уплотнение',
            'DIGITAL ROOM THERMOSTAT'           => 'Электронный комнатный термостат',
            'ROOM THERMOSTAT'                   => 'Комнатный термостат',
            'MICRO SWITCHES'                    => 'Микропереключатель',
            'MICRO SWITCH'                      => 'Микропереключатель',
            'INTERFACE CARD'                    => 'Панель управления',
            'DIGITAL ELECTRONIC CARD'           => 'Плата управления',
            'HEATER ELECTRONIC CARD'            => 'Плата управления',
            'HEATER CARD'                       => 'Плата управления',
            'ANALES ELECTRONİC CART'            => 'Плата управления',
            'ELECTRONIC CARD'                   => 'Плата управления',
            'ELECTRONIC CART'                   => 'Плата управления',
            'ELECTRONIK CART'                   => 'Плата управления',
            'ELECTRONK CARD'                    => 'Плата управления',
            'ELECTRONİC CARD'                   => 'Плата управления',
            'DIGITAL CARD'                      => 'Плата управления',
            'SCREEN CARD'                       => 'Плата дисплея',
            'SCREEN CART'                       => 'Плата дисплея',
            'SCREEN TIME'                       => 'Плата дисплея',
            'LCD CARD'                          => 'Плата управления',
            'CARD'                              => 'Плата управления',
            'STEP MOTOR'                        => 'Шаговый мотор',
            'SERVİCE GLOVES'                    => 'Сервисные перчатки',
            'EXTREME HEAT'                      => 'Аварийный',
            'SENSOR'                            => 'Датчик',
            'TEMPERATURE'                       => 'Температуры',
            'WATER GROUP'                       => 'водяной узел',
            'LEFT BLOK'                         => 'водяной узел',
            'LEFT BLOCK'                        => 'водяной узел',
            'HANGER'                            => 'Подвесное крепление дымохода',
            '3)4'                               => '3/4',
            '1)2'                               => '1/2',
            '1)4'                               => '1/4',
            '3)8'                               => '3/8',
            'PTC'                               => 'NTC',
            'FOR'                               => 'для',
            'TRIPLE'                            => 'тройной',
            'WITH'                              => 'с',
            'MOTOR'                             => 'сервопривод',
            'MODELS'                            => '',
            'NON-RETURN VALVELESS'              => '',
            'COUNTERSUNK HEAD(AIR HEAD)'        => '',
            'BOILER'                            => '',
            'CIRCLE'                            => '',
            'INTERLACED'                        => '',
            'COUPLING'                          => '',
            'OPEN ONE'                          => '',
            '  '                                => ' ',


        ];

        $none = [];

        $newData = [
            'new'       => [],
            'update'    => []
        ];

        $products = $this->products->getAllProducts();

        foreach ($products as $product) {
            $name = trim($product->original_name);
            $arrN = explode(' ', $name);
            switch($arrN[0]){
                case 'BAYMAK'               :
                case 'DEMİRDÖKÜM'           :
                case 'DEMIRDOKUM'           :
                case 'VAILLANT'             :
                case 'BOSCH'                :
                case 'ECA'                  :
                case 'ARISTON'              :
                case 'BUDERUS'              :
                case 'FERROLI'              :
                case 'ALARKO'               :
                case 'VIESSMANN'            :
                case 'FERROLİ'              :
                case 'IMMERGAS'             :
                case 'ARİSTON'              :
                case 'VAİLLANT'             :
                case 'BAYKAN'               :
                case 'PROTHERM'             :
                case 'SUSLER'               :
                case 'AIRFELL'              :
                case 'AIRFEL'               :
                case 'BERETTA'              :
                case 'İMMERGAS'             :
                case 'VİESSMANN'            :
                case 'WOLF'                 :
                case 'VIESSMAN'             :
                case 'SÜSLER'               :
                case 'AİRFELL'              :
                case 'AİRFEL'               :
                case 'WOLF,'                :
                case 'VİESSMAN'             :
                case 'VAILANT'              :
                case 'DEMİIDOKUM'           :
                case 'D.DOKUM'              :
                case 'BAXI'                 :
                case 'ARÇELİK'              :
                case 'ARCELIK'              :   $name = str_replace($arrN[0], $brandReName[$arrN[0]], $product->original_name); break;

                case 'WOLF-IHLAS'           :
                case 'SUSLER-ETNA'          :
                case 'VİESSMANN-VİTODENTS'  :
                case 'VAILLANT-TURBOTEC'    :
                case 'ECA-NOVASTAR'         :
                case 'DEMIRDOKUM-NEVA'      :
                case 'DEMIRDOKUM-CALISTO'   :
                case 'BAYMAK-MAİN'          :
                case 'BAYMAK-GOLD'          :
                case 'BAYMAK-ECO'           :
                case 'AUER-MİCRA'           :
                case 'ARİSTON-TX'           :
                                                $arrNM = explode('-', $arrN[0]);
                                                $name = str_replace($arrNM[0].'-', $brandReName[$arrNM[0]].' ', $product->original_name); break;

                default : $none[$arrN[0]][] = $product->original_name;
                //////////////////////////////////////////////////////

            }

            foreach($productReName as $find => $replace){
                if( stripos( $name, $find ) !== false){
                    $name = str_replace($find, $replace, $name);
                }
            }

            $newData['update']['name'][$product->id] = $name;
        }

        $this->updateCurrentTable($newData, $currentTableName);
    }

    public function addRurPrice(Price $price){

        $productPrices = $price->getPriceProducts('recommended');

        $this->updatePrice($priceData = [], $price_name = 'retail', $productPrices);

    }

}
