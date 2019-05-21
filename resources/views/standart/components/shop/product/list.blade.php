<div class="product-list py-2" id="product-list">
    <div class="container">

        @if(isset($products) && count($products) > 0)

            @foreach($products->chunk($global_data['project_data']['components']['shop']['chunk_products']) as $products_row)

                @include($global_data['project_data']['template_name'] .'.components.shop.product.elements.product_rows.light')

            @endforeach
        @endif
    </div>

@if( isset($products) && count($products) > 0)
        <!-- Shop Page Navigation -->
        @include($global_data['project_data']['template_name'] .'.modules.pagination.default')
    @endif

</div>