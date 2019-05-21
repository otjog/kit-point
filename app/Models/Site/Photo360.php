<?php

namespace App\Models\Site;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class Photo360
{
    protected $folderName = 'photo360';

    protected $data = [
        'extFile' => '',
        'path' => ''
    ];

    public function getPhotos($folder)
    {
        $photos = Storage::files('img/' . $this->folderName . '/' . $folder);

        if(count($photos) > 0){

            $imageManager = new ImageManager();

            $mime = $imageManager->make(public_path('storage/'.$photos[0]))->mime();

            $extFile = explode('/', $mime);

            $this->data['extFile'] = $extFile[1];
            $this->data['path'] = '/storage/img/' . $this->folderName . '/' . $folder;
            $this->data['count'] = count($photos);
        }

        return $this->data;

    }
}
