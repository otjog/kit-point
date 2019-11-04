@if( isset($product->price['sale']) && $product->price['sale'] > 0)
    <s class="text-muted">
        <span class="h6">{{$product->price['value'] + $product->price['sale']}}</span>
        <span>{{$global_data['components']['shop']['currency']['symbol']}}</span>
    </s>
    <br>
@else
    <div class="pb-2"></div>
@endif
<span class="d-inline d-lg-none">Цена: </span>
<span class="h6">{{ $product->price['value'] }}</span>
<small>{{$global_data['components']['shop']['currency']['symbol']}}</small>
