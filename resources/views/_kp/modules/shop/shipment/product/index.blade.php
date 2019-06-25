<div
        class="row"
        id="shipment-offers"
        data-parcel[width]="{{$product->width}}"
        data-parcel[height]="{{$product->height}}"
        data-parcel[length]="{{$product->length}}"
        data-parcel[weight]="{{$product->weight}}"
        data-parcel[quantity]="1"
        data-view="offer-show"
>
    <div class="col-12 col-lg-12 geo_change_location">
        @include($global_data['template']['name'] .'.modules.change-geo.product')
    </div>

    <div class="col-12 col-lg-6">
        @include($global_data['template']['name'] . '.modules.shop.shipment._elements.offers')
    </div>

    <div class="col-12 col-lg-6">
        @include($global_data['template']['name'] . '.modules.shop.shipment._elements.points')
    </div>



</div>