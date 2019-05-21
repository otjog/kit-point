{{-- PAY --}}
@if( isset( $shipments ) && count( $shipments ) > 0 )

    <div class="col-lg-12">

        <h4 class="mb-3">Способ доставки</h4>

        @foreach( $shipments->chunk(3) as $shipments_row )

            <div class="row">
                @foreach( $shipments_row as $shipment)
                    <div class="col-lg-{{12 / 3}} form-check form-check-inline mb-3 mr-0">
                        <div class="custom-control custom-radio mx-3">
                            <input
                                    id="shipment_{{$shipment['alias'] }}"
                                    class="custom-control-input"
                                    name="shipment_id"
                                    value="{{$shipment['id']}}"
                                    type="radio"
                                    required="">

                            <label
                                    for="shipment_{{$shipment['alias'] }}"
                                    class="custom-control-label">
                                {{$shipment['name']}}
                            </label>
                        </div>
                    </div>

                @endforeach
            </div>
        @endforeach
    </div>
@endif