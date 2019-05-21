<div class="col-12 col-lg-7 offset-lg-1 mt-5 mt-lg-0">
    <ul class="nav pb-2" id="tabs">
        @foreach($offers as $offer)
            @if( isset($offer->products) && count($offer->products) > 0)
                <li class="nav-item">
                    <span data-tabIndex="{{$offer->name}}"  class="nav-link @if ($loop->first) active @endif">{{$offer->header}}</span>
                </li>
            @endif
        @endforeach
    </ul>

    <div id="tab-data">
        @foreach($offers as $offer)
            {{-- Products Tab --}}
            <div class="tab-data data-{{$offer->name}}">
                @if(isset($offer->products) && count($offer->products) > 0)
                    @foreach($offer->products->chunk(3) as $products_row)

                        @include($global_data['project_data']['template_name'] .'.components.shop.product.elements.product_rows.light')

                    @endforeach
                @endif
            </div>
        @endforeach
    </div>
</div>