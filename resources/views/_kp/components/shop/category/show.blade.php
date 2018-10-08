<div class="col-lg">

    <!-- Shop Content -->

    <div class="shop_content">
        <!--div class="shop_bar clearfix mb-3">
            <div class="shop_product_count"><span>186</span> products found</div>
            <div class="shop_sorting">
                <span>Sort by:</span>
                <ul>
                    <li>
                        <span class="sorting_text">highest rated<i class="fas fa-chevron-down"></i></span>
                        <ul>
                            <li class="shop_sorting_button" data-isotope-option='{ "sortBy": "original-order" }'>highest rated</li>
                            <li class="shop_sorting_button" data-isotope-option='{ "sortBy": "name" }'>name</li>
                            <li class="shop_sorting_button"data-isotope-option='{ "sortBy": "price" }'>price</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div-->

        @include( $template_name .'.modules.product_filter.reload.list')

        @include( $template_name .'.components.shop.product.list')

    </div>

</div>