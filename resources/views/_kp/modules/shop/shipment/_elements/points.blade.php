@include( $global_data['template']['name'] .'.modules.elements.progress',
        ['msg' => 'Загружаем пункты выдачи..'])
@include( $global_data['template']['name'] .'.modules.elements.error',
['msg' => 'Мы не смогли загрузить пункты выдачи.'])

@php
    $aliasesString = '';

    foreach($shipment as $key => $service){
        $aliasesString .= $service->alias;

        if($key + 1 !== count($shipment)){
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