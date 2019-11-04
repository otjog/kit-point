@if( !isset($product->basket_parameters) || count($product->basket_parameters) === 0)
    @if(isset($product->baskets) && count($product->baskets) > 0 && $product->baskets[0]->pivot['quantity'] > 0)
        <div class="btn-group" role="group" aria-label="Buy Button Group">
            <form class="shop-buy-form" method="post" role="form" action="{{route('baskets.products.update', [csrf_token(), $product->id])}}">
                <input type="hidden" name="add" value="-1">
                <input type="hidden" name="quantity" value="{{$product->baskets[0]->pivot['quantity']}}">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                <input class="btn bg-grey" type="submit" value="-" />
            </form>

            <form action="{{route('baskets.edit', csrf_token())}}">
                <input class="btn btn-outline-success mx-1" type="submit"
                       value="В корзине {{$product->baskets[0]->pivot['quantity']}}шт." />
            </form>

            <form class="shop-buy-form" method="post" role="form" action="{{ route('baskets.products.update', [csrf_token(), $product->id]) }}">
                <input type="hidden" name="add" value="1" >
                <input type="hidden" name="quantity" value="{{$product->baskets[0]->pivot['quantity']}}">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                <input class="btn bg-primary" type="submit" value="+" />
            </form>

        </div>
    @else
        <form class="shop-buy-form " method="post" role="form" action="{{ route('baskets.products.store', csrf_token()) }}">
            <input type="hidden" name="product_id" value="{{ $product->id}}">
            <input type="hidden" name="quantity" value="1">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" >
            <input class="btn btn-danger" type="submit" value="В корзину" />
        </form>
    @endif
@endif