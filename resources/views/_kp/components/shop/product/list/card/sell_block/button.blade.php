@if( isset($product->stores) && $product->stores !== null && count($product->stores) > 0 )
    <small class="text-success mr-4">В наличии</small><br>
    @if( isset($product->price['value']) && $product->price['value'] !== null && $product->price['value'] !== 0.00)

        @if( !isset($product->basket_parameters) || count($product->basket_parameters) === 0)
            @if(isset($product->baskets) && count($product->baskets) > 0 && $product->baskets[0]->pivot['quantity'] > 0)
                <div class="btn-group" role="group" aria-label="Buy Button Group">
                    <form class="shop-buy-form" method="post" role="form" action="{{route('baskets.products.update', [csrf_token(), $product->id])}}">
                        <input type="hidden" name="add" value="-1">
                        <input type="hidden" name="quantity" value="{{$product->baskets[0]->pivot['quantity']}}">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                        <input class="btn bg-grey btn-sm" type="submit" value="-" />
                    </form>

                    <form action="{{route('baskets.edit', csrf_token())}}">
                        <input class="btn btn-outline-success btn-sm mx-1" type="submit"
                               value="{{$product->baskets[0]->pivot['quantity']}}шт." />
                    </form>

                    <form class="shop-buy-form" method="post" role="form" action="{{ route('baskets.products.update', [csrf_token(), $product->id]) }}">
                        <input type="hidden" name="add" value="1" >
                        <input type="hidden" name="quantity" value="{{$product->baskets[0]->pivot['quantity']}}">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                        <input class="btn bg-primary btn-sm" type="submit" value="+" />
                    </form>

                </div>
            @else
                <form class="shop-buy-form " method="post" role="form" action="{{ route('baskets.products.store', csrf_token()) }}">
                    <input type="hidden" name="product_id" value="{{ $product->id}}">
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                    <input class="btn btn-danger btn-sm" type="submit" value="В корзину" />
                </form>
            @endif
        @endif

    @endif
@else
    <div class="text-muted pt-4">Нет в наличии</div>
@endif