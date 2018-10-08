@if( isset($basket->products) )

    @php

        $parcels = [
            'weight'    => '',
            'length'    => '',
            'width'     => '',
            'height'    => '',
            'quantity'  => ''
        ];
    @endphp

    {{-- MODALS --}}
    @include( $template_name .'.modules.modals.forms.change-city')
    {{--   END  --}}

    <div class="col-12 col-lg-9">
        <h4 class="mb-3">Корзина</h4>
        <form method="POST" action="{{ route( 'baskets.update', csrf_token() ) }}" id="basket_form" role="form" accept-charset="UTF-8" >

            @method('PUT')
            @csrf

            @foreach($basket->products as $key => $product)

                <div class="row align-items-center my-2 border-bottom py-2">
                    <div class="order-1 col-6   order-lg-1 col-lg-1     py-lg-1 px-lg-2">
                        <img class="img-fluid mx-auto my-auto d-block" src="{{ URL::asset('storage/img/shop/product/thumbnail/'.$product->thumbnail) }}">
                    </div>
                    <div class="order-3 col-12  order-lg-2 col-lg-5 ">
                        <a href="{{ route('products.show', $product->id) }}">
                            {{ $product->name }}
                        </a>
                        <span class="text-muted">{{ $product->price['value'] }}</span>
                        <span class="text-muted small"><small>{{$components['shop']['currency']['symbol']}}</small></span>

                        <!-- Атрибуты -->

                        @if( isset($product['pivot']['order_attributes_collection']) && count( $product['pivot']['order_attributes_collection'] ) > 0)
                            <br>
                            @foreach($product['pivot']['order_attributes_collection'] as $attribute)

                                <span class="text-muted small">

                                        {{$attribute->name}} : {{$attribute->pivot->value}}

                                </span>

                            @endforeach

                        @endif

                    </div>
                    <div class="order-2 col-6   order-lg-3 col-lg-6">
                        <div class="row">
                            <div class="col-12 col-lg-6 py-2 text-muted">
                                <div class="row no-gutters">
                                    <div class="col-3 text-center py-2">
                                        <div
                                                class="icon quantity_control quantity_dec"
                                                data-quantity-min-value="0">
                                            <i class="far fa-minus-square"></i>
                                        </div>
                                    </div>
                                    <div class="col-3 text-center">

                                        <input
                                                type="hidden"
                                                name="{{ $key }}[product_id]"
                                                value="{{ $product->id }}">
                                        <input
                                                type="hidden"
                                                name="{{ $key }}[order_attributes]"
                                                value="{{ $product['pivot']['order_attributes'] }}">
                                        <input
                                                type="text"
                                                name="{{ $key }}[quantity]"
                                                value="{{ $product['pivot']['quantity'] }}"
                                                class="form-control quantity_input"
                                                size="5" >

                                    </div>
                                    <div class="col-3 text-center py-2">
                                        <div
                                                class="icon quantity_control quantity_inc">
                                            <i class="far fa-plus-square"></i>
                                        </div>
                                    </div>
                                    <div class="col-3 text-center py-2">
                                        <span class="icon quantity_upd"><i class="fas fa-sync-alt"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-10 col-lg-4 py-3 text-center">
                                <span>{{ $product->price['value'] * $product['pivot']['quantity'] }}</span>
                                <small>{{$components['shop']['currency']['symbol']}}</small>
                            </div>
                            <div class="col-12 col-lg-2 py-3 d-none d-lg-block text-center text-muted">
                                <span class="icon quantity_del"><i class="fas fa-trash-alt"></i></span>
                            </div>
                        </div>
                    </div>
                </div>

                @php

                    foreach($parcels as $param => $value){
                    //todo сделать дефолтные значения, для отсутствующих параметров

                        if( $parcels[$param] !== ''){
                             $parcels[$param] .= '|';
                        }

                        $parcels[$param] .= $product[$param];
                    }

                @endphp

            @endforeach

            <div id="delivery-best-offer" data-component="shop|basket">
                @include( $template_name .'.modules.delivery.reload.best-offer')
            </div>

        </form>

        <form id="delivery-form">
            @foreach($parcels as $param => $value)
                <input type="hidden" name="{{$param}}" value="{{$value}}">
            @endforeach
        </form>

    </div>

    <div class="col-12 col-lg-3 border-left rounded ">
        <h4 class="mb-lg-3">Итого</h4>
        <div class="row px-2">
            <div class="col-10 offset-2 mb-3">Сумма товаров: {{ $basket->total }}<small>{{$components['shop']['currency']['symbol']}}</small></div>
            @if( $basket->total > 0)
                <span class="small">Стоимость доставки не учитывается в заказе.</span>
                <a href="{{route('orders.create')}}" class="btn btn-warning btn-lg btn-block my-3" type="submit">Оформить заказ</a>
            @endif
        </div>
    </div>

@endif