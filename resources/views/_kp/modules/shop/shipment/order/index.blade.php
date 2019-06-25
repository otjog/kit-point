<div class="col-lg-12">

    <div
            id="shipment-offers"
            class="order-4 my-4"
            @foreach($parcels as $param => $value)
            data-parcel[{{$param}}]="{{$value}}"
            @endforeach
            data-view="offer-checkbox"
    >

        <h4 class="mb-3">Способ доставки</h4>

        @include($global_data['template']['name'] . '.modules.shop.shipment._elements.offers-checkbox')

    </div>

</div>