<div class="container">

    @if(isset($products) && count($products) > 0)

        @foreach($products->chunk($global_data['components']['shop']['chunk_products']) as $products_row)

            @include($global_data['template']['name'] .'.components.shop.product.elements.product_rows.light')

        @endforeach
    @endif
</div>

@if(isset($products) && count($products) > 0)
    <!-- Shop Page Navigation -->
    @include($global_data['template']['name'] .'.modules.pagination.default')
@endif
