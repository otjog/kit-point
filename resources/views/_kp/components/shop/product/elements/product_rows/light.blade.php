<div class="row no-gutters">
    @foreach( $products_row as $key => $product )
        <div class="col-12 col-lg-4">
            <div class="product-item-wrap product-item-light border h-100">

                <div class="bg-light small p-1 w-50 rounded-bottom-right">
                    Артикул: {{$product->scu or ''}}
                </div>
                <div class="product-item pb-1 pt-3 px-2">
                    <div class="row">
                        <div class="col-4 col-md-12">
                            {{--Image--}}
                            @php
                                if (count($product->images) > 0)
                                    $imageSrc = $product->images[0]->src;
                                else
                                    $imageSrc = 'noimage';
                            @endphp
                            <div class="product-image text-center">
                                <a href="{{ route( 'products.show', $product->id ) }}">
                                    <img
                                            class="img-fluid"
                                            src="{{route('getImage',['product', 's', $imageSrc, $product->id])}}"
                                            alt="{{$product->images[0]->alt or $product->name}}"
                                    />
                                </a>
                            </div>
                        </div>

                        <div class="col-8 col-md-12">
                            {{--Name--}}
                            <div class="product-name">
                                <a class="text-dark" href="{{ route( 'products.show', $product->id ) }}">
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
                            </div>
                        </div>

                        <div class="col-12">
                            {{-- Price & BuyButton --}}
                            <div class="my-1">
                                <div class="row">
                                    {{-- Price --}}
                                    <div class="col-6 text-center pt-2 m-auto price">
                                        @if( isset($product->price['value']) && $product->price['value'] !== null && $product->price['value'] !== 0.00)
                                            @if( isset($product->price['sale']) && $product->price['sale'] > 0)
                                                <span class="small text-danger">
                                            <s>
                                                {{$product->price['value'] + $product->price['sale']}}
                                                <small>{{$global_data['components']['shop']['currency']['symbol']}}</small>
                                            </s>
                                        </span>
                                            @else
                                                <div class="mt-3">{{-- Если нет скидки, этот блок опускает цену вниз --}}</div>
                                            @endif
                                            <strong>{{ $product->price['value']}}</strong><small>{{$global_data['components']['shop']['currency']['symbol']}}</small>
                                        @endif
                                    </div>
                                    <div class="col-6 text-right">
                                        @if( isset($product->stores) && $product->stores !== null && count($product->stores) > 0 )
                                            <small class="text-success mr-4">В наличии</small>
                                            @if( isset($product->price['value']) && $product->price['value'] !== null && $product->price['value'] !== 0.00)

                                                @if( !isset($product->basket_parameters) || count($product->basket_parameters) === 0)
                                                    <form method="post" role="form" action="{{route('baskets.store')}}">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="hidden" name="product_id" value="{{ $product->id}}">
                                                        <input type="hidden" name="quantity" value="1" >
                                                        <input class="btn btn-danger btn-sm" type="submit" value="В корзину" />
                                                    </form>
                                                @else
                                                    <a class="pt-2 d-block" href="{{ route( 'products.show', $product->id ) }}">
                                                        Выбрать размер
                                                    </a>
                                                @endif

                                            @endif
                                        @else
                                            <div class="text-muted pt-4">Нет в наличии</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>