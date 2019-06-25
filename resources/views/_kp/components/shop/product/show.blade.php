@extends('_kp.index')

@section('component')

    <?php
        $product =& $global_data['shop']['product'];
    ?>

    <div class="single_product">
        <div class="container">
            <div class="row">
                <!-- Images -->
                <div class="col-lg-7">
                    <div class="row">
                        @include( $global_data['template']['name']. '.components.shop.product.elements.images.gallery')
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-5 order-3">
                    <div class="product_description">
                        <div class="product_category">{{$product->category['name']}}</div>
                        <div class="product_scu">Артикул: {{$product->scu}}</div>
                        <h1 class="product_name">
                            @isset($product->manufacturer['name'])
                                {{ $product->manufacturer['name'] . ' ' }}
                            @endisset

                            {{ $product->name }}

                            @if( isset($product->brands) && count($product->brands) > 0 && $product->brands !== null)

                                @foreach($product->brands as $brand)
                                    {{ ' | ' . $brand->name}}
                                @endforeach

                            @endif
                        </h1>

                        @if( isset($product->price['value']) && $product->price['value'] !== null)

                            @if( isset($product->price['sale']) && $product->price['sale'] > 0)

                                <div class="product_price text-muted mr-3 clearfix">
                                    <s>
                                        <small>{{$product->price['value'] + $product->price['sale']}}</small><small>{{$global_data['components']['shop']['currency']['symbol']}}</small>
                                    </s>
                                </div>

                            @endif

                            <div class="product_price clearfix">
                                {{ $product->price['value'] }}
                                <small>{{$global_data['components']['shop']['currency']['symbol']}}</small>
                            </div>

                            <div class="my-2 d-flex flex-row">
                                <form id="buy-form" method="post" role="form" action="{{route('baskets.store')}}">

                                    <div class="product_quantity">
                                        <span>Кол-во: </span>
                                        <input type="text"      name="quantity"     value="1" size="5" pattern="[0-9]*" class="quantity_input">
                                        <input type="hidden"    name="product_id"   value="{{$product->id}}">
                                        <input type="hidden"    name="_token"       value="{{csrf_token()}}">

                                        <div class="quantity_buttons">
                                            <div
                                                    class="quantity_inc quantity_control"
                                            >
                                                <i class="fas fa-chevron-up"></i>
                                            </div>
                                            <div
                                                    class="quantity_dec quantity_control"
                                                    data-quantity-min-value="1"
                                            >
                                                <i class="fas fa-chevron-down"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="button_container">
                                        <button type="submit" class="button cart_button">Купить</button>
                                    </div>

                                    @if( isset($product->basket_parameters) && count($product->basket_parameters) > 0)
                                        <div class="order_parameters my-3 float-left">
                                            @foreach($product->basket_parameters as $key => $parameter)
                                                @if($key === 0 || $product->basket_parameters[$key -1 ]->name !== $parameter->name)
                                                    <strong>{{$parameter->name}}: </strong>
                                                @endif

                                                <div class="form-check form-check-inline">
                                                    <div class="custom-control custom-radio">
                                                        <input
                                                                class="custom-control-input"
                                                                type="radio"
                                                                required=""
                                                                name="order_attributes[]"
                                                                id="{{ $parameter->pivot->id }}"
                                                                value="{{ $parameter->pivot->id }}"
                                                        >
                                                        <label class="custom-control-label" for="{{ $parameter->pivot->id }}">{{$parameter->pivot->value }}</label>
                                                    </div>

                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                </form>
                            </div>

                        @else
                            <div class="alert alert-warning">
                                Мы не смогли отобразить цену. Позвоните нам и мы всё исправим.
                            </div>
                        @endif


                        {{-- Best Shipment Offer --}}
                        @include($global_data['template']['name']. '.modules.shop.shipment._elements.best-offer')

                    </div>
                </div>

                <!-- TABS -->
                <div class="col-lg-12 order-4 my-4">

                    <ul class="nav nav-tabs" id="tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-tabIndex="description">Описание</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-tabIndex="shipment">Доставка</a>
                        </li>
                    </ul>

                    <div class="pt-3" id="tab-data">

                        {{-- Description Tab --}}
                        <div class="tab-data data-description">
                            @if(isset( $product->description ))
                                <p>{{ $product->description }}</p>
                            @endif

                            @if( isset($product->parameters) && count($product->parameters) > 0)

                                <ul class="list-unstyled">
                                    @foreach($product->parameters as $key => $parameter)

                                        <li>
                                            @if($key === 0 || $product->parameters[$key -1]->name !== $parameter->name)
                                                <strong>{{$parameter->name}}: </strong>
                                            @endif

                                            <span class="text-muted">{{$parameter->pivot->value}}</span>
                                        </li>

                                    @endforeach
                                </ul>

                            @endif
                        </div>

                        {{-- Shipment Tab --}}
                        <div class="tab-data data-shipment">
                            @if(isset($global_data['modules']['shop.order.shipment.index']))
                                @php $module['template'] = 'product'; @endphp
                                @include(
                                    $global_data['template']['name']. '.modules.shop.shipment.index',
                                        [
                                            'shipment' => $global_data['modules']['shop.order.shipment.index'],
                                            'module' => $module
                                        ]
                                )
                            @endif
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection