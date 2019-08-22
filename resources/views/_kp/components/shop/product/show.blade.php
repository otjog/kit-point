@extends('_kp.index')

@section('component')

    <?php
        $product =& $global_data['shop']['product'];
        $parcelData =& $global_data['shop']['parcelData'];
    ?>

    <div class="single_product">
        <div class="container">
            <div class="row">

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

                <!-- Images -->
                <div class="col-lg-7">
                    <div class="row">
                        @include( $global_data['template']['name']. '.components.shop.product.elements.images.gallery')
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-5 order-3">
                    <div class="product_description">
                        <div>Категория: <span class="text-muted">{{$product->category['name']}}</span></div>
                        <div>Артикул: <span class="text-muted">{{$product->scu}}</span></div>

                        @if( isset($product->price['value']) && $product->price['value'] !== null)

                            @if( isset($product->price['sale']) && $product->price['sale'] > 0)

                                <div class="product_price text-muted mr-3 clearfix">
                                    <s>
                                        <small>{{$product->price['value'] + $product->price['sale']}}</small><small>{{$global_data['components']['shop']['currency']['symbol']}}</small>
                                    </s>
                                </div>

                            @endif

                            <div class="product_price clearfix">
                                @if($product->price['value'] !== 0.00)
                                    {{ $product->price['value'] }}
                                    <small>{{$global_data['components']['shop']['currency']['symbol']}}</small>
                                @else
                                    <span class="text-muted m-0">Цена не установлена</span>
                                @endif
                            </div>
                            <div>
                                @if( isset($product->stores) && $product->stores !== null && count($product->stores) > 0 )
                                    <small class="text-success">В наличии</small>
                                @else
                                    <small class="text-muted">Нет в наличии</small>
                                @endif
                            </div>

                            @if( isset($product->stores) && $product->stores !== null && count($product->stores) > 0 )
                                <div class="my-1 d-flex flex-row">
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
                            @endif

                        @else
                            <div class="alert alert-warning">
                                Мы не смогли отобразить цену. Позвоните нам и мы всё исправим.
                            </div>
                        @endif

                        {{-- Best Shipment Offer --}}
                        <div id="shipment-best-offer" class="py-1">
                            @include($global_data['template']['name']. '.modules.shop.shipment._elements.best-offer')
                        </div>

                    </div>
                </div>

                <!-- TABS -->
                <div class="col-lg-12 order-4 my-4">

                    <ul class="nav nav-tabs" id="tabs">
                        @if(isset($product->description) && $product->description !== '')
                            <li class="nav-item">
                                <a class="nav-link" data-tabIndex="description">Описание</a>
                            </li>
                        @endif
                        @if( isset($product->parameters) && count($product->parameters) > 0)
                            <li class="nav-item">
                                <a class="nav-link" data-tabIndex="parameters">Характеристики</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" data-tabIndex="shipment">Доставка</a>
                        </li>
                    </ul>

                    <div class="pt-3" id="tab-data">

                        {{-- Description Tab --}}
                        <div class="tab-data data-description">
                            @if(isset( $product->description ))
                                <p>{!! $product->description !!}</p>
                            @endif
                        </div>

                        {{-- Parameters Tab --}}
                        <div class="tab-data data-parameters">

                            @if( isset($product->parameters) && count($product->parameters) > 0)
                                @php $product->parameters = $product->parameters->groupBy('alias'); @endphp
                                <div class="container">
                                    @foreach($product->parameters as $currentParameters)

                                        @if(count($currentParameters) > 0)
                                            <div class="row">
                                                @foreach($currentParameters as $key => $parameter)
                                                    @if($loop->first)
                                                        <div class="col col-lg-3 pl-0 ml-2 product_parameter_name">
                                                            <span>{{$parameter->name}}:</span>
                                                        </div>
                                                        <div class="col col-lg-3 text-muted pl-1">
                                                            @endif
                                                            <span>{{$parameter->pivot->value}}</span>
                                                            @if($loop->last)
                                                        </div>
                                                    @else
                                                        <span> | </span>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif


                                    @endforeach
                                </div>

                            @endif
                        </div>

                        {{-- Shipment Tab --}}
                        <div class="tab-data data-shipment">
                            @if(isset($global_data['modules']['shop.order.shipment.index']))
                                @include(
                                    $global_data['template']['name']. '.modules.shop.shipment.index',
                                        [
                                            'shipments' => $global_data['modules']['shop.order.shipment.index'],
                                            'module' => ['template' =>'product']
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