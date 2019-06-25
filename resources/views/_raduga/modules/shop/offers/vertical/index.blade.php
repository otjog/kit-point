@foreach($offers as $offer)
    @if( isset($offer->products) && count($offer->products) > 0)
        <h3 class="side-heading">{{$offer->header}}</h3>
        <ul class="side-products-list">
        @foreach($offer->products as $product)
            <!-- Special Product Starts -->
                <li class="clearfix">
                    <a href="{{ route( 'products.show', $product->id ) }}">

                        @if( isset($product->images[0]->src) && $product->images[0]->src !== null )
                            <img
                                    class="img-fluid"
                                    src="{{route('models.sizes.images.show', ['product', 's', $product->images[0]->src])}}"
                                    alt="product"
                            />
                        @else
                            <img
                                    class="img-fluid"
                                    src="{{route('models.sizes.images.show', ['product', 's', 'no_image.jpg'])}}"
                                    alt="product"
                            />
                        @endif

                    </a>
                    <h5>
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
                    </h5>
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
                    @endif
                </li>
                <!-- Special Product  Ends -->
            @endforeach
        </ul>
    @endif
@endforeach