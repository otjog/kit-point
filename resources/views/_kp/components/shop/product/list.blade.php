<div class="product-list" id="product-list">
    <div class="container">

        @if(isset($products) && count($products) > 0)

            @foreach($products->chunk($components['shop']['chunk_products']) as $products_row)

                <div class="card-group">

                    @foreach( $products_row as $key => $product )

                        <div class="card rounded-0">
                            <span class="bg-light small px-1 py-1 w-50 rounded-bottom-right">Артикул: {{$product->scu or ''}}</span>
                            <div class="card-body px-2">
                                <a href="{{ route( 'products.show', $product->id ) }}">

                                    @isset( $product->thumbnail )
                                        <img class="img-fluid mx-auto d-block" src="{{ URL::asset('storage/img/shop/product/thumbnail/'.$product->thumbnail) }}">
                                    @endisset

                                    @empty( $product->thumbnail )
                                        <div class="text-center text-light"><i class="fas fa-shopping-basket fa-7x"></i></div>
                                    @endempty

                                    <span class="card-title text-dark">
                                        <u>
                                            {{ $product->manufacturer['name'] . ' ' . $product->name }}

                                            @if( isset( $product->brands ) && count($product->brands) > 0)
                                                @foreach( $product->brands as $brand)
                                                    {{ ' | ' . $brand->name }}
                                                @endforeach
                                            @endif

                                        </u>
                                    </span>
                                </a>
                            </div>

                            @if( isset($product->price['value']) && $product->price['value'] !== null)
                                <div class="card-footer bg-white">
                                    <div class="row">
                                        <div class="col-6 price category-product text-left">
                                            <div class="row">
                                                <div class="col-12" style="margin-bottom: -1.2rem">
                                                    @if( isset($product->price['sale']) && $product->price['sale'] > 0)
                                                        <span class="small text-danger">
                                                            <s>
                                                                {{$product->price['value'] + $product->price['sale']}}<small>{{$components['shop']['currency']['symbol']}}</small>
                                                            </s>
                                                        </span>
                                                    @endif

                                                </div>

                                                <div class="col-12 pt-3">
                                                    <span>{{ $product->price['value']}}</span><small>{{$components['shop']['currency']['symbol']}}</small>
                                                </div>
                                            </div>

                                        </div>

                                        @if( !isset($product->basket_parameters) || count($product->basket_parameters) === 0)
                                            <div class="col-6">
                                                <form method="post" role="form" action="{{route('baskets.store')}}">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="product_id"       value="{{ $product->id}}">
                                                    <input type="hidden" name="quantity" value="1" >
                                                    <input class="btn btn-danger" type="submit" value="В корзину" />
                                                </form>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            @endif

                        </div>
                    @endforeach
                </div>
            @endforeach
        @endif
    </div>

    @if( isset($products) && count($products) > 0)
        <!-- Shop Page Navigation -->
        @include($template_name .'.modules.pagination.default')
    @endif

</div>