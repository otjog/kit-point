<div class="row no-gutters align-items-center my-lg-2 border-bottom py-lg-2 pb-2">

    <div class="col-12 col-lg-6 mb-2 my-lg-0">
        Мы нашли лучший способ доставки в {{ $delivery['_geo']['city_name'] }}
    </div>
    <div class="col-4 col-lg-3 text-center">
        {{ $delivery['_bestOffer']['days'] }} дней
    </div>
    <div class="col-4 col-lg-1 text-center">
        {{ $delivery['_bestOffer']['price'] }}{{$components['shop']['currency']['symbol']}}
    </div>
    <div class="col-4 col-lg-2 text-center text-muted align-items-center">
        <a href="#" class="badge badge-info py-2" data-toggle="modal" data-target="#change-city-form">Изменить город</a>
    </div>

</div>
