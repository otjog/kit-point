@if(isset($service->offer) && count($service->offer) > 0 && $service->offer !== null)
    <div class="row p-2 border-bottom">

        <div class="col-1">
            <img src="{{ '/storage/img/elements/delivery/' . $service['alias'] . '/' . $service['alias'] .'_logo.jpg' }}" class="img-fluid">
        </div>

        <div class="col-5">
            <div class="custom-control custom-radio">
                <input
                        id="shipment_{{$service['alias'] }}_{{$service->offer['type']}}"
                        class="custom-control-input"
                        name="shipment_id"
                        value="{{$service['id']}}"
                        type="radio"
                        required="">

                <label
                        for="shipment_{{$service['alias'] }}_{{$service->offer['type']}}"
                        class="custom-control-label">
                    {{$service['name']}}
                </label>
            </div>
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