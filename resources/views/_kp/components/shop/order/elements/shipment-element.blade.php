<li class="list-group-item">

    <div class="custom-control custom-radio mx-3">
        <input
                id="shipment_{{ $shipment->alias }}_{{$destination}}"
                class="custom-control-input"
                name="shipment_id"
                value="{{ $shipment->id }}"
                type="radio"
                required="">

        <label
                for="shipment_{{ $shipment->alias }}_{{$destination}}"
                class="custom-control-label">

            @if( isset( $service ))
                {{ $shipment->name }} - {{$service['price']}} {{$components['shop']['currency']['symbol']}} - {{$service['days']}} дней.
            @else
                {{ $shipment->name }}
            @endif

        </label>

        <div>
            {{ $shipment->description }}
        </div>

    </div>

</li>