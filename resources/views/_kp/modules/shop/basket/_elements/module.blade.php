{{-- Cart --}}

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
            <div class="cart_price d-none d-md-block">
                {{ $basket->total  or 0}}
                <small>
                    {{$basket->currency_symbol or $global_data['components']['shop']['currency']['symbol']}}
                </small>
            </div>
        </div>
    </div>
</div>