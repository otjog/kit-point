<div class="price-head">Цена:</div>
<div class="order_parameters my-3">
    @foreach($product->basket_parameters as $key => $parameter)
        <div class="form-check form-check-inline">
            <div class="custom-control custom-radio">
                <input
                        class="custom-control-input"
                        type="radio"
                        required=""
                        name="order_attributes[]"
                        id="{{ $parameter->pivot->id }}"
                        value="{{ $parameter->pivot->id }}"
                >
                <label class="custom-control-label" for="{{ $parameter->pivot->id }}">
                    {{$parameter->pivot->value }}:
                </label>
                <span class="price-new">
                                                    {{$product->price['value']
                                                    + $parameter->pivot->basket_value
                                                    . $global_data['components']['shop']['currency']['symbol']}}
                                                </span>
                @if( isset($product->price['sale']) && $product->price['sale'] > 0)
                    <span class="price-old">
                                                        {{$product->price['value']
                                                        + $product->price['sale']
                                                        + $parameter->pivot->basket_value
                                                        .$global_data['components']['shop']['currency']['symbol']}}
                                                    </span>
                @endif
            </div>
        </div>
    @endforeach
</div>