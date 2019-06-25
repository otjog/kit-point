<div class="{{$wrapClass}}">
    <div class="product-col">
        <div class="image">
            <a href="{{ route( 'products.show', $product->id ) }}">

                @if( isset($product->images[0]->src) && $product->images[0]->src !== null )
                    <img
                            class="img-fluid"
                            src="{{route('models.sizes.images.show', ['product', 's-1-17', $product->images[0]->src])}}"
                            alt="product"
                    />
                @else
                    <img
                            class="img-fluid"
                            src="{{route('models.sizes.images.show', ['product', 's-1-17', 'no_image.jpg'])}}"
                            alt="product"
                    />
                @endif

            </a>
        </div>
        <div class="caption">
            <h4>
                <a href="{{ route( 'products.show', $product->id ) }}">
                    @isset($product->manufacturer['name'])
                        {{ $product->manufacturer['name'] . ' ' }}
                    @endisset
                    {{ $product->name }}
                    @if( isset($product->brands) && count($product->brands) > 0 && $product->brands !== null)
                        @foreach($product->brands as $brand)
                            {{ ' | ' . $brand->name}}
                        @endforeach
                    @endif
                </a>
            </h4>
            @if( isset($product->price['value']) && $product->price['value'] !== null)
                <div class="price">
                                        <span class="price-new">{{ $product->price['value']}}{{$global_data['components']['shop']['currency']['symbol']}}
                                        </span>
                    <span class="price-old">
                                            @if( isset($product->price['sale']) && $product->price['sale'] > 0)
                            {{$product->price['value'] + $product->price['sale']}}{{$global_data['components']['shop']['currency']['symbol']}}
                        @endif
                                        </span>
                </div>
                <div class="cart-button">
                    @if( !isset($product->basket_parameters) || count($product->basket_parameters) === 0)
                        <form method="post" role="form" action="{{route('baskets.store')}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="product_id"       value="{{ $product->id}}">
                            <input type="hidden" name="quantity" value="1" >
                            <button type="submit" class="btn btn-cart">
                                В корзину
                                <i class="fa fa-shopping-cart"></i>
                            </button>
                        </form>
                    @endif
                </div>
            @endif

        </div>
    </div>
</div>