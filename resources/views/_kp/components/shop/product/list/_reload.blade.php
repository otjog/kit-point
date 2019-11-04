
@if(isset($products) && count($products) > 0)
    @foreach($products->chunk($global_data['components']['shop']['chunk_products']) as $products_row)

        <div class="row no-gutters">
            @foreach( $products_row as $key => $product )
                @include($global_data['template']['name'] .'.components.shop.product.list.card')
            @endforeach
        </div>

    @endforeach

    {{-- Shop Page Navigation --}}
    @include($global_data['template']['name'] .'.modules.pagination.default')
@endif
