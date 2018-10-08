@if( isset( $product->images ) && count( $product->images ) > 1)
    <!-- Images -->
    <div class="col-lg-2 order-lg-1 order-2">
        <ul class="image_list">
            @foreach( $product->images as $image)

                <li>
                    <a class="fancybox" rel="product_images" href="{{ URL::asset('storage/img/shop/product/'.$image->src) }}" title="">
                        <img src="{{ URL::asset('storage/img/shop/product/'.$image->src) }}" alt="" />
                    </a>
                </li>

            @endforeach
        </ul>
    </div>

@endif

@isset($product->images[0]->src)
    <!-- Main Image -->
    <div class="col-lg-5 order-lg-2 order-1">
        <div class="image_selected"><img src="{{ URL::asset('storage/img/shop/product/'.$product->images[0]->src) }}" alt=""></div>
    </div>
@endisset

@empty($product->images[0]->src)
    <div class="col-lg-5 order-lg-2 order-1">
        <div class="image_selected text-light"><i class="fas fa-shopping-basket fa-7x"></i></div>
    </div>
@endempty

<!-- Right Column -->
<div class="col-lg-5 order-3">
    <div class="product_description">
        <div class="product_category">{{$product->category['name']}}</div>
        <div class="product_scu">Артикул: {{$product->scu}}</div>
        <h1 class="product_name">{{$product->name}}</h1>

        @if( isset($product->price['value']) && $product->price['value'] !== null)

            @if( isset($product->price['sale']) && $product->price['sale'] > 0)

                <div class="product_price text-muted mr-3 clearfix">
                    <s>
                        <small>{{$product->price['value'] + $product->price['sale']}}</small><small>{{$components['shop']['currency']['symbol']}}</small>
                    </s>
                </div>

            @endif

            <div class="product_price clearfix">
                {{ $product->price['value'] }}
                <small>{{$components['shop']['currency']['symbol']}}</small>
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

        <div class="my-4 py-3 border-top">

            <form id="delivery-form">
                <input type="hidden" name="weight"      value="{{$product->weight}}">
                <input type="hidden" name="length"      value="{{$product->length}}">
                <input type="hidden" name="width"       value="{{$product->width}}">
                <input type="hidden" name="height"      value="{{$product->height}}">
                <input type="hidden" name="quantity"    value="1">
            </form>

            <div id="delivery-best-offer">
                @include( $template_name .'.modules.delivery.reload.best-offer')
            </div>

            @include( $template_name .'.modules.modals.forms.change-city')

        </div>

    </div>
</div>

<!-- TABS -->
<div class="col-lg-12 order-4 my-4">

    <ul class="nav nav-tabs" id="tabs">
        <li class="nav-item">
            <a class="nav-link active" data-tabIndex="description">Описание</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-tabIndex="delivery">Доставка</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-tabIndex="reviews">Отзывы</a>
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
                            @if($key === 0 || $product->parameters[$key -1 ]->name !== $parameter->name)
                                <strong>{{$parameter->name}}: </strong>
                            @endif

                            <span class="text-muted">{{$parameter->pivot->value}}</span>
                        </li>

                    @endforeach
                </ul>

            @endif
        </div>

        {{-- Delivery Tab --}}
        <div class="tab-data data-delivery">

            <div class="row">
                <div class="col-12 col-lg-4">
                    <div id="delivery-offers">
                        @include( $template_name .'.modules.delivery.reload.offers')
                    </div>
                </div>
                <div id="map" style="height:500px;" class="col-12 col-lg-8"></div>
            </div>

        </div>

        {{-- Reviews Tab --}}
        <div class="tab-data data-reviews">
            Вскоре мы добавим возможность оставлять отзывы об этом товаре.
        </div>

    </div>

</div>