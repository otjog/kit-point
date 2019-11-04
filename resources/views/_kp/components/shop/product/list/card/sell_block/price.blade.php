@if( isset($product->price['value']) && $product->price['value'] !== null && $product->price['value'] !== 0.00)
    @if( isset($product->price['sale']) && $product->price['sale'] > 0)
        <span class="small text-danger">
                <s>
                    {{$product->price['value'] + $product->price['sale']}}
                    <small>{{$global_data['components']['shop']['currency']['symbol']}}</small>
                </s>
            </span>
    @else
        <div class="mt-3">{{-- Если нет скидки, этот блок опускает цену вниз --}}</div>
    @endif
    <strong>{{ $product->price['value']}}</strong><small>{{$global_data['components']['shop']['currency']['symbol']}}</small>
@endif