
@if(isset($shipment['services']) && count($shipment['services']) > 0 && $shipment['services'] !== null)
    @include( $global_data['project_data']['template_name'] . '.modules.elements.progress',
                       ['msg' => 'Рассчитываем доставку..'])
    <div class="shipment-offers">
        <div class="my-4">
            <h3 class="text-center">Самовывоз с пункта выдачи</h3>

            @foreach($shipment['services'] as $service)
                <div class="reload"
                     data-alias="{{$service['alias']}}"
                     data-type="toTerminal"
                >
                    @include( $global_data['project_data']['template_name'] .'.modules.shipment.reload.offer-checkbox')
                </div>
            @endforeach
        </div>
        <div class="my-4">
            <h3 class="text-center">Курьерская доставка до дверей</h3>

            @foreach($shipment['services'] as $service)
                <div class="reload"
                     data-alias="{{$service['alias']}}"
                     data-type="toDoor"
                >
                    @include( $global_data['project_data']['template_name'] .'.modules.shipment.reload.offer-checkbox')
                </div>
            @endforeach
        </div>
    </div>

@endif