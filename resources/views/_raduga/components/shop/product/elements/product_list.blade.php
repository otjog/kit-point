@if(isset($products) && count($products) > 0)
    <!-- Product Grid Display Starts -->
    @foreach($products->chunk($global_data['components']['shop']['chunk_products']) as $products_row)
        <div class="row">
        @foreach( $products_row as $key => $product )
            <!-- Product Starts -->
            @include('_raduga.components.shop.product.elements.product_card', ['wrapClass' => 'col-lg-4 col-md-6 col-sm-12 p-1'])
            <!-- Product Ends -->
            @endforeach
        </div>
    @endforeach
    <!-- Product Grid Display Ends -->

    <!-- Shop Page Navigation -->
    @include('_raduga.modules.pagination.index', ['module' => ['module' => 'pagination','template' => 'default']])
@endif