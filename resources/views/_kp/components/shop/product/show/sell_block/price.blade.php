<div class="product_price clearfix">
    @if($product->price['value'] !== 0.00)
        {{ $product->price['value'] }}
        <small>{{$global_data['components']['shop']['currency']['symbol']}}</small>
    @else
        <span class="text-muted m-0">Цена не установлена</span>
    @endif
</div>