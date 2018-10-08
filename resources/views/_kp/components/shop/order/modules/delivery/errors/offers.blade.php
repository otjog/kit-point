<div class="row">

    @foreach($shipments as $shipment)

        <div class="col-lg-6">

            <ul class="list-group list-group-flush">

                @include( $template_name .'components.shop.order.elements.shipment-element',
                        [
                            'shipment'      => $shipment,
                            'destination'   => 'default'
                        ])
            </ul>

        </div>

    @endforeach

</div>

