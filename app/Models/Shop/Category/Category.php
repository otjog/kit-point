<?php

namespace App\Models\Shop\Category;

use Illuminate\Database\Eloquent\Model;
use App\Models\Settings;

class Category extends Model{

    protected $moduleMethods = [
        'index' => 'getCategoriesTree',
    ];

    public function getModuleMethods($moduleMethod)
    {
        return $this->moduleMethods[$moduleMethod];
    }

    protected $fillable = ['active', 'name'];

    protected $settings;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->settings = Settings::getInstance();

    }

    public function products()
    {
        return $this->hasMany('App\Models\Shop\Product\Product');
    }

    public function images()
    {
        return $this->morphToMany('App\Models\Site\Image', 'imageable');
    }

    public function getAllCategories(){
        return self::select(
            'id',
            'parent_id',
            'name',
            'original_name',
            'url'
            )
            ->orderBy('name')
            ->get();
    }

    public function getActiveCategories(){
        return self::select(
            'id',
            'parent_id',
            'name',
            'original_name',
            'url'
        )
            ->where('active', 1)
            ->orderBy('sort')
            ->with('images')
            ->get();
    }

    public function getActiveCategoriesById($ids){
        return self::select(
            'id',
            'parent_id',
            'name',
            'original_name',
            'url'
        )
            ->where('active', 1)
            ->whereIn('id', $ids)
            ->orderBy('sort')
            ->with('images')
            ->get();
    }

    public function getChildrenCategories($parent_id){
        return self::select(
            'id',
            'parent_id',
            'name',
            'original_name',
            'url'
        )
            ->where('parent_id', $parent_id)
            ->orderBy('sort')
            ->with('images')
            ->get();
    }

    public function getActiveChildrenCategories($parent_id){
        return self::select(
            'id',
            'parent_id',
            'name',
            'original_name',
            'url'
        )
            ->where('active', 1)
            ->where('parent_id', $parent_id)
            ->orderBy('sort')
            ->with('images')
            ->get();
    }

    public function getCategory($id){
        return self::select(
            'id',
            'parent_id',
            'name',
            'original_name',
            'url'
        )
            ->where('id', $id)
            ->orderBy('name')
            ->with('images')
            ->get();
    }

    public function getCategoryIfActive($id){
        return self::select(
            'id',
            'parent_id',
            'name',
            'original_name',
            'url'
        )
            ->where('id', $id)
            ->where('active', 1)
            ->orderBy('name')
            ->with('images')
            ->get();
    }

    public function getCategoriesTree($parent_id = 0)
    {

        if($this->settings->getParameter('models.category.categoriesTree')){
            return $this->settings->getParameter('models.category.categoriesTree');
        }

        /**
         * http://forum.php.su/topic.php?forum=71&topic=4385
         */
        $allCat = [];
        $tree   = [];
        $categories = $this->getActiveCategories();

        foreach($categories as $category){
            $cur =& $allCat[$category['id']];

            $cur['id'] = $category['id'];
            $cur['parent_id'] = $category['parent_id'];
            $cur['name'] = $category['name'];
            $cur['images'] = $category->images;

            if($category['parent_id'] == $parent_id){ /* id категории, с которой начинается дерево */
                $tree[$category['id']] =& $cur;
            }
            else{
                $allCat[$category['parent_id']]['children'][$category['id']] =& $cur;
            }
        }

        $result = collect($tree);

        $this->settings->addParameter('models.category.categoriesTree', $result);

        return $result;
    }

}
