<span class="price-head">Цена:</span>
<span class="price-new">
    {{$product->price['value']
    . $global_data['components']['shop']['currency']['symbol']}}
</span>
@if( isset($product->price['sale']) && $product->price['sale'] > 0)
    <span class="price-old">
        {{$product->price['value']
        + $product->price['sale']
        . $global_data['components']['shop']['currency']['symbol']}}
    </span>
@endif