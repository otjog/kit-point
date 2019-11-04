{{-- Wishlist --}}
<div class="col-2 col-lg-3 order-3 text-lg-left text-right">
    <div class="wishlist_cart d-flex flex-row align-items-center justify-content-end">
        <div class="shop-module-basket"
             data-route="{{route('baskets.views.show', [csrf_token(), '_kp.modules.shop.basket._elements.module'])}}">
            @include('_kp.modules.shop.basket._elements.module')
        </div>
    </div>
</div>