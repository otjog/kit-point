@if(isset($global_data['ajax']->offer) && count($global_data['ajax']->offer) > 0 && $global_data['ajax']->offer !== null)
    <div class="row p-2 border-bottom">
        <div class="col-2">
            <img src="{{ '/storage/img/elements/delivery/' . $global_data['ajax']['alias'] . '/' . $global_data['ajax']['alias'] .'_logo.jpg' }}" class="img-fluid" alt="{{$global_data['ajax']->name}}">
        </div>

        <div class="col">
            <div class="blur">

                <div class="row">
                    <div class="col text-center">
                        <span class="shipment-price">{{$global_data['ajax']->offer['price']}}</span> {{$global_data['components']['shop']['currency']['symbol']}}
                    </div>
                    <div class="col text-center">
                        <span class="shipment-days">{{$global_data['ajax']->offer['days']}}</span> {{$global_data['ajax']->offer['declision']}}
                    </div>
                </div>

            </div>

        </div>

    </div>
@endif