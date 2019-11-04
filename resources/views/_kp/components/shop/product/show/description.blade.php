<div class="col-lg-12 order-4 my-4">

    @include($global_data['template']['name']. '.components.shop.product.show.description.text')

    @include($global_data['template']['name']. '.components.shop.product.show.description.parameters')

    @include($global_data['template']['name']. '.components.shop.product.show.description.images')

    @if(isset($global_data['modules']['shop.order.shipment.index']))
        <h3>Доставка</h3>
        @include(
            $global_data['template']['name']. '.modules.shop.shipment.index',
                [
                    'shipments' => $global_data['modules']['shop.order.shipment.index'],
                    'module' => ['template' =>'product']
                ]
        )
    @endif

</div>