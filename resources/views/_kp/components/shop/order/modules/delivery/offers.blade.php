<div class="row">
    {{-- Terminal --}}
    <div class="col-lg-6">

        <h5>Забрать с пункта выдачи:</h5>

        <ul class="list-group list-group-flush">

            @foreach($delivery['shipments'] as $shipment)

                @if( isset( $delivery['costs'][ $shipment->alias ]['toTerminal'] ))

                    @include( $template_name .'.components.shop.order.elements.shipment-element',
                        [
                            'shipment'      => $shipment,
                            'service'       => $delivery['costs'][ $shipment->alias ]['toTerminal'],
                            'destination'   => 'toTerminal'
                        ])

                @endif

            @endforeach

        </ul>

    </div>

    {{-- Door --}}
    <div class="col-lg-6">

        <h5>Доставить до дверей:</h5>

        <ul class="list-group list-group-flush">

            @foreach($delivery['shipments'] as $shipment)

                @if( isset( $delivery['costs'][ $shipment->alias ]['toDoor'] ))

                    @include( $template_name .'.components.shop.order.elements.shipment-element',
                        [
                            'shipment'      => $shipment,
                            'service'       => $delivery['costs'][ $shipment->alias ]['toDoor'],
                            'destination'   => 'toDoor'
                        ])

                @endif

            @endforeach

        </ul>

    </div>
</div>

