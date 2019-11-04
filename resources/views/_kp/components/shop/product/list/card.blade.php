<div class="col-12 col-lg-4">
    <div class="product-item-wrap product-item-light border h-100">
        <div class="bg-light small p-1 w-50 rounded-bottom-right">
            Артикул: {{$product->scu or ''}}
        </div>
        <div class="product-item pb-1 pt-3 px-2">
            <div class="row">
                <div class="col-4 col-md-12">
                    {{--Image--}}
                    @include($global_data['template']['name']. '.components.shop.product.list.card.image')
                </div>

                <div class="col-8 col-md-12">
                    {{--Name--}}
                    @include($global_data['template']['name']. '.components.shop.product.list.card.name')
                </div>

                <div class="col-12 my-1">
                    <div class="row">

                        {{-- Quantity Discount --}}
                        <div class="col-12">
                            @include( $global_data['template']['name']. '.components.shop.product.list.card.quantity_discount')
                        </div>

                        <div class="col-12">
                            <div class="row shop-basket-button-group"
                                 data-route="{{route('products.views.show', [$product->id, $global_data['template']['name']. '.components.shop.product..list.card.sell_block'])}}">

                                @include( $global_data['template']['name']. '.components.shop.product.list.card.sell_block')
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>