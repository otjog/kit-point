<div class="rounded border bg-light pt-3 pb-2 px-2">
    <div class="shop-basket-total"
         data-route="{{route('baskets.views.show', [csrf_token(), $global_data['template']['name']. '.components.shop.basket.edit.total_block._reload'])}}">
        @include($global_data['template']['name']. '.components.shop.basket.edit.total_block._reload')
    </div>
</div>