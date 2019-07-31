@if(isset($shipments) && count($shipments) > 0 && $shipments !== null)
    @include( $global_data['template']['name'] . '.modules.elements.progress',
                       ['msg' => 'Рассчитываем доставку..'])
    <div class="shipment-offers">
        <div class="my-4">
            <h5 class="text-center">Самовывоз с пункта выдачи</h5>

            @foreach($shipments as $service)
                @if($service['is_service'] || $service['alias'] === 'toTerminal')
                    <div class="reload"
                         data-alias="{{$service['alias']}}"
                         data-view="offer-checkbox"
                         data-parcel_data="{{$parcelData}}"
                         data-type="toTerminal"
                    >
                        @include( $global_data['template']['name'] .'.modules.shop.shipment._reload.offer-checkbox')
                    </div>
                @endif
            @endforeach
        </div>
        <div class="my-4">
            <h5 class="text-center">Курьерская доставка до дверей</h5>

            @foreach($shipments as $service)
                @if($service['is_service'] || $service['alias'] === 'toDoor')
                    <div class="reload"
                         data-alias="{{$service['alias']}}"
                         data-view="offer-checkbox"
                         data-parcel_data="{{$parcelData}}"
                         data-type="toDoor"
                    >
                        @include( $global_data['template']['name'] .'.modules.shop.shipment._reload.offer-checkbox')
                    </div>
                @endif
            @endforeach
        </div>
    </div>

@endif