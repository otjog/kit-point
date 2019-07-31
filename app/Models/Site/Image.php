<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use App\Models\Settings;
use Intervention\Image\ImageManager;

class Image extends Model
{
    public function products()
    {
        return $this->morphedByMany('App\Models\Shop\Product\Product', 'imageable')->withTimestamps();
    }

    public function categories()
    {
        return $this->morphedByMany('App\Models\Shop\Category\Category', 'imageable')->withTimestamps();
    }

    public function shipments()
    {
        return $this->morphedByMany('App\Models\Shop\Order\Shipment', 'imageable')->withTimestamps();
    }

    public function payments()
    {
        return $this->morphedByMany('App\Models\Shop\Order\Payment', 'imageable')->withTimestamps();
    }

    public function banner_slides()
    {
        return $this->morphedByMany('App\Models\Site\BannerSlide', 'imageable')->withTimestamps();
    }

    protected function getRelatedModelsIfNotImages($model){
        $data = [
            'category' => [
                'App\Models\Shop\Product\Product', //Path to Model
                'category'  //model name (related)
            ]
        ];

        return $data[$model];
    }

    public function getAllImages(){
        return self::select(
            'images.id',
            'images.alt',
            'images.src'
        )
            ->get();
    }

    public function showImage($model, $size, $pathToImage, $modelId, $extension)
    {
        $imagesSettings = $this->getImagesSettings($model, $size, $pathToImage, $modelId, $extension);

        if (is_file($imagesSettings['path_to_sized_image'])) {
            $imageManager = new ImageManager(array('driver' => 'imagick'));
            $sizedImg = $imageManager->make($imagesSettings['path_to_sized_image']);
        } else {
            $sizedImg = $this->makeNewImage($imagesSettings);
        }

        return $sizedImg->response();

    }

    public function getSrcImage($model, $size, $pathToImage, $modelId, $extension)
    {
        $imagesSettings = $this->getImagesSettings($model, $size, $pathToImage, $modelId, $extension);

        if (!is_file($imagesSettings['path_to_sized_image'])) {
            $this->makeNewImage($imagesSettings);
        }
        return $imagesSettings['path_to_sized_image'];
    }

    protected function makeNewImage($imageSettings)
    {
        $imageManager = new ImageManager(array('driver' => 'imagick'));

        $size =& $imageSettings['current_size'];

        $sizedImg = null;

        if (!is_dir( $imageSettings['path_to_image_folder'] . $size['string'])) {
            mkdir( $imageSettings['path_to_image_folder'] . $size['string'], 0777, true);
        }

        if (is_file($imageSettings['path_to_original_image'])) {

            $sizedImg = $imageManager->make($imageSettings['path_to_original_image']);

            switch ($imageSettings['change']) {
                case 'fit' :
                    $sizedImg->fit($size['width'], $size['height']);
                    break;
                case 'resize' :
                    $sizedImg->resize($size['width'], $size['height'], function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    if($sizedImg->width() !== $size['width'] || $sizedImg->height() !== $size['height']){
                        $canvas = $imageManager->canvas($size['width'], $size['height'], '#ffffff');
                        $canvas->insert($sizedImg, 'center');
                        $sizedImg = $canvas;
                    }
                    break;
            }

            if (isset($imageSettings['changes'][$size['string']]) && $imageSettings['changes'][$size['string']] !== null) {
                switch ($imageSettings['changes'][$size['string']]) {
                    case 'rounded' :
                        $radius = $size['width']/1.4142*2-1;

                        $sizedImg->circle($radius, $size['width']/2, $size['width']/2, function ($draw) {
                            $draw->border(1, '#FFCC99');
                        });

                        break;
                    case 'circle' :
                        $radius = $size['width']/1.4142*2;

                        $canvas = $imageManager->canvas($radius+1, $radius+1);

                        $canvas->circle($radius, $radius/2, $radius/2, function ($draw) {
                            $draw->background('#ffffff');
                            $draw->border(1, '#FFCC99');
                        });

                        $canvas->insert($sizedImg, 'center');
                        $sizedImg = $canvas;

                        break;

                }
            }

            $sizedImg->save($imageSettings['path_to_sized_image']);
        }

        return $sizedImg;
    }

    protected function getImagesSettings($model, $size, $pathToImage, $modelId, $extension)
    {
        $settings = Settings::getInstance();

        $imageSettings = $settings->getParameter('images.models.' . $model);

        if (!is_file($pathToImage)) {
            switch ($imageSettings['if_not']['action']) {
                case 'search' :

                    list($searchModelPath, $searchModelRelated) = $this->getRelatedModelsIfNotImages($model);

                    $searchModel = $searchModelPath::
                        whereHas($searchModelRelated, function ($query) use ($modelId) {
                            $query->where('id', $modelId);
                        })
                        ->with('images')
                        ->has('images')
                    ->first();

                    $pathToImage = $searchModel->images[0]->src;

                    break;
                case 'default' :
                    $pathToImage = $imageSettings['if_not']['path_to_default_image'];
                    break;
                case 'nothing' :

                    break;
            }
        }

        $imageSettings['path_info'] = pathinfo($pathToImage);

        $imageSettings['name_original_image'] = $imageSettings['path_info']['basename'];

        $uniquePartName = md5($pathToImage.$model.$imageSettings['size'][$size]);

        if ($extension === null)
            $imageSettings['name_sized_image'] = $uniquePartName . '_' . $imageSettings['name_original_image'];
        else
            $imageSettings['name_sized_image'] = $uniquePartName . '_' . $imageSettings['path_info']['filename'] . '.' . $extension;

        $imageSettings['path_to_sized_image'] = $imageSettings['path_to_image_folder'] . $size . '/' . $imageSettings['name_sized_image'];

        $imageSettings['path_to_original_image'] = $imageSettings['path_info']['dirname'] . '/' .$imageSettings['name_original_image'];

        $imageSettings['current_size']['string'] = $size;

        list($imageSettings['current_size']['width'], $imageSettings['current_size']['height']) = explode('x', $imageSettings['size'][$size]);
        
        return $imageSettings;
    }

}
