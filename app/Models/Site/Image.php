<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use App\Models\Settings;
use Intervention\Image\ImageManager;

class Image extends Model{

    protected $settings;

    protected $imageManager;

    public function __construct(array $attributes = []){
        parent::__construct($attributes);

        $this->settings = Settings::getInstance();

        $this->imageManager = new ImageManager();

    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Shop\Product\Product', 'imageable')->withTimestamps();
    }

    public function categories()
    {
        return $this->morphedByMany('App\Models\Shop\Category\Category', 'imageable')->withTimestamps();
    }

    public function banner_slides()
    {
        return $this->morphedByMany('App\Models\Site\BannerSlide', 'imageable')->withTimestamps();
    }

    public function getAllImages(){
        return self::select(
            'images.id',
            'images.alt',
            'images.src'
        )
            ->get();
    }

    public function showImage($model, $size, $originalName)
    {

        $name = str_replace('|', '/', $originalName);

        $imageSettings = $this->settings->getParameter('images.models.' . $model);

        $pathToSizedImage = $imageSettings['path_to_image_folder'] . $size . '/' . $originalName;

        $pathToOriginalImage = $imageSettings['path_to_image_folder'] . $name;

        $pathToDefaultImage = $imageSettings['path_to_default_image'];

        if (is_file($pathToSizedImage)) {

            $image =  $this->imageManager->make($pathToSizedImage);

            return $image->response();

        } else {

            list($width, $height) = explode('x', $imageSettings['size'][$size]);

            if (!is_dir( $imageSettings['path_to_image_folder'] . $size)) {
                mkdir( $imageSettings['path_to_image_folder'] . $size, 0777, true);
            }

            if (is_file($pathToOriginalImage)) {
                $sizedImg = $this->imageManager->make($pathToOriginalImage);
            } elseif (is_file($pathToDefaultImage)) {
                $sizedImg = $this->imageManager->make($pathToDefaultImage);
            } else {
                //todo нарисаовать изображение
            }

            switch ($imageSettings['change']) {
                case 'fit' :
                    $sizedImg->fit($width, $height);
                    break;
                case 'resize' :
                    $sizedImg->resize($width, $height, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    if($sizedImg->width() !== $width || $sizedImg->height() !== $height){
                        $canvas = $this->imageManager->canvas($width, $height, '#ffffff');
                        $canvas->insert($sizedImg, 'center');
                        $sizedImg = $canvas;
                    }
                    break;
            }

            $sizedImg->save($pathToSizedImage);

            return $sizedImg->response();
        }

    }

}
