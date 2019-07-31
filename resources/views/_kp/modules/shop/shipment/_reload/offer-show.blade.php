@if(isset($global_data['ajax']->offer) && count($global_data['ajax']->offer) > 0 && $global_data['ajax']->offer !== null)
    <div class="row p-2 border-bottom">
        <div class="col-2">
            @php
                if (isset($global_data['ajax']->images) && count($global_data['ajax']->images) > 0)
                    $imageSrc = $global_data['ajax']->images[0]->src;
                else
                    $imageSrc = 'noimage';
            @endphp
            <img
                    class="img-fluid"
                    src="{{route('getImage', ['default', 'xxs', $imageSrc, $global_data['ajax']->id])}}"
                    alt="{{$global_data['ajax']->images[0]->alt or $global_data['ajax']->name}}"
            />
        </div>

        <div class="col">
            <div class="blur">

                <div class="row">
                    @if(isset($global_data['ajax']->offer['error']))
                        <div class="col text-center">
                            <span class="shipment-message">{{$global_data['ajax']->offer['message']}}</span>
                        </div>
                    @else
                        <div class="col text-center">
                            <span class="shipment-price">{{$global_data['ajax']->offer['price'][0]}}</span> {{$global_data['ajax']->offer['price'][1]}}
                        </div>
                        <div class="col text-center">
                            <span class="shipment-days">{{$global_data['ajax']->offer['days'][0]}}</span> {{$global_data['ajax']->offer['days'][1]}}
                        </div>
                    @endif
                </div>

            </div>

        </div>

    </div>
@endif