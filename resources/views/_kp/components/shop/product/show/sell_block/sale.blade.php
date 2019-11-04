@if( isset($product->price['sale']) && $product->price['sale'] > 0)

    <div class="product_price text-muted mr-3 clearfix">
        <s>
            <small>
                {{$product->price['value'] + $product->price['sale']}}
                {{$global_data['components']['shop']['currency']['symbol']}}
            </small>
        </s>
    </div>

@endif