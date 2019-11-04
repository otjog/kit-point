@if(isset($product->quantity_discounts) && $product->quantity_discounts !== null && count($product->quantity_discounts) > 0)
    @php $quantity_discount = $product->quantity_discounts->last(); @endphp

    <a
            class="text-dark border-bottom-dotted small"
            data-toggle="collapse"
            href="#collapseQuantityDiscounts"
            role="button"
            aria-expanded="false"
            aria-controls="multiCollapseExample1">
        Крупный опт от {{$quantity_discount->pivot['totalPrice']}}
        <small>{{$global_data['components']['shop']['currency']['symbol']}}</small>
    </a>

    <div class="row">
        <div class="col">
            <div class="collapse multi-collapse" id="collapseQuantityDiscounts">
                <div class="my-1 py-1 pl-2 border-top border-bottom">
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
            </div>
        </div>
    </div>
@else
    <div class="mt-3">{{-- Если нет скидки, этот блок опускает цену вниз --}}</div>
@endif