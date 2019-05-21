@if(isset($service->offer) && count($service->offer) > 0 && $service->offer !== null)
    <div class="row p-2 border-bottom">
        <div class="col-2">
            <img src="{{ '/storage/img/elements/delivery/' . $service['alias'] . '/' . $service['alias'] .'_logo.jpg' }}" class="img-fluid">
        </div>

        <div class="col">
            <div class="blur">

                <div class="row">
                    <div class="col text-center">
                        <span class="shipment-price">{{$service->offer['price']}}</span> {{$global_data['project_data']['components']['shop']['currency']['symbol']}}
                    </div>
                    <div class="col text-center">
                        <span class="shipment-days">{{$service->offer['days']}}</span> дней
                    </div>
                </div>

            </div>

        </div>

    </div>
@endif