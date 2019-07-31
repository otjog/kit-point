@include( $global_data['template']['name'] .'.modules.elements.progress',
        ['msg' => 'Загружаем пункты выдачи..'])
@include( $global_data['template']['name'] .'.modules.elements.error',
['msg' => 'Мы не смогли загрузить пункты выдачи.'])

@php
    $aliasesString = '';

    foreach($shipments as $key => $service){
        if ($service->is_service === 1  ) {
            $aliasesString .= $service->alias;

            if($key + 1 !== count($shipments)){
                $aliasesString .= "|";
            }
        }
    }
@endphp

<div id="mapShipmentCheckbox" class="border-top py-2">
    <span>Показать пункты: </span>
    <div class="form-check form-check-inline">
        @foreach($shipments as $key => $service)
            @if ($service->is_service === 1)
                <input class="form-check-input ml-3" type="checkbox" id="checkboxPoint_{{$service->alias}}" value="{{$service->alias}}" disabled>
                <label class="form-check-label" for="checkboxPoint_{{$service->alias}}">{{$service->name}}</label>
            @endif
        @endforeach
    </div>

</div>

<div id="map"
     class="blur"
     style="height:500px;"
     data-alias="{{$aliasesString}}"
>
</div>