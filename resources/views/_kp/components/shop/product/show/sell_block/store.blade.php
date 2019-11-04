<div>
    @if( isset($product->stores) && $product->stores !== null && count($product->stores) > 0 )
        <small class="text-success">В наличии</small>
    @else
        <small class="text-muted">Нет в наличии</small>
    @endif
</div>