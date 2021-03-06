<?php

namespace App\Libraries\Parser;

use App\Models\Shop\Category\Category;
use App\Models\Site\Image;
use Illuminate\Http\Request;
use App\Models\Shop\Product\Product;
use Illuminate\Support\Facades\DB;
use Exception;

class FromFolder
{
    private $imgFolder = 'фото';

    private $parentFolder;

    private $customGroupIterator;

    private $mainImageFolder;

    private $imageParameters;

    private $tables;

    private $pivotTable;

    private $compareColumn;

    private $product;

    private $category;

    private $image;

    private $exceptions = [];

    public function __construct(Request $request, Product $product, Category $category, Image $image){

        $this->parentFolder = public_path('storage/load_products');

        $this->imageParameters = [
            'action'    => 'add',//replace|add|false = nothing
            'addition'  => ''
        ];

        $this->tables = [

            'categories' => [
                'active' => '1',
            ],

            'images' => [
            ],
            'products' => [
                'active' => '1',
                'description' => ''
            ],

            'product_has_price.retail' => [
                'active' => '1',
                'price_id' => '1',
                'currency_id' => '1',
            ],
            'product_has_parameter' => [
                [
                    'parameter_id' => '1',
                ]
            ],

            'product_has_image' => [
            ],

        ];

        $this->pivotTable       = 'products';

        $this->compareColumn    = 'scu';

        $this->product  = $product;

        $this->category = $category;

        $this->image    = $image;

        $this->mainImageFolder = 'storage/img/shop/product/';

        $this->customGroupIterator = [];

    }

    public function parse(){

        $newDataInTables = $this->read();

        $this->store($newDataInTables);
    }

    private function read(){

        $newDataInTables = [];

        $groupIteraror = $this->getGroupIterator();

        foreach($groupIteraror as $anchor){

            $itemIterator = $this->getItemIterator($anchor);

            foreach ($itemIterator as $item) {

                if (is_file($item)) {
                    $parsedParameters = $this->getCurrentParameters($item, $anchor);

                    if(isset ($parsedParameters[ $this->pivotTable ][ $this->compareColumn ] ) ){
                        $sc_value = $parsedParameters[ $this->pivotTable ][ $this->compareColumn ];
                    }else{
                        break;
                    }

                    foreach($parsedParameters as $tableName => $currentParameters){

                        if( isset($newDataInTables[$tableName]) === false ){
                            $newDataInTables[$tableName] = [];
                        }

                        if( count( $currentParameters ) > 0 ){
                            $newDataInTables[$tableName][ $sc_value ] = $currentParameters;
                        }

                    }
                }


            }
        }

        return $newDataInTables;

    }

    private function store($newDataInTables){

        foreach ($newDataInTables as $tableName => $parameters){

            list($clearTableName) = explode('.', $tableName);

            switch($clearTableName){

                case 'categories' :
                    $relatedParameters = $this->storeCategoriesAndGetIds($parameters);
                    $newDataInTables = array_merge_recursive($newDataInTables, $relatedParameters);
                    break;

                case 'images' :
                    $relatedParameters = $this->storeImagesAndGetRelatedParameters($parameters);
                    $newDataInTables = array_merge_recursive($newDataInTables, $relatedParameters);
                    break;

                case 'products' :
                    $this->storeProducts($newDataInTables[ $this->pivotTable ]);
                    break;

                case 'product_has_price' :
                    $this->storePrices($parameters);
                    break;

                case 'product_has_parameter' :
                    $this->storeProductParameters($parameters);
                    break;

                case 'product_has_image' :
                    $this->storeProductsImages($newDataInTables [ 'product_has_image' ] );
                    break;

            }

        }

    }

    private function getGroupIterator(){

        if( count($this->customGroupIterator) > 0 ){

            return $this->customGroupIterator;

        }else{

            return $this->getFilesInFolder($this->parentFolder);
        }

    }

    private function getFilesInFolder($folder){

        if(is_dir($folder)){
            $files = array_diff(scandir($folder), array('..', '.'));

            return array_map(function($file) use ($folder){
                return $folder . '/' . $file;
            }, $files);

        }
        return [];
    }

    private function getItemIterator($anchor){

        return $this->getFilesInFolder($anchor);

    }

    private function getCurrentParameters($txtFile, $folder){

        $productDescArray = file($txtFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        $productDescArray = mb_convert_encoding($productDescArray, "UTF-8", "cp1251");

        $currentParameters = $this->tables;

        $productScu = basename($txtFile, '.txt');

        $pathArray = explode('/', $folder);
        $categoryName = end($pathArray);

        $currentParameters['products']['scu'] = $productScu;

        $currentParameters['categories']['name'] = $categoryName;

        foreach ($productDescArray as $key => $value) {

            $value = trim($value);

            if($value !== ''){

                if (!isset($currentParameters['products']['name'])) {
                    $currentParameters['products']['name'] = $value;
                } elseif (stripos($value, 'Цена') === false && stripos($value, 'С монтажом') === false) {
                    $currentParameters['products']['description'] .= $value;

                } else {

                    if (stripos($value, 'Цена') !== false) {

                        $currentParameters['product_has_price.retail']['value'] = (int)str_ireplace(['Цена', 'С монтажом', ' ' ], '', $value);

                        $currentParameters['product_has_parameter'][0]['value'] = 'Без монтажа';

                        $currentParameters['product_has_parameter'][0]['basket_value'] = 0;

                    } elseif (stripos($value, 'С монтажом') !== false) {

                        $currentParameters['product_has_parameter'][1] = $currentParameters['product_has_parameter'][0];

                        $currentParameters['product_has_parameter'][1]['value'] = 'C монтажом';

                        $value = (int)str_ireplace(['Цена', 'С монтажом', ' ' ], '', $value);

                        $currentParameters['product_has_parameter'][1]['basket_value'] = $value - $currentParameters['product_has_price.retail']['value'];

                    }

                }

            }

        }

        $currentParameters['images']['name'] = $this->getFilesInFolder($folder . '/' . $this->imgFolder  . '/' . $productScu);

        return $currentParameters;

    }

    private function getCategoriesData($parameters){

        $data = [
            'new'       => [],
            'update'    => []
        ];

        $products = [];

        $collection = $this->category->getAllCategories();

        foreach ($parameters as $sc_value => $currentParameters) {

            $tableRow = $this->getCurrentTableRow($collection, 'name', $currentParameters['name']);

            if($tableRow !== null){

                $data['update'] = $this->getArrayForUpdate($currentParameters, $tableRow, $data['update']);

                $products[$sc_value]['category_id'] = $tableRow->id;

            }else{

                $result = $this->getArrayForInsert($currentParameters, $data['new'], 'name');

                if($result !== false){
                    $data['new'][] = $result;
                }

            }
        }

        return ['categories' => $data, 'products' => $products];
    }

    private function storeCategoriesAndGetIds($categoryParameters){
        $data = $this->getCategoriesData($categoryParameters);
        //$this->deActivate....
        $categories = array_shift($data);
        $this->updateCurrentTable($categories, 'categories');

        if( count( $categories['new'] ) > 0 ){
            $data = $this->getCategoriesData($categoryParameters);
        }
        return $data;
    }

    private function getProductsData($parameters){

        $data = [
            'new'       => [],
            'update'    => []
        ];

        $productsCollection = $this->product->getAllProducts();

        foreach ($parameters as $currentParameters) {

            $product = $this->getCurrentTableRow($productsCollection, $this->compareColumn, $currentParameters[$this->compareColumn]);

            if($product !== null){

                $data['update'] = $this->getArrayForUpdate($currentParameters, $product, $data['update']);

            }else{

                $result = $this->getArrayForInsert($currentParameters, $data['new'], $this->compareColumn);

                if($result !== false){
                    $data['new'][] = $result;
                }

            }
        }

        return $data;
    }

    private function storeProducts($productsParameters){
        $data = $this->getProductsData($productsParameters);
        //$this->deActivate....
        $this->updateCurrentTable($data, 'products');
    }

    private function getImagesData($parameters){

        $data = [
            'images' => [
                'new'       => [],
                'update'    => [],
            ],
            'products' => [],
            'product_has_image' => []
        ];

        $imagesCollection = $this->image->getAllImages();

        foreach($parameters as $sc_value => $currentParameters){

            foreach($currentParameters['name'] as $key => $src){

                try {
                    $exifImageType = exif_imagetype($src);

                } catch (Exception $exception){
                    $this->exceptions[] = [
                        $exception->getMessage(),
                        $exception->getCode(),
                        $exception->getLine()
                    ];
                    break;
                }

                if($exifImageType !== false){

                    $imageName  = $this->getNewImageName($sc_value . $this->imageParameters['addition'], $exifImageType);

                    try {
                        file_put_contents($this->mainImageFolder . $imageName, file_get_contents($src));

                    } catch (Exception $exception) {
                        $this->exceptions[] = [
                            $exception->getMessage(),
                            $exception->getCode(),
                            $exception->getLine()
                        ];
                        break;
                    }

                    $tableRow = $this->getCurrentTableRow($imagesCollection, 'name', $imageName);

                    if($tableRow !== null){

                        $data['images']['update'] = $this->getArrayForUpdate(['name' => $imageName], $tableRow, $data['images']['update']);

                    }else{

                        $result = $this->getArrayForInsert(['name' => $imageName], $data['images']['new'], 'name');

                        if($result !== false) {
                            $data['images']['new'][] = $result;
                            $data['product_has_image'][] = [ 'product_' . $this->compareColumn  => $sc_value, 'name' => $result['name']];
                        }

                    }
                }
            }

        }

        return $data;

    }

    private function storeImagesAndGetRelatedParameters($imagesParameters){
        $data = $this->getImagesData($imagesParameters);

        $this->updateCurrentTable(array_shift($data), 'images');

        return $data;
    }

    private function getPricesData($parameters){

        $data = [
            'new'   => []
        ];

        $oldPrice = [
            'prices_id'    => [ $parameters[ key($parameters) ]['price_id'] ],
            'products_id'  => [],
        ];

        $productsCollection = $this->product->getAllProducts();

        foreach($parameters as $sc_value => $currentParameters) {

            $product = $this->getCurrentTableRow($productsCollection, $this->compareColumn, $sc_value);

            if($product !== null){

                $oldPrice['products_id'][] = $product->id;

                $currentParameters['product_id'] = $product->id;

                $currentParameters = $this->addTimeStamp($currentParameters);

                $data['new'][] = $currentParameters;

            }
        }

        return ['new_price' => $data, 'old_price' => $oldPrice];
    }

    private function storePrices($priceParameters){
        $data = $this->getPricesData($priceParameters);
        $this->deActiveOldPrice($data['old_price']);
        $this->updateCurrentTable($data['new_price'], 'product_has_price');
    }

    private function getProductParametersData($parameters)
    {

        $data = [
            'new'   => []
        ];

        $productsCollection = $this->product->getAllProducts();

        foreach($parameters as $sc_value => $currentParameters) {

            $product = $this->getCurrentTableRow($productsCollection, $this->compareColumn, $sc_value);

            if($product !== null){

                foreach ($currentParameters as $currentParameter) {
                    $currentParameter['product_id'] = $product->id;

                    $currentParameter = $this->addTimeStamp($currentParameter);

                    $data['new'][] = $currentParameter;
                }

            }
        }

        return $data;

    }

    private function storeProductParameters($parameters){
        $data = $this->getProductParametersData($parameters);

        $this->updateCurrentTable($data, 'product_has_parameter');
    }

    private function getProductsImagesData($parameters){

        $data = [
            'new' => []
        ];

        $productsCollection = $this->product->getAllProducts();
        $imagesCollection   = $this->image->getAllImages();

        foreach ($parameters as $currentParameters) {

            $product = $this->getCurrentTableRow($productsCollection, $this->compareColumn, $currentParameters[ 'product_' . $this->compareColumn ] );

            if($product !== null){

                $image = $this->getCurrentTableRow($imagesCollection, 'name', $currentParameters[ 'name' ] );

                if($image !==  null){

                    $result = $this->getArrayForInsert([], $data['new']);

                    $result['product_id']    = $product->id;

                    $result['image_id']      = $image->id;

                    if($result !== false){
                        $data['new'][] = $result;
                    }

                }

            }

        }

        return $data;

    }

    private function storeProductsImages($parameters){

        $data = $this->getProductsImagesData($parameters);

        $this->updateCurrentTable($data, 'product_has_image');

    }

    /******** Helpers *********/

    private function getCurrentTableRow($collection, $columnName, $columnValue){
        return $collection->first(function($value, $key) use ($columnName, $columnValue){
            return $value->$columnName == $columnValue;
        });
        //todo не точное сравнение!!!
    }

    private function addTimeStamp($currentParameters){
        //todo неверная локализация даты!
        $currentParameters['created_at'] = date('Y-m-d H:i:s',time());
        $currentParameters['updated_at'] = date('Y-m-d H:i:s',time());

        return $currentParameters;
    }

    private function getArrayForUpdate($currentParameters, $tableRow, $data){

        foreach($currentParameters as $name_param => $value ){
            if($value !== $tableRow[$name_param]){
                $data[$name_param][$tableRow['id']] = $value;
            }
        }
        return $data;
    }

    private function getArrayForInsert($currentParameters, $data, $sc_value = null){

        if($sc_value !== null){
            foreach($data as $tableRow){

                if( $tableRow[$sc_value] === $currentParameters[$sc_value] ) {
                    return false;
                }

            }
        }

        $currentParameters = $this->addTimeStamp($currentParameters);

        return $currentParameters;
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

    private function deActiveOldPrice($columns){

        DB::table('product_has_price')
            ->where('active', 1)
            ->whereIn('product_id',    $columns['products_id'])
            ->whereIn('price_id',      $columns['prices_id'])
            ->update(['active' => 0]
            );
    }

    private function getExtensionImage($exifImageType){

        $mime = explode( '/', image_type_to_mime_type($exifImageType)) ;

        return array_pop($mime);

    }

    private function getNewImageName($partName, $exifImageType){

        $extension = $this->getExtensionImage($exifImageType);

        $partName = $this->translit($partName);
        $partName = strtolower($partName);
        $partName = preg_replace('~[^-a-z0-9_]+~u', '-', $partName);
        $partName = trim($partName, "-");

        $fullName =  $partName . '.' . $extension;

        if( file_exists(public_path($this->mainImageFolder) . $fullName )){
            $newPartName = $this->changeSimilarName($partName);
            $fullName = $this->getNewImageName($newPartName, $exifImageType);
        }

        return $fullName;
    }

    private function changeSimilarName($name){

        $isHasNumber = preg_match('/(__)([0-9]*)$/', $name,$matches);

        if($isHasNumber){
            $num = intval($matches[2]) + 1;

            return str_replace($matches[0], '__' . (string) $num , $name);

        }else{
            return $name . '__1';
        }

    }

    private function translit($string){
        $converter = array(
            'а' => 'a',     'б' => 'b',     'в' => 'v',
            'г' => 'g',     'д' => 'd',     'е' => 'e',
            'ё' => 'e',     'ж' => 'zh',    'з' => 'z',
            'и' => 'i',     'й' => 'y',     'к' => 'k',
            'л' => 'l',     'м' => 'm',     'н' => 'n',
            'о' => 'o',     'п' => 'p',     'р' => 'r',
            'с' => 's',     'т' => 't',     'у' => 'u',
            'ф' => 'f',     'х' => 'h',     'ц' => 'c',
            'ч' => 'ch',    'ш' => 'sh',    'щ' => 'sch',
            'ь' => '',      'ы' => 'y',     'ъ' => '',
            'э' => 'e',     'ю' => 'yu',    'я' => 'ya',

            'А' => 'A',     'Б' => 'B',     'В' => 'V',
            'Г' => 'G',     'Д' => 'D',     'Е' => 'E',
            'Ё' => 'E',     'Ж' => 'Zh',    'З' => 'Z',
            'И' => 'I',     'Й' => 'Y',     'К' => 'K',
            'Л' => 'L',     'М' => 'M',     'Н' => 'N',
            'О' => 'O',     'П' => 'P',     'Р' => 'R',
            'С' => 'S',     'Т' => 'T',     'У' => 'U',
            'Ф' => 'F',     'Х' => 'H',     'Ц' => 'C',
            'Ч' => 'Ch',    'Ш' => 'Sh',    'Щ' => 'Sch',
            'Ь' => '',      'Ы' => 'Y',     'Ъ' => '',
            'Э' => 'E',     'Ю' => 'Yu',    'Я' => 'Ya',
        );
        return strtr($string, $converter);
    }
}