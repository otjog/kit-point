@if( isset($product->quantity_discounts) && $product->quantity_discounts !== null && count($product->quantity_discounts) > 0 )
    <div class="border rounded py-2 px-3">
        <h5>Покупка оптом</h5>
        <ul>
            @foreach($product->quantity_discounts as $quantity_discount)
                @if(isset($quantity_discount->pivot['totalPrice']) && $quantity_discount->pivot['totalPrice'] !== null)
                    <li class="py-1">
                        <div class="row">
                            <div class="col">
                                        <span>
                                            от
                                            <strong>{{$quantity_discount->pivot['quantity']}}</strong>
                                            шт.
                                        </span>
                                -
                                <span>
                                            <strong>
                                                {{$quantity_discount->pivot['totalPrice']}}
                                            </strong>
                                            <small>
                                            {{$global_data['components']['shop']['currency']['symbol']}}/шт
                                            </small>
                                        </span>
                            </div>
                        </div>

                    </li>
                @endif
            @endforeach
        </ul>
    </div>
@endif