<span class="text-muted">Товар был удален из корзины.</span>
<form class="shop-buy-form " method="post" role="form" action="{{ route('baskets.products.store', csrf_token()) }}">
    <input type="hidden" name="product_id" value="{{ $product->id}}">
    <input type="hidden" name="quantity" value="1">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" >
    <input class="btn btn-link" type="submit" value="Восстановить" />
</form>