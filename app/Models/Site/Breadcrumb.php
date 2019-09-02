<?php

namespace App\Models\Site;

class Breadcrumb
{
    public function getBreadcrumbs($modelCollection, $componentName)
    {
        $data = [];

        if($modelCollection === null)
            return $data;

        if(is_object($modelCollection[0]))
            $modelCollection = $modelCollection[0];

        $data[] = ['name' => $modelCollection->name];

        if (isset($modelCollection->category)) {
            $modelCollection->parent = $modelCollection->category;
        }

        $data = $this->getParent($modelCollection->parent, $data, $componentName);

        return array_reverse($data);
    }

    protected function getParent($modelCollection, $data, $componentName)
    {
        if ($modelCollection !== null){
            $data[] = [
                'name' => $modelCollection->name,
                'href' => /* '/' .$componentName .*/'/categories/' . $modelCollection->id,
            ];

            return $this->getParent($modelCollection->parent, $data, $componentName);
        }
        return $data;



    }
}
