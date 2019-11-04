<div class="btn-group" role="group" aria-label="Buy Button Group">

    <form class="shop-buy-form" method="post" role="form" action="{{route('baskets.products.update', [csrf_token(), $product->id])}}">
        <input type="hidden" name="add" value="-1">
        <input type="hidden" name="quantity" value="{{$product->baskets[0]->pivot['quantity']}}">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
        <input class="btn bg-grey" type="submit" value="-" />
    </form>

    <form class="shop-buy-form mx-1" method="post" role="form" action="{{route('baskets.products.update', [csrf_token(), $product->id])}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="add" value="0">
        <input
                type="text"
                name="quantity"
                value="{{$product->baskets[0]->pivot['quantity']}}"
                class="form-control quantity_input text-center"
                size="4" >
    </form>

    <form class="shop-buy-form" method="post" role="form" action="{{ route('baskets.products.update', [csrf_token(), $product->id]) }}">
        <input type="hidden" name="add" value="1" >
        <input type="hidden" name="quantity" value="{{$product->baskets[0]->pivot['quantity']}}">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
        <input class="btn bg-primary" type="submit" value="+" />
    </form>

</div>