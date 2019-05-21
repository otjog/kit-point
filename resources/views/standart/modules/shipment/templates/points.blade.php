@include( $global_data['project_data']['template_name'] .'.modules.elements.progress',
        ['msg' => 'Загружаем пункты выдачи..'])
@include( $global_data['project_data']['template_name'] .'.modules.elements.error',
['msg' => 'Мы не смогли загрузить пункты выдачи.'])

@php
    $aliasesString = '';

    foreach($shipment['services'] as $key => $service){
        $aliasesString .= $service->alias;

        if($key + 1 !== count($shipment['services'])){
            $aliasesString .= "|";
        }
    }
@endphp

<div id="map"
     class="blur"
     style="height:500px;"
     data-alias="{{$aliasesString}}"
>
</div>