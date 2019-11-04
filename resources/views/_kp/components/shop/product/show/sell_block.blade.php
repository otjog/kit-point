@if( isset($product->price['value']) && $product->price['value'] !== null)

    @include( $global_data['template']['name']. '.components.shop.product.show.sell_block.sale')

    @include( $global_data['template']['name']. '.components.shop.product.show.sell_block.price')

    @include( $global_data['template']['name']. '.components.shop.product.show.sell_block.store')

    @if( isset($product->stores) && $product->stores !== null && count($product->stores) > 0 )
        <div class="my-1 d-flex flex-row">
            @include( $global_data['template']['name']. '.components.shop.product.show.sell_block.forms')
        </div>
    @endif

@else
    <div class="alert alert-warning">
        Мы не смогли отобразить цену. Позвоните нам и мы всё исправим.
    </div>
@endif