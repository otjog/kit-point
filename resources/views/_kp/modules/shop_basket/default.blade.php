<div class="wishlist_cart d-flex flex-row align-items-center justify-content-end">

<!-- Cart -->
    <div class="cart">
        <div class="cart_container d-flex flex-row align-items-center justify-content-end">
            <div class="cart_icon">
                @if( isset($basket) && $basket !== null)
                    <a href="{{route('baskets.edit', csrf_token())}}">
                        <img src="{{ URL::asset('storage/img/elements/cart.png') }}" alt="">
                        <div class="cart_count"><span>{{ $basket->count_scu or 0}}</span></div>
                    </a>
                @else
                    <img src="{{ URL::asset('storage/img/elements/cart.png') }}" alt="">
                    <div class="cart_count"><span>{{ $basket->count_scu or 0}}</span></div>
                @endif
            </div>
            <div class="cart_content">
                <div class="cart_text">Корзина</div>
                <div class="cart_price">
                    {{ $basket->total  or 0}}<small>{{$components['shop']['currency']['symbol']}}</small>
                </div>
            </div>
        </div>
    </div>

</div>