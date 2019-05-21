<div class="row no-gutters">
    @foreach( $products_row as $key => $product )
        <div class="product-item-wrap product-item-light col-4 rounded-0 border-right border-bottom">
        <!--span class="bg-light small px-1 py-1 w-50 rounded-bottom-right">Артикул: {{$product->scu or ''}}</span-->
            <div class="product-item pb-1 pt-3 px-2">
                <!-- Image-->
                <div class="product-image">
                    <a href="{{ route( 'products.show', $product->id ) }}">

                        @if( isset($product->images[0]->name) && $product->images[0]->name !== null )
                            <img
                                    class="img-fluid"
                                    src="{{ URL::asset('storage/img/shop/product/s/' . $product->images[0]->name) }}"
                                    alt=""
                            />
                        @else
                            <img
                                    class="img-fluid"
                                    src="{{ URL::asset('storage/img/shop/default/s/' . $global_data['project_data']['components']['shop']['images']['default_name']) }}"
                                    alt=""
                            />
                        @endif

                    </a>
                </div>
                <!--Price-->
                @if( isset($product->price['value']) && $product->price['value'] !== null)
                    <div class="bg-white pt-3 pb-2">
                        <div class="row">
                            <div class="col-12 price category-product text-center">
                                <div class="row">
                                    @if( isset($product->price['sale']) && $product->price['sale'] > 0)
                                        <div class="col-6">
                                            <span class="small">
                                                <s>
                                                    {{$product->price['value'] + $product->price['sale']}}<small>{{$global_data['project_data']['components']['shop']['currency']['symbol']}}</small>
                                                </s>
                                            </span>
                                        </div>
                                    @endif
                                    <div class="col text-danger">
                                        <span>{{ $product->price['value']}}</span><small>{{$global_data['project_data']['components']['shop']['currency']['symbol']}}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            @endif

            <!--Name-->
                <!--Name-->
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
                <!--Action-->
                <div class="product-action w-100 text-center border-top mt-2">
                    @if( !isset($product->basket_parameters) || count($product->basket_parameters) === 0)
                        <form method="post" role="form" action="{{route('baskets.store')}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="product_id"       value="{{ $product->id}}">
                            <input type="hidden" name="quantity" value="1" >
                            <input class="btn btn-link pb-0" type="submit" value="В корзину" />
                        </form>
                    @else
                        <a class="pt-2 d-block" href="{{ route( 'products.show', $product->id ) }}">
                            Выбрать размер
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>