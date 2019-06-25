<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $casts = [
        'options' => 'array',
    ];

    protected $data;

    protected $schemaName;

    protected $metatags;

    public function getTemplateData($component, $model=null, $view=null, $id=null){

        $this->schemaName = env('SITE_TEMPLATE_SCHEMA', 'default');

        $model  !== null ? $model = '.'.$model  : $model = '';

        $view   !== null ? $view = '.'.$view    : $view = '';

        $id     !== null ? $id   = '.'.$id      : $id   = '';

        $this->data['name'] = env('SITE_TEMPLATE');

        $this->data['componentKey'] = $component . $model;

        $this->data['contentKey'] = $this->data['componentKey'] . $view;

        $this->data['metatagsKey'] = $this->data['contentKey'] . $id;

        $this->data['viewKey'] = $this->data['name'] . '.' . ($component==='home' ? '' : 'components.') . $this->data['componentKey'] . $view;

        $this->data['schema'] = $this->getTemplateSchema();

        return $this->data;
    }

    private function getTemplateSchema(){
        $options = self::select(
            'id',
            'name',
            'options'
        )
            ->where('name', $this->schemaName)
            ->first();

        $currentTemplate = $options->options;

        $currentTemplate['content'] = array_get($currentTemplate['content'], $this->data['contentKey'], null);

        $options['current'] = $currentTemplate;

        return $options;
    }
}
