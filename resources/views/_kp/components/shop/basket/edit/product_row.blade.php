<div class="row align-items-center my-2 border-bottom py-2">
    <div class="order-1 col-6   order-lg-1 col-lg-1     py-lg-1 px-lg-2">
        @include( $global_data['template']['name']. '.components.shop.basket.edit.product_row.image')
    </div>
    <div class="order-3 col-12  order-lg-2 col-lg-5">
        @include( $global_data['template']['name']. '.components.shop.basket.edit.product_row.name')
    </div>
    <div class="order-2 col-6   order-lg-3 col-lg-6">
        <div class="shop-basket-button-group"
             data-route="{{route('products.views.show',
             [$product->id, $global_data['template']['name'] . '.components.shop.basket.edit.product_row._reload'])}}">
            @include( $global_data['template']['name']. '.components.shop.basket.edit.product_row._reload')
        </div>
    </div>
</div>