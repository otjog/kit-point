<?php

namespace App\Models\Shop\Category;

use Illuminate\Database\Eloquent\Model;
use App\Facades\GlobalData;

class Category extends Model{

    protected $moduleMethods = [
        'index' => 'getActiveChildrenCategories',
    ];

    public function getModuleMethods($moduleMethod)
    {
        return $this->moduleMethods[$moduleMethod];
    }

    protected $fillable = ['active', 'name'];

    public function getNameAttribute($value)
    {
        if($value === null)
            return 'Категории магазина';
        return $value;
    }

    public function products()
    {
        return $this->hasMany('App\Models\Shop\Product\Product');
    }

    public function images()
    {
        return $this->morphToMany('App\Models\Site\Image', 'imageable');
    }

    public function parent()
    {
        return $this->belongsTo(    'App\Models\Shop\Category\Category');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Shop\Category\Category', 'parent_id');
    }

    public function getAllCategories(){
        return self::select(
            'id',
            'parent_id',
            'name',
            'description',
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
            'description',
            'original_name',
            'url'
        )
            ->where('active', 1)
            ->orderBy('sort')
            ->with('images')
            ->with('parent')
            ->with('children')
            ->get();
    }

    public function getActiveCategoriesById($ids){
        return self::select(
            'id',
            'parent_id',
            'name',
            'description',
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
            'description',
            'original_name',
            'url'
        )
            ->where('parent_id', $parent_id)
            ->orderBy('sort')
            ->with('images')
            ->get();
    }

    public function getActiveChildrenCategories($parent_id = 0){
        return self::select(
            'id',
            'parent_id',
            'name',
            'description',
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
            'description',
            'original_name',
            'url'
        )
            ->where('id', $id)
            ->orderBy('name')
            ->with('images')
            ->with('parent')
            ->with('children')
            ->get();
    }

    public function getRootCategory()
    {
        $rootCategory = new self();
        $rootCategory->children = $this->getActiveChildrenCategories(0);
        return $rootCategory;
    }

    public function getCategoryIfActive($id){
        return self::select(
            'id',
            'parent_id',
            'name',
            'description',
            'original_name',
            'url'
        )
            ->where('id', $id)
            ->where('active', 1)
            ->orderBy('name')
            ->with('images')
            ->get();
    }

    /*Depricated???*/
    public function getCategoriesTree($parent_id = 0)
    {
        if(GlobalData::getParameter('models.category.categoriesTree')){
            return GlobalData::getParameter('models.category.categoriesTree');
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

        GlobalData::addParameter('models.category.categoriesTree', $result);

        return $result;
    }

    /*добавить эту функцию ко всем моделям продуктов, чтобы использовать в качестве breadcrumbs*/
    public function getParentCategories($id, $categories = [], $allCategories = null  )
    {
        if ($allCategories === null)
            $allCategories = $this->getActiveCategories();

        $category = $allCategories->first(function ($value, $key) use ($id) {
            return $value->id === $id;
        });

        if ($category !== null) {
            $category->children = $categories;
            return $this->getParentCategories($category->parent_id, $category, $allCategories);
        }
        return $categories;
    }
}
