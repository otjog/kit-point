<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class BannerSlide extends Model
{
    public function images()
    {
        return $this->morphToMany('App\Models\Site\Image', 'imageable');
    }

    public function banner()
    {
        return $this->belongsTo(    'App\Models\Site\Banner');
    }

}
