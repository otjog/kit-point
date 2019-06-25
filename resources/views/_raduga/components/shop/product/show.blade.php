@extends('_raduga.index')

@section('component')

    <?php
        $product =& $global_data['shop']['product'];
    ?>

    <!-- Product Info Starts -->
    <div class="row product-info full">
        <!-- Left Starts -->
        <div class="col-sm-6 images-block">
            <p>
                @if( isset($product->images[0]->src) && $product->images[0]->src !== null)
                    <a
                            href="{{route('models.sizes.images.show', ['product', 'l', $product->images[0]->src])}}"
                            class="open-popup-link"
                            data-magnific-type="image"
                            title=""
                    >
                        <img
                                src="{{route('models.sizes.images.show', ['product', 'm', $product->images[0]->src])}}"
                                alt=""
                        />
                    </a>
                @else
                    <img
                            src="{{route('models.sizes.images.show', ['product', 'm', 'no_image.jpg'])}}"
                            alt=""
                    />
                @endif
            </p>
            <ul class="list-unstyled list-inline">
                @if( isset( $product->images ) && count( $product->images ) > 1)
                    @foreach( $product->images as $image)
                        <li class="list-inline-item">
                            <a
                                    href="{{route('models.sizes.images.show', ['product', 'l', $image->src])}}"
                                    class="open-popup-link"
                                    data-magnific-type="image"
                            >
                                <img src="{{route('models.sizes.images.show', ['product', 'xxs', $image->src])}}" alt="Image" class="img-fluid img-thumbnail rounded-0" />
                            </a>
                        </li>
                    @endforeach
                @endif
                    @if(isset($global_data['photo360']['extFile']) && $global_data['photo360']['extFile'] !== '')
                        <li class="list-inline-item">
                            <a
                                    href="#photo360-popup"
                                    class="open-popup-link"
                                    data-magnific-type="inline"
                                    data-magnific-src="#photo360-popup"
                            >
                                <img src="{{route('models.sizes.images.show', ['photo360', 'xxs', 'icon'])}}" alt="Image" class="img-fluid img-thumbnail rounded-0" />
                            </a>
                        </li>
                            <div id="photo360-popup" class="photo360-popup mfp-hide">
                                <div
                                        id="photo360"
                                        data-location="{{$global_data['photo360']['path']}}"
                                        data-format="{{$global_data['photo360']['extFile']}}"
                                        data-count="{{$global_data['photo360']['count']}}"
                                >
                                </div>
                                <button type="button" class="btn custom-control-next">Назад</button>
                                <button type="button" class="btn custom-control-stop">Остановить</button>
                                <button type="button" class="btn custom-control-start">Воспроизвести</button>
                                <button type="button" class="btn custom-control-prev">Вперед</button>
                            </div>
                    @endif
            </ul>
        </div>
        <!-- Left Ends -->
        <!-- Right Starts -->
        <div class="col-sm-6 product-details">
            <div class="panel-smart">
                <!-- Product Name Starts -->
                <h2>
                    @isset($product->manufacturer['name'])
                        {{ $product->manufacturer['name'] . ' ' }}
                    @endisset

                    {{ $product->name }}


                </h2>
                <!-- Product Name Ends -->
                <hr />
                <!-- Manufacturer Starts -->
                <ul class="list-unstyled manufacturer">
                    @if( isset($product->brands) && count($product->brands) > 0 && $product->brands !== null)

                        @foreach($product->brands as $brand)
                            <li>
                                <span>Brand:</span> {{$brand->name}}
                            </li>
                        @endforeach

                    @endif

                    <li><span>Артикул:</span>{{$product->scu}}</li>
                </ul>
                <!-- Manufacturer Ends -->
                <hr />
            @if( isset($product->price['value']) && $product->price['value'] !== null)
                    <form id="buy-form" method="post" role="form" action="{{route('baskets.store')}}">
                        <!-- Price Starts -->
                        <div class="price">
                            @if( isset($product->basket_parameters) && count($product->basket_parameters) > 0)
                                @include('_raduga.components.shop.product.elements.multi_price')
                            @else
                                @include('_raduga.components.shop.product.elements.once_price')
                            @endif
                        </div>
                        <!-- Price Ends -->
                        <div class="my-4">
                            <div class="row mx-0">
                                <div class="product_quantity col-12 col-md-6 col-lg-6">
                                    <span>Кол-во: </span>
                                    <input type="text"      name="quantity"     value="1" size="5" pattern="[0-9]*" class="quantity_input">
                                    <input type="hidden"    name="product_id"   value="{{$product->id}}">
                                    <input type="hidden"    name="_token"       value="{{csrf_token()}}">
                                    <div class="quantity_buttons">
                                        <div class="quantity_inc quantity_control">
                                            <i class="fas fa-chevron-up"></i>
                                        </div>
                                        <div class="quantity_dec quantity_control" data-quantity-min-value="1">
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="cart-button button-group px-0 px-md-2 col-12 col-md-6 col-lg-6 mt-3 mt-md-0">
                                    <button type="submit" class="btn btn-cart btn-block">
                                        В корзину
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                @endif
                @if(isset( $product->description ))
                    <h4>Описание</h4>
                    <p>{{ $product->description }}</p>
                @endif
            </div>
        </div>
        <!-- Right Ends -->
    </div>
    <!-- Product Info Ends -->
@endsection