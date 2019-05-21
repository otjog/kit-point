<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class MenuModel extends Model
{
    public function menus(){
        return $this->belongsToMany('App\Models\Site\Menu', 'menu_has_model')->withTimestamps();
    }
}
