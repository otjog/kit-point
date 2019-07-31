<!-- Wishlist -->
<div class="col-lg-3 col-6 order-lg-3 order-2 text-lg-left text-right">
    <div class="wishlist_cart d-flex flex-row align-items-center justify-content-end">
        <!-- Cart -->
        <div class="cart">
            <div class="cart_container d-flex flex-row align-items-center justify-content-end">
                <div class="cart_icon">
                    @if(isset($basket->products) && $basket !== null && count($basket->products) > 0)
                        <a href="{{route('baskets.edit', csrf_token())}}">
                            <img src="{{ URL::asset('storage/_kp/images/cart.png') }}" alt="">
                            <div class="cart_count"><span>{{ $basket->count_scu or 0}}</span></div>
                        </a>
                    @else
                        <img src="{{ URL::asset('storage/_kp/images/cart.png') }}" alt="">
                        <div class="cart_count"><span>{{ $basket->count_scu or 0}}</span></div>
                    @endif
                </div>
                <div class="cart_content">
                    <div class="cart_text">
                        @if(isset($basket->products) && $basket !== null && count($basket->products) > 0)
                            <a href="{{route('baskets.edit', csrf_token())}}">Корзина</a>
                        @else
                            <span>Корзина</span>
                        @endif
                    </div>
                    <div class="cart_price">
                        {{ $basket->total  or 0}}<small>{{$global_data['components']['shop']['currency']['symbol']}}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>