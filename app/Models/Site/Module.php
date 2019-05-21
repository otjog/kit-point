<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{

    protected $modelsPath = 'App\Models';

    protected $data;

    public function getModulesData($schema)
    {
        foreach ($schema['current'] as $nameMainPosition => $sidePositions) {

            if($sidePositions !== null) {
                foreach ($sidePositions as $nameSidePosition => $modules) {

                    foreach ($modules as $key=>$module) {

                        if(isset($module['resource']) && $module['resource'] !== null){

                            if(!isset($this->data[$module['resource']]) ||  $this->data[$module['resource']] === null){

                                $this->data[$module['resource']] = $this->getModelData($module['resource']);

                            }

                        }

                    }

                }

            }

        }
        return $this->data;
    }

    protected function getClassData($resourceKey)
    {
        $keys = explode('.', $resourceKey);

        $class['name'] = $this->modelsPath;

        $class['method'] = '';

        $class['arguments'] = [];

        foreach ($keys as $key) {

            if (class_exists($class['name'])) {
                if( $class['method'] === '')
                    $class['method'] = $key;
                else
                    $class['arguments'][] = $key;
            } else {
                $class['name'] .= '\\' . ucfirst($key)  ;
            }

        }

        if(!class_exists($class['name']))
            $class = null;
        return $class;
    }

    protected function getModelData($resourceKey)
    {
        $classData = $this->getClassData($resourceKey);

        if($classData === null)
            return null;

        $model = new $classData['name']();

        $method = $model->getModuleMethods($classData['method']);

        $moduleData = $model->$method(...$classData['arguments']);

        return $moduleData;
    }

}
