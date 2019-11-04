@if( !isset($product->basket_parameters) || count($product->basket_parameters) === 0)
    @if(isset($product->baskets) && count($product->baskets) > 0 && $product->baskets[0]->pivot['quantity'] > 0)
<div class="row no-gutters">
    <div class="col-12 col-lg-3 py-2 text-lg-center">
        @include( $global_data['template']['name']. '.components.shop.basket.edit.product_row.price')
    </div>
    <div class="col-12 col-lg-5 py-2 text-muted text-center">
        @include( $global_data['template']['name']. '.components.shop.basket.edit.product_row.quantity')
    </div>
    <div class="col-12 col-lg-3 py-lg-3 py-1 text-lg-right">
        @include( $global_data['template']['name']. '.components.shop.basket.edit.product_row.price_sum')
    </div>
</div>
    @else
        <div class="text-center">
            @include( $global_data['template']['name']. '.components.shop.basket.edit.product_row.restore')
        </div>
    @endif
@endif